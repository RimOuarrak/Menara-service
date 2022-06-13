<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="card-header">			
		</div>
<div class="col-lg-12">
	<div class="card card-outline card-info">
		<div class="card-body">
			<form action="" id="manage-bnq">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Nom de la banque</label>
					<input type="text" class="form-control form-control-sm" name="nom" value="<?php echo isset($nom) ? $nom : '' ?>">
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
					<label for="" class="control-label">Contact</label>
					<input type="text" class="form-control form-control-sm" name="contact" value="<?php echo isset($contact) ? $contact : '' ?>">
				</div>
			</div>
			</div>
		</div>
        </form>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-info mx-2" form="manage-bnq">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=bnq_list'">Cancel</button>
    		</div>
    	</div>
	</div>
</div>
<script>
	$('#manage-bnq').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_bnq',
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
						location.replace('index.php?page=bnq_list')
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