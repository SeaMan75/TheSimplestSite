alert("wevefgv");
$( document ).ready(function() {
    $("#search_button").click(
    function(){
      alert("wevefgv");
      sendAjaxForm();
      return false;
    }
  );
});

function sendAjaxForm() {
    $.ajax({
        url:     "search.php", 
        type:     "POST", 
        dataType: "html", 
        data: $("#search_form").serialize(),  
        success: function(response) { 
          result = $.parseJSON(response);
          $('#search_result').html(result.search_result);
      },
      error: function(response) { 
            $('#search_result').html('Ошибка. Данные не отправлены.');
      }
  });
}