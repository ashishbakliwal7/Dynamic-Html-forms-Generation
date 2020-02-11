<?php
class viewdatamodel extends CI_Model{
    

    public function view_data($formdata,$formname,$type){
    //$formname = "dynamicform".date('YmdHis');
    $today = date('Y-m-d H:i:s');
    $status = 1;

    $query="INSERT INTO `form_dynamic_create_json`(`form_name`, `form_json_data`, `status`, `formtype`, `created_at`, `modified_at`) VALUES('$formname','$formdata',$status, $type,'$today','$today')";
    
    $this->db->query($query);
    $insert_id = $this->db->insert_id();

    return  $insert_id;
    
    }
    
    
    


}
?>