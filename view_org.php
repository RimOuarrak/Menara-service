<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM org where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<dl>
		<dt><b class="border-bottom border-primary">Nom d'organisme</b></dt>
		<dd><?php echo ucwords(html_entity_decode($name)) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Email</b></dt>
		<dd><?php echo ucwords($email) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Numéro</b></dt>
		<dd><?php echo ucwords($num) ?></dd>
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