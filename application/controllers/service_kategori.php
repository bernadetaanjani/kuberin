<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_kategori extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->model('Beritamodel');
        $this->load->helper('text');

    }
    function kategori($kategori,$page_number=1)
    {
        $tampung = $this->Beritamodel->kategoriBerita($kategori);
        if(!empty($tampung))
        {
            $config['base_url']=base_url()."index.php/service_kategori/kategori";

//            $rows = $this->Beritamodel->getBeritaKategori($tampung);
//            $data['berita_list'] = $rows;
            $config['total_rows'] = $this->Beritamodel->GetJumlahDataBeritaKategori($tampung);
            $config['per_page'] = 10;
            $config['uri_segment'] = 3;
            $config['use_page_numbers'] = TRUE;
            $offset = ($page_number  == 1) ? 0 : ($page_number * $config['per_page']) - $config['per_page'];

            $data['offset']     = $offset;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['berita_list'] = $this->Beritamodel->fetchBeritaKategori($config['per_page'], $offset,$tampung);
            header('Content-Type: application/json');
            if($data['berita_list']!=null)
            {
                echo json_encode(array('st'=>'0','berita'=>$data['berita_list']));
            }
            else
            {
                echo json_encode(array('st'=>'1','berita'=>"Kosong"));
            }


        }
        else
        {
            header('Content-Type: application/json');
            echo json_encode(array('st'=>'2','berita'=>"Kosong"));

        }

    }


}