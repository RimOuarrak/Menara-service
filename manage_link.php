<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM task_list where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$meta[$k] = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-link" >
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="form-group">
			<label for="" class="control-label">Nom</label>
			<input type="text" name="nom" id="nom" class="form-control" value="<?php echo isset($meta['nom']) ? $meta['nom']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="name">Le lien</label>
			<input type="text" name="link" id="link" class="form-control" value="<?php echo isset($meta['link']) ? $meta['link']: '' ?>" required>
		</div>
	</form>
</div>

<script>
    
    $('#manage-link').submit(function(e){
    	e.preventDefault()
    	start_load()
    	$.ajax({
    		url:'ajax.php?action=save_link',
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
						location.reload()
					},1500)
				}
			}
    	})
    })
</script>