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
  <script></script>
      </head>
      <body>
   <br><?php echo $error; ?>
  
   <?php echo form_open_multipart(base_url('/dynamicform/index.php/form/excelTOJson')); ?>
   <div class="form-group" style = "padding-left : 50px; padding-right :1000px">
   <label class="form-group" for="file">Upload Excel file:</label>
   <input type="file" class="form-control" name="userfile" size="20" />
   <br /><br />
   <input type="submit" name = "submit" class = "btn btn-primary" value="upload" />
   <a href="/dynamicform/" class="btn btn-primary">Dynamic form</button></a>
   <a href="/dynamicform/index.php/form/displayformbutton" class="btn btn-primary">Goto listing</a>
   </form>
   </body>
</div>
      </body>
