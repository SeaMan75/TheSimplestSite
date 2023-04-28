$( document ).ready(function() {
    $("#button_reg").click(
    function(){
      sendAjaxForm();
      return false;
    }
  );
});

function sendAjaxForm() {
  //alert("wervvg");
    $.ajax({
        url:     "register.php", 
        type:     "POST", 
        dataType: "html", 
        data: $('#ajax_reg_form').serialize(),  
        success: function(response) { 
          result = $.parseJSON(response);
          $('#result_reg_form').html(result.state);
      },
      error: function(response) { 
            $('#result_reg_form').html('Ошибка отправки данных');
      }
  });
}