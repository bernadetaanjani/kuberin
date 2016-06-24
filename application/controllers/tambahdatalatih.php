<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tambahdatalatih extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('datalatihmodel');
        $this->load->model('katamodel');
        $this->load->helper('text');
    }

    function index()
    {
        if($this->session->userdata('logged_in'))
        {
            $data['base_url']=$this->config->item('base_url');
            $session_data = $this->session->userdata('logged_in');
            $data['username'] = $session_data['nama'];
            $data['nav_scrap'] = 'active';
            $data['nav_data']='';
            $data['nav_tags']='';
            $data['nav_kategori']='';
            $data['nav_summarize']='';
            $data['nav_summarizebaru']='';
            $data['nav_summarizevalen']='';
            $data['nav_datalatih']='';
            $data['nav_tambahdatalatih']='';
            $data['page_title']='Kuberin Administrator';
            $this->load->view('header', $data);
            $this->load->view('navigation', $data);
            $this->load->view('tambahdatalatih_view', $data);
            $this->load->view('footer', $data);
        }
        else
        {
            redirect('home', 'refresh');
        }
    }


    public function case_folding($data){
                return strtolower($data);
        }

    public function cleansing($tweet){
                // $tweet = iconv("UTF-8","ISO-8859-1//IGNORE", $tweet);
                //mention
                $tweet = preg_replace('/@[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i','', $tweet);
                //hashtag
                $tweet = preg_replace('/#[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i','', $tweet);
                // link
                $tweet = preg_replace('/\b(https?|ftp|file|http):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i','', $tweet);
                $tweet = preg_replace('/rt | â€¦/i', '', $tweet);
                //hapus http
                $tweet = str_replace("…", "", $tweet);
                // $tweet = str_replace("http", "", $tweet);
                // $tweet = str_replace(" rt", "", $tweet);
                // $tweet = str_replace(" rt ", "", $tweet);
                // $tweet = str_replace("rt ", "", $tweet);
                return $tweet;
        }

    public function stopword_removal($tweet){
            $tweet = preg_replace(
                    array_map( 
                        function($stopword){
                                return'/\b'.$stopword.'\b/';
                            }, $this->stopwords), '',$tweet);
            return $tweet;
    }

    public function tokenizer($tweet){
            $tweet = stripcslashes($tweet);
            //karakter 
            $tweet = preg_replace('/[-0-9+&@#\/%?=~_|$!:^>`{}<*,.;()"-$]/i', '', $tweet);
            
            //hapus satu karakter
            $tweet = preg_replace('/\b\w\b(\s|.\s)?/', '', $tweet);
            //hapus bracket
            $tweet = preg_replace("/[\[(.)\]]/", '', $tweet);

            //hapus kutip satu
            $tweet = str_replace("'", "", $tweet);

            $tweet = preg_replace('/\s+/', ' ', $tweet);
            $tweet = trim($tweet);
            return $tweet;
    }

    public function tokenizer2($teks){
            $teks = explode(" ", $teks);
            $teks = implode("<br/>", $teks);
            return $teks;
        }

    public function positif($idberita){
        $result=$this->datalatihmodel->get_news_item($idberita);
        // var_dump($result);
        // echo $result[0]['isi_berita'];
        $this->insertKataLatihPos($result[0]['isi_berita'], $idberita);
        redirect('datalatih');
    }

    public function negatif($idberita){
        $result=$this->datalatihmodel->get_news_item($idberita);
        // var_dump($result);
        // echo $result[0]['isi_berita'];
        $this->insertKataLatihNeg($result[0]['isi_berita'], $idberita);
        redirect('datalatih');
    }

    function simpan(){
        // $this->form_validation->set_rules('sumberberita', 'Sumber Berita', )
        $sumberberita= $this->input->post('sumberberita');
        $url=$this->input->post('url');
        $kategori=$this->input->post('tagkategori');
        $judul=$this->input->post('tagjudul');
        $gambar=$this->input->post('taggambar');
        $isi=$this->input->post('tagberita');
        $tanggal=$this->input->post('tagtanggal');
        // $date=$this->input->post('tagtanggal');
        // $tanggal=date_create($date);
        // $tanggal=date_timestamp_get($date);
        $flag=1;

        var_dump($sumberberita." ".$url." ".$kategori." ".$judul." ".$gambar." ".$isi." ".$tanggal." ".$flag);

        $insert=$this->datalatihmodel->insertDataLatih($judul, $tanggal, $tanggal, $kategori, $gambar, $isi, $sumberberita, $flag);

        $isiberitafolded = $this->case_folding($isi);
        // var_dump($isiberitafolded);
        $isiberitaremoved = $this->stopword_removal($isiberitafolded);
        var_dump($isiberitaremoved);
        $tokenized = $this->tokenizer($isiberitaremoved);
        // var_dump($tokenized);
        $tokenized2= $this->tokenizer2($tokenized);
        $stemmed= $this->stem_word($tokenized);
        $data['isi_berita'] = $stemmed;

        $sentiment=$this->uri->segment(4);
        var_dump($stemmed);


    }
}