<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-org">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Nom d'organisme</label>
					<input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Numéro</label>
					<input type="text" class="form-control form-control-sm" name="num" value="<?php echo isset($num) ? $num : '' ?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">Email</label>
				<input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
				<small id="#msg"></small>
			</div>
			</div>
		</div>
        </form>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-org">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=org_list'">Cancel</button>
    		</div>
    	</div>
	</div>
</div>
<script>
	$('#manage-org').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_org',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=org_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>