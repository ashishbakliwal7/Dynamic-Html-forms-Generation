<html>
<head>
<title>Display records</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
  
</head>
 
<body>
  <br>
  <center><button class = "btn btn-primary" onclick="window.location.href = '/dynamicform'">Create form</button></center>

  <div class = "row"  style = "padding : 50px">

  <table id="example" class="table table-bordered table-striped">
  <thead>
  <tr style="background:#CCC">
    <th>Sr.no</th>
    <?php 
    $countFormFields = count($FormFields);
    echo "<th>Row id </th>";
    //echo "<th>ss id </th>";
    for($i=0;$i<$countFormFields;$i++){
    ?>
    <th><?= $FormFields[$i]['field_label']; ?></th>
    <?php } ?>
    
  </tr>
</thead>
</table>
<script>
 
 var table;
  
 $(document).ready(function() {
  
     //datatables
     table = $('#example').DataTable({ 
  
         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.
  
         // Load data for the table's content from an Ajax source
         "ajax": {
             "url": "ajax_list_formvalues",
             "type": "POST",
             "data" : function(post){
                    post.formid=<?= $formid; ?>;
             }
         },
  
         //Set column definition initialisation properties.
         "columnDefs": [
         { 
             "targets": [ 0 ], //first column / numbering column
             "orderable": false, //set not orderable
         },
         { 
             "targets": [ 1 ], //first column / numbering column
             "orderable": false, //set not orderable
            // "visible": false,
         },
        //  { 
        //      "targets": [ 3 ], //first column / numbering column
        //      "data": function ( row, type, val, meta ) {
        //        return '<a href=displayform?id='+row[1]+'>View form</a>'
        //      }
        //  },
        //  { 
        //      "targets": [ 4 ], //first column / numbering column
        //      "data": function ( row, type, val, meta ) {
        //        return '<a href=listing?id='+row[1]+'>View values</a>'
        //      }
        //  },
         ],
  
     });
  
 });
      </script>  
</div>
