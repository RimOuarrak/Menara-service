<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM bnq where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<dl>
		<dt><b class="border-bottom border-primary">Nom de la banque</b></dt>
		<dd><?php echo ucwords(html_entity_decode($nom)) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Numéro</b></dt>
		<dd><?php echo ucwords($num) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Contact</b></dt>
		<dd><?php echo ucwords($contact) ?></dd>
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