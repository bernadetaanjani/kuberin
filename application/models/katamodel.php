<?php
class Katamodel extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_kata($slug = FALSE)
		{
		        if ($slug === FALSE)
		        {
		                $query = $this->db->get('tbl_kata');
		                return $query->result_array();
		        }

		        $query = $this->db->get_where('tbl_kata', array('id_kata' => $slug));
		        return $query->row_array();
		}

		public function insert_kata_get_id($kata){
			$sqlInsert = "INSERT IGNORE INTO tbl_kata (kata) VALUES ('".$kata."')";
			$this->db->query($sqlInsert);

			
			$sqlGet = "SELECT id_kata FROM tbl_kata WHERE kata='".$kata."'";
			$id = $this->db->query($sqlGet)->row();
			// $id=0;
			return $id;

		}

		public function insert_katahasil($idberita, $idkata, $hasil){
			$sqlInsertKH = "INSERT IGNORE INTO tbl_katahasil (id_berita, id_kata, hasil) VALUES(?,?,?)";
			$this->db->query($sqlInsertKH, array($idberita, $idkata, $hasil));
		}

		// public function get_kata_exist

}