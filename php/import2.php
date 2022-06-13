<?php

//import.php

include '../vendor/autoload.php';

$connect = new PDO("mysql:host=localhost;dbname=tms_db", "root", "");

if($_FILES["import2_excel"]["name"] != '')
{
 $allowed_extension = array('xls', 'csv', 'xlsx');
 $file_array = explode(".", $_FILES["import2_excel"]["name"]);
 $file_extension = end($file_array);

 if(in_array($file_extension, $allowed_extension))
 {
  $file_name = time() . '.' . $file_extension;
  move_uploaded_file($_FILES['import2_excel']['tmp_name'], $file_name);
  $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

  $spreadsheet = $reader->load($file_name);

  unlink($file_name);

  $data = $spreadsheet->getActiveSheet()->toArray();
////
$data = array();

foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
    $worksheetTitle = $worksheet->getTitle();
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    for ($row = 1; $row <= $highestRow; ++$row) {
        for ($col = 0; $col <= $highestColumnIndex; ++$col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
            $data[$row][$col] = $val;
        }
    }
}

unset($data[1]); // SKIP HEADER

  foreach($data as $row)
  {
    $insert_data = array(
  
      ':num_ordr'  => $row[1],
      ':num_offr'  => $row[2],
      ':name' =>$row[3],
      ':description'  => $row[4],
      ':ctn'  => $row[5],
      ':est'  => $row[6],
      ':est_min'  => $row[7],
      ':est_max'  => $row[8],
      ':ville'  => $row[9],
      ':end_date'  => $row[10],
      ':hr'  => $row[11],
      ':qc'  => $row[12],
     );
    
    
     $query = "
     INSERT IGNORE INTO org (name) 
     VALUES (:name);
     INSERT INTO project_list (description, end_date, num_ordr, num_offr, ctn, est, est_min, est_max, ville, hr, qc) 
     VALUES (:description, TO_DATE(:end_date , :num_ordr, :num_offr, :ctn, :est, :est_min, :est_max, :ville, :hr, :qc)
     ";

   $statement = $connect->prepare($query);
   $result = $statement->execute($insert_data);
  }
    if ($result == 1) {
      $message = '<div class="alert alert-success">Les données sont importés avec succé</div>';
    } else {
      $message = '<div class="alert alert-danger">An error occurred when uploading the data to the DB.</div>';
    }

 }
 else
 {
  $message = '<div class="alert alert-danger">Only .xls .csv or .xlsx file allowed</div>';
 }
}
else
{
 $message = '<div class="alert alert-danger">Please Select File</div>';
}

echo $message;

?>