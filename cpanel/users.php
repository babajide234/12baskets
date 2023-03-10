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
?>

<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-people icons ic"></i> <?=$lang['dash']['users']?>
		<p><a href="<?=path?>"><?=$lang['header']['dashboard']?></a> <i class="fas fa-long-arrow-alt-right"></i> <?=$lang['dash']['users']?></p>
	</div>
	<div class="pt-options">
		<a href="#myModal" data-toggle="modal" class="pt-btn"><i class="fas fa-plus"></i> <?=$lang['dash']['u_create']?></a>
	</div>
</div>

<h3 class="cp-form-title mt-4">Branch Managers</h3>

<div class="pt-resaurants">
	<div class="pt-resaurant">
		<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th scope="col"><?=$lang['dash']['u_username']?></th>
				<th scope="col" class="text-center">Branch</th>
				<th scope="col" class="text-center"><?=$lang['dash']['u_registred']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['u_updated']?></th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = $db->query("SELECT * FROM ".prefix."users where level != 6 AND level != 4 AND level != 1  ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
			if($sql->num_rows):
			while($rs = $sql->fetch_assoc()):
			?>
			<tr>
				<td width="20%">
					<div class="pt-thumb">
						<img src="<?=($rs['photo'] ? $rs['photo'] : nophoto)?>" onerror="this.src='<?=nophoto?>'" />
					</div>
					<a href="#" class="pt-name"><?=$rs['username']?></a>
				</td>
				<td class="text-center">
					<?php
					
					$id= $rs['branch'];
					$sql = $db->query("SELECT * FROM `pl_restaurants` WHERE id ={$id}");
					$rss = $sql->fetch_assoc();
					echo $rss['name'];
					?>
				</td>
				
				
				<td class="text-center"><?=fh_ago($rs['date'])?></td>
				<td class="text-center"><?=($rs['updated_at']?fh_ago($rs['updated_at']):'--')?></td>
				<td class="pt-dot-options">
					<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
					<ul class="pt-drop">
						<li><a href="<?=path?>/userdetails.php?id=<?=$rs['id']?>"><i class="far fa-edit"></i> <?=$lang['dash']['edit']?></a></li>
						<li><a href="#assignBranch" data-toggle="modal"><i class="far fa-edit assign_branch" data-id="<?=$rs['id']?>"></i> Assign Branch</a></li>
						<li><a href="#" class="pt-delete" data-id="<?=$rs['id']?>" data-type="user"><i class="fas fa-trash-alt"></i> <?=$lang['dash']['delete']?></a></li>
					</ul>
				</td>
			</tr>
			<?php
			endwhile;
			echo '<tr><td colspan="8">'.fh_pagination("users",$limit, path."/dashboard.php?pg=users&").'</td></tr>';
			else:
				?>
				<tr>
					<td colspan="8">
						<?=fh_alerts($lang['alerts']["no-data"], "info")?>
					</td>
				</tr>
				<?php
			endif;
			$sql->close();
			?>
		</tbody>
	</table>
	</div>
	</div>
</div>

<h3 class="cp-form-title mt-4">Customers</h3>

<div class="pt-resaurants">
	<div class="pt-resaurant">
		<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th scope="col"><?=$lang['dash']['u_username']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['u_plan']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['u_credits']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['u_last_p']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['u_registred']?></th>
				<th scope="col" class="text-center"><?=$lang['dash']['u_updated']?></th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = $db->query("SELECT * FROM ".prefix."users where level != 6 AND level != 4 AND level != 2 ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
			if($sql->num_rows):
			while($rs = $sql->fetch_assoc()):
			?>
			<tr>
				<td width="20%">
					<div class="pt-thumb">
						<img src="<?=($rs['photo'] ? $rs['photo'] : nophoto)?>" onerror="this.src='<?=nophoto?>'" />
					</div>
					<a href="#" class="pt-name"><?=$rs['username']?></a>
				</td>
				<td class="text-center">
					<span class="badge <?=( $rs['plan']=='1' ? 'bg-gy' : ( $rs['plan']=='2' ? 'bg-gr' : ( $rs['plan']=='3' ? 'bg-v' : ( $rs['plan']=='4' ? 'bg-o' : ''))))?>">
						<?=($rs['plan']?db_get("plans", "plan", $rs['plan']):'--')?>
					</span>
				</td>
				<td class="text-center"><?=($rs['balance']?dollar_sign.$rs['balance']:'--')?></td>
				<td class="text-center"><?=($rs['lastpayment']?fh_ago($rs['lastpayment']):'--')?></td>
				<td class="text-center"><?=fh_ago($rs['date'])?></td>
				<td class="text-center"><?=($rs['updated_at']?fh_ago($rs['updated_at']):'--')?></td>
				<td class="pt-dot-options">
					<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
					<ul class="pt-drop">
						<li><a href="<?=path?>/userdetails.php?id=<?=$rs['id']?>"><i class="far fa-edit"></i> <?=$lang['dash']['edit']?></a></li>
						<li><a href="#" class="pt-delete" data-id="<?=$rs['id']?>" data-type="user"><i class="fas fa-trash-alt"></i> <?=$lang['dash']['delete']?></a></li>
					</ul>
				</td>
			</tr>
			<?php
			endwhile;
			echo '<tr><td colspan="8">'.fh_pagination("users",$limit, path."/dashboard.php?pg=users&").'</td></tr>';
			else:
				?>
				<tr>
					<td colspan="8">
						<?=fh_alerts($lang['alerts']["no-data"], "info")?>
					</td>
				</tr>
				<?php
			endif;
			$sql->close();
			?>
		</tbody>
	</table>
	</div>
	</div>
</div>
<!-- The Modal -->
<form id="sendsignup">
<div class="modal fade newmodal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"><?=$lang['dash']['u_create']?></h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
				<div class="form-group">
					<label>Role: <small class="text-danger">*</small></label>
					<select name="reg_role" class="">
						<option value="" default> Choose Role</option>
						<option value="1">Customer</option>
						<option value="2">Manager</option>
						<option value="6">Admin</option>
					</select>
				</div>
				<div class="form-group">
					<label><?=$lang['details']['username_l']?>: <small class="text-danger">*</small></label>
					<input type="text" name="reg_name" placeholder="<?=$lang['details']['username_l']?>">
				</div>
				<div class="form-row">
					<div class="col">
						<div class="form-group">
							<label><?=$lang['details']['password_l']?>: <small class="text-danger">*</small></label>
							<input type="password" name="reg_pass" placeholder="<?=$lang['details']['password_l']?>">
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label><?=$lang['signup']['rpassword']?>: <small class="text-danger">*</small></label>
							<input type="password" name="reg_repass" placeholder="<?=$lang['signup']['rpassword']?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label><?=$lang['details']['email_l']?>: <small class="text-danger">*</small></label>
					<input type="text" name="reg_email" placeholder="<?=$lang['details']['email_l']?>">
				</div>
				<div class="pt-msg"></div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="pt-btn"><?=$lang['send']?></button>
      </div>

    </div>
  </div>
</div>
</form>
<form id="assignBranchform">
<div class="modal fade newmodal" id="assignBranch">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"><?=$lang['dash']['u_create']?></h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
				<div class="form-group">
					<label>Branch: <small class="text-danger">*</small></label>
					<select name="asn_branch" id="" class="">
					    <option default> Select Branch</option>
						<?php
							$sql = $db->query("SELECT * FROM `pl_restaurants`");
							while($rs = $sql->fetch_assoc()):
						?>
						<option value="<?=$rs['id']?>"><?=$rs['name']?></option>
						<?php
							endwhile;
							$sql->close();
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Managers: <small class="text-danger">*</small></label>
					<select name="asn_manager" id="" class="">
						<?php
							$sql = $db->query("SELECT * FROM `pl_users` WHERE `level` = 2");
							while($rs = $sql->fetch_assoc()):
						?>

						<option default> Select Manager</option>
						<option value="<?=$rs['id']?>"><?=$rs['username']?></option>
						<?php
							endwhile;
							$sql->close();
						?>
					</select>
				</div>
				<div class="pt-msg"></div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="pt-btn"><?=$lang['send']?></button>
      </div>

    </div>
  </div>
</div>
</form>

