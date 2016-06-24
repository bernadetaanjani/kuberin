<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beritamodel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getBerita()
    {
        $data = array();

        $this->db->order_by('tanggal','DESC');
        $this->db->order_by('waktu','DESC');
        $this->db->group_by('judul');
        $query = $this->db->get('tbl_berita');

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
    function GetJumlahDataBerita()
    {
        $this->db->group_by('judul');
        return $this->db->count_all('tbl_berita');
    }

    function fetchBerita($limit, $start)
    {
        $this->db->limit($limit,$start);
        $this->db->order_by('tanggal','DESC');
        $this->db->order_by('waktu','DESC');
        $this->db->group_by('judul');
        $query = $this->db->get('tbl_berita');
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
    function getBeritasearch($sumberberita,$tanggal,$katakunci)
    {
        if(!empty($katakunci)&&!empty($tanggal)&&!empty($sumberberita)) {
            $tmptanggal = explode(' - ', $tanggal);
            $data = array();
            $this->db->like('isi_berita', $katakunci);
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->like('sumberberita', $sumberberita);
            $this->db->from('tbl_berita');
            $query = $this->db->get();
            $row = $query->row();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;
        }
        else if(!empty($katakunci)&&!empty($tanggal)&&empty($sumberberita))
        {
            $tmptanggal = explode(' - ',$tanggal);
            $data = array();
            $this->db->like('isi_berita',$katakunci);
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            $query = $this->db->get();
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
        else if(!empty($katakunci)&&empty($tanggal)&&!empty($sumberberita))
        {
            $data = array();
            $this->db->like('isi_berita',$katakunci);
            $this->db->like('sumberberita',$sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            $query = $this->db->get();
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
        else if(!empty($katakunci)&&empty($tanggal)&&empty($sumberberita))
        {
            $data = array();
            $this->db->like('isi_berita',$katakunci);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            $query = $this->db->get();
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
        else if(empty($katakunci)&&!empty($tanggal)&&!empty($sumberberita)) {
            $tmptanggal = explode(' - ', $tanggal);
            $data = array();
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->like('sumberberita', $sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            $query = $this->db->get();
            $row = $query->row();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;
        }
        else if(empty($katakunci)&&!empty($tanggal)&&empty($sumberberita)) {
            $tmptanggal = explode(' - ', $tanggal);
            $data = array();

            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            $query = $this->db->get();
            $row = $query->row();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;
        }
        else if(empty($katakunci)&&empty($tanggal)&&!empty($sumberberita)) {
            $data = array();
            $this->db->like('sumberberita', $sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            $query = $this->db->get();
            $row = $query->row();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;
        }
        else
        {
            return null;
        }

    }
    function GetJumlahDataBeritaSearch($sumberberita,$tanggal,$katakunci)
    {
        if(!empty($katakunci)&&!empty($tanggal)&&!empty($sumberberita)) {
            $tmptanggal = explode(' - ', $tanggal);
            $this->db->like('isi_berita', $katakunci);
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->like('sumberberita', $sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');

            return $this->db->count_all_results();
        }
        else if(!empty($katakunci)&&!empty($tanggal)&&empty($sumberberita))
        {
            $tmptanggal = explode(' - ',$tanggal);

            $this->db->like('isi_berita',$katakunci);
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            return $this->db->count_all_results();
        }
        else if(!empty($katakunci)&&empty($tanggal)&&!empty($sumberberita))
        {
            $this->db->like('isi_berita',$katakunci);
            $this->db->like('sumberberita',$sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            return $this->db->count_all_results();

        }
        else if(!empty($katakunci)&&empty($tanggal)&&empty($sumberberita))
        {

            $this->db->like('isi_berita',$katakunci);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            return $this->db->count_all_results();
        }
        else if(empty($katakunci)&&!empty($tanggal)&&!empty($sumberberita)) {
            $tmptanggal = explode(' - ', $tanggal);

            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->like('sumberberita', $sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');

            return $this->db->count_all_results();
        }
        else if(empty($katakunci)&&!empty($tanggal)&&empty($sumberberita)) {
            $tmptanggal = explode(' - ', $tanggal);

            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');

            return $this->db->count_all_results();
        }
        else if(empty($katakunci)&&empty($tanggal)&&!empty($sumberberita)) {


            $this->db->like('sumberberita', $sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');

            return $this->db->count_all_results();
        }
        else
        {
            return null;
        }
    }
    function fetchBeritaSearch($limit, $start, $sumberberita,$tanggal,$katakunci)
    {
        if(!empty($katakunci)&&!empty($tanggal)&&!empty($sumberberita)) {
            $tmptanggal = explode(' - ', $tanggal);
            $data = array();
            $this->db->like('isi_berita', $katakunci);
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->like('sumberberita', $sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');

            $this->db->limit($limit, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;
        }
        else if(!empty($katakunci)&&!empty($tanggal)&&empty($sumberberita))
        {
            $tmptanggal = explode(' - ',$tanggal);
            $data = array();
            $this->db->like('isi_berita',$katakunci);
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            $this->db->limit($limit, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;

        }
        else if(!empty($katakunci)&&empty($tanggal)&&!empty($sumberberita))
        {
            $data = array();
            $this->db->like('isi_berita',$katakunci);
            $this->db->like('sumberberita',$sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            $this->db->limit($limit, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;


        }
        else if(!empty($katakunci)&&empty($tanggal)&&empty($sumberberita))
        {
            $data = array();
            $this->db->like('isi_berita',$katakunci);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');
            $this->db->limit($limit, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;
        }
        else if(empty($katakunci)&&!empty($tanggal)&&!empty($sumberberita)) {
            $tmptanggal = explode(' - ', $tanggal);
            $data = array();
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->like('sumberberita', $sumberberita);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');

            $this->db->limit($limit, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;
        }
        else if(empty($katakunci)&&!empty($tanggal)&&empty($sumberberita)) {
            $tmptanggal = explode(' - ', $tanggal);
            $data = array();

            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->from('tbl_berita');

            $this->db->limit($limit, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;
        }
        else if(empty($katakunci)&&empty($tanggal)&&!empty($sumberberita)) {

            $data = array();

            $this->db->like('sumberberita', $sumberberita);
            $this->db->from('tbl_berita');
            $this->db->order_by('tanggal','DESC');
            $this->db->order_by('waktu','DESC');
            $this->db->group_by('judul');
            $this->db->limit($limit, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                $query->free_result();
            } else {
                $data = null;
            }
            return $data;
        }
        else
        {
            return null;
        }
    }
    function getBeritaTampil($id)
    {

        $this->db->where('id_berita',$id);
        $query = $this->db->get('tbl_berita');
        $row = $query->row();
        return $row;
    }
    function getSumberBerita()
    {
        $data = array();
        $this->db->select('sumberberita');
        $this->db->from('tbl_berita');
        $this->db->group_by('sumberberita');
        $query = $this->db->get();
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
    function kategoriBerita($kategori)
    {
        $data = array();
        $this->db->select('tbl_kategoriberita.kategori');
        $this->db->from('tbl_kategoriberita');
        $this->db->join('tbl_kategori_has_tbl_kategoriberita','tbl_kategoriberita.id_kategoriberita = tbl_kategori_has_tbl_kategoriberita.tbl_kategoriberita_id_kategoriberita');
        $this->db->join('tbl_kategori','tbl_kategori_has_tbl_kategoriberita.tbl_kategori_id_kategori = tbl_kategori.id_kategori');
        $this->db->where('tbl_kategori.nama_kategori',$kategori);

        $query = $this->db->get();
        $row = $query->row();
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $data[] = $row['kategori'];
            }
            $query->free_result();
        }
        else
        {
            $data = null;
        }
        return $data;
    }

    function getBeritaKategori($kategori)
    {
        $data = array();

        $this->db->where_in('kategori',$kategori);
        $this->db->order_by('tanggal','DESC');
        $this->db->order_by('waktu','DESC');
        $this->db->group_by('judul');
        $query = $this->db->get('tbl_berita');
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
    function GetJumlahDataBeritaKategori($kategori)
    {

        $this->db->where_in('kategori',$kategori);
        $this->db->order_by('tanggal','DESC');
        $this->db->order_by('waktu','DESC');
        $this->db->group_by('judul');
        return $this->db->count_all('tbl_berita');
    }

    function fetchBeritaKategori($limit, $start,$kategori)
    {
        $data = array();
        $this->db->where_in('kategori',$kategori);
        $this->db->order_by('tanggal','DESC');
        $this->db->order_by('waktu','DESC');
        $this->db->group_by('judul');
        $this->db->limit($limit,$start);
        $query = $this->db->get('tbl_berita');
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



}
