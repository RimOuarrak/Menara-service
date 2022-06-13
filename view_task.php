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
	<dl>
		<dt><b class="border-bottom border-primary">Titre de caution</b></dt>
		<dd><?php echo ucwords($task) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Banque</b></dt>
		<dd><?php echo ucwords($bq_name) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Agence</b></dt>
		<dd><?php echo ucwords($agence) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Montant de caution</b></dt>
		<dd><?php echo ucwords($mntn) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Status</b></dt>
		<dd>
			<?php 
        	if($status == 1){
		  		echo "<span class='badge badge-secondary'>Récupéré</span>";
        	}elseif($status == 2){
		  		echo "<span class='badge badge-primary'>En péparation</span>";
        	}elseif($status == 3){
		  		echo "<span class='badge badge-success'>Déposé</span>";
        	}
        	?>
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Note</b></dt>
		<dd><?php echo html_entity_decode($description) ?></dd>
	</dl>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>