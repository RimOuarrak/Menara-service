<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM task_list where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-task">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="form-group">
			<label for="">titre de caution</label>
	
			<select name="task" class="form-control form-control-sm">
			<option value="Caution provisoire">Caution provisoire</option>
			<option value="Caution difinitive">Caution difinitive</option>
			</select>			
		</div>
		<div class="form-group">
			<label for="name">Nom de la banque</label>
			<input type="text" name="bq_name" id="bq_name" class="form-control" value="<?php echo isset($meta['bq_name']) ? $meta['bq_name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="name">Contact</label>
			<input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['contact']) ? $meta['contact']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="name">Montant du caution</label>
			<input type="text" name="mntn" id="mntn" class="form-control" value="<?php echo isset($meta['mntn']) ? $meta['mntn']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="">Status</label>
			<select name="status" id="status" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Récupéré</option>
				<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>En préparation</option>
				<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>Déposé</option>
			</select>
		</div>
		<div class="form-group">
			<label for="">Note</label>
			<textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
				<?php echo isset($description) ? $description : '' ?>
			</textarea>
		</div>
		
	</form>
</div>

<script>
	$(document).ready(function(){


	$('.summernote').summernote({
        height: 200,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    })
     })
    
    $('#manage-task').submit(function(e){
    	e.preventDefault()
    	start_load()
    	$.ajax({
    		url:'ajax.php?action=save_task',
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