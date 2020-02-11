<?php
class savemodel extends CI_Model 
{
    function savedata($id,$name,$label)
    {
        $today = date('Y-m-d H:i:s');
        $status = 1;
        // $data = array(
        //     'form_id' => $id,
        //     'field_name'=> $takefieldid,
        //     'status' => $status,
        //     'created_at' => $today,
        //     'modified_at' => $today
        // );
        
        // $this->db->insert('form_fields', $data); 
         $query="INSERT INTO `form_fields`(`form_id`, `field_name`, `status`, `field_label`, `created_at`, `modified_at`) VALUES('$id','$name',$status,'$label','$today','$today')";
         $this->db->query($query);
    } 
    function savevalue($id,$value,$name,$i)
    {
        $today = date('Y-m-d H:i:s');
        $status = 1;
       // $takefieldid = "SELECT * FROM `form_fields` WHERE field_name = '$name'";
        $result = $this->db->get_where('form_fields',array('form_id' => $id));
        foreach($result->result() as $row)
        {
            if($row->field_name == $name)
            {
                $takefieldid = $row->field_id;
                $curidquery = "SELECT `form_current_id` FROM `form_dynamic_create_json` WHERE `form_id` = $id";
                $curid = $this->db->query($curidquery);
                $curid = $curid->result();
                $curid = $curid[0]->form_current_id+1;
                echo $curid;
                $data = array(
                    'form_id' => $id,
                    'field_id'=> $takefieldid,
                    'fv_value'=> $value,
                    'fv_row_id' => $curid,
                    'status' => $status,
                    'created_at' => $today,
                    'modified_at' => $today
                );

                $this->db->insert('form_field_value', $data); 

                // $queryvalue = "INSERT INTO `form_field_value`(`form_id`, `field_id`, `fv_value`, `fv_row_id`,`status`, `created_at`, `modified_at`) VALUES('$id','$takefieldid','$value','$curid',$status,'$today','$today')";
                // $this->db->query($queryvalue);
                return $curid;
            }
        }
    } 
    function savecurid($id,$curid)
    {
        $curidinsert = "UPDATE `form_dynamic_create_json` SET `form_current_id` = $curid WHERE `form_id` = $id";
        $this->db->query($curidinsert);
    }
    function userdatadisplay()
    {
       
        $query=$this->db->query("select form_id,field_id,fv_value,fv_row_id from form_field_value");
        return $query->result_array();

    }

    function getFormFields($formid)
    {
       
        $query=$this->db->query("select field_id,field_name,field_label from form_fields where form_id=$formid and status=1 ");
        return $query->result_array();

    }

    function getFormFieldValues($formid,$FormFields)
    {
        $intFormFieldsCount = count($FormFields);
        $sel='';
        for($i=0,$char='a';$i<$intFormFieldsCount;$i++,$char++){
            //print_r($field['field_id']);

            $sel .= "GROUP_CONCAT(IF(fv.field_id=".$FormFields[$i]['field_id'].", fv.fv_value, null)) as $char,";
        }

        $sel .= "fv.fv_row_id";
      
      
        $query=$this->db->query("select $sel FROM form_field_value fv WHERE fv.form_id=$formid GROUP BY fv.fv_row_id");
        return $query->result_array();

    }
    function updatevalue($formid,$jcount,$fieldvalue,$fv_row_id)
    {
        $data = array(
            'fv_value' => $fieldvalue,
             );
        $array = array('form_id' => $formid, 'field_id' => $jcount, 'fv_row_id' => $fv_row_id);
        $this->db->where($array);
        $this->db->update('form_field_value', $data);
        return "success";

       
    } 
    function getFieldid($name,$formid)
    {
        //$query=$this->db->get("field_id from form_fields where field_name ='$name' AND form_id = $formid");
        $query = $this->db->get_where('form_fields', array('field_name' => $name, 'form_id' => $formid));
        return $query->result_array();
    }
    function delete($fid,$rid)
    {
        $this->db->delete('form_field_value', array('form_id' => $fid,'fv_row_id' => $rid));

    }

}