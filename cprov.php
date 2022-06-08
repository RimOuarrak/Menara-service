<?php
include_once('db_connect.php');

require('html2pdf.php');
 
        $database = $conn;

        $id = $_GET['id'];
        
        $task_lst = $conn->query("SELECT * FROM task_list WHERE id=$id");  
        $task_list = $task_lst->fetch_assoc();         
        $task=$task_list['task'];
        $bq_name=$task_list['bq_name'];
        $agence=$task_list['agence'];
        $project_id=$task_list['project_id'];
        $mntn=$task_list['mntn'];

        $project_lst = $conn->query("SELECT * FROM project_list WHERE id=$project_id");  
        $project_list = $project_lst->fetch_assoc();        
        $num_offr=$project_list['num_offr'];
        $org_id=$project_list['org_id'];
        $ville=$project_list['ville'];
        $end_date=$project_list['end_date'];
        $hr=$project_list['hr'];
        $description=$project_list['description'];
        $dec=str_replace("&amp;#x2019;","'",$description);
        $desc=utf8_decode(html_entity_decode($dec));

        $org_lst = $conn->query("SELECT * FROM org WHERE id=$org_id");  
        $org = $org_lst->fetch_assoc(); 
        $name=$org['name'];
        $name_s=str_replace("&amp;#x2019;","'",$name);

    
// Instanciation de la classe dérivée
$pdf=new PDF_html();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetX(23);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252', 'A Monsieur le Directeur d’'.$bq_name));
$pdf->Ln(6);
$pdf->SetX(70);
$pdf->Cell(0,10,''.$agence);
$pdf->Ln(25);
$pdf->SetX(23);
$pdf->SetFont('Times', 'bu', 12);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252','Objet: '));
$pdf->SetX(36);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252','Demande de '.$task.' AO N° '.$num_offr));
$pdf->SetX(90);
$pdf->Ln(15);
$pdf->SetX(23);
$pdf->SetFont('Times', '', 12);
$pdf->multiCell(0,10,iconv('UTF-8', 'windows-1252','Nous vous prions à fournir à la La Sous-Direction Régionale auprès de la '.$name_s.' de '.$ville.' , sous notre pleine et entière responsabilité à votre égard une caution rédigée dans les termes suivants :'));
$pdf->Ln(10);
$pdf->SetX(33);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252','-Une ' .$task. ' de : '.$mntn.' dhs .'));
$pdf->SetX(80);
$pdf->SetFont('Times', 'B', 12);
$pdf->Ln(10);
$pdf->SetX(33);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252','-Date de limite :  le '.$end_date.' .'));
$pdf->SetX(62);
$pdf->SetX(88);
$pdf->SetFont('Times', '', 12);
$pdf->multiCell(0,10,iconv('UTF-8', 'windows-1252',' à  '.$hr.' .'));
$pdf->SetX(33);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252','-Objet du marché :'));
$pdf->SetX(66);
$pdf->SetFont('Times','B',12);
$pdf->Multicell(0,10,$pdf->WriteHTML($desc));
$pdf->Ln(10);
$pdf->SetX(23);
$pdf->SetFont('Times', '', 12);
$pdf->multiCell(0,10,iconv('UTF-8', 'windows-1252','Nous vous autorisons à constituer par le débit de notre compte toute provision que vous jugez utile pour couvrir le montant de ce cautionnement.
Veuillez agréer Monsieur nos salutations distinguées.'));
$pdf->Ln(10);
$pdf->SetY(252);
$pdf->SetX(-65);
$pdf->SetFont('Times', '', 12);
date_default_timezone_set('UTC');
$currentdate = date("d/m/Y");
$pdf->Cell(0,10,'Casablanca le '.$currentdate,0,0,'C');
$pdf->Output();
$pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
?>