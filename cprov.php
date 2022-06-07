<?php
include_once('db_connect.php');

require('fpdf.php');


  
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

        $description=$project_list['description'];
        $desc=utf8_encode($description);
       
        


        $org_lst = $conn->query("SELECT * FROM org WHERE id=$org_id");  
        $org = $org_lst->fetch_assoc(); 

        $name=$org['name'];
        $name_s=str_replace("&amp;#x2019;","'",$name);

  


    

class PDF extends FPDF
{
// En-tête
function Header()
{
    // Logo
    $this->Image('logo.png',10,6,30);
 
    
    // Saut de ligne
    $this->Ln(25);
}

// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-22);
    // Police Arial italique 8
    $this->SetFont('Arial','I',6);
    // Numéro de page
    $footer=('MENARA TOOLS
Siège Social:158, Av. Aviateur Bourgadam La Villette étg. 3, Casablanca. Capital : 100 000, 00 Dh RC: CASA N°336029 Patente: 34292386 IF: 15284214 CNSS: 4615889 ICE: 000260582000084 TEL: 05 20 52 36 06 Fax: 05 20 98 89 80 GSM:+212 660-154300 E-mail:rabii.elkhadiri@menaratools.com');
    $footer=utf8_decode($footer);
    $this->multicell(0,5,$footer,'L');
}
}

       

   
// Instanciation de la classe dérivée

$pdf = new PDF();
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
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252','-Une ' .$task. ' de : '.$mntn));
$pdf->SetX(80);
$pdf->SetFont('Times', 'B', 12);
//// to modify MONTANT
/*$pdf->Cell(0,10,iconv('UTF-8','windows-1252',$mt_prov.'Dhs (neuf Mille Dirhams).'));*/
$pdf->Ln(10);
$pdf->SetX(33);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252','-Objet du marché :'));
$pdf->SetX(66);
$pdf->SetFont('Times', 'B', 12);
//// to modify OBJET
$pdf->multiCell(0,10,iconv('UTF-8', 'windows-1252',' '.$desc));
$pdf->Ln(0);
$pdf->SetX(33);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252','-Date de limite : '.$end_date));
$pdf->SetX(62);
//// to modify HEURE
$pdf->SetFont('Times', 'B', 12);
//$pdf->multiCell(0,10,iconv('UTF-8', 'windows-1252','le '.$dt_lmt. 'à 11H00.'));
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


 
?>