<!DOCTYPE html>
<html>
   <head>
     <title>Import Data From Excel or CSV File to Mysql using PHPSpreadsheet</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
   </head>
   <body>
     <div class="container">
      <br />
      <h3 align="center">Choisissez le fichier puis importez le</h3>
      <br />
        <div class="panel panel-default">
           <span id="message"></span>
              <form method="post" id="import2_excel_form" enctype="multipart/form-data">
                <table class="table">
                  <tr>
                    <td width="80%"><input type="file" class="btn btn-flat  bg-gradient-primary mx-2" name="import2_excel" /></td>
                    <td width="50%"><input type="submit" name="import2" id="import2" class="btn btn-flat  bg-gradient-primary mx-2" value="Importer" /></td>
                  </tr>
                </table>
              </form>
           <br />
              
          </div>
          </div>
        </div>
     </div>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
     <script src="./js/ExceltoMysql2.js"></script>
  </body>
</html>