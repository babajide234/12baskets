<?php
    include __DIR__."/head.php";

    if( isset($_SESSION['login']) ){
        if( us_level == 6 || us_level == 4 ){
            fh_go(path."/dashboard.php");
            exit;
        }
        if( us_level == 2){
            fh_go(path."/restaurant.php");
            exit;
        }
    }

?>
    
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <h5 class="card-title text-center">Sign In</h5>

              <form class="form-signin" id="sendsignin">
                <div class="form-group pt-form-icon">
					<span><i class="icons icon-user"></i></span>
					<input type="text" name="sign_name" placeholder="<?=$lang['login']['username']?>">
				</div>
				<div class="form-group pt-form-icon">
					<span><i class="icons icon-key"></i></span>
					<input type="password" name="sign_pass" placeholder="<?=$lang['login']['password']?>">
				</div>
                <div class="row">
					<div class="col">
						<div class="form-group">
							<input type="checkbox" name="sign_type" id="ck1" value="1" class="choice">
							<label for="ck1"><?=$lang['login']['keep']?></label>
						</div>
					</div>
				</div>
				<div class="pt-msg"></div>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit"><?=$lang['login']['btn']?></button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>

<?php
    include __DIR__."/scripts.php";
?>
</body>
</html>
