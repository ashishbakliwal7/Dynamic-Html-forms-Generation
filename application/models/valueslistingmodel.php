<?php
class valueslistingmodel extends CI_Model 
{
   public function listing()
    {
        $result = "SELECT
        fv.fv_row_id,
        GROUP_CONCAT(IF(fv.field_id=18, fv.fv_value, null)) as frst,
        FROM form_field_value fv
        WHERE fv.form_id=12
        GROUP BY fv.fv_row_id";
        $result = $this->db->query($result);
        //$result = $this->db->group_by("fv_row_id");
        foreach($result->result() as $row)
        {
             return $row->fv_row_id;
             echo $row->form_id;
        }
    } 
}
?>