<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Summarizemodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getBeritaTest()
    {
        $data=array();
        $this->db->select('isi_berita');
        $this->db->from('tbl_berita');
        $this->db->where('id_berita','13');
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

    function getBeritaJudul()
    {

        $data=array();
        $this->db->select('judul');
        $this->db->from('tbl_berita');
        $this->db->where('id_berita','1');
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
//    function getBeritaSummarizeNew($katakunci,$tanggalrange,$sumber)
//    {
//        if(!empty($katakunci)&&!empty($tanggalrange)&&!empty($sumber))
//        {
//            $tmptanggal = explode(' - ',$tanggalrange);
//            $data = array();
//            $this->db->select('id_berita,judul,isi_berita,ROUND((CHAR_LENGTH(isi_berita) - CHAR_LENGTH( REPLACE ( isi_berita, "'.$katakunci.'", ""))) / LENGTH("'.$katakunci.'")) AS count');
//            $this->db->like('isi_berita',$katakunci);
//            $this->db->where('tanggal >=', $tmptanggal[0]);
//            $this->db->where('tanggal <=', $tmptanggal[1]);
//            $this->db->like('sumberberita',$sumber);
//            $this->db->limit(20);
//            $this->db->order_by('tanggal','DESC');
//            $this->db->order_by('waktu','DESC');
//            $this->db->order_by('count','DESC');
//
//            $this->db->from('tbl_berita');
//            $query = $this->db->get();
//            $row = $query->row();
//            if($query->num_rows() > 0)
//            {
//                foreach ($query->result_array() as $row)
//                {
//                    $data[] = $row;
//                }
//                $query->free_result();
//            }
//            else
//            {
//                $data = null;
//            }
//            return $data;
//
//        }
//
//    }


    function getBeritaSummarizeNew($katakunci,$tanggalrange,$sumber, $limit)
    {
        if(!empty($katakunci)&&!empty($tanggalrange)&&!empty($sumber))
        {
            $katakunci1=' '.$katakunci.' ';
            $katakunci2=' '.$katakunci.'. ';
            $katakunci3=' '.$katakunci.', ';
            $tmpsumber=explode(', ',$sumber);
            foreach($tmpsumber as $datasumber)
            {
                $querytmpsumber[] = "sumberberita LIKE '%".$datasumber."%'";
            }
            $tampungquerysum=implode(' OR ',$querytmpsumber);
            $querysumfix='('.$tampungquerysum.')';
            $querywh = "(isi_berita LIKE '%".$katakunci1."%' OR isi_berita LIKE '%".$katakunci2."%' OR isi_berita LIKE '%".$katakunci3."%')";
            $tmptanggal = explode(' - ',$tanggalrange);
            $data = array();

            $this->db->where($querywh, NULL, FALSE);
            $this->db->where($querysumfix, NULL, FALSE);
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->limit($limit);
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
        else if(!empty($katakunci)&&!empty($tanggalrange)&&empty($sumber))
        {
            $katakunci1=' '.$katakunci.' ';
            $katakunci2=' '.$katakunci.'. ';
            $katakunci3=' '.$katakunci.', ';
            $querywh = "(isi_berita LIKE '%".$katakunci1."%' OR isi_berita LIKE '%".$katakunci2."%' OR isi_berita LIKE '%".$katakunci3."%')";
            $tmptanggal = explode(' - ',$tanggalrange);
            $data = array();

            $this->db->where($querywh, NULL, FALSE);

            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->limit($limit);
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
        else if(!empty($katakunci)&&empty($tanggalrange)&&!empty($sumber))
        {
            $katakunci1=' '.$katakunci.' ';
            $katakunci2=' '.$katakunci.'. ';
            $katakunci3=' '.$katakunci.', ';
            $tmpsumber=explode(', ',$sumber);
            foreach($tmpsumber as $datasumber)
            {
                $querytmpsumber[] = "sumberberita LIKE '%".$datasumber."%'";
            }
            $tampungquerysum=implode(' OR ',$querytmpsumber);
            $querysumfix='('.$tampungquerysum.')';
            $querywh = "(isi_berita LIKE '%".$katakunci1."%' OR isi_berita LIKE '%".$katakunci2."%' OR isi_berita LIKE '%".$katakunci3."%')";
            $data = array();

            $this->db->where($querywh, NULL, FALSE);
            $this->db->where($querysumfix, NULL, FALSE);
            $this->db->limit($limit);
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
        else if(!empty($katakunci)&&empty($tanggalrange)&&empty($sumber))
        {
            $katakunci1=' '.$katakunci.' ';
            $katakunci2=' '.$katakunci.'. ';
            $katakunci3=' '.$katakunci.', ';
            $querywh = "(isi_berita LIKE '%".$katakunci1."%' OR isi_berita LIKE '%".$katakunci2."%' OR isi_berita LIKE '%".$katakunci3."%')";
            $data = array();

            $this->db->where($querywh, NULL, FALSE);

            $this->db->limit($limit);
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
        else
        {
            return null;
        }


    }
    function getBeritaSummarize($katakunci,$tanggalrange,$sumber,$limit)
    {
        if(!empty($katakunci)&&!empty($tanggalrange)&&!empty($sumber))
        {
            $katakunci1=' '.$katakunci.' ';
            $katakunci2=' '.$katakunci.'. ';
            $katakunci3=' '.$katakunci.', ';
            $tmpsumber=explode(', ',$sumber);
            foreach($tmpsumber as $datasumber)
            {
                $querytmpsumber[] = "sumberberita LIKE '%".$datasumber."%'";
            }
            $tampungquerysum=implode(' OR ',$querytmpsumber);
            $querysumfix='('.$tampungquerysum.')';
            $querywh = "(isi_berita LIKE '%".$katakunci1."%' OR isi_berita LIKE '%".$katakunci2."%' OR isi_berita LIKE '%".$katakunci3."%')";
            $tmptanggal = explode(' - ',$tanggalrange);
            $data = array();

            $this->db->where($querywh, NULL, FALSE);
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->where($querysumfix, NULL, FALSE);
 //           $this->db->like('sumberberita',$sumber);
            $this->db->limit($limit);
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
        else if(!empty($katakunci)&&!empty($tanggalrange)&&empty($sumber))
        {
            $katakunci1=' '.$katakunci.' ';
            $katakunci2=' '.$katakunci.'. ';
            $katakunci3=' '.$katakunci.', ';
            $querywh = "(isi_berita LIKE '%".$katakunci1."%' OR isi_berita LIKE '%".$katakunci2."%' OR isi_berita LIKE '%".$katakunci3."%')";
            $tmptanggal = explode(' - ',$tanggalrange);
            $data = array();

            $this->db->where($querywh, NULL, FALSE);
            $this->db->where('tanggal >=', $tmptanggal[0]);
            $this->db->where('tanggal <=', $tmptanggal[1]);
            $this->db->limit($limit);
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
        else if(!empty($katakunci)&&empty($tanggalrange)&&!empty($sumber))
        {
            $katakunci1=' '.$katakunci.' ';
            $katakunci2=' '.$katakunci.'. ';
            $katakunci3=' '.$katakunci.', ';
            $tmpsumber=explode(', ',$sumber);
            foreach($tmpsumber as $datasumber)
            {
                $querytmpsumber[] = "sumberberita LIKE '%".$datasumber."%'";
            }
            $tampungquerysum=implode(' OR ',$querytmpsumber);
            $querysumfix='('.$tampungquerysum.')';
            $querywh = "(isi_berita LIKE '%".$katakunci1."%' OR isi_berita LIKE '%".$katakunci2."%' OR isi_berita LIKE '%".$katakunci3."%')";
            $data = array();

            $this->db->where($querywh, NULL, FALSE);
            $this->db->where($querysumfix, NULL, FALSE);
            $this->db->limit($limit);
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
        else if(!empty($katakunci)&&empty($tanggalrange)&&empty($sumber))
        {
            $katakunci1=' '.$katakunci.' ';
            $katakunci2=' '.$katakunci.'. ';
            $katakunci3=' '.$katakunci.', ';
            $querywh = "(isi_berita LIKE '%".$katakunci1."%' OR isi_berita LIKE '%".$katakunci2."%' OR isi_berita LIKE '%".$katakunci3."%')";
            $data = array();

            $this->db->where($querywh, NULL, FALSE);

            $this->db->limit($limit);
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
        else
        {
            return null;
        }


    }
    function getBeritaByID($id)
    {
        $this->db->where('id_berita',$id);
        $query = $this->db->get('tbl_berita');
        $row = $query->row();
        return $row;
    }
    function insertLog($datalog)
    {
        $this->db->insert('tbl_log',$datalog);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
    function insertDetailLog($detaillog)
    {
        $this->db->insert_batch('tbl_detaillog',$detaillog);
    }
    function getJumlahDataByKeyword()
    {
        $data = array();

        $this->db->select('id_log, keyword, COUNT(*) c');
        $this->db->limit(5);
        $this->db->where('idberita_terkait IS NOT NULL',NULL, FALSE);
        $this->db->group_by('keyword');
        $this->db->order_by('c','DESC');
        $this->db->from('tbl_log');
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
    function getDataLogTerbaru()
    {
        $data = array();

        $this->db->select('l.id_log, l.keyword, COUNT(*) c');
        $this->db->where('l.idberita_terkait IS NOT NULL',NULL, FALSE);
        $this->db->where('l.datetime_summarize=(SELECT max(datetime_summarize) FROM `tbl_log` l2 WHERE l2.keyword = l.keyword)');
        $this->db->group_by('l.keyword');
        $this->db->order_by('l.datetime_summarize','DESC');
        $this->db->from('tbl_log l');
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
    function GetDataLogByID($id)
    {
        $this->db->select('id_log, keyword, summarize, idberita_terkait');
        $this->db->where('id_log',$id);
        $query = $this->db->get('tbl_log');
        $row = $query->row();
        return $row;
    }
    function GetDataDetailLogByIDLog($idLog)
    {
        $data = array();
        $this->db->from('tbl_detaillog');
        $this->db->where('tbl_log_id_log',$idLog);
        $this->db->order_by('score','DESC');
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

}