<?php
class Datalatihmodel extends CI_Model {
	  public function __construct()
        {
                $this->load->database();
        }

        public function record_count() {
	        return $this->db->count_all('tbl_berita');
	    }


        public function get_news($limit, $start, $slug = FALSE)
		{
			$this->db->limit($limit,$start);
	        if ($slug === FALSE)
	        {

	                $query = $this->db->get_where('tbl_berita', array('flag_analyzed' =>0));
	        		// $query ="SELECT * FROM tbl_berita WHERE 'flag_analyzed'=0 LIMIT ".$start.", ".$limit.";";
	        		// echo $query;
	                return $query->result_array();
	        }

	        $query = $this->db->get_where('tbl_berita', array('id_berita' => $slug));
	        return $query->row_array();
		}

		public function get_news_item($slug){
			$q = $this->db->query('SELECT * FROM tbl_berita WHERE id_berita = "'.$slug.'"');
			// var_dump($query->result_array);
			return $q->result_array();

		}

		public function check_analyzed($slug){
			$q=$this->db->query('SELECT * from tbl_katahasil WHERE id_berita = "'.$slug.'"');
			// var_dump($q->num_rows());
			$numrows=$q->num_rows();
			if($numrows>0){
				return true;
			}else{
				return false;
			}
		}

		public function change_flag($slug){
			$q=$this->db->query('UPDATE tbl_berita SET flag_analyzed=1 WHERE id_berita='.$slug);
		}

		public function insertDataLatih($judul, $tanggal, $waktu, $kategori, $gambar, $isi_berita, $sumberberita, $flag){
			$q=$this->db->query("INSERT INTO `tbl_berita`(`judul`, `tanggal`, `waktu`, `kategori`, `gambar`, `isi_berita`, `sumberberita`,  `flag_analyzed`) 
				VALUES ('".$judul."','".$tanggal."','".$waktu."','".$kategori."','".$gambar."','".$isi_berita."','".$sumberberita."','".$flag."');");
		}
	}

// 		public function tambahdata($sumberberita, $url, $judul, $kategori, $gambar, $isi){
// 			$q=$this->db->query("INSERT INTO 'tbl_berita")
// 		}
// }