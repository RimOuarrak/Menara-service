<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-warning" href="./index.php?page=Marches"><i class="fa fa-file-excel" aria-hidden="true"></i> Importer un fichier</a>
			</div>
		</div>
<div class="col-lg-12">
	<div class="card card-outline card-info">
		<div class="card-body">
			<form action="" id="manage-project">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
		<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">N° ordre</label>
					<input type="text" class="form-control form-control-sm" autocomplete="off" name="num_ordr" value="<?php echo isset($num_ordr) ? $num_ordr : '' ?>">
				</div>
			</div>
		<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">N° d’Appel d’Offre</label>
					<input type="text" class="form-control form-control-sm" autocomplete="off" name="num_offr" value="<?php echo isset($num_offr) ? $num_offr : '' ?>">
				</div>
			</div>
			<!-- note -->
			<div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Organisme</label>
              <select class="form-control form-control-sm select2" name="org_id">
              	<option></option>
              	<?php 
              	$org = $conn->query("SELECT *,name FROM org order by name asc ");
              	while($row= $org->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php echo isset($org_id) && $org_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords(html_entity_decode($row['name']))?></option>
              	<?php endwhile; ?>
              </select>
            </div>
          </div>
	
		<!-- note -->
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Caution</label>
					<input type="text" class="form-control form-control-sm" autocomplete="off" name="ctn" value="<?php echo isset($ctn) ? $ctn : '' ?>">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Estimation</label>
					<input type="text" class="form-control form-control-sm" autocomplete="off" name="est" value="<?php echo isset($est) ? $est : '' ?>">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Estimation Min</label>
					<input type="text" class="form-control form-control-sm" autocomplete="off" name="est_min" value="<?php echo isset($est_min) ? $est_min : '' ?>">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Estimation Max</label>
					<input type="text" class="form-control form-control-sm" autocomplete="off" name="est_max" value="<?php echo isset($est_max) ? $est_max : '' ?>">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Ville</label>
					<input type="text" class="form-control form-control-sm" name="ville" value="<?php echo isset($ville) ? $ville : '' ?>">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Heure</label>
					<input type="time" class="form-control form-control-sm" name="hr" value="<?php echo isset($hr) ? $hr : '' ?>">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Qualification|Classification</label>
					<input type="hour" class="form-control form-control-sm" name="qc" value="<?php echo isset($qc) ? $qc : '' ?>">
				</div>
			</div>
          	<div class="col-md-6">
				<div class="form-group">
					<label for="">Status</label>
					<select name="status" id="status" class="custom-select custom-select-sm">
						<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
						<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>On-Hold</option>
						<option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Done</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Date début</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("d/m/Y",strtotime($start_date)) : '' ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Date limite</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" value="<?php echo isset($end_date) ? date("d/m/Y",strtotime($end_date)) : '' ?>">
            </div>
          </div>
		</div>
        <div class="row">
        	<?php if($_SESSION['login_type'] == 1 ): ?>
           <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Project Manager</label>
              <select class="form-control form-control-sm select2" name="manager_id">
              	<option></option>
              	<?php 
              	$managers = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 2 order by concat(firstname,' ',lastname) asc ");
              	while($row= $managers->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php echo isset($manager_id) && $manager_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
          </div>
      <?php else: ?>
      	<input type="hidden" name="manager_id" value="<?php echo $_SESSION['login_id'] ?>">
      <?php endif; ?>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Project Team Members</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">
              	<option></option>
              	<?php 
              	$employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
              	while($row= $employees->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<label for="" class="control-label">Objet</label>
					<textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($description) ? $description : '' ?>
					</textarea>
				</div>
			</div>
		</div>
        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-info mx-2" form="manage-project">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>
    		</div>
    	</div>
	</div>
</div>
<script>
	$('#manage-project').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_project',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=project_list'
					},2000)
				}
			}
		})
	})
</script>