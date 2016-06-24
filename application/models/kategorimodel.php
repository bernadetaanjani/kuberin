<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategorimodel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function getKategori()
    {
        $data = array();

        $query = $this->db->get('tbl_kategori');
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
    function insertKategori($data_kategori)
    {
        $this->db->insert('tbl_kategori',$data_kategori);

    }
    function checkKategori($kategori)
    {
        $this->db->where('nama_kategori',$kategori);
        $this->db->limit(1);

        $query=$this->db->get('tbl_kategori');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function getKategoriBerita()
    {
        $data = array();
        $this->db->select('kategori');
        $this->db->from('tbl_berita');
        $this->db->where('kategori NOT IN (SELECT kategori FROM tbl_kategoriberita)', NULL, FALSE);
        $this->db->group_by('kategori');
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
    function getTblKategoriBerita()
    {
        $data = array();
        $this->db->select('*');
        $this->db->from('tbl_kategoriberita');
        $this->db->where('id_kategoriberita NOT IN (SELECT tbl_kategoriberita_id_kategoriberita FROM tbl_kategori_has_tbl_kategoriberita)', NULL, FALSE);
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
    function insertKategoriBerita($data)
    {
        $this->db->insert_batch('tbl_kategoriberita',$data);

    }

    function insertHubungKategoriBerita($data)
    {
        $this->db->insert_batch('tbl_kategori_has_tbl_kategoriberita',$data);

    }


}
