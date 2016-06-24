<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '\vendor\autoload.php';
error_reporting(0);

class Summarizevalen extends CI_Controller {
    
    public $num_docs;
    public $total_words=0,$total_document,$total_last_words;
    public $corpus_summary,$corpus_summary_temp;
    public $Doc;
    public $summary_sentences_temp,$summary_sentences_score;
    public $katakunci_temp='jn';
    public $testvar;

    public $stopwords = array('--', '-', 'ada','adalah','adanya','adapun','agak','agaknya','agar','akan','akankah','akhir','akhiri','akhirnya','aku','akulah','amat','amatlah','anda','andalah','antar','antara','antaranya','apa','apaan','apabila','apakah','apalagi','apatah','artinya','asal','asalkan','atas','atau','ataukah','ataupun','awal','awalnya','bagai','bagaikan','bagaimana','bagaimanakah','bagaimanapun','bagi','bagian','bahkan','bahwa','bahwasanya','baik','bakal','bakalan','balik','banyak','bapak','baru','bawah','beberapa','begini','beginian','beginikah','beginilah','begitu','begitukah','begitulah','begitupun','bekerja','belakang','belakangan','belum','belumlah','benar','benarkah','benarlah','berada','berakhir','berakhirlah','berakhirnya','berapa','berapakah','berapalah','berapapun','berarti','berawal','berbagai','berdatangan','beri','berikan','berikut','berikutnya','berjumlah','berkali-kali','berkata','berkehendak','berkeinginan','berkenaan','berlainan','berlalu','berlangsung','berlebihan','bermacam','bermacam-macam','bermaksud','bermula','bersama','bersama-sama','bersiap','bersiap-siap','bertanya','bertanya-tanya','berturut','berturut-turut','bertutur','berujar','berupa','besar','betul','betulkah','biasa','biasanya','bila','bilakah','bisa','bisakah','boleh','bolehkah','bolehlah','buat','bukan','bukankah','bukanlah','bukannya','bulan','bung','cara','caranya','cukup','cukupkah','cukuplah','cuma','dahulu','dalam','dan','dapat','dari','daripada','datang','dekat','demi','demikian','demikianlah','dengan','depan','di','dia','diakhiri','diakhirinya','dialah','diantara','diantaranya','diberi','diberikan','diberikannya','dibuat','dibuatnya','didapat','didatangkan','digunakan','diibaratkan','diibaratkannya','diingat','diingatkan','diinginkan','dijawab','dijelaskan','dijelaskannya','dikarenakan','dikatakan','dikatakannya','dikerjakan','diketahui','diketahuinya','dikira','dilakukan','dilalui','dilihat','dimaksud','dimaksudkan','dimaksudkannya','dimaksudnya','diminta','dimintai','dimisalkan','dimulai','dimulailah','dimulainya','dimungkinkan','dini','dipastikan','diperbuat','diperbuatnya','dipergunakan','diperkirakan','diperlihatkan','diperlukan','diperlukannya','dipersoalkan','dipertanyakan','dipunyai','diri','dirinya','disampaikan','disebut','disebutkan','disebutkannya','disini','disinilah','ditambahkan','ditandaskan','ditanya','ditanyai','ditanyakan','ditegaskan','ditujukan','ditunjuk','ditunjuki','ditunjukkan','ditunjukkannya','ditunjuknya','dituturkan','dituturkannya','diucapkan','diucapkannya','diungkapkan','dong','dua','dulu','empat','enggak','enggaknya','entah','entahlah','guna','gunakan','hal','hampir','hanya','hanyalah','hari','harus','haruslah','harusnya','hendak','hendaklah','hendaknya','hingga','ia','ialah','ibarat','ibaratkan','ibaratnya','ibu','ikut','ingat','ingat-ingat','ingin','inginkah','inginkan','ini','inikah','inilah','itu','itukah','itulah','jadi','jadilah','jadinya','jangan','jangankan','janganlah','jauh','jawab','jawaban','jawabnya','jelas','jelaskan','jelaslah','jelasnya','jika','jikalau','juga','jumlah','jumlahnya','justru','kala','kalau','kalaulah','kalaupun','kalian','kami','kamilah','kamu','kamulah','kan','kapan','kapankah','kapanpun','karena','karenanya','kasus','kata','katakan','katakanlah','katanya','ke','keadaan','kebetulan','kecil','kedua','keduanya','keinginan','kelamaan','kelihatan','kelihatannya','kelima','keluar','kembali','kemudian','kemungkinan','kemungkinannya','kenapa','kepada','kepadanya','kesampaian','keseluruhan','keseluruhannya','keterlaluan','ketika','khususnya','kini','kinilah','kira','kira-kira','kiranya','kita','kitalah','kok','kurang','lagi','lagian','lah','lain','lainnya','lalu','lama','lamanya','lanjut','lanjutnya','lebih','lewat','lima','luar','macam','maka','makanya','makin','malah','malahan','mampu','mampukah','mana','manakala','manalagi','masa','masalah','masalahnya','masih','masihkah','masing','masing-masing','mau','maupun','melainkan','melakukan','melalui','melihat','melihatnya','memang','memastikan','memberi','memberikan','membuat','memerlukan','memihak','meminta','memintakan','memisalkan','memperbuat','mempergunakan','memperkirakan','memperlihatkan','mempersiapkan','mempersoalkan','mempertanyakan','mempunyai','memulai','memungkinkan','menaiki','menambahkan','menandaskan','menanti','menanti-nanti','menantikan','menanya','menanyai','menanyakan','mendapat','mendapatkan','mendatang','mendatangi','mendatangkan','menegaskan','mengakhiri','mengapa','mengatakan','mengatakannya','mengenai','mengerjakan','mengetahui','menggunakan','menghendaki','mengibaratkan','mengibaratkannya','mengingat','mengingatkan','menginginkan','mengira','mengucapkan','mengucapkannya','mengungkapkan','menjadi','menjawab','menjelaskan','menuju','menunjuk','menunjuki','menunjukkan','menunjuknya','menurut','menuturkan','menyampaikan','menyangkut','menyatakan','menyebutkan','menyeluruh','menyiapkan','merasa','mereka','merekalah','merupakan','meski','meskipun','meyakini','meyakinkan','minta','mirip','misal','misalkan','misalnya','mula','mulai','mulailah','mulanya','mungkin','mungkinkah','nah','naik','namun','nanti','nantinya','nyaris','nyatanya','oleh','olehnya','pada','padahal','padanya','pak','paling','panjang','pantas','para','pasti','pastilah','penting','pentingnya','per','percuma','perlu','perlukah','perlunya','pernah','persoalan','pertama','pertama-tama','pertanyaan','pertanyakan','pihak','pihaknya','pukul','pula','pun','punya','rasa','rasanya','rata','rupanya','saat','saatnya','saja','sajalah','saling','sama','sama-sama','sambil','sampai','sampai-sampai','sampaikan','sana','sang','sangat','sangatlah','satu','saya','sayalah','se','sebab','sebabnya','sebagai','sebagaimana','sebagainya','sebagian','sebaik','sebaik-baiknya','sebaiknya','sebaliknya','sebanyak','sebegini','sebegitu','sebelum','sebelumnya','sebenarnya','seberapa','sebesar','sebetulnya','sebisanya','sebuah','sebut','sebutlah','sebutnya','secara','secukupnya','sedang','sedangkan','sedemikian','sedikit','sedikitnya','seenaknya','segala','segalanya','segera','seharusnya','sehingga','seingat','sejak','sejauh','sejenak','sejumlah','sekadar','sekadarnya','sekali','sekali-kali','sekalian','sekaligus','sekalipun','sekarang','sekarang','sekecil','seketika','sekiranya','sekitar','sekitarnya','sekurang-kurangnya','sekurangnya','sela','selain','selaku','selalu','selama','selama-lamanya','selamanya','selanjutnya','seluruh','seluruhnya','semacam','semakin','semampu','semampunya','semasa','semasih','semata','semata-mata','semaunya','sementara','semisal','semisalnya','sempat','semua','semuanya','semula','sendiri','sendirian','sendirinya','seolah','seolah-olah','seorang','sepanjang','sepantasnya','sepantasnyalah','seperlunya','seperti','sepertinya','sepihak','sering','seringnya','serta','serupa','sesaat','sesama','sesampai','sesegera','sesekali','seseorang','sesuatu','sesuatunya','sesudah','sesudahnya','setelah','setempat','setengah','seterusnya','setiap','setiba','setibanya','setidak-tidaknya','setidaknya','setinggi','seusai','sewaktu','siap','siapa','siapakah','siapapun','sini','sinilah','soal','soalnya','suatu','sudah','sudahkah','sudahlah','supaya','tadi','tadinya','tahu','tahun','tak','tambah','tambahnya','tampak','tampaknya','tandas','tandasnya','tanpa','tanya','tanyakan','tanyanya','tapi','tegas','tegasnya','telah','tempat','tengah','tentang','tentu','tentulah','tentunya','tepat','terakhir','terasa','terbanyak','terdahulu','terdapat','terdiri','terhadap','terhadapnya','teringat','teringat-ingat','terjadi','terjadilah','terjadinya','terkira','terlalu','terlebih','terlihat','termasuk','ternyata','tersampaikan','tersebut','tersebutlah','tertentu','tertuju','terus','terutama','tetap','tetapi','tiap','tiba','tiba-tiba','tidak','tidakkah','tidaklah','tiga','tinggi','toh','tunjuk','turut','tutur','tuturnya','ucap','ucapnya','ujar','ujarnya','umum','umumnya','ungkap','ungkapnya','untuk','usah','usai','waduh','wah','wahai','waktu','waktunya','walau','walaupun','wong','yaitu','yakin','yakni','yang');


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
                    $this->testvar='';
                    
                    

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
            $data['nav_summarizebaru']='';
            $data['nav_summarizevalen']='active';

            $data['page_title']='Kuberin Administrator';
           // $data['sumberberita_list'] = $this->Summarizemodel->getBeritaTest;
                $data['sumberberita_list'] = $this->Summarizemodel->getSumberBerita();
                 $berita=$this->Summarizemodel->getBeritaTest();
                 $judul=$this->Summarizemodel->getBeritaJudul();
                foreach($berita as $list_berita)
                {
                    $data['isi_test'] = $list_berita['isi_berita'];
                }

                foreach($judul as $judul_berita)
                {
                    $data['judul_test'] = $judul_berita['judul'];
                }
                
                
                $normalize_sentence = $this->normalize_sentence($data['isi_test']);
                $data['test2']=$this->global_count($data['isi_test']);
                $data['test']=$this->single_summary($data['isi_test']);

                $data['sentences']=$normalize_sentence;
               // $data['word_stem'] = $this->stem_word($data['isi_test']);
               // $data['judul_count'] = $this->count_title($data['judul_test']);
             //   $data['sentences2']=$this->stopwords_removal($data['sentences']);
               //  print_r($data['isi_test']);
                //print_r($data['sentences']);


                $this->load->view('header', $data);
                $this->load->view('navigation', $data);
                $this->load->view('summarizevalen_view', $data);
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
       // $katakunci_temp=$this->input->post('katakunci');

        $katakunci = $this->input->post('katakunci');
        $berita['kk']=$katakunci;
      

       
        $tanggalrange = $this->input->post('tanggalrange');
        $sumber = $this->input->post('optsumberberita');
        $limitget = $this->input->post('optjumlahberita');
        $sumberjadi=implode(', ',$sumber);
        if(!empty($katakunci)&&!empty($limitget)) {
            $berita['berita'] = $this->Summarizemodel->getBeritaSummarizeNew($katakunci, $tanggalrange, $sumberjadi, $limitget);
            if (!empty($berita['berita'])) {
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



    public function count_title($title)
    {
        $title=(str_word_count($title, 1));
        $title=count($title);
        return $title;
    }

    public function count_title_word($text)
    {
        
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

    public function stem_word($word)
    {
        
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();
      
        $word   = $stemmer->stem($word);

        return $word;
    }

    public function normalize_sentence($Doc){
        

        $Doc = $this->sentence_tokenize(strtolower($Doc));
        $num_sentences = count($Doc);
        for($i=0; $i<$num_sentences; $i++){
            $doc_terms = array();
            $Doc[$i]=str_replace(array('\'', '"','(',')','[',']','{','}',',','.','/',''), ' ', $Doc[$i]);
            $Doc[$i] = $this->stem_word($Doc[$i]);
        }


        return $Doc;
    }




    function sentence_tokenize($text){
        //$text=$this->stem_word($text);
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

     function global_count($text){
        $sentences = $this->normalize_sentence($text);
        $word_stats = array();
        $this->total_words=0;
        for($i=0; $i<count($sentences); $i++){

            $words = $this->word_tokenize($sentences[$i]);
            //$words=str_replace($this->stopwords,'',$words);
            $words=str_replace(array('\'', '"','(',')','[',']','{','}',',','.'), '', $words);
            //$words=str_replace($this->stopwords,'',$words);
            // print_r($words);
            // echo count($words)."<br>";
            foreach ($words as $word){
                $this->total_words++;
                 
                if (in_array($word, $this->stopwords)){

                        $word_stats[$word]=0;
                    

                }else{
                    


                    if (!isset($word_stats[$word])) {
                        $word_stats[$word]=1;//echo $word."<br>";
                    } else {
                        $word_stats[$word]++;
                    }
                }
            }
        }
         //echo $this->total_words;
        arsort($word_stats);
        //echo count($word_stats);
       //  print_r($word_stats);
        // foreach ($word_stats as $key => $value) {
        // echo $key." ".$value."<br>";
        // }

        return $word_stats;
    }


   
    function summarizeberita()
    {
        $tampberitaparse=array();
        $idberitacheckbox = $this->input->post('checkboxberita');
        $getkatakunci=$this->input->post('testkatakunci');
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
                    if(count($idberitacheckbox)==1)
                    {
                      
                        /*

                        $sum_temp = array();
                        foreach ($this->Doc as $doc) {
                            $doc_temp = $this->single_summary($doc);
                            $this->total_document++;
                            array_push($sum_temp, implode(' ',$doc_temp));
                            $this->corpus_summary_temp = $this->corpus_summary_temp.implode(' ',$doc_temp).' ';
                            array_push($this->corpus_summary,implode(' ',$doc_temp));
                        }*/
                        $test=$this->single_summary($doc);
                    }
                    else
                    {
                       //$test=$this->count_w($this->Doc);
                        $test=$this->multi_summary($this->Doc,$getkatakunci);
                    }
                        echo json_encode(array('st'=>1,'msg'=>json_encode($test)));
                }

                else
                {
                      echo json_encode(array('st'=>0,'msg'=>'Pilih 2'));
                }
        }

   }

   function multi_summary($Doc,$kk)
    {
        
        
        $word_score_all=array();
        for($j=0;$j<count($Doc);$j++)
        {

            $sentences=$this->normalize_sentence($Doc[$j]);
           // $word_score= $this->global_count($Doc);

            for($i=0; $i<count($sentences); $i++){

            $words = $this->word_tokenize($sentences[$i]);
            $words = str_replace(array('\'', '"','(',')','[',']','{','}',',','.'), '', $words);

            $word_status = array();

            foreach ($words as $word){
                if (in_array($word, $this->stopwords)){

                        $word_score_all[$word]=0;
                    

                }else{
                    //ngitung tf

                if (!isset($word_score_all[$word])){
                    $word_score_all[$word]=1;
                } else {
                    $word_score_all[$word]++;
                }
            }
            }
           
        }


        }
         $idf=array();
         //ngitung idf

            foreach ($word_score_all as $word_score_idf=>$value) {
                    //array_push($idf,$word_score_idf);
                if($value!=0)
                {
                    $ndf=(count($Doc)+1)/$value;
                    $idf[$word_score_idf]=log($ndf,10);
                }
                else
                {
                     $idf[$word_score_idf]=0;
                }
                 
            }

                return $idf;
            
}

    public function count_w($Doc)
    {
        //$word_score_all=array();
        $idf=$this->multi_summary($Doc);
        $sentence_bag = array();
      /*  for($j=0;$j<count($Doc);$j++)
        {
            $word_score_all=array();

            $sentences=$this->normalize_sentence($Doc[$j]);
            $word_score= $this->global_count($Doc[$j]);

            foreach ($word_score as $key => $value) {
                $word_score_all[$key]=$idf[$key]*$value;
            }

        }*/
        for($j=0;$j<count($Doc);$j++)
        {
            $word_score_all=array();
            $sentences=$this->normalize_sentence($Doc[$j]);
            
            for($i=0;$i<count($sentences);$i++)
            {
                $word_score= $this->global_count($Doc[$j]);
                 
                 foreach ($word_score as $key => $value) {
                $word_score_all[$key]=$idf[$key]*$value;
                }
                $sentence_bag[] = array(
                'doc' => $Doc[$j],
                'sentence' => $sentences,
                'word_score' => $word_score,
                'word_score_all' => $word_score_all
            );
                 break;
            }
        }

        return $sentence_bag;
    }
         

    public function single_summary($Doc)
    {
        $sentences = $this->normalize_sentence($Doc);//diilangi tanda bacanya
        $word_score = $this->global_count($Doc);//hitung jumlah kata dalam suatu kalimat

       // print_r($word_score);
      //  echo count($sentences);
        $sentence_bag = array();

        for($i=0; $i<count($sentences); $i++){

            $words = $this->word_tokenize($sentences[$i]);//diambil perkata

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
          // print_r ($word_status);
             arsort($word_status);
             /*foreach ($word_status as $key => $value) {
              echo 'kalimat'.$i." ".$key." ".$value."<br>";
             }*/
        }
//        echo arsort($word_status);
       
        $sentence_bag=$this->calculate_score($sentence_bag);//hitung jumlah nilai kata dalam 1 kalimat
        $this->aasort($sentence_bag,'score');
//        print_r($sentence_bag);
        $summary_bag = array_slice($sentence_bag,0,4); //4 kalimat



        usort($summary_bag, array(&$this, 'cmp_arrays_ord'));
        usort($sentence_bag, array(&$this, 'cmp_arrays_ord'));
      //  print_r($sentence_bag);
        $summary_sentences = array();

        $temp_summary = $this->sentence_tokenize($Doc);//temp array kalimat

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
