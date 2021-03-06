<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-info">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-warning" href="./index.php?page=new_project"><i class="fa fa-plus"></i> Ajouter un marché </a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Project</th>
						<th>Caution</th>
						<th>Agence</th>
						<th>Montant</th>
						<th>Project Started</th>
						<th>Project Due Date</th>
						<th>Project Status</th>
						<th>Status de caution</th>
						<th>La demande</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$where = "";
					if($_SESSION['login_type'] == 2){
						$where = " where p.manager_id = '{$_SESSION['login_id']}' ";
					}elseif($_SESSION['login_type'] == 3){
						$where = " where concat('[',REPLACE(p.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
					}
					
					$stat = array("Récupéré","Started","En préparation","On-Hold","Over Due","Déposé");
					$qry = $conn->query("SELECT t.*,p.org_id as pname,p.start_date,p.status as pstatus, p.end_date,p.id as pid FROM task_list t inner join project_list p on p.id = t.project_id $where order by p.name asc");
					while($row= $qry->fetch_assoc()):
						$org = $conn->query("SELECT *,name FROM org where id = " . $row['pname']);
						$org = $org->num_rows > 0 ? $org->fetch_array() : array();
						
						
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['description']),$trans);
						$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
						$tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['pid']}")->num_rows;						
		                $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['pid']} and status = 3")->num_rows;
						$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
		                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
		                $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['pid']}")->num_rows;
		                if($row['pstatus'] == 0 && strtotime(date('d/m/Y')) >= strtotime($row['start_date'])):
		                if($prod  > 0  || $cprog > 0)
		                  $row['pstatus'] = 2;
		                else
		                  $row['pstatus'] = 1;
		                elseif($row['pstatus'] == 0 && strtotime(date('d/m/Y')) > strtotime($row['end_date'])):
		                $row['pstatus'] = 4;
		                endif;


					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td><b><?php if(isset($org['id'])) : ?>
									<div class="d-flex align-items-center mt-1">
										<b><?php echo ucwords(html_entity_decode($org['name'])) ?></b>
									</div>
									<?php else: ?>
										<small><i>Organism Deleted from Database</i></small>
									<?php endif; ?>
								</b>
						</td>
						<td>
							<p><b><?php echo ucwords($row['task']) ?></b></p>
							<p class="truncate"><?php echo strip_tags($desc) ?></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['agence']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['mntn']) ?></b></p>
						</td>
						<td><b><?php echo date("d/m/Y",strtotime($row['start_date'])) ?></b></td>
						<td><b><?php echo date("d/m/Y",strtotime($row['end_date'])) ?></b></td>
						<td class="text-center">
							<?php
							  if($stat[$row['pstatus']] =='Récupéré'){
							  	echo "<span class='badge badge-secondary'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='Started'){
							  	echo "<span class='badge badge-primary'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='En préparation'){
							  	echo "<span class='badge badge-info'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='On-Hold'){
							  	echo "<span class='badge badge-warning'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='Over Due'){
							  	echo "<span class='badge badge-danger'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='Déposé'){
							  	echo "<span class='badge badge-success'>{$stat[$row['pstatus']]}</span>";
							  }
							?>
						</td>
						<td>
                        	<?php 
                        	if($row['status'] == 1){
						  		echo "<span class='badge badge-secondary'>Récupéré</span>";
                        	}elseif($row['status'] == 2){
						  		echo "<span class='badge badge-primary'>En préparation</span>";
                        	}elseif($row['status'] == 3){
						  		echo "<span class='badge badge-success'>Déposé</span>";
                        	}
                        	?>
                        </td>
						<form method="POST" action="cprov.php">
						<td class="text-center">
							<a type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info " aria-expanded="true" data-pid = '<?php echo $row['pid'] ?>' data-tid = '<?php echo $row['id'] ?>'  data-task = '<?php echo ucwords($row['task']) ?>'  target="_blank" href="cprov.php?id=<?php echo $row['id'] ?>">
		                      pdf
		                    </a>
			                    
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	$('.new_productivity').click(function(){
		uni_modal("<i class='fa fa-plus'></i> New Progress for: "+$(this).attr('data-task'),"manage_progress.php?pid="+$(this).attr('data-pid')+"&tid="+$(this).attr('data-tid'),'large')
	})
	})
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_project',
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