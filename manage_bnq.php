<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$bnq = $conn->query("SELECT * FROM bnq where id =".$_GET['id']);
foreach($bnq->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-bnq">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="nom">Nom de la banque</label>
			<input type="text" name="nom" id="nom" class="form-control" value="<?php echo isset($meta['nom']) ? $meta['nom']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="num">Email</label>
			<input type="text" name="num" id="num" class="form-control" value="<?php echo isset($meta['num']) ? $meta['num']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="contact">Numéro</label>
			<input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['contact']) ? $meta['contact']: '' ?>" required>
		</div>
		
	</form>
</div>

<script>

	$('#manage-bnq').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_bnq',
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
					$('#msg').html('<div class="alert alert-danger">Cette banque existe déjà</div>')
					end_load()
				}
			}
		})
	})

</script>