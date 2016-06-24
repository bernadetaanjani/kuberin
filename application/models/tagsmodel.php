<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagsmodel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getTagsSemua()
    {
        $data = array();
        $this->db->where('id_tag_pengganti', NULL);
        $this->db->order_by('sumberberita','ASC');
        $query = $this->db->get('tbl_geturl');
        $row = $query->row();
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $data[] = $row;
            }
            $query->free_result();
        }
        else
        {
            $data = null;
        }
        return $data;
    }
    function getTagsTampil($id)
    {
        $this->db->where('id_geturl',$id);
        $query = $this->db->get('tbl_geturl');
        $row = $query->row();
        return $row;
    }
    function updateDataTags($data, $url)
    {
        $this->db->where('url', $url);
        $this->db->where('status_tag','true');
        $this->db->where('id_tag_pengganti', NULL);
        $this->db->update('tbl_geturl', $data);
    }
    function cekStatusTag($url)
    {
        $this->db->like('url',$url);
        $this->db->where('id_tag_pengganti', NULL);
        $query=$this->db->get('tbl_geturl');
        $row = $query->row();
        return $row;
    }
    function InsertGetUrl($geturl)
    {
        $this->db->insert('tbl_geturl', $geturl);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
    function UpdateTagPengganti($data,$url)
    {
        $this->db->where('url', $url);
        $this->db->where('status_tag','false');
        $this->db->where('id_tag_pengganti', NULL);
        $this->db->update('tbl_geturl', $data);

    }

}
