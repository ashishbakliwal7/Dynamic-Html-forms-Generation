<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
	<script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
	<script>
  
  jQuery(function($) {
var fbEditor = document.getElementById('fb-editor');

		var options = {
		showActionButtons: false,
		disableFields: [
		'button',
		'file',
		'paragraph',
		'hidden'
		]
};

var formBuilder = $(fbEditor).formBuilder(options);

document.getElementById('getJSON').addEventListener('click', function() {
var jsonData = formBuilder.actions.getData('json');
var formData = jsonData,
  formRenderOpts = {
	dataType: 'json',
	formData: formData
  };
var renderedForm = $('<div>');
renderedForm.formRender(formRenderOpts);
var form_name = document.getElementById('form_name').value;
//console.log(jsonData);
if (form_name == "") {
    alert("Name must be filled out");
    return false;
  }
  else
  {
 var type = 2;
	$.ajax({

		type: "POST",
		url: "index.php/form/loadView",
		data: {data : jsonData,form_name : form_name,type : type},
		// dataType : "JSON",
		success: function(response) {
				alert(response);
				console.log(jsonData);
		}
	});
  }

window.location = "/dynamicform/";
});

document.getElementById('goTOForm').addEventListener('click', function() {
window.location = "/dynamicform/index.php/form/displayformbutton";
});

document.getElementById('goTOExcelForm').addEventListener('click', function() {
window.location = "/dynamicform/index.php/form/excelTojson";
});

});

</script>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>
	

  <div class="row" id="fb-editor" style = "padding : 50px">
  
      <label for="usr">Form Name:</label>
	  <input type="text" id="form_name" name="formName" class="form-control" id="usr">
	  <br>

</div>

  <div class="setDataWrap">

		<center><button class="btn btn-primary" id="getJSON" type="button">Save Form</button>
		<button class="btn btn-primary" id="goTOForm" type="button">Goto Forms list</button>
		<button class="btn btn-primary" id="goTOExcelForm" type="button">Generate from Excel </button>
	</center>

      </div>
  <div id="markup"></div>



</body>
</html>