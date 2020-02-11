<html>
<head>
<title>Display records</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
  <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>


<script>
var table;
 $(document).ready( function () {
    // $('#example').DataTable();
      table = $('#example').DataTable();


      $("#example").on('click','.delete',function() {
        //$("#modal-edit").modal("show");
        var tr=$(this).parents('tr')[0];
       // console.log(tr);
       // alert( 'The table has '+data.length+' records' );
        var data = table
        .row(tr)
        .data();
        var deleteformid = data[1];
        var deleterowid = data[2];
        $.ajax({
    type: "POST",
    url: 'deletedata',
    data: {deleteformid : deleteformid, deleterowid : deleterowid},
    success: function(response) {
        alert(response);
        console.log(response);
    }
    });

    window.location = "/dynamicform/index.php/form/listing?id="+deleteformid;
      });

   
      $("#example").on('click','.add',function() {
        $("#modal-edit").modal("show");
        var tr=$(this).parents('tr')[0];
       // console.log(tr);
       // alert( 'The table has '+data.length+' records' );
        var data = table
        .row(tr)
        .data();
          '<?php  $countFormFields = count($FormFields);
          for($i=0;$i<$countFormFields;$i++){
            $nameArr[] = $FormFields[$i]['field_name'];
            }?>'


            var nameArr = <?php echo json_encode($nameArr); ?>;
           console.log(nameArr);
            console.log(data);
        var i;
      //  var getrowid = data[2];
      $('#hiddenfield').val(data[2]);
        j = 3;
        for (i = 0; i < nameArr.length; i++) { 
          if(nameArr[i].match(/(^|\W)radio($|\W)/) && data[j] != "") 
          {
          $("input[name= " +nameArr[i]+ "][value=" + data[j] + "]").prop('checked', true); 
          }
          else if(nameArr[i].match(/(^|\W)checkbox($|\W)/)) 
          {
            //alert('cool1');
            if(data[j] == "")
            {
             // alert(nameArr[i]+'[]');
             $('#'+nameArr[i]+'-0').prop('checked', false);
            }
          }
          else{
          $("#fb-render #"+nameArr[i]).val(data[j]);
          }
          
          j++;
        }
      });


 } );



  </script>
</head>
 
<body>
<br>
<center><button class = "btn btn-primary" onclick="window.location.href = '/dynamicform/index.php/form/displayformbutton'">Goto Form Listing</button></center>
  <div class = "row" style = "padding : 50px">
  <table id="example" class="table table-bordered table-striped">
  <thead>
  <tr style="background:#CCC">
  
    <th>Sr.no</th>
    <th>form id</th>
    <?php 
    $countFormFields = count($FormFields);
    echo "<th>Row id </th>";
    for($i=0;$i<$countFormFields;$i++){
    ?>
    <th><?= $FormFields[$i]['field_label']; ?></th>
    <?php } ?>

    <th>edit</th>
  </tr>
    </thead>
  <?php
  for ( $i =0; $i < count($data); $i++){
    $jsontable = $data->form_json_data;
    
 }
  $sr=1;
  foreach($FormFieldsValue as $row)
  {


    echo "<tr>";
    echo "<td>".$sr."</td>";
    echo "<td>".$form_id."</td>";
    echo "<td>".$row["fv_row_id"]."</td>";
   // echo "<td>".$row["field_id"]."</td>";
    for($i=0,$char='a';$i<(count($row)-1);$i++,$char++){
    echo "<td>".$row[$char]."</td>";
  }
  
  echo "<td>";
  echo '<button type="button" class="btn btn-info add">Edit</button>';
  echo " ";
  echo '<button type="button" class="btn btn-danger delete">delete</button>';
  echo "</td>";
  $sr++;
  }
   ?>
   
</tr>
</table>
</div>
      
    </div>
  </div>

  <div class="modal fade" id = 'modal-edit' role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
      


    <div class = "row" style = "padding : 50px">
    <input type="hidden" name="hiddenfield" id="hiddenfield" value="">
    <form id="fb-render" style="width: 500;">
    
    </form>
    <button class = "btn btn-primary" type="button" id="get-user-data">update formData</button>
    </div>
  <script>

const originalFormData = <?php echo $jsontable?>;

const getUserDataBtn = document.getElementById("get-user-data");
const fbRender = document.getElementById("fb-render");
jQuery(function($) {
  const formData = JSON.stringify(originalFormData);
  const id = <?php echo $form_id ?>;
  $(fbRender).formRender({ formData });

  getUserDataBtn.addEventListener(
    "click",
    () => {
      var rowid = document.getElementById("hiddenfield").value;
     var getFormData=$(fbRender).formRender("userData");
      $.ajax({
    type: "POST",
    url: 'updateuserdata',
    data: {data : getFormData,id : id,rowid : rowid},
    success: function(response) {
        alert(response);
        console.log(response);
    }
    });
   window.location = "/dynamicform/index.php/form/listing?id="+id;
    },
    false
  );
  
});
</script>
  
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>
</body>
</html>