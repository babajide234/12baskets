<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-notebook icons ic"></i> Delivery
		<p>
			<a href="<?=path?>">Dashboard</a> <i class="fas fa-long-arrow-alt-right"></i> Items
		</p>
	</div>

	<div class="pt-options">
		<a href="#addriderModal" data-toggle="modal" class="pt-btn"><i class="fas fa-plus"></i> Add new Rider</a>
	</div>
</div>

<div class="row">
    <div class="col-12">
        
    </div>
</div>
<div class="pt-resaurants">
	<div class="pt-resaurant">
		<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Name</th>
				<th scope="col" class="text-center">Branch</th>
				<th scope="col" class="text-center">Current Asigned Order</th>
				<th scope="col" class="text-center"><?=$lang['dash']['u_updated']?></th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$sql = $db->query("SELECT * FROM ".prefix."users WHERE level = 4 ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
				if($sql->num_rows):
				while($rs = $sql->fetch_assoc()):
			?>
			<tr>
				<td width="40%">
					<div class="pt-thumb">
						<img src="<?=($rs['photo'] ? $rs['photo'] : nophoto)?>" onerror="this.src='<?=nophoto?>'" />
					</div>
					<a href="#" class="pt-name"><?=$rs['firstname']?> <?=$rs['lastname']?></a>
				</td>
				<td class="text-center"><?=$rs['branch']?></td>
				<td class="text-center"><?=fh_ago($rs['date'])?></td>
				<td class="text-center"><?=($rs['updated_at']?fh_ago($rs['updated_at']):'--')?></td>
				<td class="pt-dot-options">
					<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
					<ul class="pt-drop">
						<li><a href="<?=path?>/userdetails.php?id=<?=$rs['id']?>"><i class="far fa-edit"></i> <?=$lang['dash']['edit']?></a></li>
						<li><a href="#locationModal" data-toggle="modal" class="location" data-id="<?=$rs['id']?>" ><i class="far fa-edit"></i> Location</a></li>
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

<form id="addrider">
	<div class="modal fade newmodal" id="addriderModal">
	<div class="modal-dialog">
		<div class="modal-content">

		<div class="modal-header">
			<h4 class="modal-title">Create New Rider</h4>
			<button type="button" class="close" data-dismiss="modal">×</button>
		</div>

		<div class="modal-body">
					<div class="form-row">
						<div class="col">
							<div class="form-group">
								<label><?=$lang['details']['firstname_l']?>: <small class="text-danger">*</small></label>
								<input type="text" name="reg_fname" placeholder="<?=$lang['details']['firstname']?>">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label><?=$lang['details']['lastname_l']?>: <small class="text-danger">*</small></label>
								<input type="text" name="reg_lname" placeholder="<?=$lang['details']['lastname']?>">
							</div>
						</div>
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

<form id="locationMod">
	<div class="modal fade newmodal" id="locationModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<div class="" >
					<h4 class="modal-title">Rider Location</h4>
					<p class="">Last Update: <span class="tracktime"></span></p>
				</div>
				<button type="button" class="close" data-dismiss="modal">×</button>
			</div>

			<div class="modal-body">
				<div class="mapContainer">
					<div id="map" class="map"></div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="pt-btn close" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
	</div>
		</form>

