<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatags extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('Tagsmodel');
        $this->load->helper('text');
        $this->load->controller('scraping');
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
            $data['nav_tags']='active';
            $data['nav_kategori']='';
            $data['nav_summarize']='';
            $data['nav_summarizebaru']='';
            $data['page_title']='Kuberin Administrator';

            $tampungan = $this->Tagsmodel->getTagsSemua();
//            foreach($tampungsementara as $tmpsem)
//            {
//                if(empty($tmpsem['id_tag_pengganti']))
//                {
//                    $tampungan[]=$tmpsem;
//                }
//                else
//                {
//
//                }
//            }
            $data['tags_list']=$tampungan;
            $this->load->view('header', $data);
            $this->load->view('navigation', $data);
            $this->load->view('datatags_view', $data);
            $this->load->view('footer', $data);
        }
        else
        {
            redirect('home', 'refresh');
        }

    }
    function testdanupdate()
    {
        $btn = $this->input->post('select');

        if($btn == 'Test')
        {
            $this->scraping->test();


        }
        else
        {
            $this->updatetags();

        }

    }
    function updatetags()
    {
        $this->form_validation->set_rules('url', 'Url', 'trim|required|xss_clean|');
        $this->form_validation->set_rules('taglink1', 'Tag link berita 1', 'trim|required|xss_clean');
        $this->form_validation->set_rules('taglink2', 'Tag link berita 2', 'trim|required|xss_clean');
        $this->form_validation->set_rules('taglink3', 'Tag link berita 3', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tagjudul1', 'Tag judul berita 1', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tagjudul2', 'Tag judul berita 2', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tagkategori1', 'Tag kategori berita 1', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tagkategori2', 'Tag kategori berita 2', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tagtanggal1', 'Tag tanggal berita 1', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tagtanggal2', 'Tag tanggal berita 2', 'trim|required|xss_clean');
        $this->form_validation->set_rules('taggambar1', 'Tag gambar berita 1', 'trim|required|xss_clean');
        $this->form_validation->set_rules('taggambar2', 'Tag gambar berita 2', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tagberita1', 'Tag isi berita 1', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tagberita2', 'Tag isi berita 2', 'trim|required|xss_clean');
        if($this->form_validation->run()==FALSE)
        {
            echo json_encode(array('st'=>0,'msg'=>validation_errors()));
        }
        else
        {
            $sumberberita = $this->input->post('sumberberita');
            $url = $this->input->post('url');
            $taglink1 = $this->input->post('taglink1');
            $taglink2 = $this->input->post('taglink2');
            $taglink3 = $this->input->post('taglink3');

            $judulber1 = $this->input->post('tagjudul1');
            $judulber2 = $this->input->post('tagjudul2');

            $kategoriber1 = $this->input->post('tagkategori1');
            $kategoriber2 = $this->input->post('tagkategori2');

            $tanggalber1 = $this->input->post('tagtanggal1');
            $tanggalber2 = $this->input->post('tagtanggal2');

            $gambarber1 = $this->input->post('taggambar1');
            $gambarber2 = $this->input->post('taggambar2');

            $isiber1 = $this->input->post('tagberita1');
            $isiber2 = $this->input->post('tagberita2');

            $kontentdkperlu = $this->input->post('tagbuangkonten');
            $pagination1 = $this->input->post('pagination1');
            $pagination2 = $this->input->post('pagination2');

            $tagsstatus = $this->Tagsmodel->cekStatusTag($url);
            if($tagsstatus->status_tag == 'true')
            {
                $geturl = array(
                    'url' =>$url,
                    'taglink1' => $taglink1,
                    'taglink2' => $taglink2,
                    'taglink3' => $taglink3,
                    'judulberita1' => $judulber1,
                    'judulberita2' => $judulber2,
                    'kategoriberita1' => $kategoriber1,
                    'kategoriberita2' => $kategoriber2,
                    'tanggalberita1' => $tanggalber1,
                    'tanggalberita2' => $tanggalber2,
                    'gambarberita1' => $gambarber1,
                    'gambarberita2' => $gambarber2,
                    'isiberita1' => $isiber1,
                    'isiberita2' => $isiber2,
                    'buangkonten' => $kontentdkperlu,
                    'pagination1' => $pagination1,
                    'pagination2' => $pagination2,
                    'status_tag' =>'true',
                    'sumberberita' => $sumberberita
                );
                $this->Tagsmodel->updateDataTags($geturl, $url);
            }
            else
            {

                $geturlbaru = array(
                    'url' =>$url,
                    'taglink1' => $taglink1,
                    'taglink2' => $taglink2,
                    'taglink3' => $taglink3,
                    'judulberita1' => $judulber1,
                    'judulberita2' => $judulber2,
                    'kategoriberita1' => $kategoriber1,
                    'kategoriberita2' => $kategoriber2,
                    'tanggalberita1' => $tanggalber1,
                    'tanggalberita2' => $tanggalber2,
                    'gambarberita1' => $gambarber1,
                    'gambarberita2' => $gambarber2,
                    'isiberita1' => $isiber1,
                    'isiberita2' => $isiber2,
                    'buangkonten' => $kontentdkperlu,
                    'pagination1' => $pagination1,
                    'pagination2' => $pagination2,
                    'status_tag' =>'true',
                    'sumberberita' => $sumberberita
                );
                $nganu = $this->Tagsmodel->InsertGetUrl($geturlbaru);
                $geturlf = array(
                    'url' =>$url,
                    'status_tag' =>'false',
                    'id_tag_pengganti' => $nganu
                );
                $this->Tagsmodel->UpdateTagPengganti($geturlf, $url);


            }
            echo json_encode(array('st'=>1,'msg'=>'Data Tersimpan'));

        }
    }
    function tampiltags()
    {
        $id = $this->input->post('id');
        $tags = $this->Tagsmodel->getTagsTampil($id);
        $tmpe['sumberberita'] = $tags->sumberberita;
        $tmpe['url'] = $tags->url;
        $tmpe['taglink1'] = $tags->taglink1;
        $tmpe['taglink2'] = $tags->taglink2;
        $tmpe['taglink3'] = $tags->taglink3;
        $tmpe['judulberita1'] = $tags->judulberita1;
        $tmpe['judulberita2'] = $tags->judulberita2;
        $tmpe['kategoriberita1'] = $tags->kategoriberita1;
        $tmpe['kategoriberita2'] = $tags->kategoriberita2;
        $tmpe['tanggalberita1'] = $tags->tanggalberita1;
        $tmpe['tanggalberita2'] = $tags->tanggalberita2;
        $tmpe['gambarberita1'] = $tags->gambarberita1;
        $tmpe['gambarberita2'] = $tags->gambarberita2;
        $tmpe['isiberita1'] = $tags->isiberita1;
        $tmpe['isiberita2'] = $tags->isiberita2;
        $tmpe['buangkonten'] = $tags->buangkonten;
        $tmpe['pagination1'] = $tags->pagination1;
        $tmpe['pagination2'] = $tags->pagination2;

        echo json_encode($tmpe);

    }

}