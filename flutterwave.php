<?php

include __DIR__ . "/configs.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && us_level) {
    // echo json_encode($_POST);
    // exit();
    $amount = (float)($_POST['amount']);
	$billing_info = json_encode($_POST);
	$transactionID  = $_POST['tx_ref'];
	$paidAmount     = $amount;
	$paidCurrency   =  $_POST['currency'];
	$payment_status = $_POST['status'];;
    $address = $_POST['address'];
    $city =$_POST['city'];
    $state = $_POST['state'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];
	$email = $_POST['email'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$billing = [
		"name" => $name,
		"email" => $email,
		"phone" => $phone,
		"address" => $address,
		"city" => $city,
		"state" => $state,
		"country" => $country,
		"postal_code" => $postal_code,
	];

    $data = [
		'transaction_id' => $transactionID,
		'payment_amount' => $paidAmount,
		'payment_status' => $payment_status,
		'invoice_id'     => '',
		'created_at'     => time(),
		'billing_info'   => (object) $billing,
		'gender'         => $gender,
		'author'         => us_id,
		'ip'             => get_ip,
		'os'             => get_os,
		'browser'        => get_browser,
		'device'         => get_device,
		'country_name'   => $country,
		'country_code'   => us_country,
		'state'          => us_state,
		'city_name'      => us_city
	];

    if($payment_status != 'successful'){
		echo '<div id="loading">'.fh_alerts($lang['alerts']['wrong'], "danger", path."/index.php", 2).'</div>';
		include __DIR__."/footer.php";
		exit(1);
	}

    $data_order_price = 0;
	foreach (json_decode($_COOKIE['addtocart'], true) as $key => $value) {
			
		foreach ($value as $k => $v) {
					$data['order_cart'] = sc_cookie($v);
					$data_order_cart    = json_decode($data['order_cart'], true);
					$data_order_price   += $data_order_cart['item_price'] * $data_order_cart['item_quantities'] + (float)($data_order_cart['item_delivery']);

					if($data_order_cart['item_extra']){
						foreach($data_order_cart['item_extra'] as $k => $extra){
							$extra            = db_unserialize([db_get("items", "extra", $key), $extra]);
							$item_extra_price = $extra['price'] * $data_order_cart['item_quantities'];
							$data_order_price += $item_extra_price;
						}
					}

					$data['item'] = $key;
					$data['restaurant'] = db_get("items", "restaurant", $key);
					$data['user']       = db_get("restaurants", "author", $data['restaurant']);
					if(!db_rows("orders WHERE transaction_id = '{$data['transaction_id']}' && order_cart = '{$data['order_cart']}'")){

						db_insert("orders", $data);

						$taxes = (taxes/100)*$data_order_price;

						$data_taxes = [
							"taxes"      => $taxes,
							'created_at' => time(),
							"order_id"   => db_get("orders", "id", "author", us_id, "&& transaction_id = '{$data['transaction_id']}' && order_cart = '{$data['order_cart']}'"),
						];

						$data_order_price = $data_order_price-$taxes;

						db_insert("taxes", $data_taxes);
						db_update("users", ['balance' => (db_get("users", "balance", $data['user']) + $data_order_price)], $data['user']);

					}
					$data_order_price = 0;

					/* SEND NOTIFICATION TO restaurant */

					$s_itemname   = db_get("items", "name", $key);
					$s_email      = db_get("users", "email", $data['user']);
					$s_username   = db_get("users", "username", $data['user']);

					$mail->addAddress($s_email, $s_username);
					$mail->isHTML(true);
					$mail->Subject = $lang['email']['paid_t'].' '.$s_itemname;
					$mail->Body    = fh_send_email($s_username, $s_email, path."/restaurant.php?pg=orders", $s_itemname, "paid");
					if( $mail->send() ){
						$alert = [
							'type'  =>'success',
							'alert' => fh_alerts("Send succesfully.", 'success')
						];
					} else {
						$alert = [
							'type'  =>'danger',
							'alert' => fh_alerts($lang['alerts']['wrong'])
						];
					}
		}
	}
	echo '<div id="loading">'.fh_alerts($lang['alerts']['payment'], "success", path."/index.php?pg=ordersuccess", 3).'</div>';
}
