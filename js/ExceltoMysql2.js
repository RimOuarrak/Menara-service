$(document).ready(function(){
  $('#import2_excel_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"./php/import2.php",
      method:"POST",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      beforeSend:function(){
        $('#import2').attr('disabled', 'disabled');
        $('#import2').val('Importing...');
      },
      success:function(data)
      {
        $('#message').html(data);
        $('#import2_excel_form')[0].reset();
        $('#import2').attr('disabled', false);
        $('#import2').val('Import2');
      }
    })
  });
});