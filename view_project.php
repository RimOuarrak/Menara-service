<?php
include 'db_connect.php';
$stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
$qry = $conn->query("SELECT * FROM project_list where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
$tprog = $conn->query("SELECT * FROM task_list where project_id = {$id}")->num_rows;
$cprog = $conn->query("SELECT * FROM task_list where project_id = {$id} and status = 3")->num_rows;
$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
$prog = $prog > 0 ?  number_format($prog,2) : $prog;
$prod = $conn->query("SELECT * FROM user_productivity where project_id = {$id}")->num_rows;
if($status == 0 && strtotime(date('d-m-y')) >= strtotime($start_date)):
if($prod  > 0  || $cprog > 0)
  $status = 2;
else
  $status = 1;
elseif($status == 0 && strtotime(date('d-m-y')) > strtotime($end_date)):
$status = 4;
endif;
$manager = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id = $manager_id");
$manager = $manager->num_rows > 0 ? $manager->fetch_array() : array();
$org = $conn->query("SELECT *,name FROM org where id = $org_id");
$org = $org->num_rows > 0 ? $org->fetch_array() : array();
?>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-12">
			<div class="callout callout-info">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<dl>
								<dt><b class="border-bottom border-primary">N°ordre</b></dt>
								<dd><?php echo $num_ordr ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">N° d’Appel d’Offre</b></dt>
								<dd><?php echo $num_offr ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Organisme</b></dt>
								<dd>
									<?php if(isset($org['id'])) : ?>
									<div class="d-flex align-items-center mt-1">
										<b><?php echo ucwords(html_entity_decode($org['name'])) ?></b>
									</div>
									<?php else: ?>
										<small><i>Organism Deleted from Database</i></small>
									<?php endif; ?>
								</dd>
								<dl>
								<dt><b class="border-bottom border-primary">Ville</b></dt>
								<dd><?php echo $ville ?></dd>
								</dl>						
								<dt><b class="border-bottom border-primary">Objet</b></dt>
								<dd><?php echo html_entity_decode($description) ?></dd>
							</dl>
							
						</div>
						<div class="col-md-6">
							<dl>
								<dt><b class="border-bottom border-primary">Caution</b></dt>
								<dd><?php echo $ctn ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Estimation</b></dt>
								<dd><?php echo $est ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Estimation min</b></dt>
								<dd><?php echo $est_min ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Estimation max</b></dt>
								<dd><?php echo $est_max ?></dd>
							</dl>
							
							<dl>
								<dt><b class="border-bottom border-primary">Date début</b></dt>
								<dd><?php echo date("F d, Y",strtotime($start_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Date fin</b></dt>
								<dd><?php echo date("F d, Y",strtotime($end_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Heure</b></dt>
								<dd><?php echo $hr ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Qualification|Classification</b></dt>
								<dd><?php echo $qc ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Status</b></dt>
								<dd>
									<?php
									  if($stat[$status] =='Pending'){
									  	echo "<span class='badge badge-secondary'>{$stat[$status]}</span>";
									  }elseif($stat[$status] =='Started'){
									  	echo "<span class='badge badge-primary'>{$stat[$status]}</span>";
									  }elseif($stat[$status] =='On-Progress'){
									  	echo "<span class='badge badge-info'>{$stat[$status]}</span>";
									  }elseif($stat[$status] =='On-Hold'){
									  	echo "<span class='badge badge-warning'>{$stat[$status]}</span>";
									  }elseif($stat[$status] =='Over Due'){
									  	echo "<span class='badge badge-danger'>{$stat[$status]}</span>";
									  }elseif($stat[$status] =='Done'){
									  	echo "<span class='badge badge-success'>{$stat[$status]}</span>";
									  }
									?>
								</dd>
							</dl>		
							<dl>
								<dt><b class="border-bottom border-primary">Project Manager</b></dt>
								<dd>
									<?php if(isset($manager['id'])) : ?>
									<div class="d-flex align-items-center mt-1">
										<img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="assets/uploads/<?php echo $manager['avatar'] ?>" alt="Avatar">
										<b><?php echo ucwords($manager['name']) ?></b>
									</div>
									<?php else: ?>
										<small><i>Manager Deleted from Database</i></small>
									<?php endif; ?>
								</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		
		<div class="col-md-12">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<span><b>Suivie des cautions:</b></span>
					<?php if($_SESSION['login_type'] != 3): ?>
					<div class="card-tools">
						<button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_task"><i class="fa fa-plus"></i> Ajouter une caution</button>
					</div>
				<?php endif; ?>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
					<table class="table table-condensed m-0 table-hover">
						<colgroup>
							<col width="5%">
							<col width="25%">
							<col width="30%">
							<col width="15%">
							<col width="15%">
						</colgroup>
						<thead>
							<th>#</th>
							<th>Cautions</th>
							<th>Banque</th>
							<th>Description</th>
							<th>Status</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							$tasks = $conn->query("SELECT * FROM task_list where project_id = {$id} order by task asc");
							while($row=$tasks->fetch_assoc()):
								$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
								unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
								$desc = strtr(html_entity_decode($row['description']),$trans);
								$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
							?>
								<tr>
			                        <td class="text-center"><?php echo $i++ ?></td>
			                        <td class=""><b><?php echo ucwords($row['task']) ?></b></td>
									<td class=""><b><?php echo ucwords($row['bq_name']) ?></b></td>
			                        <td class=""><p class="truncate"><?php echo strip_tags($desc) ?></p></td>
			                        <td>
			                        	<?php 
			                        	if($row['status'] == 1){
									  		echo "<span class='badge badge-secondary'>Pending</span>";
			                        	}elseif($row['status'] == 2){
									  		echo "<span class='badge badge-primary'>On-Progress</span>";
			                        	}elseif($row['status'] == 3){
									  		echo "<span class='badge badge-success'>Done</span>";
			                        	}
			                        	?>
			                        </td>
			                        <td class="text-center">
										<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
					                      Action
					                    </button>
					                    <div class="dropdown-menu" style="">
					                      <a class="dropdown-item view_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"  data-task="<?php echo $row['task'] ?>">View</a>
					                      <div class="dropdown-divider"></div>
					                      <?php if($_SESSION['login_type'] != 3): ?>
					                      <a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"  data-task="<?php echo $row['task'] ?>">Edit</a>
					                      <div class="dropdown-divider"></div>
					                      <a class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
										  <div class="dropdown-divider"></div>
										  <a class="dropdown-item fichier" data-pid = '<?php echo $row['pid'] ?>' data-tid = '<?php echo $row['id'] ?>'  data-task = '<?php echo ucwords($row['task']) ?>'  target="_blank" href="cprov.php?id=<?php echo $row['id'] ?> ">PDF</a>
					                  <?php endif; ?>
					                    </div>
									</td>
		                    	</tr>
							<?php 
							endwhile;
							?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<span><b>Les liens:</b></span>
					<?php if($_SESSION['login_type'] != 3): ?>
					<div class="card-tools">
						<button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_link"><i class="fa fa-plus"></i> Ajouter une lien</button>
					</div>
				<?php endif; ?>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
					<table class="table table-condensed m-0">
						<colgroup>
							<col width="85%">							
							<col width="15%">
						</colgroup>
						<tbody>
							<?php 
							$i = 1;
							$links = $conn->query("SELECT * FROM docs where project_id = {$id} order by nom asc");
							while($row=$links->fetch_assoc()):
							?>
								<tr>
								<td><a href="<?php echo ucwords($row['link'])?>" target="_blank" class="link-black text-sm"><i class="fas fa-link mr-1"></i><?php echo ucwords($row['nom'])?></a></td>			                        
			                        <td class="text-center">
										<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
					                      Action
					                    </button>
					                    <div class="dropdown-menu" style="">
					                      <?php if($_SESSION['login_type'] != 3): ?>
					                      <a class="dropdown-item edit_link" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"  data-link="<?php echo $row['nom'] ?>">Edit</a>
					                      <div class="dropdown-divider"></div>
					                      <a class="dropdown-item delete_link" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
					                  <?php endif; ?>
					                    </div>
									</td>
		                    	</tr>
							<?php 
							endwhile;
							?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	
<style>

	.truncate {
		-webkit-line-clamp:1 !important;
	}
</style>
<script>
	$('#new_task').click(function(){
		uni_modal("Ajouter une caution pour <?php echo ucwords(html_entity_decode($org['name'])) ?>","manage_task.php?pid=<?php echo $id ?>","mid-large")
	})
	$('.edit_task').click(function(){
		uni_modal("Modification de caution: "+$(this).attr('data-task'),"manage_task.php?pid=<?php echo $id ?>&id="+$(this).attr('data-id'),"mid-large")
	})
	$('.delete_task').click(function(){
		_conf("Voulez vous vraiment supprimer cette caution?","delete_task",[$(this).attr('data-id')])
	})
	$('.view_task').click(function(){
		uni_modal("Détails de la caution","view_task.php?id="+$(this).attr('data-id'),"mid-large")
	})

	$('#new_link').click(function(){
		uni_modal("Ajouter un lien pour <?php echo ucwords(html_entity_decode($org['name'])) ?>","manage_link.php?pid=<?php echo $id ?>","mid-large")
	})
	$('.edit_link').click(function(){
		uni_modal("Modification du lien "+$(this).attr('data-link'),"manage_link.php?pid=<?php echo $id ?>&id="+$(this).attr('data-id'),"mid-large")
	})
	$('.delete_link').click(function(){
		_conf("Voulez vous vraiment supprimer cette caution?","delete_link",[$(this).attr('data-id')])
	})

	$('#ajt_fichier').click(function(){
		uni_modal("<i class='fa fa-plus'></i> Fichiers","manage_progress.php?pid=<?php echo $id ?>",'large')
	})
	$('.manage_progress').click(function(){
		uni_modal("<i class='fa fa-edit'></i> Edit Progress","manage_progress.php?pid=<?php echo $id ?>&id="+$(this).attr('data-id'),'large')
	})
	
	$('.spr_fichier').click(function(){
	_conf("Are you sure to delete this progress?","spr_fichier",[$(this).attr('data-id')])
	})
	function spr_fichier($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=spr_fichier',
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
	function delete_task($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_task',
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
	function delete_link($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_link',
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