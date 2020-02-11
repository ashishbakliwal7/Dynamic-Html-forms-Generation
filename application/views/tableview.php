<html>
<head>
<title>Display records</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
 
<body>
<?php 

for ( $i =0; $i < count($data); $i++){
   $jsontable = $data->form_json_data;
   
}
?>
<div class = "row" style = "padding : 50px">
<form id="fb-render" style="width: 500;"></form>
<button class = "btn btn-primary" type="button" id="get-user-data">Submit formData</button>
<button class = "btn btn-primary" onclick="window.location.href = '/dynamicform/index.php/form/displayformbutton'">Goto Form Listing</button>
</div>

  <div id="markup"></div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
  <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
  <script>

const originalFormData = <?php echo $jsontable ?>;
const id = <?php echo $id ?>;
const getUserDataBtn = document.getElementById("get-user-data");
const fbRender = document.getElementById("fb-render");
jQuery(function($) {
  const formData = JSON.stringify(originalFormData);

  $(fbRender).formRender({ formData });
  getUserDataBtn.addEventListener(
    "click",
    () => {
     var getFormData=$(fbRender).formRender("userData");
      $.ajax({
    type: "POST",
    url: 'saveuserdata',
    data: {data : getFormData, id : id},
    success: function(response) {
        alert("Saved"+response);
        console.log(response);
    }
    });
   window.location = "/dynamicform/index.php/form/listing?id="+id;
    },
    false
  );
  
});
</script>
</body>
