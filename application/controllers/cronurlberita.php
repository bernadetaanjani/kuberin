<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronurlberita extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('simple_html_dom');
        $this->load->model('Scrapmodel');
    }
    function index($sumber)
    {
        $taggeturl = $this->Scrapmodel->GetTag($sumber);
        $tampungurlberita=array();

        if(!empty($taggeturl)) {
            foreach ($taggeturl as $rows) {
                $id = $rows['id_geturl'];
                $url = $rows['url'];
                $html = file_get_html($url);
                $tampungurl = explode('/', $url);
                $urlfix = "http://" . $tampungurl[2];
                $tempexpl = explode('.',$tampungurl[2]);

                $taglink1 = $rows['taglink1'];
                $taglink2 = $rows['taglink2'];
                $taglink3 = $rows['taglink3'];
                foreach ($html->find($taglink1) as $linkberita1) {
                    foreach ($linkberita1->find($taglink2) as $linkberita2) {
                        $articles = $linkberita2->find($taglink3, 0)->href;


                        if (strpos($articles, 'http') !== false) {
                            $result = $this->Scrapmodel->CheckDbTagGetBerita($articles);
                            if(!$result && $articles!='http://www.tempo.co/read/news/1970/01/01/0000/')
                            {
                                $gabungurl = array(
                                    'url_berita' => $articles,
                                    'status' => 'belum',
                                    'tbl_geturl_id_geturl' => $id
                                );
                                $tampungurlberita[] = $gabungurl;

                            }
                            else
                            {

                            }


                        }
                        else if(strpos($articles, $tampungurl[2]) !== false && !(strpos($articles, 'http') !== false))
                        {
                            $tmpurl='http:'.$articles;
                            $result = $this->Scrapmodel->CheckDbTagGetBerita($tmpurl);
                            if(!$result && $tmpurl!='http://www.tempo.co/read/news/1970/01/01/0000/')
                            {
                                $gabungurl = array(
                                    'url_berita' => $tmpurl,
                                    'status' => 'belum',
                                    'tbl_geturl_id_geturl' => $id
                                );
                                $tampungurlberita[] = $gabungurl;

                            }
                            else
                            {

                            }

                        }
                        else if(!(strpos($articles,$tempexpl[1]) !==false)&&!(strpos($articles, $tampungurl[2]) !== false) && !(strpos($articles, 'http') !== false)){
                            $tmpurl = $urlfix . $articles;
                            $result = $this->Scrapmodel->CheckDbTagGetBerita($tmpurl);
                            if(!$result && $tmpurl!='http://www.tempo.co/read/news/1970/01/01/0000/')
                            {
                                $gabungurl = array(
                                    'url_berita' => $tmpurl,
                                    'status' => 'belum',
                                    'tbl_geturl_id_geturl' => $id
                                );
                                $tampungurlberita[] = $gabungurl;
                            }
                            else
                            {

                            }

                        }
                        else if(strpos($articles,$tempexpl[1]) !==false&&!(strpos($articles, $tampungurl[2]) !== false) && !(strpos($articles, 'http') !== false)){
                            $tmpurl = "http:" . $articles;
                            $result = $this->Scrapmodel->CheckDbTagGetBerita($tmpurl);
                            if(!$result && $tmpurl!='http://www.tempo.co/read/news/1970/01/01/0000/')
                            {
                                $gabungurl = array(
                                    'url_berita' => $tmpurl,
                                    'status' => 'belum',
                                    'tbl_geturl_id_geturl' => $id
                                );
                                $tampungurlberita[] = $gabungurl;
                            }
                            else
                            {

                            }

                        }


                    }
                }

                sleep(3);
            }

            if(!empty($tampungurlberita))
            {
                $new_arraytampung = array_intersect_key($tampungurlberita, array_unique(array_map('serialize', $tampungurlberita)));
                //$new_arraytampung = array_unique($tampungurlberita, SORT_REGULAR);
                $yuuu = array_chunk($new_arraytampung,20);
                foreach ($yuuu as $rows) {
                    $this->Scrapmodel->InsertGetBerita($rows);
                    sleep(3);
                }
            }
            sleep(3);

        }




    }
}