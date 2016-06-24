<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Scrapmodel extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    function InsertGetUrl($geturl)
    {
        $this->db->insert('tbl_geturl', $geturl);
    }
    function CheckTblGetUrl($url)
    {
        $this->db->where('url',$url);
        $this->db->limit(1);

        $query=$this->db->get('tbl_geturl');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }


	function InsertGetBerita($getberita)
	{
        $this->db->insert_batch('tbl_getberita',$getberita);
		
	}
    function GetTag($sumber)
    {
        $data = array();
        $this->db->where('status_tag','true');
        $this->db->where('sumberberita',$sumber);
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
    function CheckDbTagGetBerita($url)
    {
        $this->db->where('url_berita',$url);
        $this->db->limit(1);

        $query=$this->db->get('tbl_getberita');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
    function GetUrlBerita()
    {
        $data = array();
        $this->db->select('*');
        $this->db->from('tbl_getberita');
        $this->db->join('tbl_geturl','tbl_getberita.tbl_geturl_id_geturl = tbl_geturl.id_geturl');
        $this->db->where('tbl_geturl.status_tag','true');
        $this->db->where('tbl_getberita.status','belum');
        $this->db->order_by('tbl_getberita.id_getberita','ASC');
        $this->db->limit(10);
        $query=$this->db->get();
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
    function GetUrlBeritaMenunggu()
    {
        $data = array();
        $this->db->select('*');
        $this->db->from('tbl_getberita');
        $this->db->join('tbl_geturl','tbl_getberita.tbl_geturl_id_geturl = tbl_geturl.id_geturl');
        $this->db->where('tbl_geturl.status_tag','true');
        $this->db->where('tbl_getberita.status','menunggu');
        $this->db->order_by('tbl_getberita.id_getberita','ASC');
        $this->db->limit(10);
        $query=$this->db->get();
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
    function SetStatusTagUrlBerita($data,$url)
    {
        $this->db->where('url_berita', $url);
        $this->db->update('tbl_getberita', $data);

    }
    function SetStatusTagGetUrl($data,$url)
    {
        $this->db->where('url', $url);
        $this->db->where('status_tag','true');
        $this->db->update('tbl_geturl', $data);


    }
    function CheckDbBerita($link,$judulberita)
    {
        $this->db->like('link',$link);
        $this->db->or_like('judul',$judulberita);
        $this->db->limit(1);

        $query=$this->db->get('tbl_berita');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function InsertBerita($arrayberita)
    {
        $this->db->insert('tbl_berita',$arrayberita);
    }


}