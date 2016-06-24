<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginmodel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function Login($username,$password)
	{
		$this->db->where('username',$username);
        $this->db->where('password',$password);
        $this->db->limit(1);

		$query=$this->db->get('tbl_user');
        if($query->num_rows()==1)
        {
         	return $query->result();
		}
        else
        {
            return false;
        }

		
	}


	

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */