<?php
# -------------------------------------------------#
#¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤#
#	¤                                            ¤   #
#	¤              Puerto iFood 1.0              ¤   #
#	¤--------------------------------------------¤   #
#	¤              By Khalid Puerto              ¤   #
#	¤--------------------------------------------¤   #
#	¤                                            ¤   #
#	¤  Facebook : fb.com/prof.puertokhalid       ¤   #
#	¤  Instagram : instagram.com/khalidpuerto    ¤   #
#	¤  Site : http://www.puertokhalid.com        ¤   #
#	¤  Whatsapp: +212 654 211 360                ¤   #
#	¤                                            ¤   #
#	¤--------------------------------------------¤   #
#	¤                                            ¤   #
#	¤  Last Update: 29/06/2020                   ¤   #
#	¤                                            ¤   #
#¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤#
# -------------------------------------------------#

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(!us_level || us_level == 6){
		$reg_fname  = isset($_POST['reg_fname']) ? sc_sec($_POST['reg_fname'])     : '';
		$reg_lname  = isset($_POST['reg_lname']) ? sc_sec($_POST['reg_lname'])     : '';
		$reg_name   = isset($_POST['reg_name']) ? sc_sec($_POST['reg_name'])     : '';
		$reg_pass   = isset($_POST['reg_pass']) ? sc_sec($_POST['reg_pass'])     : '';
		$reg_repass = isset($_POST['reg_repass']) ? sc_sec($_POST['reg_repass']) : '';
		$reg_email  = isset($_POST['reg_email']) ? sc_sec($_POST['reg_email'])   : '';

		if(empty($reg_fname) || empty($reg_lname) || empty($reg_name) || empty($reg_pass) || empty($reg_email)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['required'])
			];
		} elseif(!preg_match('/^[\p{L}\' -]+$/u',$reg_name)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['char_username'])
			];
		} elseif(strlen($reg_name) < 3 || strlen($reg_name) > 15){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['limited_username'])
			];
		} elseif(db_rows("users WHERE username = '".$reg_name."'")){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['exist_username'])
			];
		} elseif(strlen($reg_pass) < 6 || strlen($reg_pass) > 18){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['limited_pass'])
			];
		} elseif($reg_pass != $reg_repass){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['repass'])
			];
		} elseif(!sc_check_email($reg_email)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['check_email'])
			];
		} elseif(db_rows("users WHERE email = '".$reg_email."'")){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['signup']['alert']['exist_email'])
			];
		} else {
			$data = [
                'firstname'      => "{$reg_fname}",
                'lastname'      => "{$reg_lname}",
				'username'   => "{$reg_name}",
				'email'      => "{$reg_email}",
				'password'   => sc_pass($reg_pass),
				'date'       => time(),
				'level'      => "4"
			];

			if(site_users==0){ // moderat(0) -> active
				$alert = [
						'type'  =>'success',
						'alert' => fh_alerts($lang['signup']['alert']['success'], 'success')
				];
			} elseif(site_users==2){ // moderat(2) -> email activation

				$token     = bin2hex(openssl_random_pseudo_bytes(16));
				$reset_url = path."/email-verification.php?action=reset&token=".$token."&t=".sha1($reg_email);

				$to      = $reg_email;
				$from    = notreply;
				$subject = "iFood: Email Verification";
				$body    = "";
				$html    = fh_resset_p(fh_bbcode(email_verification_msg), $reset_url, [$reg_name, $to]);
				$mail    = new Mail($to, $from, $subject, $body, $html);

				if (  $mail->send() ) {
					$alert = [
							'type'  =>'success',
							'alert' => fh_alerts($lang['signup']['alert']['success2'], 'success')
					];
				} else {
					$alert = [
							'type'  =>'success',
							'alert' => fh_alerts($lang['signup']['alert']['success1'], 'success')
					];
				}

				$data['token'] = $token;
				$data['moderat'] = '2';
			} else {
				$alert = [
						'type'  =>'success',
						'alert' => fh_alerts($lang['signup']['alert']['success1'], 'success')
				];
				$data['moderat'] = '3';
			}

			db_insert("users", $data);

			$alert = [
					'type'  =>'success',
					'alert' => fh_alerts($lang['signup']['alert']['success'], 'success')
			];

		}

		echo json_encode($alert);
	}
}
