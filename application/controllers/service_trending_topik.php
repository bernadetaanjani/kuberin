<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_trending_topik extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Summarizemodel');
        $this->load->helper('text');

    }

    function trending()
    {
        $beritatrendsum = $this->Summarizemodel->getJumlahDataByKeyword();
        $beritatrenbaru = $this->Summarizemodel->getDataLogTerbaru();


        foreach($beritatrendsum as $tmptrendingjumlahkeyword)
        {
            foreach($beritatrenbaru as $tmptrendingterbaru)
            {
                if(stripos($tmptrendingjumlahkeyword['keyword'],$tmptrendingterbaru['keyword'])!== FALSE)
                {
                    $tmptrendingbaru=array(
                        'id_log'=>$tmptrendingterbaru['id_log'],
                        'keyword'=>$tmptrendingjumlahkeyword['keyword'],
                        'jumlah'=>$tmptrendingjumlahkeyword['c']
                    );
                    $trendingtopikarr[]=$tmptrendingbaru;

                }
                else
                {

                }
            }
        }

//        $this->aasort($trendingtopikarr,"jumlah");
        if(!empty($beritatrendsum)&&!empty($beritatrenbaru)&&!empty($trendingtopikarr))
        {
            echo json_encode(array('st'=>'1','msg'=>$trendingtopikarr));
        }
        else
        {
            echo json_encode(array('st'=> '0','msg'=>'Data Tidak Ada'));

        }
    }
    function GetDetailTrending()
    {
        $idLog = $_POST['id_log'];
        $beritatrendsum = $this->Summarizemodel->GetDataLogByID($idLog);
        if (!empty($beritatrendsum)) {
            $tampungexplode = explode(',', $beritatrendsum->idberita_terkait);
            foreach ($tampungexplode as $tmpIDBer) {
                $embuh = $this->Summarizemodel->getBeritaByID($tmpIDBer);
                $tampungan = array(
                    'id_berita' => $embuh->id_berita,
                    'judul' => $embuh->judul,
                    'tanggal' => $embuh->tanggal,
                    'waktu' => $embuh->waktu,
                    'kategori' => $embuh->kategori,
                    'gambar' => $embuh->gambar,
                    'isi_berita' => $embuh->isi_berita,
                    'link' => $embuh->link,
                    'sumberberita' => $embuh->sumberberita,
                    'timer' => $embuh->timer,
                    'datetime_scraping' => $embuh->datetime_scraping,
                );
                $tampberitaparse[] = $tampungan;
            }
            $detailLogGet = $this->Summarizemodel->GetDataDetailLogByIDLog($idLog);
            echo json_encode(array('st' => '1', 'msg' => $beritatrendsum->summarize, 'sum_score'=>$detailLogGet, 'berita' => $tampberitaparse));

        }
        else
        {
            echo json_encode(array('st'=>'2','msg'=>'Data Tidak Ada'));
        }

    }
    function aasort (&$array, $key) {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        arsort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;
    }


}