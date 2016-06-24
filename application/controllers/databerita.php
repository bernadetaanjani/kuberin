<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Databerita extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('Beritamodel');
        $this->load->helper('text');

    }

    function index($page_number=1)
    {
        if($this->session->userdata('logged_in'))
        {
            $data['base_url']=$this->config->item('base_url');
            $session_data = $this->session->userdata('logged_in');
            $data['username'] = $session_data['nama'];
            $data['nav_scrap'] = '';
            $data['nav_data']='active';
            $data['nav_tags']='';
            $data['nav_kategori']='';
            $data['nav_summarize']='';
            $data['nav_summarizebaru']='';
            $data['nav_datalatih']='';
            $data['nav_tambahdatalatih']='';
            $data['page_title']='Kuberin Administrator';
            $data['sumberberita_list'] = $this->Beritamodel->getSumberBerita();

            $config['base_url']=base_url()."index.php/databerita/index";

//            $rows = $this->Beritamodel->getBerita();
//            $data['berita_list'] = $rows;
            $config['total_rows'] = $this->Beritamodel->GetJumlahDataBerita();
            $config['per_page'] = 10;
            $config['uri_segment'] = 3;
            $config['use_page_numbers'] = TRUE;
            $offset = ($page_number  == 1) ? 0 : ($page_number * $config['per_page']) - $config['per_page'];

            $data['offset']     = $offset;

            $config['full_tag_open'] = "<ul class='pagination pagination-sm no-margin pull-right'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['berita_list'] = $this->Beritamodel->fetchBerita($config['per_page'], $offset);
            $data['links'] = $this->pagination->create_links();




            $this->load->view('header', $data);
            $this->load->view('navigation', $data);
            $this->load->view('databerita_view', $data);
            $this->load->view('footer', $data);
        }
        else
        {
            redirect('home', 'refresh');
        }



    }
    function cari($page_number=1)
    {
        $data['base_url']=$this->config->item('base_url');
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['nama'];
        $data['nav_scrap'] = '';
        $data['nav_data']='active';
        $data['nav_tags']='';
        $data['nav_kategori']='';
        $data['nav_summarize']='';
        $data['nav_summarizebaru']='';
        $data['page_title']='Kuberin Administrator';
        $data['sumberberitasearch'] ="";
        $data['tanggalsearch'] ="";
        $data['katakuncisearch'] ="";
        $tampsumberberita=$this->input->post('optsumberberita');
        $tamptanggal=$this->input->post('tanggalberita');
        $tampkatakunci=$this->input->post('katakunci');

//        $this->form_validation->set_rules('optsumberberita', 'Sumber berita', 'trim|xss_clean|callback_cekInputan');
//        $this->form_validation->set_rules('tanggalberita', 'Tanggal berita', 'trim|xss_clean');
//        $this->form_validation->set_rules('katakunci', 'kata kunci', 'trim|xss_clean');
//        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
//
//        if($this->form_validation->run()==FALSE)
//        {
//            $data['berita_list'] = "";
//            $data['links'] = "";
//            $data['offset']     = "";
//        }
//        else
        if(!empty($tampsumberberita)&&empty($tamptanggal)&&empty($tampkatakunci))
        {
            $data['sumberberitasearch'] = $this->input->post('optsumberberita');
            $this->session->set_userdata('pencariansumber', $data['sumberberitasearch']);

        }
        else if(empty($tampsumberberita)&&!empty($tamptanggal)&&empty($tampkatakunci))
        {
            $data['tanggalsearch'] = $this->input->post('tanggalberita');
            $this->session->set_userdata('pencariantanggal', $data['tanggalsearch']);
        }

        else if(empty($tampsumberberita)&&empty($tamptanggal)&&!empty($tampkatakunci))
        {
            $data['katakuncisearch'] = $this->input->post('katakunci');
            $this->session->set_userdata('pencariankatakunci', $data['katakuncisearch']);
        }
        else if(!empty($tampsumberberita)&&!empty($tamptanggal)&&empty($tampkatakunci))
        {
            $data['sumberberitasearch'] = $this->input->post('optsumberberita');
            $this->session->set_userdata('pencariansumber', $data['sumberberitasearch']);
            $data['tanggalsearch'] = $this->input->post('tanggalberita');
            $this->session->set_userdata('pencariantanggal', $data['tanggalsearch']);

        }
        else if(empty($tampsumberberita)&&!empty($tamptanggal)&&!empty($tampkatakunci))
        {
            $data['tanggalsearch'] = $this->input->post('tanggalberita');
            $this->session->set_userdata('pencariantanggal', $data['tanggalsearch']);
            $data['katakuncisearch'] = $this->input->post('katakunci');
            $this->session->set_userdata('pencariankatakunci', $data['katakuncisearch']);
        }

        else if(!empty($tampsumberberita)&&empty($tamptanggal)&&!empty($tampkatakunci))
        {
            $data['sumberberitasearch'] = $this->input->post('optsumberberita');
            $this->session->set_userdata('pencariansumber', $data['sumberberitasearch']);
            $data['katakuncisearch'] = $this->input->post('katakunci');
            $this->session->set_userdata('pencariankatakunci', $data['katakuncisearch']);
        }
        else if(!empty($tampsumberberita)&&!empty($tamptanggal)&&!empty($tampkatakunci))
        {
            $data['sumberberitasearch'] = $this->input->post('optsumberberita');
            $this->session->set_userdata('pencariansumber', $data['sumberberitasearch']);
            $data['tanggalsearch'] = $this->input->post('tanggalberita');
            $this->session->set_userdata('pencariantanggal', $data['tanggalsearch']);
            $data['katakuncisearch'] = $this->input->post('katakunci');
            $this->session->set_userdata('pencariankatakunci', $data['katakuncisearch']);
        }

        else
        {
            $data['sumberberitasearch'] = $this->session->userdata('pencariansumber');
            $data['tanggalsearch'] = $this->session->userdata('pencariantanggal');
            $data['katakuncisearch'] = $this->session->userdata('pencariankatakunci');
        }


        $config['base_url']=base_url()."index.php/databerita/cari";
//        $rows = $this->Beritamodel->getBeritasearch($data['sumberberitasearch'],$data['tanggalsearch'],$data['katakuncisearch']);
//        $data['berita_list'] = $rows;
        $config['total_rows'] = $this->Beritamodel->GetJumlahDataBeritaSearch($data['sumberberitasearch'],$data['tanggalsearch'],$data['katakuncisearch']);
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
        $offset = ($page_number  == 1) ? 0 : ($page_number * $config['per_page']) - $config['per_page'];

        $data['offset']     = $offset;


        $config['full_tag_open'] = "<ul class='pagination pagination-sm no-margin pull-right'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['berita_list'] = $this->Beritamodel->fetchBeritaSearch($config['per_page'], $offset,$data['sumberberitasearch'],$data['tanggalsearch'],$data['katakuncisearch']);
        $data['links'] = $this->pagination->create_links();

        $this->load->view('header', $data);
        $this->load->view('navigation', $data);
        $this->load->view('databeritasearch_view', $data);
        $this->load->view('footer', $data);
    }
    function cekInputan($optsumberberita)
    {
        $tamptanggal=$this->input->post('tanggalberita');
        $tampkatakunci=$this->input->post('katakunci');
        if(empty($optsumberberita) && empty($tamptanggal) && empty($tampkatakunci))
        {
            $this->form_validation->set_message('cekInputan', 'Harus diisi salah satu!');
            return false;
        }
        else
        {
            return true;
        }

    }
    function tampilberita()
    {
        $id = $this->input->post('id');
        $berita = $this->Beritamodel->getBeritaTampil($id);
        $tmpe['judul'] = $berita->judul;
        $tmpe['tanggaldanwaktu'] = (date("d-m-Y", strtotime($berita->tanggal))).'|'.date('G:i',strtotime($berita->waktu));
        $tmpe['kategori'] = $berita->kategori;
        $tmpe['gambar'] = $berita->gambar;
        $tmpe['isiberita'] = $berita->isi_berita;
        $tmpe['link'] = $berita->link;
        echo json_encode($tmpe);
    }

}