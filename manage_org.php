<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$org = $conn->query("SELECT * FROM org where id =".$_GET['id']);
foreach($org->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-org">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Nom d'organisme</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="name">Numéro</label>
			<input type="text" name="num" id="num" class="form-control" value="<?php echo isset($meta['num']) ? $meta['num']: '' ?>" required>
		</div>
		
	</form>
</div>

<script>

	$('#manage-org').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_org',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Organism already exist</div>')
					end_load()
				}
			}
		})
	})

</script>