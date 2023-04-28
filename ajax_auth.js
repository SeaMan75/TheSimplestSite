
$( document ).ready(function() {
    $("#auth_button").click(
    function(){
      sendAjaxForm();
      return false;
    }
  );
});

function sendAjaxForm() {
  $.ajax({
        url:     "login.php", 
        type:     "POST", 
        dataType: "html", 
        data: $("#ajax_auth_form").serialize(),  
        success: function(response) {
          result = $.parseJSON(response);
          $('#result_auth_form').html(result.state);
      },
      error: function(response) { 
            $('#result_auth_form').html('Ошибка. Данные не отправлены.');
      }
  });
}