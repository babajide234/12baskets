
<!-- Latest compiled and minified jQuery Library -->
<?php
	// echo 'hello world';
?>
<script src="<?=path?>/js/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="<?=path?>/js/popper.min.js"></script>
<script src="<?=path?>/js/bootstrap.min.js"></script>

<!-- Livequery plugin -->
<script src="<?=path?>/js/jquery.livequery.js"></script>

<script src="<?=path?>/js/jquery-confirm.min.js"></script>
<script src="<?=path?>/js/jquery.mask.min.js"></script>
<script src="<?=path?>/js/bootstrap-select.min.js"></script>
<script src="<?=path?>/js/jquery.scrollbar.js"></script>
<script src="<?=path?>/js/Chart.min.js"></script>
<script src="<?=path?>/js/html2pdf.bundle.min.js"></script>
<script src="<?=path?>/js/jquery.uploader.js"></script>
<script src="<?=path?>/js/lightbox.js"></script>
<script src="<?=path?>/js/file_upload/fileinput.min.js"></script>
<script src="<?=path?>/js/bootstrap-timepicker.js"></script>
<script src="<?=path?>/js/owl.carousel.js"></script>

<!-- sceditor -->
<script src="<?=path?>/js/minified/sceditor.min.js"></script>
<script src="<?=path?>/js/minified/formats/bbcode.js"></script>
<script src="<?=path?>/js/minified/icons/material.js"></script>

<!-- Scroll -->
<link rel="stylesheet" href="<?=path?>/css/jquery.jscrollpane.css">
<script src="<?=path?>/js/jquery.jscrollpane.min.js"></script>
<script src="<?=path?>/js/jquery.mousewheel.js"></script>

<?php if(page == 'cart'): ?>
	<script src="//js.stripe.com/v3/"></script>
	<script>var stripe = Stripe('<?=site_stripe_key?>');</script>
	<script src="<?=path?>/js/stripe.js"></script>
<?php endif; ?>

<script>
	var path         = '<?=path?>';
	var lang         = <?=json_encode($lang)?>;
	var nophoto      = '<?=nophoto?>';
	var dollar_sign  = '<?=dollar_sign?>';
	var user_id	  = '<?=$_SESSION['login']?>';
	var level	  = '<?=us_level?>';
	var country_code = '<?=us_country?>';
	var country_name = '<?=us_country?>';
</script>

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="<?=path?>/js/custom.js"></script>
<script src="<?=path?>/js/gmapsintegration.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBP36yIMHK0Fk1EFDoRNt_nLqadIm5wlMc&callback=init"></script>
<?php if ($pg == "pages" && $request == 'new'): ?>

<?php else: ?>
<script src="<?=path?>/js/scroll.js"></script>
<link rel="stylesheet" href="<?=path?>/css/scroll.css">
<?php endif; ?>
