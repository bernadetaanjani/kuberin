<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Croncekaktif extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('simple_html_dom');
        $this->load->model('Scrapmodel');
    }
    function index($sumber)
    {
        $gabungurl = array();
        $gabungurlpaging = array();
        $katarray = array();
        $tmpluar = array();
        $tampungbaca = array();
        $tampungbacabuang = array();
        $tampungisiberitapaging=array();
        $tanggaldanwaktu=array();



        $taggeturl = $this->Scrapmodel->GetTag($sumber);


        if(!empty($taggeturl)) {
            foreach ($taggeturl as $rows) {
                $url = $rows['url'];
                $sumberberita = $rows['sumberberita'];
                $taglink1 = $rows['taglink1'];
                $taglink2 = $rows['taglink2'];
                $taglink3 = $rows['taglink3'];
                $judulber1 = $rows['judulberita1'];
                $judulber2 = $rows['judulberita2'];
                $kategoriber1 = $rows['kategoriberita1'];
                $kategoriber2 = $rows['kategoriberita2'];
                $tanggalber1 = $rows['tanggalberita1'];
                $tanggalber2 = $rows['tanggalberita2'];
                $gambarber1 = $rows['gambarberita1'];
                $gambarber2 = $rows['gambarberita2'];
                $isiber1 = $rows['isiberita1'];
                $isiber2 = $rows['isiberita2'];
                $kontentdkperlu = $rows['buangkonten'];
                $pagination1 = $rows['pagination1'];
                $pagination2 = $rows['pagination2'];

                $html = file_get_html($url);
                $tampungurl = explode('/', $url);
                $urlfix = "http://" . $tampungurl[2];
                $tempexpl = explode('.',$tampungurl[2]);

                foreach ($html->find($taglink1) as $linkberita1) {
                    foreach ($linkberita1->find($taglink2) as $linkberita2) {
                        @$articles = $linkberita2->find($taglink3, 0)->href;

                        if (strpos($articles, 'http') !== false) {
                            @$gabungurl[] = $articles;
                        } else if (strpos($articles, $tampungurl[2]) !== false && strpos($articles, 'http') == false) {
                            @$gabungurl[] = "http:" . $articles;
                        } else if(strpos($articles,$tempexpl[1]) ==false&&strpos($articles, $tampungurl[2]) == false && strpos($articles, 'http') == false){
                            @$gabungurl[] = $urlfix . $articles;
                        } else if(strpos($articles,$tempexpl[1]) !==false&&strpos($articles, $tampungurl[2]) == false && strpos($articles, 'http') == false){
                            @$gabungurl[] = "http:" . $articles;
                        }
                    }
                }
                $tampungurl=array();

                if (!empty($gabungurl)) {
                    for ($i = 0; $i < 1; $i++) {
                        $ber = file_get_html($gabungurl[$i]);

                        foreach ($ber->find($judulber1) as $judulberita) {
                            @$judultamp = $judulberita->find($judulber2, 0)->plaintext;
                            @$judul = trim($judultamp);
                            @$judulfix = preg_replace("/&#?[a-z0-9]+;/i", " ", $judul);
                            $tmpjud = utf8_encode($judulfix);
                            $judulfix = str_replace('â',"",$tmpjud);
                            $judulfix = str_replace('Œ',"",$judulfix);
                            $judulfix = str_replace('œ',"",$judulfix);
                            $judulfix = str_replace('€',"",$judulfix);
                            $judulfix = str_replace('�',"",$judulfix);
                        }

                        foreach ($ber->find($kategoriber1) as $kategoriberita) {
                            foreach ($kategoriberita->find($kategoriber2) as $kattmp) {
                                @$kategoritmp = trim($kattmp->plaintext);
                                @$katarray[] = $kategoritmp;
                            }
                            @$kategorifix = trim(end($katarray));

                        }

                        foreach ($ber->find($tanggalber1) as $tanggalberita) {
                            @$tanggaldanwaktu[] = $tanggalberita->find($tanggalber2, 0)->plaintext;
                            foreach ($tanggaldanwaktu as $tglwkt) {
                                if (empty($tglwkt)) {

                                } else {
                                    @$tanggal = $this->tanggalconvert($tglwkt);
                                    @$waktu = $this->waktuconvert($tglwkt);
                                }
                            }


                        }
                        foreach ($ber->find($gambarber1) as $gambarberita) {
                            @$gambartamp = $gambarberita->find($gambarber2 . '[alt=' . $judul . ']', 0)->src;
                            if (empty($gambartamp)) {
                                @$gambarx = $gambarberita->find($gambarber2, 0)->src;
                                if(stripos($gambarx,'http')!==false||strpos($gambarx,'https')!==false)
                                {
                                    $gambar=$gambarx;

                                }
                                else
                                {
                                    $gambar='http:'.$gambarx;

                                }
                            } else {
                                @$gambarx = $gambarberita->find($gambarber2 . '[alt=' . $judul . ']', 0)->src;
                                if(stripos($gambarx,'http')!==false||strpos($gambarx,'https')!==false)
                                {
                                    $gambar=$gambarx;
                                }
                                else
                                {
                                    $gambar='http:'.$gambarx;

                                }
                            }
                        }

                        $isiutama = $this->getIsiBerita($ber,$isiber1,$isiber2,$kontentdkperlu);
                        if(!empty($isiutama)) {
                            $isiutama = $isiutama . ".";
                            $isiutama = str_replace('......', ".", $isiutama);
                            $isiutama = str_replace('.....', ".", $isiutama);
                            $isiutama = str_replace('....', ".", $isiutama);
                            $isiutama = str_replace('...', ".", $isiutama);
                            $isiutama = str_replace('..', ".", $isiutama);
                            $isiutama = str_replace(' . . ', ".", $isiutama);
                            $isiutama = str_replace(' .. ', ".", $isiutama);
                            $isiutama = str_replace('.. ', ".", $isiutama);
                            $isiutama = str_replace(' ..', ".", $isiutama);

                            if (!empty($pagination1) && !empty($pagination2)) {
                                foreach ($ber->find($pagination1) as $psg1) {
                                    foreach ($psg1->find($pagination2) as $linknganu) {
                                        $linkpanging = trim($linknganu->href);
                                        if (strpos($linkpanging, 'http') !== false) {
                                            $gabungurlpaging[] = $linkpanging;
                                        } else if (strpos($linkpanging, '//') !== false && !(strpos($linkpanging, 'http:') !== false)) {
                                            $gabungurlpaging[] = "http:" . $linkpanging;
                                        } else {
                                            $gabungurlpaging[] = $urlfix . $linkpanging;
                                        }
                                    }
                                }
                                $gabungurlpaging = array_filter($gabungurlpaging);
                                $gabungurlpaging = array_unique($gabungurlpaging, SORT_REGULAR);

                                if (!empty($gabungurlpaging)) {
                                    foreach ($gabungurlpaging as $paglink) {
                                        $beritalink = file_get_html($paglink);
                                        $isifix = $this->getIsiBerita($beritalink, $isiber1, $isiber2, $kontentdkperlu);
                                        $isifix = $isifix . ".";
                                        $isifix = str_replace('......', ".", $isifix);
                                        $isifix = str_replace('.....', ".", $isifix);
                                        $isifix = str_replace('....', ".", $isifix);
                                        $isifix = str_replace('...', ".", $isifix);
                                        $isifix = str_replace('..', ".", $isifix);
                                        $isifix = str_replace(' . . ', ".", $isifix);
                                        $isifix = str_replace(' .. ', ".", $isifix);
                                        $isifix = str_replace('.. ', ".", $isifix);
                                        $isifix = str_replace(' ..', ".", $isifix);
                                        $tampungisiberitapaging[] = $isifix;
                                    }
                                    $isigab = implode(" ", $tampungisiberitapaging);
                                    $isigab = trim($isigab);
                                    $tampungisiberitapaging = array();

                                    $isiutama = trim($isiutama);

//                        $tampungpecahisifixa = explode(".",$isiutama);
//                        $tampindexisifixa = $tampungpecahisifixa[0].'.'.$tampungpecahisifixa[1];

                                    if (stripos($isigab, $isiutama) !== false) {
                                        $isiberitafix = $isigab;
                                        $isiberitafix = str_replace("  ", " ", $isiberitafix);
                                        $isiberitafix = $isiberitafix . ".";
                                        $isiberitafix = str_replace('......', ".", $isiberitafix);
                                        $isiberitafix = str_replace('.....', ".", $isiberitafix);
                                        $isiberitafix = str_replace('....', ".", $isiberitafix);
                                        $isiberitafix = str_replace('...', ".", $isiberitafix);
                                        $isiberitafix = str_replace('..', ".", $isiberitafix);
                                        $isiberitafix = str_replace(' . . ', ".", $isiberitafix);
                                        $isiberitafix = str_replace(' .. ', ".", $isiberitafix);
                                        $isiberitafix = str_replace('.. ', ".", $isiberitafix);
                                        $isiberitafix = str_replace(' ..', ".", $isiberitafix);

                                    } else {
                                        $isiberitafix = $isiutama . " " . $isigab;
                                        $isiberitafix = str_replace("  ", " ", $isiberitafix);
                                        $isiberitafix = $isiberitafix . ".";
                                        $isiberitafix = str_replace('......', ".", $isiberitafix);
                                        $isiberitafix = str_replace('.....', ".", $isiberitafix);
                                        $isiberitafix = str_replace('....', ".", $isiberitafix);
                                        $isiberitafix = str_replace('...', ".", $isiberitafix);
                                        $isiberitafix = str_replace('..', ".", $isiberitafix);
                                        $isiberitafix = str_replace(' . . ', ".", $isiberitafix);
                                        $isiberitafix = str_replace(' .. ', ".", $isiberitafix);
                                        $isiberitafix = str_replace('.. ', ".", $isiberitafix);
                                        $isiberitafix = str_replace(' ..', ".", $isiberitafix);
                                    }

                                } else {
                                    $isiberitafix = $isiutama;
                                    $isiberitafix = $isiberitafix . ".";
                                    $isiberitafix = str_replace('......', ".", $isiberitafix);
                                    $isiberitafix = str_replace('.....', ".", $isiberitafix);
                                    $isiberitafix = str_replace('....', ".", $isiberitafix);
                                    $isiberitafix = str_replace('...', ".", $isiberitafix);
                                    $isiberitafix = str_replace('..', ".", $isiberitafix);
                                    $isiberitafix = str_replace(' . . ', ".", $isiberitafix);
                                    $isiberitafix = str_replace(' .. ', ".", $isiberitafix);
                                    $isiberitafix = str_replace('.. ', ".", $isiberitafix);
                                    $isiberitafix = str_replace(' ..', ".", $isiberitafix);
                                }
                                $gabungurlpaging = array();

                            } else {
                                $isiberitafix = $isiutama;
                                $isiberitafix = $isiberitafix . ".";
                                $isiberitafix = str_replace('......', ".", $isiberitafix);
                                $isiberitafix = str_replace('.....', ".", $isiberitafix);
                                $isiberitafix = str_replace('....', ".", $isiberitafix);
                                $isiberitafix = str_replace('...', ".", $isiberitafix);
                                $isiberitafix = str_replace('..', ".", $isiberitafix);
                                $isiberitafix = str_replace(' . . ', ".", $isiberitafix);
                                $isiberitafix = str_replace(' .. ', ".", $isiberitafix);
                                $isiberitafix = str_replace('.. ', ".", $isiberitafix);
                                $isiberitafix = str_replace(' ..', ".", $isiberitafix);
                            }
                        }
                        else
                        {
                            $isiberitafix="";
                        }



                        if ((((!empty($judulfix)) && (!empty($kategorifix)) && (!empty($tanggal)) && (!empty($waktu)) && (!empty($isiberitafix))) || (!empty($gambar))) || ((!empty($judul)) && (!empty($kategorifix)) && (!empty($tanggal)) && (!empty($waktu)) && (!empty($isiberitafix)) &&(!empty($gambar))) ) {
                            unset($gabungurl);
                            $gabungurl = array();
                            unset($tmpluar);
                            $tmpluar = array();
                        }
                        else
                        {
                            $timenow = date("Y-m-d H:i:s");
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
                                'status_tag' =>'false',
                                'sumberberita' => $sumberberita,
                                'tgl_tdkaktif' => $timenow
                            );

                            $this->Scrapmodel->SetStatusTagGetUrl($geturl,$url);
                            unset($gabungurl);
                            $gabungurl = array();
                            unset($tmpluar);
                            $tmpluar = array();
                            $geturl=array();
                        }


                    }

                } else {
                    $timenow = date("Y-m-d H:i:s");
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
                        'status_tag' =>'false',
                        'sumberberita' => $sumberberita,
                        'tgl_tdkaktif' => $timenow
                    );

                    $this->Scrapmodel->SetStatusTagGetUrl($geturl,$url);
                    unset($gabungurl);
                    $gabungurl = array();
                    unset($tmpluar);
                    $tmpluar = array();
                    $geturl=array();

                }

            }
        }
        else
        {
            return null;
        }


    }
    function delete_all_between($beginning, $end, $string) {
        $beginningPos = strpos($string, $beginning);
        $endPos = strpos($string, $end);
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return str_replace($textToDelete, '', $string);
    }

    function getIsiBerita($ber,$isiber1,$isiber2,$kontentdkperlu)
    {
        $gabungurl=array();
        $tmpluar=array();
        $tmpa=array();
        $tampungbaca=array();
        $tampungsimak=array();
        $tampungbacabuang=array();
        $tampungsimakbuang=array();
        $tampungpilihan=array();
        $tampungpilihanbuang=array();

        foreach ($ber->find($isiber1) as $isiberita) {
            if(empty($kontentdkperlu))
            {
                @$isi = $isiberita->find($isiber2, 0)->plaintext;
                $isi = str_replace('&amp;','&',$isi);
                $isi = str_replace('&ldquo;','"',$isi);
                $isi = str_replace('&rdquo;','"',$isi);
                $isi = preg_replace("/&#?[a-z0-9]+;/i"," ",$isi);

                foreach($isiberita->find($isiber2) as $tmpisistr)
                {
                    foreach($tmpisistr->find('strong') as $estr)
                    {
                        @$tagstr=trim($estr->plaintext);
                        @$tagstr = str_replace('&amp;','&',$tagstr);
//                        @$tagstr = str_replace('&ldquo;','"',$tagstr);
//                        @$tagstr = str_replace('&rdquo;','"',$tagstr);
                        @$tagstrfix=preg_replace("/&#?[a-z0-9]+;/i"," ",$tagstr);
                        @$tmpstr[]=$tagstrfix;
                        @$tmpstr=array_unique($tmpstr, SORT_REGULAR);
                    }
                    foreach($tmpisistr->find('span') as $espan)
                    {
                        @$tagspan=trim($espan->plaintext);
                        @$tagspan = str_replace('&amp;','&',$tagspan);
//                        @$tagspan = str_replace('&ldquo;','"',$tagspan);
//                        @$tagspan = str_replace('&rdquo;','"',$tagspan);
                        @$tagspanfix=preg_replace("/&#?[a-z0-9]+;/i"," ",$tagspan);
                        @$tmpspan[]=$tagspanfix;
                        @$tmpspan=array_unique($tmpspan, SORT_REGULAR);
                    }

                    foreach($tmpisistr->find('b') as $eb)
                    {
                        @$tagb=trim($eb->plaintext);
                        @$tagb = str_replace('&amp;','&',$tagb);
//                        @$tagb = str_replace('&ldquo;','"',$tagb);
//                        @$tagb = str_replace('&rdquo;','"',$tagb);
                        @$tagbfix=preg_replace("/&#?[a-z0-9]+;/i"," ",$tagb);
                        @$tmpb[]=$tagbfix;
                        @$tmpb=array_unique($tmpb, SORT_REGULAR);
                    }

                }
                if(empty($tmpspan)&&!empty($tmpstr)&&empty($tmpb)) {
                    $arraymrn = $tmpstr;
                }
                else if(!empty($tmpspan)&&empty($tmpstr)&&empty($tmpb))
                {
                    $arraymrn = $tmpspan;
                }
                else if(empty($tmpspan)&&empty($tmpstr)&&!empty($tmpb))
                {
                    $arraymrn = $tmpb;
                }
                else if(!empty($tmpspan)&&!empty($tmpstr)&&empty($tmpb))
                {
                    $arraymrn = array_merge($tmpstr, $tmpspan);
                }
                else if(!empty($tmpspan)&&empty($tmpstr)&&!empty($tmpb))
                {
                    $arraymrn = array_merge($tmpspan, $tmpb);
                }
                else if(empty($tmpspan)&&!empty($tmpstr)&&!empty($tmpb))
                {
                    $arraymrn = array_merge($tmpstr, $tmpb);
                }
                else if(!empty($tmpspan)&&!empty($tmpstr)&&!empty($tmpb))
                {
                    $arraymrn = array_merge($tmpspan, $tmpstr, $tmpb);
                }
                else
                {
                    $arraymrn='';
                }

                $tampungsem = explode(". ",$isi);
                if(!empty($arraymrn))
                {
                    foreach($arraymrn as $arlop)
                    {
                        if(stripos($arlop,'/')==false&&stripos($arlop,'|')==false&&stripos($arlop,'?')==false&&stripos($arlop,'(')==false&&stripos($arlop,')')==false)
                        {
                            $tampungsem[0]=preg_replace('/'.$arlop.'/',"",$tampungsem[0],1);
                        }
                        else
                        {
                            $tampungsem[0]=str_replace($arlop,"",$tampungsem[0]);
                        }
                    }
                    $tampungc = explode(". ",$isi);
                    $isi = str_replace($tampungc[0],$tampungsem[0],$isi);
                }

                $isi = str_replace("      "," ",$isi);
                $isi = str_replace("     "," ",$isi);
                $isi = str_replace("    "," ",$isi);
                $isi = str_replace("   "," ",$isi);
                $isi = str_replace("  "," ",$isi);
                $isi = str_replace('......'," ",$isi);
                $isi = str_replace('.....'," ",$isi);
                $isi = str_replace('....'," ",$isi);
                $isi = str_replace('...'," ",$isi);
                $isi = str_replace('..'," ",$isi);
                $isi = str_replace(' . . ',".",$isi);
                $isi = str_replace(' .. ',".",$isi);
                $isi = str_replace('.. ',".",$isi);
                $isi = str_replace(' ..',".",$isi);
                $isi = str_replace(' ()'," ",$isi);
                $isi = str_replace('()'," ",$isi);
                $isi = str_replace('( )'," ",$isi);
                $isi = str_replace(' ( )'," ",$isi);
                $isi = str_replace('() '," ",$isi);
                $isi = str_replace('( ) '," ",$isi);

                if(strpos($tampungsem[0], ' ') !== false)
                {
                    foreach($isiberita->find($isiber2) as $tmpisia)
                    {
                        foreach($tmpisia->find('a') as $ea)
                        {
                            @$taga=trim($ea->plaintext);
                            $tmpa[]=$taga;
                            $tmpa=array_unique($tmpa, SORT_REGULAR);
                        }
                    }
                    $tmpa=array_filter($tmpa);



                    foreach($tampungsem as $tampungbertitik) {
                        if (stripos($tampungbertitik, 'Baca') !== false || stripos($tampungbertitik, 'baca') !== false) {
                            $tampungbaca[]=$tampungbertitik;
                        }
                        else if (stripos($tampungbertitik, 'Simak') !== false || stripos($tampungbertitik, 'simak') !== false) {
                            $tampungsimak[]=$tampungbertitik;
                        }
                        else if(stripos($tampungbertitik, 'PILIHAN:')!==false||stripos($tampungbertitik,'pilihan:')!==false)
                        {
                            $tampungpilihan[]=$tampungbertitik;
                        }
                        else
                        {}
                    }

                    foreach($tampungbaca as $bacahapus)
                    {
                        foreach($tmpa as $atag)
                        {
                            if(stripos($bacahapus,$atag)!==false)
                            {
                                $xtmp = str_replace("     "," ",$bacahapus);
                                $xtmp = str_replace("    "," ",$xtmp);
                                $xtmp = str_replace("   "," ",$xtmp);
                                $xtmp = str_replace("  "," ",$xtmp);
                                $xtmp = str_replace('......'," ",$xtmp);
                                $xtmp = str_replace('.....'," ",$xtmp);
                                $xtmp = str_replace('....'," ",$xtmp);
                                $xtmp = str_replace('...'," ",$xtmp);
                                $xtmp = str_replace('..'," ",$xtmp);
                                $ytmp = str_replace("     "," ",$atag);
                                $ytmp = str_replace("    "," ",$ytmp);
                                $ytmp = str_replace("   "," ",$ytmp);
                                $ytmp = str_replace("  "," ",$ytmp);
                                $ytmp = str_replace('......'," ",$ytmp);
                                $ytmp = str_replace('.....'," ",$ytmp);
                                $ytmp = str_replace('....'," ",$ytmp);
                                $ytmp = str_replace('...'," ",$ytmp);
                                $ytmp = str_replace('..'," ",$ytmp);
                                $bacatam['kal_baca']=$xtmp;
                                $bacatam['kal_taga']=$ytmp;
                                $tampungbacabuang[]=$bacatam;
                            }
                            else
                            { }
                        }
                    }


                    $result = array();

                    foreach ($tampungbacabuang as $item)
                    {
                        $id = $item['kal_baca'];

                        if (isset($result[$id]))
                        {
                            $result[$id]['kal_taga']= $result[$id]['kal_taga']." ".$item['kal_taga'];
                        }
                        else
                        {
                            $result[$id] = $item;
                        }
                    }

                    $isi = str_replace("      "," ",$isi);
                    $isi = str_replace("     "," ",$isi);
                    $isi = str_replace("    "," ",$isi);
                    $isi = str_replace("   "," ",$isi);
                    $isi = str_replace("  "," ",$isi);
                    $tmpbuangan = array_values($result);


                    foreach ($tmpbuangan as $nganugan)
                    {
                        if(strpos($nganugan['kal_baca'],'(Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('(Baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'( Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('( Baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'[Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('[Baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'[ Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('[ Baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('Baca',$nganugan['kal_taga'],$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'(baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('(baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'( baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('( baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'[baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('[baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'[ baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('[ baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('baca',$nganugan['kal_taga'],$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }

                    }
                    foreach($tampungsimak as $simakhapus)
                    {
                        foreach($tmpa as $atag)
                        {
                            if(stripos($simakhapus,$atag)!==false)
                            {
                                $qtmp = str_replace("     "," ",$simakhapus);
                                $qtmp = str_replace("    "," ",$qtmp);
                                $qtmp = str_replace("   "," ",$qtmp);
                                $qtmp = str_replace("  "," ",$qtmp);
                                $qtmp = str_replace('......'," ",$qtmp);
                                $qtmp = str_replace('.....'," ",$qtmp);
                                $qtmp = str_replace('....'," ",$qtmp);
                                $qtmp = str_replace('...'," ",$qtmp);
                                $qtmp = str_replace('..'," ",$qtmp);
                                $wtmp = str_replace("     "," ",$atag);
                                $wtmp = str_replace("    "," ",$wtmp);
                                $wtmp = str_replace("   "," ",$wtmp);
                                $wtmp = str_replace("  "," ",$wtmp);
                                $wtmp = str_replace('......'," ",$wtmp);
                                $wtmp = str_replace('.....'," ",$wtmp);
                                $wtmp = str_replace('....'," ",$wtmp);
                                $wtmp = str_replace('...'," ",$wtmp);
                                $wtmp = str_replace('..'," ",$wtmp);
                                $simaktam['kal_simak']=$qtmp;
                                $simaktam['kal_taga']=$wtmp;
                                $tampungsimakbuang[]=$simaktam;
                            }
                            else
                            { }
                        }
                    }

                    $resultsimak = array();

                    foreach ($tampungsimakbuang as $itemsimak)
                    {
                        $idsimak = $itemsimak['kal_simak'];

                        if (isset($resultsimak[$idsimak]))
                        {
                            $resultsimak[$idsimak]['kal_taga']= $resultsimak[$idsimak]['kal_taga']." ".$itemsimak['kal_taga'];
                        }
                        else
                        {
                            $resultsimak[$idsimak] = $itemsimak;
                        }
                    }
                    $tmpbuangansimak = array_values($resultsimak);
                    foreach ($tmpbuangansimak as $nganugansimak) {
                        if (strpos($nganugansimak['kal_simak'], 'Simak') !== false) {
                            $tampunghasile = $this->delete_all_between('Simak', $nganugansimak['kal_taga'], $nganugansimak['kal_simak']);
                            $isi = str_replace($nganugansimak['kal_simak'], $tampunghasile, $isi);
                        }
                        else if (strpos($nganugansimak['kal_simak'], 'simak') !== false) {
                            $tampunghasile = $this->delete_all_between('simak', $nganugansimak['kal_taga'], $nganugansimak['kal_simak']);
                            $isi = str_replace($nganugansimak['kal_simak'], $tampunghasile, $isi);
                        }

                    }
                    foreach($tampungpilihan as $pilihanhapus)
                    {
                        foreach($tmpa as $atag)
                        {
                            if(stripos($pilihanhapus,$atag)!==false)
                            {
                                $rtmp = str_replace("     "," ",$pilihanhapus);
                                $rtmp = str_replace("    "," ",$rtmp);
                                $rtmp = str_replace("   "," ",$rtmp);
                                $rtmp = str_replace("  "," ",$rtmp);
                                $rtmp = str_replace('......'," ",$rtmp);
                                $rtmp = str_replace('.....'," ",$rtmp);
                                $rtmp = str_replace('....'," ",$rtmp);
                                $rtmp = str_replace('...'," ",$rtmp);
                                $rtmp = str_replace('..'," ",$rtmp);
                                $itmp = str_replace("     "," ",$atag);
                                $itmp = str_replace("    "," ",$itmp);
                                $itmp = str_replace("   "," ",$itmp);
                                $itmp = str_replace("  "," ",$itmp);
                                $itmp = str_replace('......'," ",$itmp);
                                $itmp = str_replace('.....'," ",$itmp);
                                $itmp = str_replace('....'," ",$itmp);
                                $itmp = str_replace('...'," ",$itmp);
                                $itmp = str_replace('..'," ",$itmp);
                                $pilihantam['kal_pilihan']=$rtmp;
                                $pilihantam['kal_taga']=$itmp;
                                $tampungpilihanbuang[]=$pilihantam;
                            }
                            else
                            { }
                        }
                    }

                    $resultpilihan = array();

                    foreach ($tampungpilihanbuang as $itempilihan)
                    {
                        $idpilihan = $itempilihan['kal_pilihan'];

                        if (isset($resultpilihan[$idpilihan]))
                        {
                            $resultpilihan[$idpilihan]['kal_taga']= $resultpilihan[$idpilihan]['kal_taga']."".$itempilihan['kal_taga'];
                        }
                        else
                        {
                            $resultpilihan[$idpilihan] = $itempilihan;
                        }
                    }
                    $tmpbuanganpilihan = array_values($resultpilihan);
                    foreach ($tmpbuanganpilihan as $nganuganpilihan) {

                        if (strpos($nganuganpilihan['kal_pilihan'], 'PILIHAN') !== false) {
                            $tampunghasile = $this->delete_all_between('PILIHAN', $nganuganpilihan['kal_taga'], $nganuganpilihan['kal_pilihan']);
                            $isi = str_replace($nganuganpilihan['kal_pilihan'], $tampunghasile, $isi);

                        }
                        else if (strpos($nganuganpilihan['kal_pilihan'], 'Pilihan') !== false) {
                            $tampunghasile = $this->delete_all_between('Pilihan', $nganuganpilihan['kal_taga'], $nganuganpilihan['kal_pilihan']);
                            $isi = str_replace($nganuganpilihan['kal_pilihan'], $tampunghasile, $isi);

                        }

                    }

                    $isi=trim($isi);
                    $isi = ltrim($isi,',  - ');
                    $isi = ltrim($isi,',- ');
                    $isi = ltrim($isi,', - ');
                    $isi = ltrim($isi,', -');
                    $isi = ltrim($isi,',  -');
                    $isi = ltrim($isi,', :');
                    $isi = ltrim($isi,'-- ');
                    $isi = ltrim($isi,'– ');
                    $isi = ltrim($isi,'- ');
                    $isi = ltrim($isi,' - ');
                    $isi = ltrim($isi,',    ');
                    $isi = ltrim($isi,',   ');
                    $isi = ltrim($isi,',  ');
                    $isi = ltrim($isi,',');

                    $isi = str_replace("      "," ",$isi);
                    $isi = str_replace("     "," ",$isi);
                    $isi = str_replace("    "," ",$isi);
                    $isi = str_replace("   "," ",$isi);
                    $isi = str_replace("  "," ",$isi);
                    $isi = str_replace('......',".",$isi);
                    $isi = str_replace('.....',".",$isi);
                    $isi = str_replace('....',".",$isi);
                    $isi = str_replace('...',".",$isi);
                    $isi = str_replace('..',".",$isi);
                    $isi = str_replace(' . . ',".",$isi);
                    $isi = str_replace(' .. ',".",$isi);
                    $isi = str_replace('.. ',".",$isi);
                    $isi = str_replace(' ..',".",$isi);
                    $isi = str_replace(' ()'," ",$isi);
                    $isi = str_replace('()'," ",$isi);
                    $isi = str_replace('( )'," ",$isi);
                    $isi = str_replace(' ( )'," ",$isi);
                    $isi = str_replace('() '," ",$isi);
                    $isi = str_replace('( ) '," ",$isi);
                    $isi = str_replace('
Berita ini juga dapat dibaca melalui m.detik.com dan aplikasi detikcom untuk BlackBerry, Android, iOS & Windows Phone. Install sekarang!',"",$isi);

                    $yarr = explode(".",$isi);
                    $xount = count($yarr);
                    for($x=0;$x<$xount;$x++)
                    {
                        @$j=$x+1;
                        $last_word_start = strrpos($yarr[$x], ' ') + 1; // +1 so we don't include the space in our result
                        $last_word = substr($yarr[$x], $last_word_start);

                        @$xss=strpos($yarr[$j], ' ');
                        @$first_word = substr($yarr[$j], 0, $xss !== false ? $xss : strlen($yarr[$j]));
                        if(is_numeric($last_word)&& is_numeric($first_word))
                        {
                            @$xyc = "";
                        }
                        else if($last_word!==''&&$first_word==='')
                        {
                            @$xyc = "";
                        }
                        else
                        {
                            @$xyc['lama'] = $yarr[$j];
                            @$xyc['baru'] = " ".$yarr[$j];
                        }

                        $arrxvb[]=$xyc;
                    }
                    $tampungbaru = array_filter($arrxvb);
                    foreach($tampungbaru as $asa)
                    {
                        $isi = str_replace($asa['lama'],$asa['baru'],$isi);
                    }
                    return trim($isi);
                }
                else
                {
                    return "";
                }

            }
            else
            {
                @$isi = $isiberita->find($isiber2, 0)->plaintext;
                $isi = str_replace('&amp;','&',$isi);
                $isi = str_replace('&ldquo;','"',$isi);
                $isi = str_replace('&rdquo;','"',$isi);
                $isi = preg_replace("/&#?[a-z0-9]+;/i"," ",$isi);

                $kontentdkperlutmp = explode(",",$kontentdkperlu);
                foreach($kontentdkperlutmp as $kontentdk)
                {
                    foreach($isiberita->find($isiber2) as $tmpisi)
                    {
                        foreach($tmpisi->find($kontentdk) as $e)
                        {
                            @$luarisix=trim($e->plaintext);
                            @$luarisix = str_replace('&amp;','&',$luarisix);
                            @$luarisix = str_replace('&ldquo;','"',$luarisix);
                            @$luarisix = str_replace('&rdquo;','"',$luarisix);
                            @$luarisi=preg_replace("/&#?[a-z0-9]+;/i"," ",$luarisix);
                            $tmpluar[]=$luarisi;
                            $tmpluar=array_unique($tmpluar, SORT_REGULAR);
                        }


                    }

                }
                //  print_r($tmpluar);
                foreach($tmpluar as $s)
                {
                    if(stripos($s,'/')==false&&stripos($s,'|')==false&&stripos($s,'?')==false&&stripos($s,'(')==false&&stripos($s,')')==false)
                    {
                        $isi=preg_replace('/'.$s.'/',"",$isi,1);
                    }
                    else
                    {
                        $isi = str_replace($s,"",$isi);
                    }
                }
                $tmpluar=array();

                foreach($isiberita->find($isiber2) as $tmpisistr)
                {
                    foreach($tmpisistr->find('strong') as $estr)
                    {
                        @$tagstr=trim($estr->plaintext);
                        @$tagstr = str_replace('&amp;','&',$tagstr);
//                        @$tagstr = str_replace('&ldquo;','"',$tagstr);
//                        @$tagstr = str_replace('&rdquo;','"',$tagstr);
                        @$tagstrfix=preg_replace("/&#?[a-z0-9]+;/i"," ",$tagstr);
                        @$tmpstr[]=$tagstrfix;
                        @$tmpstr=array_unique($tmpstr, SORT_REGULAR);
                    }
                    foreach($tmpisistr->find('span') as $espan)
                    {
                        @$tagspan=trim($espan->plaintext);
                        @$tagspan = str_replace('&amp;','&',$tagspan);
//                        @$tagspan = str_replace('&ldquo;','"',$tagspan);
//                        @$tagspan = str_replace('&rdquo;','"',$tagspan);
                        @$tagspanfix=preg_replace("/&#?[a-z0-9]+;/i"," ",$tagspan);
                        @$tmpspan[]=$tagspanfix;
                        @$tmpspan=array_unique($tmpspan, SORT_REGULAR);
                    }

                    foreach($tmpisistr->find('b') as $eb)
                    {
                        @$tagb=trim($eb->plaintext);
                        @$tagb = str_replace('&amp;','&',$tagb);
//                        @$tagb = str_replace('&ldquo;','"',$tagb);
//                        @$tagb = str_replace('&rdquo;','"',$tagb);
                        @$tagbfix=preg_replace("/&#?[a-z0-9]+;/i"," ",$tagb);
                        @$tmpb[]=$tagbfix;
                        @$tmpb=array_unique($tmpb, SORT_REGULAR);
                    }

                }

                if(empty($tmpspan)&&!empty($tmpstr)&&empty($tmpb)) {
                    $arraymrn = $tmpstr;
                }
                else if(!empty($tmpspan)&&empty($tmpstr)&&empty($tmpb))
                {
                    $arraymrn = $tmpspan;
                }
                else if(empty($tmpspan)&&empty($tmpstr)&&!empty($tmpb))
                {
                    $arraymrn = $tmpb;
                }
                else if(!empty($tmpspan)&&!empty($tmpstr)&&empty($tmpb))
                {
                    $arraymrn = array_merge($tmpstr, $tmpspan);
                }
                else if(!empty($tmpspan)&&empty($tmpstr)&&!empty($tmpb))
                {
                    $arraymrn = array_merge($tmpspan, $tmpb);
                }
                else if(empty($tmpspan)&&!empty($tmpstr)&&!empty($tmpb))
                {
                    $arraymrn = array_merge($tmpstr, $tmpb);
                }
                else if(!empty($tmpspan)&&!empty($tmpstr)&&!empty($tmpb))
                {
                    $arraymrn = array_merge($tmpspan, $tmpstr, $tmpb);
                }
                else
                {
                    $arraymrn='';
                }

                $tampungsem = explode(". ",$isi);
                if(!empty($arraymrn))
                {
                    foreach($arraymrn as $arlop)
                    {
                        if(stripos($arlop,'/')==false&&stripos($arlop,'|')==false&&stripos($arlop,'?')==false&&stripos($arlop,'(')==false&&stripos($arlop,')')==false)
                        {
                            $tampungsem[0]=preg_replace('/'.$arlop.'/',"",$tampungsem[0],1);
                        }
                        else
                        {
                            $tampungsem[0]=str_replace($arlop,"",$tampungsem[0]);
                        }
                    }
                    $tampungc = explode(". ",$isi);
                    $isi = str_replace($tampungc[0],$tampungsem[0],$isi);
                }

                $isi = str_replace("      "," ",$isi);
                $isi = str_replace("     "," ",$isi);
                $isi = str_replace("    "," ",$isi);
                $isi = str_replace("   "," ",$isi);
                $isi = str_replace("  "," ",$isi);
                $isi = str_replace('......'," ",$isi);
                $isi = str_replace('.....'," ",$isi);
                $isi = str_replace('....'," ",$isi);
                $isi = str_replace('...'," ",$isi);
                $isi = str_replace('..'," ",$isi);
                $isi = str_replace(' . . ',".",$isi);
                $isi = str_replace(' .. ',".",$isi);
                $isi = str_replace('.. ',".",$isi);
                $isi = str_replace(' ..',".",$isi);
                $isi = str_replace(' ()'," ",$isi);
                $isi = str_replace('()'," ",$isi);
                $isi = str_replace('( )'," ",$isi);
                $isi = str_replace(' ( )'," ",$isi);
                $isi = str_replace('() '," ",$isi);
                $isi = str_replace('( ) '," ",$isi);
                if(strpos($tampungsem[0], ' ') !== false)
                {
                    foreach($isiberita->find($isiber2) as $tmpisia)
                    {
                        foreach($tmpisia->find('a') as $ea)
                        {
                            @$taga=trim($ea->plaintext);
                            $tmpa[]=$taga;
                            $tmpa=array_unique($tmpa, SORT_REGULAR);
                        }
                    }
                    $tmpa=array_filter($tmpa);


                    foreach($tampungsem as $tampungbertitik) {
                        if (stripos($tampungbertitik, 'Baca') !== false || stripos($tampungbertitik, 'baca') !== false) {
                            $tampungbaca[]=$tampungbertitik;
                        }
                        else if (stripos($tampungbertitik, 'Simak') !== false || stripos($tampungbertitik, 'simak') !== false) {
                            $tampungsimak[]=$tampungbertitik;
                        }
                        else if(stripos($tampungbertitik, 'PILIHAN:')!==false||stripos($tampungbertitik,'pilihan:')!==false)
                        {
                            $tampungpilihan[]=$tampungbertitik;
                        }
                        else
                        {}
                    }

                    foreach($tampungbaca as $bacahapus)
                    {
                        foreach($tmpa as $atag)
                        {
                            if(stripos($bacahapus,$atag)!==false)
                            {
                                $xtmp = str_replace("     "," ",$bacahapus);
                                $xtmp = str_replace("    "," ",$xtmp);
                                $xtmp = str_replace("   "," ",$xtmp);
                                $xtmp = str_replace("  "," ",$xtmp);
                                $xtmp = str_replace('......'," ",$xtmp);
                                $xtmp = str_replace('.....'," ",$xtmp);
                                $xtmp = str_replace('....'," ",$xtmp);
                                $xtmp = str_replace('...'," ",$xtmp);
                                $xtmp = str_replace('..'," ",$xtmp);
                                $ytmp = str_replace("     "," ",$atag);
                                $ytmp = str_replace("    "," ",$ytmp);
                                $ytmp = str_replace("   "," ",$ytmp);
                                $ytmp = str_replace("  "," ",$ytmp);
                                $ytmp = str_replace('......'," ",$ytmp);
                                $ytmp = str_replace('.....'," ",$ytmp);
                                $ytmp = str_replace('....'," ",$ytmp);
                                $ytmp = str_replace('...'," ",$ytmp);
                                $ytmp = str_replace('..'," ",$ytmp);
                                $bacatam['kal_baca']=$xtmp;
                                $bacatam['kal_taga']=$ytmp;
                                $tampungbacabuang[]=$bacatam;
                            }
                            else
                            { }
                        }
                    }


                    $result = array();

                    foreach ($tampungbacabuang as $item)
                    {
                        $id = $item['kal_baca'];

                        if (isset($result[$id]))
                        {
                            $result[$id]['kal_taga']= $result[$id]['kal_taga']." ".$item['kal_taga'];
                        }
                        else
                        {
                            $result[$id] = $item;
                        }
                    }

                    $isi = str_replace("      "," ",$isi);
                    $isi = str_replace("     "," ",$isi);
                    $isi = str_replace("    "," ",$isi);
                    $isi = str_replace("   "," ",$isi);
                    $isi = str_replace("  "," ",$isi);
                    $tmpbuangan = array_values($result);


                    foreach ($tmpbuangan as $nganugan)
                    {
                        if(strpos($nganugan['kal_baca'],'(Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('(Baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'( Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('( Baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'[Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('[Baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'[ Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('[ Baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'Baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('Baca',$nganugan['kal_taga'],$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'(baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('(baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'( baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('( baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'[baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('[baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'[ baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('[ baca',')',$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }
                        else if(strpos($nganugan['kal_baca'],'baca')!== false)
                        {
                            $tampunghasile=$this->delete_all_between('baca',$nganugan['kal_taga'],$nganugan['kal_baca']);
                            $isi = str_replace($nganugan['kal_baca'],$tampunghasile,$isi);
                        }

                    }
                    foreach($tampungsimak as $simakhapus)
                    {
                        foreach($tmpa as $atag)
                        {
                            if(stripos($simakhapus,$atag)!==false)
                            {
                                $qtmp = str_replace("     "," ",$simakhapus);
                                $qtmp = str_replace("    "," ",$qtmp);
                                $qtmp = str_replace("   "," ",$qtmp);
                                $qtmp = str_replace("  "," ",$qtmp);
                                $qtmp = str_replace('......'," ",$qtmp);
                                $qtmp = str_replace('.....'," ",$qtmp);
                                $qtmp = str_replace('....'," ",$qtmp);
                                $qtmp = str_replace('...'," ",$qtmp);
                                $qtmp = str_replace('..'," ",$qtmp);
                                $wtmp = str_replace("     "," ",$atag);
                                $wtmp = str_replace("    "," ",$wtmp);
                                $wtmp = str_replace("   "," ",$wtmp);
                                $wtmp = str_replace("  "," ",$wtmp);
                                $wtmp = str_replace('......'," ",$wtmp);
                                $wtmp = str_replace('.....'," ",$wtmp);
                                $wtmp = str_replace('....'," ",$wtmp);
                                $wtmp = str_replace('...'," ",$wtmp);
                                $wtmp = str_replace('..'," ",$wtmp);
                                $simaktam['kal_simak']=$qtmp;
                                $simaktam['kal_taga']=$wtmp;
                                $tampungsimakbuang[]=$simaktam;
                            }
                            else
                            { }
                        }
                    }

                    $resultsimak = array();

                    foreach ($tampungsimakbuang as $itemsimak)
                    {
                        $idsimak = $itemsimak['kal_simak'];

                        if (isset($resultsimak[$idsimak]))
                        {
                            $resultsimak[$idsimak]['kal_taga']= $resultsimak[$idsimak]['kal_taga']." ".$itemsimak['kal_taga'];
                        }
                        else
                        {
                            $resultsimak[$idsimak] = $itemsimak;
                        }
                    }
                    $tmpbuangansimak = array_values($resultsimak);
                    foreach ($tmpbuangansimak as $nganugansimak) {
                        if (strpos($nganugansimak['kal_simak'], 'Simak') !== false) {
                            $tampunghasile = $this->delete_all_between('Simak', $nganugansimak['kal_taga'], $nganugansimak['kal_simak']);
                            $isi = str_replace($nganugansimak['kal_simak'], $tampunghasile, $isi);
                        }
                        else if (strpos($nganugansimak['kal_simak'], 'simak') !== false) {
                            $tampunghasile = $this->delete_all_between('simak', $nganugansimak['kal_taga'], $nganugansimak['kal_simak']);
                            $isi = str_replace($nganugansimak['kal_simak'], $tampunghasile, $isi);
                        }

                    }
                    foreach($tampungpilihan as $pilihanhapus)
                    {
                        foreach($tmpa as $atag)
                        {
                            if(stripos($pilihanhapus,$atag)!==false)
                            {
                                $rtmp = str_replace("     "," ",$pilihanhapus);
                                $rtmp = str_replace("    "," ",$rtmp);
                                $rtmp = str_replace("   "," ",$rtmp);
                                $rtmp = str_replace("  "," ",$rtmp);
                                $rtmp = str_replace('......'," ",$rtmp);
                                $rtmp = str_replace('.....'," ",$rtmp);
                                $rtmp = str_replace('....'," ",$rtmp);
                                $rtmp = str_replace('...'," ",$rtmp);
                                $rtmp = str_replace('..'," ",$rtmp);
                                $itmp = str_replace("     "," ",$atag);
                                $itmp = str_replace("    "," ",$itmp);
                                $itmp = str_replace("   "," ",$itmp);
                                $itmp = str_replace("  "," ",$itmp);
                                $itmp = str_replace('......'," ",$itmp);
                                $itmp = str_replace('.....'," ",$itmp);
                                $itmp = str_replace('....'," ",$itmp);
                                $itmp = str_replace('...'," ",$itmp);
                                $itmp = str_replace('..'," ",$itmp);
                                $pilihantam['kal_pilihan']=$rtmp;
                                $pilihantam['kal_taga']=$itmp;
                                $tampungpilihanbuang[]=$pilihantam;
                            }
                            else
                            { }
                        }
                    }

                    $resultpilihan = array();

                    foreach ($tampungpilihanbuang as $itempilihan)
                    {
                        $idpilihan = $itempilihan['kal_pilihan'];

                        if (isset($resultpilihan[$idpilihan]))
                        {
                            $resultpilihan[$idpilihan]['kal_taga']= $resultpilihan[$idpilihan]['kal_taga']."".$itempilihan['kal_taga'];
                        }
                        else
                        {
                            $resultpilihan[$idpilihan] = $itempilihan;
                        }
                    }
                    $tmpbuanganpilihan = array_values($resultpilihan);
                    foreach ($tmpbuanganpilihan as $nganuganpilihan) {

                        if (strpos($nganuganpilihan['kal_pilihan'], 'PILIHAN') !== false) {
                            $tampunghasile = $this->delete_all_between('PILIHAN', $nganuganpilihan['kal_taga'], $nganuganpilihan['kal_pilihan']);
                            $isi = str_replace($nganuganpilihan['kal_pilihan'], $tampunghasile, $isi);

                        }
                        else if (strpos($nganuganpilihan['kal_pilihan'], 'Pilihan') !== false) {
                            $tampunghasile = $this->delete_all_between('Pilihan', $nganuganpilihan['kal_taga'], $nganuganpilihan['kal_pilihan']);
                            $isi = str_replace($nganuganpilihan['kal_pilihan'], $tampunghasile, $isi);

                        }

                    }

                    $isi=trim($isi);
                    $isi = ltrim($isi,',  - ');
                    $isi = ltrim($isi,',- ');
                    $isi = ltrim($isi,', - ');
                    $isi = ltrim($isi,', -');
                    $isi = ltrim($isi,',  -');
                    $isi = ltrim($isi,', :');
                    $isi = ltrim($isi,'-- ');
                    $isi = ltrim($isi,'– ');
                    $isi = ltrim($isi,'- ');
                    $isi = ltrim($isi,' - ');
                    $isi = ltrim($isi,',    ');
                    $isi = ltrim($isi,',   ');
                    $isi = ltrim($isi,',  ');
                    $isi = ltrim($isi,',');

                    $isi = str_replace("      "," ",$isi);
                    $isi = str_replace("     "," ",$isi);
                    $isi = str_replace("    "," ",$isi);
                    $isi = str_replace("   "," ",$isi);
                    $isi = str_replace("  "," ",$isi);
                    $isi = str_replace('......',".",$isi);
                    $isi = str_replace('.....',".",$isi);
                    $isi = str_replace('....',".",$isi);
                    $isi = str_replace('...',".",$isi);
                    $isi = str_replace('..',".",$isi);
                    $isi = str_replace(' . . ',".",$isi);
                    $isi = str_replace(' .. ',".",$isi);
                    $isi = str_replace('.. ',".",$isi);
                    $isi = str_replace(' ..',".",$isi);
                    $isi = str_replace(' ()'," ",$isi);
                    $isi = str_replace('()'," ",$isi);
                    $isi = str_replace('( )'," ",$isi);
                    $isi = str_replace(' ( )'," ",$isi);
                    $isi = str_replace('() '," ",$isi);
                    $isi = str_replace('( ) '," ",$isi);
                    $isi = str_replace('
Berita ini juga dapat dibaca melalui m.detik.com dan aplikasi detikcom untuk BlackBerry, Android, iOS & Windows Phone. Install sekarang!',"",$isi);

                    $yarr = explode(".",$isi);
                    $xount = count($yarr);
                    for($x=0;$x<$xount;$x++)
                    {
                        @$j=$x+1;
                        $last_word_start = strrpos($yarr[$x], ' ') + 1; // +1 so we don't include the space in our result
                        $last_word = substr($yarr[$x], $last_word_start);

                        @$xss=strpos($yarr[$j], ' ');
                        @$first_word = substr($yarr[$j], 0, $xss !== false ? $xss : strlen($yarr[$j]));
                        if(is_numeric($last_word)&& is_numeric($first_word))
                        {
                            @$xyc = "";
                        }
                        else if($last_word!==''&&$first_word==='')
                        {
                            @$xyc = "";
                        }
                        else
                        {
                            @$xyc['lama'] = $yarr[$j];
                            @$xyc['baru'] = " ".$yarr[$j];
                        }

                        $arrxvb[]=$xyc;
                    }
                    $tampungbaru = array_filter($arrxvb);
                    foreach($tampungbaru as $asa)
                    {
                        $isi = str_replace($asa['lama'],$asa['baru'],$isi);
                    }

                    return trim($isi);

                }
                else

                {

                    return "";
                }

            }


        }


    }


    function waktuconvert($tanggaldanwaktu)
    {
        $tglwaktu1 = str_replace(",","",$tanggaldanwaktu);
        $tglwaktu2 = str_replace("|","",$tglwaktu1);
        $tglwaktu3 = str_replace("-","",$tglwaktu2);
        $tglwaktu4 = str_replace("−","",$tglwaktu3);
        $tglwaktu5 = str_replace(".",":",$tglwaktu4);
        $tamptglwaktu = explode(' ',$tglwaktu5);
        foreach($tamptglwaktu as $rowstglwaktu)
        {
            if(substr($rowstglwaktu,2,1)===':')
            {
                $waktu = $rowstglwaktu;
            }

        }

        return $waktu;

    }
    function tanggalconvert($tanggaldanwaktu)
    {
        $tglwaktu1 = str_replace(",","",$tanggaldanwaktu);
        $tglwaktu2 = str_replace("|","",$tglwaktu1);
        $tglwaktu3 = str_replace("-","",$tglwaktu2);
        $tglwaktu4 = str_replace("−","",$tglwaktu3);
        $tglwaktu5 = str_replace(".",":",$tglwaktu4);
        $tamptglwaktu = explode(' ',$tglwaktu5);
        foreach($tamptglwaktu as $rowstglwaktu)
        {
            if($rowstglwaktu=="2015")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2014")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2013")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2012")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2011")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2010")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2009")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2008")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2016")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2017")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2018")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2019")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2020")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2021")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2022")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2023")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2024")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=="2025")
            {
                $tahun = $rowstglwaktu;
            }
            else if($rowstglwaktu=='Januari'||$rowstglwaktu=='januari'||$rowstglwaktu=='Jan'||$rowstglwaktu=='jan')
            {
                $bulan = '01';
            }
            else if($rowstglwaktu=='Februari'||$rowstglwaktu=='februari'||$rowstglwaktu=='Feb'||$rowstglwaktu=='feb')
            {
                $bulan = '02';
            }
            else if($rowstglwaktu=='Maret'||$rowstglwaktu=='maret'||$rowstglwaktu=='Mar'||$rowstglwaktu=='mar')
            {
                $bulan = '03';
            }
            else if($rowstglwaktu=='April'||$rowstglwaktu=='april'||$rowstglwaktu=='Apr'||$rowstglwaktu=='apr')
            {
                $bulan = '04';
            }
            else if($rowstglwaktu=='Mei'||$rowstglwaktu=='mei'||$rowstglwaktu=='May'||$rowstglwaktu=='may')
            {
                $bulan = '05';
            }
            else if($rowstglwaktu=='Juni'||$rowstglwaktu=='juni'||$rowstglwaktu=='Jun'||$rowstglwaktu=='jun')
            {
                $bulan = '06';
            }
            else if($rowstglwaktu=='Juli'||$rowstglwaktu=='juli'||$rowstglwaktu=='Jul'||$rowstglwaktu=='jul')
            {
                $bulan = '07';
            }
            else if($rowstglwaktu=='Agustus'||$rowstglwaktu=='agustus'||$rowstglwaktu=='Aug'||$rowstglwaktu=='aug'||$rowstglwaktu=='agu'||$rowstglwaktu=='Agu')
            {
                $bulan = '08';
            }
            else if($rowstglwaktu=='September'||$rowstglwaktu=='september'||$rowstglwaktu=='Sep'||$rowstglwaktu=='sep')
            {
                $bulan = '09';
            }
            else if($rowstglwaktu=='Oktober'||$rowstglwaktu=='oktober'||$rowstglwaktu=='Oct'||$rowstglwaktu=='oct'||$rowstglwaktu=='okt'||$rowstglwaktu=='Okt')
            {
                $bulan = '10';
            }
            else if($rowstglwaktu=='November'||$rowstglwaktu=='november'||$rowstglwaktu=='Nov'||$rowstglwaktu=='nov')
            {
                $bulan = '11';
            }
            else if($rowstglwaktu=='Desember'||$rowstglwaktu=='desember'||$rowstglwaktu=='Dec'||$rowstglwaktu=='dec'||$rowstglwaktu=='des'||$rowstglwaktu=='Des')
            {
                $bulan = '12';
            }
            else if($rowstglwaktu=='01'||$rowstglwaktu=='1')
            {
                $tanggal = '01';
            }
            else if($rowstglwaktu=='02'||$rowstglwaktu=='2')
            {
                $tanggal = '02';
            }
            else if($rowstglwaktu=='03'||$rowstglwaktu=='3')
            {
                $tanggal = '03';
            }
            else if($rowstglwaktu=='04'||$rowstglwaktu=='4')
            {
                $tanggal = '04';
            }
            else if($rowstglwaktu=='05'||$rowstglwaktu=='5')
            {
                $tanggal = '05';
            }
            else if($rowstglwaktu=='06'||$rowstglwaktu=='6')
            {
                $tanggal = '06';
            }
            else if($rowstglwaktu=='07'||$rowstglwaktu=='7')
            {
                $tanggal = '07';
            }
            else if($rowstglwaktu=='08'||$rowstglwaktu=='8')
            {
                $tanggal = '08';
            }
            else if($rowstglwaktu=='09'||$rowstglwaktu=='9')
            {
                $tanggal = '09';
            }
            else if($rowstglwaktu=='10')
            {
                $tanggal = '10';
            }
            else if($rowstglwaktu=='11')
            {
                $tanggal = '11';
            }
            else if($rowstglwaktu=='12')
            {
                $tanggal = '12';
            }
            else if($rowstglwaktu=='13')
            {
                $tanggal = '13';
            }
            else if($rowstglwaktu=='14')
            {
                $tanggal = '14';
            }
            else if($rowstglwaktu=='15')
            {
                $tanggal = '15';
            }
            else if($rowstglwaktu=='16')
            {
                $tanggal = '16';
            }
            else if($rowstglwaktu=='17')
            {
                $tanggal = '17';
            }
            else if($rowstglwaktu=='18')
            {
                $tanggal = '18';
            }
            else if($rowstglwaktu=='19')
            {
                $tanggal = '19';
            }
            else if($rowstglwaktu=='20')
            {
                $tanggal = '20';
            }
            else if($rowstglwaktu=='21')
            {
                $tanggal = '21';
            }
            else if($rowstglwaktu=='22')
            {
                $tanggal = '22';
            }
            else if($rowstglwaktu=='23')
            {
                $tanggal = '23';
            }
            else if($rowstglwaktu=='24')
            {
                $tanggal = '24';
            }
            else if($rowstglwaktu=='25')
            {
                $tanggal = '25';
            }
            else if($rowstglwaktu=='26')
            {
                $tanggal = '26';
            }
            else if($rowstglwaktu=='27')
            {
                $tanggal = '27';
            }
            else if($rowstglwaktu=='28')
            {
                $tanggal = '28';
            }
            else if($rowstglwaktu=='29')
            {
                $tanggal = '29';
            }
            else if($rowstglwaktu=='30')
            {
                $tanggal = '30';
            }
            else if($rowstglwaktu=='31')
            {
                $tanggal = '31';
            }
            else if(stripos($rowstglwaktu,'/')!== false)
            {
                $tampungtgl = explode("/",$rowstglwaktu);
                if(strlen($tampungtgl[0])==4)
                {
                    $tanggal = $tampungtgl[2];
                    $bulan = $tampungtgl[1];
                    $tahun = $tampungtgl[0];
                }
                else
                {
                    $tanggal = $tampungtgl[0];
                    $bulan = $tampungtgl[1];
                    $tahun = $tampungtgl[2];
                }
            }


        }
        if(!empty($tanggal)&&!empty($bulan)&&!empty($tahun)) {
            return $tahun . '/' . $bulan . '/' . $tanggal;
        }

    }
}