<html>
<head>
    <title>Example formBuilder</title>
</head>
<body>

   <div class = "row" style = "padding : 50px; padding-right :1000px">
   <label for="usr">Form Name:</label>
	  <input type="text" id="form_name" name="formName" class="form-control" id="usr">
	  <br>
  <form id="fb-render">
 
  </form>
  
  <button class = "btn btn-primary"type="button" id="get-user-data">Submit fields</button>
  
</div>

  <div id="markup"></div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
  <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
  <script>

const originalFormData = [<?php echo $row; ?>];

console.log(<?php print_r($row) ?>);

const getUserDataBtn = document.getElementById("get-user-data");
const fbRender = document.getElementById("fb-render");
jQuery(function($) {
    var form_name = document.getElementById('form_name').value;
  const formData = JSON.stringify(originalFormData);

  $(fbRender).formRender({ formData });
    getUserDataBtn.addEventListener(
    "click",
  () => {
   var getFormData=$(fbRender).formRender("userData");
   var form_name = document.getElementById('form_name').value;
    if (form_name == "") {
    alert("Name must be filled out");
    return false;
  }
  else
  {
   console.log($(fbRender).formRender("userData"));
   var type = 1;
    $.ajax({

type: "POST",
url: "loadView",
data: {data : formData, form_name : form_name, type : type},
// dataType : "JSON",
success: function(response) {
   window.location = "/dynamicform/index.php/form/displayform?id="+response;
}
});
  }
    },
    false
  );
  
});

</script>


</body>
</html>