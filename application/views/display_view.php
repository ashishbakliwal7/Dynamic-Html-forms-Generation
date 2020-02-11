<html>
<head>
<title>Display records</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
 
<body>
  <br>
  <center><button class = "btn btn-primary" onclick="window.location.href = '/dynamicform'">Create form</button></center>

  <div class = "row"  style = "padding : 50px">

  <table class = "table table-hover">
  <tr style="background:#CCC">
    <th>Sr.no</th>
    <th>Table name</th>
    <th>view</th>
    <th>view data</th>
  </tr>
  <?php
  $i=1;
  foreach($data as $row)
  {
      echo "<tr>";
      echo "<td>".$i."</td>";
      echo "<td>".$row->form_name."</td>";
      echo "<td><a href='displayform?id=".$row->form_id."'>View</a></td>";
      echo "<td><a href='listing?id=".$row->form_id."'>View values</a></td>";
      echo "</tr>";
      $i++;
  }
   ?>
</table>
</div>
