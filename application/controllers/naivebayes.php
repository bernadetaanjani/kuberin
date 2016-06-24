<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Naivebayes extends CI_Controller {
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
        $this->load->model('nbmodel');
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
            $data['nav_kategori']='';
            $data['nav_summarize']='';
            $data['nav_summarizebaru']='';
            $data['nav_summarizevalen']='';
            $data['nav_datalatih']='';
            $data['nav_naivebayes']='active';
            $data['nav_tambahdatalatih']='';
            $data['page_title']='Kuberin Administrator';
            $this->load->view('header', $data);
            $this->load->view('navigation', $data);
            $this->load->view('naivebayes_view', $data);
            $this->load->view('footer', $data);
        }
        else
        {
            redirect('home', 'refresh');
        }
    }

    public $stopwords = array('--', '-', 'ada','adalah','adanya','adapun','agak','agaknya','agar','akan','akankah','akhir','akhiri','akhirnya','aku','akulah','amat','amatlah','anda',
        'andalah','antar','antara','antaranya','apa','apaan','apabila','apakah','apalagi','apatah','artinya','asal','asalkan','atas','atau','ataukah','ataupun','awal','awalnya',
        'bagai','bagaikan','bagaimana','bagaimanakah','bagaimanapun','bagi','bagian','bahkan','bahwa','bahwasanya','baik','bakal','bakalan','balik','banyak','bapak','baru','bawah',
        'beberapa','begini','beginian','beginikah','beginilah','begitu','begitukah','begitulah','begitupun','bekerja','belakang','belakangan','belum','belumlah','benar','benarkah',
        'benarlah','berada','berakhir','berakhirlah','berakhirnya','berapa','berapakah','berapalah','berapapun','berarti','berawal','berbagai','berdatangan','beri','berikan','berikut',
        'berikutnya','berjumlah','berkali-kali','berkata','berkehendak','berkeinginan','berkenaan','berlainan','berlalu','berlangsung','berlebihan','bermacam','bermacam-macam','bermaksud','bermula','bersama','bersama-sama','bersiap','bersiap-siap','bertanya','bertanya-tanya','berturut','berturut-turut','bertutur','berujar','berupa','besar','betul','betulkah','biasa','biasanya','bila','bilakah','bisa','bisakah','boleh','bolehkah','bolehlah','buat','bukan','bukankah','bukanlah','bukannya','bulan','bung','cara','caranya','cukup','cukupkah','cukuplah','cuma','dahulu','dalam','dan','dapat','dari','daripada','datang','dekat','demi','demikian','demikianlah','dengan','depan','di','dia','diakhiri','diakhirinya','dialah','diantara','diantaranya','diberi','diberikan','diberikannya','dibuat','dibuatnya','didapat','didatangkan','digunakan','diibaratkan','diibaratkannya','diingat','diingatkan','diinginkan','dijawab','dijelaskan','dijelaskannya','dikarenakan','dikatakan','dikatakannya','dikerjakan','diketahui','diketahuinya','dikira','dilakukan','dilalui','dilihat','dimaksud','dimaksudkan','dimaksudkannya','dimaksudnya','diminta','dimintai','dimisalkan','dimulai','dimulailah',
        'dimulainya','dimungkinkan','dini','dipastikan','diperbuat','diperbuatnya','dipergunakan','diperkirakan','diperlihatkan','diperlukan','diperlukannya','dipersoalkan','dipertanyakan','dipunyai','diri','dirinya','disampaikan','disebut','disebutkan','disebutkannya','disini','disinilah','ditambahkan','ditandaskan','ditanya','ditanyai','ditanyakan','ditegaskan','ditujukan','ditunjuk','ditunjuki','ditunjukkan','ditunjukkannya','ditunjuknya','dituturkan','dituturkannya','diucapkan','diucapkannya','diungkapkan','dong','dua','dulu','empat','enggak','enggaknya','entah','entahlah','guna','gunakan','hal','hampir','hanya',
        'hanyalah','hari','harus','haruslah','harusnya','hendak','hendaklah','hendaknya','hingga','ia','ialah','ibarat','ibaratkan','ibaratnya','ibu','ikut','ingat','ingat-ingat','ingin','inginkah','inginkan','ini','inikah','inilah','itu','itukah','itulah','jadi','jadilah','jadinya','jangan','jangankan','janganlah','jauh','jawab','jawaban','jawabnya','jelas','jelaskan','jelaslah','jelasnya','jika','jikalau','juga','jumlah','jumlahnya','justru','kala','kalau','kalaulah','kalaupun','kalian','kami','kamilah','kamu','kamulah','kan','kapan','kapankah','kapanpun','karena','karenanya','kasus','kata','katakan','katakanlah','katanya','ke','keadaan','kebetulan','kecil','kedua','keduanya','keinginan','kelamaan','kelihatan','kelihatannya','kelima','keluar','kembali','kemudian','kemungkinan','kemungkinannya','kenapa','kepada','kepadanya','kesampaian','keseluruhan','keseluruhannya','keterlaluan','ketika','khususnya','kini','kinilah','kira','kira-kira','kiranya','kita','kitalah','kok','kurang','lagi','lagian','lah','lain','lainnya','lalu','lama','lamanya','lanjut','lanjutnya','lebih','lewat','lima','luar','macam','maka','makanya','makin','malah','malahan','mampu','mampukah',
        'mana','manakala','manalagi','masa','masalah','masalahnya','masih','masihkah','masing','masing-masing','mau','maupun','melainkan','melakukan','melalui','melihat','melihatnya','memang','memastikan','memberi','memberikan','membuat','memerlukan','memihak','meminta','memintakan','memisalkan','memperbuat','mempergunakan','memperkirakan','memperlihatkan','mempersiapkan','mempersoalkan','mempertanyakan','mempunyai','memulai','memungkinkan','menaiki','menambahkan','menandaskan','menanti','menanti-nanti','menantikan','menanya','menanyai','menanyakan','mendapat','mendapatkan','mendatang','mendatangi','mendatangkan','menegaskan','mengakhiri','mengapa','mengatakan','mengatakannya','mengenai','mengerjakan','mengetahui','menggunakan','menghendaki','mengibaratkan','mengibaratkannya','mengingat','mengingatkan','menginginkan','mengira','mengucapkan','mengucapkannya','mengungkapkan','menjadi','menjawab','menjelaskan','menuju','menunjuk','menunjuki','menunjukkan','menunjuknya','menurut','menuturkan','menyampaikan','menyangkut','menyatakan','menyebutkan','menyeluruh','menyiapkan','merasa','mereka','merekalah','merupakan','meski','meskipun','meyakini','meyakinkan','minta','mirip','misal','misalkan','misalnya','mula','mulai','mulailah','mulanya','mungkin','mungkinkah','nah','naik','namun','nanti','nantinya','nyaris','nyatanya','oleh','olehnya','pada','padahal','padanya','pak','paling','panjang','pantas','para','pasti','pastilah','penting','pentingnya','per','percuma','perlu','perlukah','perlunya','pernah','persoalan','pertama','pertama-tama','pertanyaan','pertanyakan','pihak','pihaknya','pukul','pula','pun','punya','rasa','rasanya','rata','rupanya','saat','saatnya','saja','sajalah','saling','sama','sama-sama','sambil','sampai','sampai-sampai','sampaikan','sana','sang','sangat','sangatlah','satu','saya','sayalah','se','sebab','sebabnya','sebagai','sebagaimana','sebagainya','sebagian','sebaik','sebaik-baiknya','sebaiknya','sebaliknya','sebanyak','sebegini','sebegitu','sebelum','sebelumnya','sebenarnya','seberapa','sebesar','sebetulnya','sebisanya','sebuah','sebut','sebutlah','sebutnya','secara','secukupnya','sedang','sedangkan','sedemikian','sedikit','sedikitnya','seenaknya','segala','segalanya','segera','seharusnya','sehingga','seingat','sejak','sejauh','sejenak','sejumlah','sekadar',
        'sekadarnya','sekali','sekali-kali','sekalian','sekaligus','sekalipun','sekarang','sekarang','sekecil','seketika','sekiranya','sekitar','sekitarnya','sekurang-kurangnya',
        'sekurangnya','sela','selain','selaku','selalu','selama','selama-lamanya','selamanya','selanjutnya','seluruh','seluruhnya','semacam','semakin',
        'semampu','semampunya','semasa','semasih','semata','semata-mata','semaunya','sementara','semisal','semisalnya','sempat','semua','semuanya',
        'semula','sendiri','sendirian','sendirinya','seolah','seolah-olah','seorang','sepanjang','sepantasnya','sepantasnyalah','seperlunya','seperti','sepertinya','sepihak',
        'sering','seringnya','serta','serupa','sesaat','sesama','sesampai','sesegera','sesekali','seseorang','sesuatu','sesuatunya','sesudah',
        'sesudahnya','setelah','setempat','setengah','seterusnya','setiap','setiba','setibanya','setidak-tidaknya','setidaknya','setinggi','seusai','sewaktu',
        'siap','siapa','siapakah','siapapun','sini','sinilah','soal','soalnya','suatu','sudah','sudahkah','sudahlah','supaya','tadi','tadinya','tahu',
        'tahun','tak','tambah','tambahnya','tampak','tampaknya','tandas','tandasnya','tanpa','tanya','tanyakan','tanyanya','tapi','tegas','tegasnya',
        'telah','tempat','tengah','tentang','tentu','tentulah','tentunya','tepat','terakhir','terasa','terbanyak','terdahulu','terdapat','terdiri',
        'terhadap','terhadapnya','teringat','teringat-ingat','terjadi','terjadilah','terjadinya','terkira','terlalu','terlebih','terlihat','termasuk',
        'ternyata','tersampaikan','tersebut','tersebutlah','tertentu','tertuju','terus','terutama','tetap','tetapi','tiap','tiba','tiba-tiba','tidak',
        'tidakkah','tidaklah','tiga','tinggi','toh','tunjuk','turut','tutur','tuturnya','ucap','ucapnya','ujar','ujarnya','umum','umumnya','ungkap',
        'ungkapnya','untuk','usah','usai','waduh','wah','wahai','waktu','waktunya','walau','walaupun','wong','yaitu','yakin','yakni','yang');

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

        public function netral($idberita){
            $result=$this->datalatihmodel->get_news_item($idberita);
            // var_dump($result);
            // echo $result[0]['isi_berita'];
            $this->insertKataLatihNet($result[0]['isi_berita'], $idberita);
            redirect('datalatih');
        }


        public function insertKataLatihPos($teks, $idberita){
            //ubah string ke array of strings
            $teks = explode(" ", $teks);
            $log="";

            //insert $teks ke tbl_kata dgn unique index & insert ke tbl_katahasil (id_kata, id_berita, hasil)
            //      insert ($teks[i]) to tbl_kata
            //      select id_kata where kata = $teks[i]
            //      insert (id_kata, $id_berita, $hasil) to tbl_katahasil 

            for($i=0;$i<count($teks);$i++){
                if ($teks[$i]!=null) {
                    $result = $this->katamodel->insert_kata_get_id($teks[$i]);
                    // $resdata= $result->result_array();
                    $idkata= $result->id_kata;
                    // var_dump($idkata);
                    if($idkata!=null){
                        if($this->katamodel->insert_katahasil($idberita, $idkata, 'pos')){
                            $log=$log."; katahasil ".$i." berhasil";
                        }else{
                            $log=$log."; katahasil ".$i." tidak berhasil";
                        }

                    }else{
                        $log=$log."; idkata ".$i." null";
                    }
                }
            }

            $this->datalatihmodel->change_flag($idberita);

            // $data['title']="hasil";

            // $this->load->view('templates/header', $data);
            // $this->load->view('news/hasilanalisis', $log);
            // $this->load->view('templates/footer');
            
            

            //if finished return true, klo error return false
        }



        public function insertKataLatihNet($teks, $idberita){
            //ubah string ke array of strings
            $teks = explode(" ", $teks);
            $log="";

            //insert $teks ke tbl_kata dgn unique index & insert ke tbl_katahasil (id_kata, id_berita, hasil)
            //      insert ($teks[i]) to tbl_kata
            //      select id_kata where kata = $teks[i]
            //      insert (id_kata, $id_berita, $hasil) to tbl_katahasil 

            for($i=0;$i<count($teks);$i++){
                if ($teks[$i]!=null) {
                    $result = $this->katamodel->insert_kata_get_id($teks[$i]);
                    // $resdata= $result->result_array();
                    $idkata= $result->id_kata;
                    // var_dump($idkata);
                    if($idkata!=null){
                        if($this->katamodel->insert_katahasil($idberita, $idkata, 'net')){
                            $log=$log."; katahasil ".$i." berhasil";
                        }else{
                            $log=$log."; katahasil ".$i." tidak berhasil";
                        }

                    }else{
                        $log=$log."; idkata ".$i." null";
                    }
                }
            }

            // $data['title']="hasil";

            // $this->load->view('templates/header', $data);
            // $this->load->view('news/hasilanalisis', $log);
            // $this->load->view('templates/footer');
            
            

            //if finished return true, klo error return false

            $this->datalatihmodel->change_flag($idberita);
        }

        public function insertKataLatihNeg($teks, $idberita){
            //ubah string ke array of strings
            $teks = explode(" ", $teks);
            $log="";

            //insert $teks ke tbl_kata dgn unique index & insert ke tbl_katahasil (id_kata, id_berita, hasil)
            //      insert ($teks[i]) to tbl_kata
            //      select id_kata where kata = $teks[i]
            //      insert (id_kata, $id_berita, $hasil) to tbl_katahasil 

            for($i=0;$i<count($teks);$i++){
                if ($teks[$i]!=null) {
                    $result = $this->katamodel->insert_kata_get_id($teks[$i]);
                    // $resdata= $result->result_array();
                    $idkata= $result->id_kata;
                    // var_dump($idkata);
                    if($idkata!=null){
                        if($this->katamodel->insert_katahasil($idberita, $idkata, 'neg')){
                            $log=$log."; katahasil ".$i." berhasil";
                        }else{
                            $log=$log."; katahasil ".$i." tidak berhasil";
                        }

                    }else{
                        $log=$log."; idkata ".$i." null";
                    }
                }
                
            }

            $this->datalatihmodel->change_flag($idberita);

            // $data['title']="hasil";

            // $this->load->view('templates/header', $data);
            // $this->load->view('news/hasilanalisis', $log);
            // $this->load->view('templates/footer');
            
            

            //if finished return true, klo error return false
        }
        public function stem_word($word)
        {
            
            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();
          
            $word   = $stemmer->stem($word);

            return $word;
        }

        public function sentimentAnalyzing($teks){
            // $teks berupa array of strings
            $teks = explode(" ", $teks);
            $log="";
            $tempPos=1;
            $tempNeg=1;

            //insert $teks ke tbl_kata dgn unique index & insert ke tbl_katahasil (id_kata, id_berita, hasil)
            //      insert ($teks[i]) to tbl_kata
            //      select id_kata where kata = $teks[i]
            //      insert (id_kata, $id_berita, $hasil) to tbl_katahasil 

            //POSITIF
            for($i=0;$i<count($teks);$i++){
                if ($teks[$i]!=null) {
                    $idkata=$this->nbmodel->getidkata($teks[$i]); //nbmodel->get id_kata from tbl_kata where kata=$teks[$i]
                    $jmlKataPos=$this->nbmodel->countkataPos($idkata); //nbmodel-> select count(select * from tbl_katahasil where id_kata=$idkata && hasil='pos')
                    $jmlBeritaPos=$this->nbmodel->countberitaPos(); //hitung semua berita positif
                    $tempPos=$tempPos*($jmlKataPos/$jmlBeritaPos);

                    $jmlKataNeg=$this->nbmodel->countkataNeg($idkata); //nbmodel-> select count(select * from tbl_katahasil where id_kata=$idkata && hasil='neg')
                    $jmlBeritaNeg=$this->nbmodel->countberitaNeg(); //hitung semua berita positif
                    $tempNeg=$tempNeg*($jmlKataNeg/$jmlBeritaNeg);
                }
            }

            $totalBerita=$this->nbmodel->jumlahBerita(); //mysql_num_rows($berita)
            $likelihoodPos = $tempPos*($jmlBeritaPos/$totalBerita);
            $likelihoodNeg = $tempNeg*($jmlBeritaNeg/$totalBerita);

            $probabilityPos=$likelihoodPos/($likelihoodPos+$likelihoodNeg);
            $probabilityNeg=$likelihoodNeg/($likelihoodPos+$likelihoodNeg);

            if($probabilityPos>$probabilityNeg)
                return 'pos';
            else
                return 'net';

            // hitung positif-> perulangan -> $idkata = select id_kata from tbl_kata where kata=$teks[$i]
            //                                  $jmlKataPos = select count(select * from tbl_katahasil where id_kata=$idkata && hasil='pos')
            //                                  $jmlBeritaPos = select count(*) from tbl_hasilanalisis where hasil='pos'
            //                                  $temp=$temp*($jmlKataPos/$jmlBeritaPos)
            //                 $totalBerita = mysql_num_rows($berita)
            //                 $likelihoodPos = $temp*($jmlBeritaPos/$totalBerita)

            // hitung negatif-> perulangan -> $idkata = select id_kata from tbl_kata where kata=$teks[$i]
            //                                  $jmlKataNeg = select count(select * from tbl_katahasil where id_kata=$idkata && hasil='neg')
            //                                  $jmlBeritaNeg = select count(*) from tbl_hasilanalisis where hasil='neg'
            //                                  $temp=$temp*($jmlKataNeg/$jmlBeritaNeg)
            //                 $likelihoodNeg = $temp*($jmlBeritaNeg/$totalBerita)

            // hitung netral-> perulangan -> $idkata = select id_kata from tbl_kata where kata=$teks[$i]
            //                                  $jmlKataNet = select count(select * from tbl_katahasil where id_kata=$idkata && hasil='net')
            //                                  $jmlBeritaNet = select count(*) from tbl_hasilanalisis where hasil='net'
            //                                  $temp=$temp*($jmlKataNet/$jmlBeritaNet)
            //                 $likelihoodNet = $temp*($jmlBeritaNet/$totalBerita)

            // $probabilityPos=$likelihoodPos/($likelihoodPos+$likelihoodNeg+$likelihoodNet)
            // $probabilityNeg=$likelihoodNeg/($likelihoodPos+$likelihoodNeg+$likelihoodNet)
            // $probabilityNet=$likelihoodNet/($likelihoodPos+$likelihoodNeg+$likelihoodNet)

            // if($probabilityPos>$probabilityNeg){
            //     if($probabilityPos>$probabilityNet)
            //         return 'pos';
            //     else
            //         return 'net';
            // }else if ($probabilityNeg>$probabilityNet){
            //     return 'neg';
            // } else
            // return 'net';
        }





        public function analyze($slug = NULL)
        {
                $data['news_item'] = $this->news_model->get_news(1,0,$slug);
                // var_dump($data);

                if (empty($data['news_item']))
                {
                        show_404();
                }

                $data['title'] = $data['news_item']['judul'];
                $isiberita = $data['news_item']['isi_berita'];
                
                $isiberitafolded = $this->case_folding($isiberita);
                // var_dump($isiberitafolded);
                $isiberitaremoved = $this->stopword_removal($isiberitafolded);
                // var_dump($isiberitaremoved);
                $tokenized = $this->tokenizer($isiberitaremoved);
                // var_dump($tokenized);
                $tokenized2= $this->tokenizer2($tokenized);
                $stemmed= $this->stem_word($tokenized);
                $data['isi_berita'] = $stemmed;

                $sentiment=$this->uri->segment(4);
                var_dump($stemmed);
               





                // if($sentiment="pos"){
                //     $data['log']=$this->insertKataLatihPos($stemmed,$slug);    
                // }elseif ($sentiment="net") {
                //     $data['log']=$this->insertKataLatihNet($stemmed,$slug);
                // }else{
                //     $data['log']=$this->insertKataLatihNeg($stemmed,$slug);
                // }
                


                // $this->load->view('templates/header', $data);
                // $this->load->view('news/hasil', $data);
                // $this->load->view('templates/footer');
        }



}