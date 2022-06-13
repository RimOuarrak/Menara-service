<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-info">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-warning" href="./index.php?page=new_bnq"><i class="fa fa-plus"></i> Ajouter une banque</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Nom</th>
						<th>Numéro</th>
						<th>Contact</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM bnq order by nom asc");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo  html_entity_decode($row['nom']) ?></b></td>
						<td><b><?php echo $row['num'] ?></b></td>
						<td><b><?php echo $row['contact'] ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_bnq" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Consulter</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_bnq&id=<?php echo $row['id'] ?>">Modifier</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_bnq" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Supprimer</a>
		                    </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	$('.view_bnq').click(function(){
		uni_modal("<i class='fa fa-id-card'></i> Bank Details","view_bnq.php?id="+$(this).attr('data-id'))
	})
	$('.delete_bnq').click(function(){
	_conf("Voulez vous vraiment supprimer cette banque?","delete_bnq",[$(this).attr('data-id')])
	})
	})
	function delete_bnq($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_bnq',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>