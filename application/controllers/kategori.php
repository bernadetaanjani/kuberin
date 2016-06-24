<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('Kategorimodel');
        $this->load->helper('text');

    }

    function index()
    {
        if($this->session->userdata('logged_in'))
        {
            $data['base_url']=$this->config->item('base_url');
            $session_data = $this->session->userdata('logged_in');
            $data['username'] = $session_data['nama'];
            $data['nav_scrap'] = '';
            $data['nav_data']='';
            $data['nav_tags']='';
            $data['nav_kategori']='active';
            $data['nav_summarize']='';
            $data['nav_summarizebaru']='';
            $data['kategori_list']=$this->Kategorimodel->getKategoriBerita();
            $data['kategori_utama']=$this->Kategorimodel->getKategori();
            $data['kategori_berita']=$this->Kategorimodel->getTblKategoriBerita();
            $data['page_title']='Kuberin Administrator';
            $this->load->view('header', $data);
            $this->load->view('navigation', $data);
            $this->load->view('kategori_view', $data);
            $this->load->view('footer', $data);
        }
        else
        {
            redirect('home', 'refresh');
        }

    }
    function insertKategoriUtama()
    {
        $this->form_validation->set_rules('kategoritxt', 'Kategori', 'trim|required|xss_clean|callback_cekSamaKategori');
        if($this->form_validation->run()==FALSE)
        {
            echo json_encode(array('st'=>0,'msg'=>validation_errors()));
        }
        else
        {
            $kategori = $this->input->post('kategoritxt');
            $getkategori = array(
                'nama_kategori' =>$kategori
            );
            $this->Kategorimodel->insertKategori($getkategori);
            echo json_encode(array('st'=>1,'msg'=>'Data Tersimpan'));

        }
    }
    function cekSamaKategori($kategoritxt)
    {
        $result = $this->Kategorimodel->checkKategori($kategoritxt);
        if($result)
        {
            $this->form_validation->set_message('cekSamaKategori', 'This %s already exists in the Database');
            return false;

        }
        else
        {
            return true;
        }

    }
    function insertKategoriBerita()
    {

        $kategori = $this->input->post('checkboxkat');
        if (!empty($kategori)) {
            foreach ($kategori as $kat) {
                $getkategori = array(
                    'kategori' => $kat
                );
                $kattampung[] = $getkategori;
            }

            $this->Kategorimodel->insertKategoriBerita($kattampung);
            echo json_encode(array('st' => 1, 'msg' => 'Data Tersimpan'));
        } else {
            echo json_encode(array('st' => 2, 'msg' => 'The Kategori field is required.'));
        }


    }

    function insertHubKategoriBerita()
    {
        $kategoriutama = $this->input->post('optkategori');
        $kategori = $this->input->post('checkboxkatberita');

        if (!empty($kategori) && !empty($kategoriutama)) {
            foreach ($kategori as $kat) {
                $getkategori = array(
                    'tbl_kategori_id_kategori' => $kategoriutama,
                    'tbl_kategoriberita_id_kategoriberita' =>$kat
                );
                $kattampung[] = $getkategori;
            }
            $this->Kategorimodel->insertHubungKategoriBerita($kattampung);
            echo json_encode(array('st' => 1, 'msg' => 'Data Tersimpan'));
        } else if($kategoriutama == '' && empty($kategori)){
            echo json_encode(array('st' => 2, 'msg1' => 'The Kategori Utama field is required.','msg2' => 'The Kategori Berita field is required.'));
        }
        else if($kategoriutama == ''){
            echo json_encode(array('st' => 3, 'msg1' => 'The Kategori Utama field is required.'));
        }
        else if(empty($kategori)) {
            echo json_encode(array('st' => 4, 'msg2' => 'The Kategori Berita field is required.'));
        }

    }

}