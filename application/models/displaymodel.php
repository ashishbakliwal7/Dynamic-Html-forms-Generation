<?php
class displaymodel extends CI_Model 
{
    /*Display*/
	function display_records()
	{
	$query=$this->db->query("select form_id,form_name,form_json_data from form_dynamic_create_json");
	return $query->result();
	}
   /*view*/
	function viewtable($id)
	{
    $query=$this->db->query("select form_json_data from form_dynamic_create_json where form_id=$id");
    return $query->row();
	}
}
 