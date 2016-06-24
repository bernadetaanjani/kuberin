<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);

class Summarizebaru extends CI_Controller {
    public $stopwords;
    public $num_docs;
    public $total_words,$total_document,$total_last_words;
    public $corpus_summary,$corpus_summary_temp;
    public $Doc;
    public $summary_sentences_temp,$summary_sentences_score;
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Summarizemodel');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->num_docs = 0;
        $this->total_words = 0;
        $this->Doc = array();
        $this->total_document = 0;
        $this->total_last_words = 0;
        $this->corpus_summary_temp = '';
        $this->summary_sentences_score = array();
        $this->summary_sentences_temp = array();
        $this->corpus_summary = array();
        $this->stopwords = array(
            '--', '-', 'itu', 'dan', 'yang', 'ini', 'atau', 'dengan', 'dari', 'di', 'ke', 'untuk', 'bagi',
            'tidak', 'selain', 'seperti', 'suatu', 'belum', 'sudah', 'telah', 'demikian', 'mana', 'sana', 'sini', 'sebab',
            'sebelum', 'sesudah', 'sesuatu', 'disebabkan', 'menyebabkan', 'saya', 'kamu', 'dia', 'aku', 'mereka', 'mungkin', 'memungkinkan', 'melakukan',
            'beda','selesai', 'semua', 'semuanya', 'kecuali', 'banyak', 'sedikit', 'selama', 'lama', 'tiap', 'setiap', 'cukup', 'meskipun',
            'final', 'pergi', 'dapat', 'mendapatkan', 'punya', 'mempunyai', 'memiliki', 'inisial', 'hanya', 'daripada', 'pada',
            'kepada', 'jika', 'jikalau', 'mari', 'lihat', 'melihat', 'sering', 'mati', 'hidup', 'seharusnya', 'harus', 'seseorang', 'apa', 'kenapa', 'mengapa',
            'bagaimana', 'kemana', 'dimana', 'beberapa', 'kami', 'tanpa', 'siapa', 'saja', 'adanya', 'akan', 'akibat', 'bahkan', 'bahwa', 'bisa', 'biasa',
            'juga','jadi', 'lagi', 'karena', 'menjadi', 'misalnya', 'namun', 'penyebab', 'sama', 'sejumlah', 'sekaligus', 'makin', 'semakin', 'sementara',
            'terjadi', 'melainkan', 'padahal', 'sedangkan', 'maupun', 'tetapi', 'sejak', 'sehingga', 'sedemikian', 'entah', 'jangankan', 'pun', 'andaikan', 'agar',
            'biarpun', 'ibarat', 'hingga', 'lalu', 'meski', 'bila', 'sambil', 'apabila', 'andaikata', 'seandainya', 'sekiranya', 'semenjak', 'bagaikan', 'asalkan',
            'walaupun', 'kendatipun', 'bermula', 'sebermula', 'alkisah', 'syahdan', 'arkian', 'maka', 'bahwasanya', 'hatta', 'adapun', 'biar', 'sekalipun',
            'sungguhpun', 'sampai', 'asal', 'kalau', 'seraya', 'sebagai', 'seakan-akan', 'ketika', 'supaya', 'agar', 'serupa', 'apalagi',
            'umpama', 'contoh', 'bila', 'manakala', 'tatkala', 'setelah', 'sehabis', 'selagi', 'seumpama', 'sebaliknya', 'bagaimanapun',
            'guna', 'sesudahnya', 'sebelumnya', 'akibatnya', 'bilamana', 'bagai', 'sebagaimana', 'kian', 'yaitu', 'yakni', 'ringkasnya', 'akhirnya', 'kemudian',
            'sedang', 'sambil'
        );

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
            $data['nav_kategori']='';
            $data['nav_summarize']='';
            $data['nav_summarizebaru']='active';
            $data['nav_summarizevalen']='';

            $data['page_title']='Kuberin Administrator';
            $data['sumberberita_list'] = $this->Summarizemodel->getSumberBerita();

//            $this->form_validation->set_rules('katakunci', 'Kata Kunci', 'trim|required|xss_clean');
//            if($this->form_validation->run()==FALSE)
//            {
//
//            }
//            else
//            {
//                $katakunci = $this->input->post('katakunci');
//                $tanggalrange = $this->input->post('tanggalrange');
//                $sumber = $this->input->post('optsumberberita');
//                $berita = $this->Beritamodel->getBeritaSummarize($katakunci,$tanggalrange,$sumber);
//                if(!empty($berita))
//                {
//                    foreach($berita as $list_berita)
//                    {
//                        $doc=$list_berita['isi_berita'];
//                        if(empty($doc)===false){
//                            array_push($this->Doc , $doc);
//                        }
//
//                    }
//                    $sum_temp = array();
//                    foreach ($this->Doc as $doc) {
//                        $doc_temp = $this->single_summary($doc);
//                        $this->total_document++;
//                        array_push($sum_temp, implode(' ',$doc_temp));
//                        $this->corpus_summary_temp = $this->corpus_summary_temp.implode(' ',$doc_temp).' ';
//                        array_push($this->corpus_summary,implode(' ',$doc_temp));
//                    }
//                    $data['sum_all'] = implode(' ',$this->multi_summary($this->corpus_summary_temp));
//                    $data['sum'] = $sum_temp;
//                    $data['result'] = true;
//
//
//
//                }
//                else
//                {
//                    $data['result'] = false;
//
//                }
//            }
            $this->load->view('header', $data);
            $this->load->view('navigation', $data);
            $this->load->view('summarizebaru_view', $data);
            $this->load->view('footer', $data);

        }
        else
        {
            redirect('home', 'refresh');
        }

    }
    function tampilBeritaFilter()
    {
//        $this->form_validation->set_rules('katakunci', 'Kata Kunci', 'trim|required|xss_clean');
//        if($this->form_validation->run()==FALSE)
//        {
//            echo json_encode(array('st'=>0,'msg'=>validation_errors()));
//        }
//        else
//        {
        $katakunci = $this->input->post('katakunci');
        $tanggalrange = $this->input->post('tanggalrange');
        $sumber = $this->input->post('optsumberberita');
        $limitget = $this->input->post('optjumlahberita');
        $sumberjadi=implode(', ',$sumber);
        if(!empty($katakunci)&&!empty($limitget)) {
            $berita = $this->Summarizemodel->getBeritaSummarizeNew($katakunci, $tanggalrange, $sumberjadi, $limitget);
            if (!empty($berita)) {
                echo json_encode(array('st' => 1, 'msg' => $berita));
            } else {
                echo json_encode(array('st' => 2, 'msg' => 'Data Kosong'));
            }
        }
        else if(empty($katakunci) && empty($limitget)){
            echo json_encode(array('st' => 0, 'msg' => 'The Kata Kunci and Limit field is required.'));
        }
        else if(empty($katakunci)){
            echo json_encode(array('st' => 0, 'msg' => 'The Kata Kunci field is required.'));
        }
        else if(empty($limitget)) {
            echo json_encode(array('st' => 0, 'msg' => 'The Limit field is required.'));
        }
        //}
    }

    function summarizeberita()
    {
        $tampberitaparse=array();
        $idberitacheckbox = $this->input->post('checkboxberita');
        if(empty($idberitacheckbox))
        {
            echo json_encode(array('st'=>0,'msg'=>'The Checkbox Berita field is required.'));
        }
        else
        {
            foreach ($idberitacheckbox as $idberitaget) {
                $embuh=$this->Summarizemodel->getBeritaByID($idberitaget);
                $tampungan=array(
                    'id_berita'=>$embuh->id_berita,
                    'judul'=>$embuh->judul,
                    'tanggal'=>$embuh->tanggal,
                    'waktu'=>$embuh->waktu,
                    'kategori'=>$embuh->kategori,
                    'gambar'=>$embuh->gambar,
                    'isi_berita'=>$embuh->isi_berita,
                    'link'=>$embuh->link,
                    'sumberberita'=>$embuh->sumberberita,
                    'timer'=>$embuh->timer,
                    'datetime_scraping'=>$embuh->datetime_scraping,

                );
                $tampberitaparse[]=$tampungan;

            }

            if(!empty($tampberitaparse))
            {
                foreach($tampberitaparse as $list_berita)
                {
                    $doc=$list_berita['isi_berita'];
                    if(empty($doc)===false){
                        array_push($this->Doc , $doc);
                    }

                }

                $sum_temp = array();
                foreach ($this->Doc as $doc) {
                    $doc_temp = $this->single_summary($doc);
                    $this->total_document++;
                    array_push($sum_temp, implode(' ',$doc_temp));
                    $this->corpus_summary_temp = $this->corpus_summary_temp.implode(' ',$doc_temp).' ';
                    array_push($this->corpus_summary,implode(' ',$doc_temp));
                }

                $tmps = $this->multi_summary($this->corpus_summary_temp);
                $summary = $this->summary_sentences_score;
                $this->aasort($summary,"1");
                foreach($summary as $suma)
                {
                    $arrsumbaru = array(
                        'kalimat' =>$suma['0'],
                        'score'=> $suma['1']
                    );
                    $summarybaru[]=$arrsumbaru;
                }

//                print_r($summarybaru);
//
                foreach ($tmps as $skal) {
                    foreach($summarybaru as $sumrr)
                    {
                        if(stripos($skal,$sumrr['kalimat'])!==false)
                        {
                            $arrsekelsi = array(
                                'kalimat'=> $sumrr['kalimat'],
                                'score'=> $sumrr['score']
                            );
                            $arrbaru[]=$arrsekelsi;
                        }
                        else
                        {

                        }
                    }
                }
                $arrbaru=array_unique($arrbaru, SORT_REGULAR);

//                print_r($arrbaru);

                $this->aasort($arrbaru,"score");
                foreach($arrbaru as $xbar)
                {
                    $tmpbar[]=$xbar['kalimat'];
                }
//                print_r($arrbaru);
                $data = implode(' ',$tmpbar);


                $tmpdatasum = explode('. ',$data);
                foreach($tmpdatasum as $rowssum)
                {
//                    $rowssumtmp=substr($rowssum,500);
                    foreach($tampberitaparse as $list_berita)
                    {
                        if (stripos($list_berita['isi_berita'],$rowssum) !== FALSE) {
                            $tmparr=array(
                                'id'=>$list_berita['id_berita'],
                                'kalimat'=>$rowssum
                            );
                            $tmpkal[]=$tmparr;
                        }

                        else
                        {

                        }

                    }

                }


                $result = array();

                foreach ($tmpkal as $item)
                {
                    $id = $item['id'];

                    if (isset($result[$id]))
                    {

                        $result[$id]['kalimat']= $result[$id]['kalimat'].'. '.$item['kalimat'];

                    }
                    else
                    {
                        $result[$id] = $item;
                    }
                }


                $tmpkal = array_values($result);
                //print_r($tmpkal);
                foreach ($tmpkal as $nganukal) {
                    // = $nganukal['id'];

                    $embuh=$this->Summarizemodel->getBeritaByID($nganukal['id']);
                    $tampungan=array(
                        'id_berita'=>$embuh->id_berita,
                        'judul'=>$embuh->judul,
                        'tanggal'=>$embuh->tanggal,
                        'waktu'=>$embuh->waktu,
                        'kategori'=>$embuh->kategori,
                        'gambar'=>$embuh->gambar,
                        'isi_berita'=>$embuh->isi_berita,
                        'link'=>$embuh->link,
                        'sumberberita'=>$embuh->sumberberita,
                        'timer'=>$embuh->timer,
                        'datetime_scraping'=>$embuh->datetime_scraping,
                        'bandwidth'=>$embuh->bandwidth
                    );
                    $tampberitaparse[]=$tampungan;


                }
                ///print_r($tampberitaparse);
                // print_r($tampungberita);
//                $timenow = date("Y-m-d H:i:s");
//                $tampLog=array(
//                    'datetime_summarize'=>$timenow,
//                    'keyword'=>$katakunci,
//                    'summarize'=>$data,
//                    'id_device'=>'sad332523d',
//                    'nama_device'=>'xiaomi Redmi 2'
//                );
//                $idlog = $this->Summarizemodel->insertLog($tampLog);
//
//
//
//
//                foreach($summary as $sumbro)
//                {
//                    $tampDetailLog=array(
//                        'kalimat'=>$sumbro[0],
//                        'score'=>$sumbro[1],
//                        'tbl_log_id_log'=>$idlog
//                    );
//                    $tmpdatadetaillog[]=$tampDetailLog;
//                }
//                $this->Summarizemodel->insertDetailLog($tmpdatadetaillog);


                //               print_r($summary);
                echo json_encode(array('st'=>1,'msg'=>$data,'sum_score'=>$summarybaru,'kalimat'=>$tmpkal));

            }
            else
            {
                echo json_encode(array('st'=>2,'msg'=>'Data Tidak Ada'));

            }

        }
    }
    public function normalize_sentence($Doc){
        $Doc = $this->sentence_tokenize($Doc);
        $num_sentences = count($Doc);
        for($i=0; $i<$num_sentences; $i++){
            $doc_terms = array();
            $Doc[$i]=str_replace(array('\'', '"','(',')','[',']','{','}',',','.'), '', $Doc[$i]);
        }
        return $Doc;
    }

    public function normalize_sentence2($Doc){
        $Doc = $this->sentence_tokenize($Doc);
        $num_sentences = count($Doc);
        for($i=0; $i<$num_sentences; $i++){
            $doc_terms = array();
            $Doc[$i]=str_replace(array('\'', '"','(',')','[',']','{','}',','), '', $Doc[$i]);
        }
        return $Doc;
        // print_r($Doc);
    }

    public function split_to_word($Doc){
        $sentences = $this->normalize_sentence($Doc);
        $word_stats = array();
        print_r($sentences);
        $x=0;
        for($i=0; $i<count($sentences); $i++){
            $words = $this->word_tokenize($sentences[$i]);

            foreach ($words as $word){

                if(empty( $word_stats )){
                    $word_stats[] = array(
                        'word' => $word,
                        'count' => 1
                    );
                }
                else if(!$this->search_word($word_stats,$word)){
                    if(in_array($word, $this->stopwords)){
                        $word_stats[] = array(
                            'word' => $word,
                            'count' => 0
                        );
                    }else{
                        $word_stats[] = array(
                            'word' => $word,
                            'count' => 1
                        );
                    }

                    // $x++;
                }
                else{
                    $key = $this->search_key($word_stats,$word);
                    if(in_array($word, $this->stopwords)){
                        $word_stats[$key]['count']=0;
                    }else{
                        $word_stats[$key]['count']++;
                    }

                }
            }
        }
        // sort($word_stats);
        // print_r($word_stats);
        // echo count($word_stats);
        return $word_stats;
    }

    public function single_summary($Doc){
        $sentences = $this->normalize_sentence($Doc);
        $word_score = $this->global_count($Doc);
        // print_r($word_score);
        $sentence_bag = array();
        // echo $this->total_words;
        for($i=0; $i<count($sentences); $i++){

            $words = $this->word_tokenize($sentences[$i]);

            $word_status = array();

            foreach ($words as $word){
                // echo $word.'-';
                if (!isset($word_status[$word])){
                    // echo $word."<br>";
                    $word_status[$word]=number_format($word_score[$word]/$this->total_words,5);

                } else {
                    $word_status[$word]=$word_status[$word]+number_format($word_score[$word]/$this->total_words,5);
                }
            }

            $sentence_bag[] = array(
                'sentence' => $sentences[$i],
                'word_stats' => $word_status,
                'ord' => $i
            );
            // print_r($word_status);
            // foreach ($word_status as $key => $value) {
            // 	echo $key." ".$value."<br>";
            // }
        }
        // print_r($word_stats);

        arsort($word_status);

        $sentence_bag=$this->calculate_score($sentence_bag);

        $this->aasort($sentence_bag,'score');

        $summary_bag = array_slice($sentence_bag,0,4);

        usort($summary_bag, array(&$this, 'cmp_arrays_ord'));
        usort($sentence_bag, array(&$this, 'cmp_arrays_ord'));

        // print_r($summary_bag);
        // foreach ($summary_bag as $key) {
        // 	array_push($this->corpus_summary,$key);
        // }

        $summary_sentences = array();

        $temp_summary = $this->sentence_tokenize($Doc);

        $temp = array();
        foreach($sentence_bag as $sentence){
            $temp[] =  array($temp_summary[$sentence['ord']],$sentence['score']);
        }
        array_push($this->summary_sentences_temp,$temp);

        // echo $sentence_bag['sentence'];
        foreach($summary_bag as $sentence){
            // echo $sentence['ord'];
            $summary_sentences[] = $temp_summary[$sentence['ord']];
        }
        // print_r( $summary_sentences);

        return $summary_sentences;
    }

    public function multi_summary($Doc){
        $sentences = $this->normalize_sentence2($Doc);
        $word_score = $this->global_sum_count($Doc);
        $word_appear = $this->global_appear_count();

        $sentence_bag = array();
        for($i=0; $i<count($sentences); $i++){

            $words = $this->word_tokenize($sentences[$i]);
            $words = str_replace(array('\'', '"','(',')','[',']','{','}',',','.'), '', $words);
            $word_status = array();

            foreach ($words as $word){

                if (!isset($word_status[$word])){
                    $word_status[$word]=number_format(number_format($word_score[$word]/$this->total_words,5)*number_format(log($this->total_document/$word_appear[$word]),5),5);
                } else {
                    $word_status[$word]=number_format($word_status[$word]+number_format($word_score[$word]/$this->total_words,5)*number_format(log($this->total_document/$word_appear[$word]),5),5);
                }
            }

            $sentence_bag[] = array(
                'sentence' => $sentences[$i],
                'word_stats' => $word_status,
                'ord' => $i
            );
            // print_r($word_status);
            // foreach ($word_status as $key => $value) {
            // 	echo $key."<br>";
            // }
        }

        $sentence_bag=$this->calculate_score($sentence_bag);

        $this->aasort($sentence_bag,'score');

        $summary_bag = array_slice($sentence_bag,0,3);

        usort($summary_bag, array(&$this, 'cmp_arrays_ord'));
        usort($sentence_bag, array(&$this, 'cmp_arrays_ord'));

        $summary_sentences = array();
        $temp_summary = $this->sentence_tokenize($Doc);

        foreach($sentence_bag as $sentence){
            $this->summary_sentences_score[] =  array($temp_summary[$sentence['ord']],$sentence['score']);
        }

        foreach($summary_bag as $sentence){
            $summary_sentences[] = $temp_summary[$sentence['ord']];
        }

        // print_r($this->summary_sentences_score);
        // $this->corpus_summary_temp+=$summary_sentences;

        return $summary_sentences;
    }

    function sentence_tokenize($text){
        if (preg_match_all('/["\']*.+?([.?!\n\r]+["\']*\s+|$)/si', $text, $matches, PREG_SET_ORDER)){
            $rez = array();
            foreach ($matches as $match){
                array_push($rez, trim($match[0]));
            }
            return $rez;
        } else {
            return array($text);
        }
    }

    function word_tokenize($sentence){
        $words = preg_split('/[\'\s\r\n\t$]+/', $sentence);
        $rez = array();
        foreach($words as $word){
            $word = preg_replace('/(^[^a-z0-9]+|[^a-z0-9]$)/i','', $word);
            $word = strtolower($word);
            if (strlen($word)>0)
                array_push($rez, $word);
        }
        return $rez;
    }

    function search_word($source, $word)
    {
        $bol = false;
        foreach($source as $key => $words)
        {
            if ( $words['word'] === $word )
                $bol = true;
        }
        return $bol;
    }

    function search_key($source, $word)
    {
        foreach($source as $key => $words)
        {
            if ( $words['word'] === $word )
                return $key;
        }
        return false;
    }

    function global_count($text){
        $sentences = $this->sentence_tokenize($text);
        $word_stats = array();
        $this->total_words=0;
        for($i=0; $i<count($sentences); $i++){

            $words = $this->word_tokenize($sentences[$i]);
            $words=str_replace(array('\'', '"','(',')','[',']','{','}',',','.'), '', $words);
            // print_r($words);
            // echo count($words)."<br>";
            foreach ($words as $word){
                $this->total_words++;
                if (in_array($word, $this->stopwords)){

                    if (!isset($word_stats[$word])){
                        $word_stats[$word]=0;

                    } else {
                        $word_stats[$word]=0;
                    }

                }else{

                    if (!isset($word_stats[$word])) {
                        $word_stats[$word]=1;//echo $word."<br>";
                    } else {
                        $word_stats[$word]++;
                    }
                }
            }
        }
        // echo $this->total_words;
        // echo count($word_stats);
        arsort($word_stats);
        // print_r($word_stats);
        // foreach ($word_stats as $key => $value) {
        // echo $key." ".$value."<br>";
        // }

        return $word_stats;
    }

    function global_sum_count($text){
        $sentences = $this->sentence_tokenize($text);
        $word_stats = array();

        $this->total_last_words=0;

        for($y=0;$y<$this->total_document;$y++){
            $sentence_temp = $this->corpus_summary[$y];
            for($i=0; $i<count($sentences); $i++){

                $words = $this->word_tokenize($sentences[$i]);
                $words = str_replace(array('\'', '"','(',')','[',']','{','}',',','.'), '', $words);

                foreach ($words as $word){
                    $this->total_last_words++;
                    if (in_array($word, $this->stopwords)){

                        if (!isset($word_stats[$word])){
                            $word_stats[$word]=0;
                        } else {
                            $word_stats[$word]=0;
                        }
                    }else{

                        if (!isset($word_stats[$word])) {
                            $word_stats[$word]=1;

                        } else {
                            $word_stats[$word]++;
                        }
                    }
                }
            }
        }

        // print_r($word_stats);
        // echo count($word_stats);
        // arsort($word_stats);
        // foreach ($word_stats as $key => $value) {
        // 	echo $key." ".$value."<br>";
        // }

        return $word_stats;
    }

    public function global_appear_count(){

        $word_stats = $this->global_sum_count($this->corpus_summary_temp);

        $word_appear = array();

        for($y=0;$y<$this->total_document;$y++){

            $words = $this->word_tokenize($this->corpus_summary[$y]);
            $words = str_replace(array('\'', '"','(',')','[',']','{','}',',','.'), '', $words);
            // print_r($this->corpus_summary[$y]);
            foreach ($word_stats as $word => $count){
                // echo $word.'-';
                if (in_array($word, $this->stopwords)){

                    // if (preg_match("/\b".$word."\b/i", $words)) {
                    if(in_array($word, $words)){
                        if (!isset($word_appear[$word])) {
                            $word_appear[$word]=1;

                        } else {
                            $word_appear[$word]=1;
                        }
                    }

                }else{

                    // if (preg_match("/\b".$word."\b/i", $words)) {
                    if(in_array($word, $words)){
                        if (!isset($word_appear[$word])) {
                            $word_appear[$word]=1;

                        } else {
                            $word_appear[$word]++;
                        }
                    }
                }
            }
        }

        // print_r($word_appear);
        // echo count($word_appear);
        // foreach ($word_appear as $key => $value) {
        // 	echo $key." ".$value."<br>";
        // }

        return $word_appear;
    }

    function calculate_score($sentence_bag){

        for($i=0; $i<count($sentence_bag); $i++){
            $score = 0;
            foreach ($sentence_bag[$i]['word_stats'] as $word => $count){
                $score += $count;
            }
            $sentence_bag[$i]['score'] = $score;
        }

        return $sentence_bag;
    }

    function cmp_arrays_ord($a, $b){
        return $this->cmp_arrays($a, $b, 'ord');
    }

    function cmp_arrays($a, $b, $key){
        if (is_int($a[$key]) || is_float($a[$key])){
            return floatval($a[$key])-floatval($b[$key]);
        } else {
            return strcmp(strval($a[$key]), strval($b[$key]));
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