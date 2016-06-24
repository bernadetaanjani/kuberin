<?php
class Nbmodel extends CI_Model {

    public function __construct()
    {
            $this->load->database();
    }

    public function getidkata($teks){
    	$q=$this->db->query('SELECT DISTINCT id_kata from tbl_kata WHERE kata='.$teks);
    }
}