<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
require_once APPPATH . '../vendor/autoload.php';

class Proses extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $username = $this->session->userdata('username');
        if (!isset($username))
        {
            $this->flashmsg('Anda harus login dulu','warning');
            redirect('Login');
            exit;
        }

        $this->load->library('Preprocessing');

    }

    public function index()
    {
        $this->data['title'] = 'Input Pendapat';
        $this->data['content'] = 'input_pendapat';
        $this->template($this->data, 'input');
    }


    /**
     *  Method ini digunakan untuk melakukan proses input pendapat dan analisis.
     *  @author Ayu Lestari
     *  @return msg (positif, negatif, netral)

    */
    public function analysis(){
        
        if($this->POST('submit-input')){
            $stem = [];

            $data               = $this->input->post('text_input');
            $casefolding        = $this->preprocessing->casefolding($data);
            $sentence_splitter  = $this->preprocessing->sentence_splitter($casefolding);

            foreach($sentence_splitter as $sentence){
                $stem[] = $this->preprocessing->stem($sentence);
            }

            $tokenizing         = $this->preprocessing->tokenizing($stem, ' ');
            $stopwords_removal  = $this->preprocessing->stopwords_removal($tokenizing);

            $this->data['casefolding']          = $casefolding;
            $this->data['sentence_splitter']    = $sentence_splitter;
            $this->data['stemming']             = $stem;
            $this->data['tokenizing']           = $tokenizing;
            $this->data['stopwords_removal']    = $stopwords_removal;
        }

        $this->data['title'] = 'Input Pendapat';
        $this->data['content'] = 'input_pendapat';
        $this->template($this->data, 'input');
    }

    /**
     *  Method ini digunakan untuk melakukan praproses data.
     *  @author Ayu Lestari
     *  @return array dua dimensi

    */
    public function praproses_data($data){
        $stem = [];

        $casefolding        = $this->preprocessing->casefolding($data);

        $sentence_splitter  = $this->preprocessing->sentence_splitter($casefolding);

        foreach($sentence_splitter as $sentence){
            $stem[] = $this->preprocessing->stem($sentence);
        }

        $tokenizing         = $this->preprocessing->tokenizing($stem, ' ');
        
        // array hasil stopword removal itu tidak semuanya ada. bisa array(2){[1]=> "Aku",[3]=> "lala"}
        $stopwords_removal  = $this->preprocessing->stopwords_removal($tokenizing);

        return $stopwords_removal;
    }

    public function preprocess_document($data)
    {
        $stem = [];

        $casefolding        = $this->preprocessing->casefolding($data[0]);

        $sentence_splitter  = $this->preprocessing->sentence_splitter($casefolding);

        foreach($sentence_splitter as $sentence){
            $stem []= $this->preprocessing->stem($sentence);
        }

        $tokenizing         = $this->preprocessing->tokenizing($stem, ' ');
        
        // array hasil stopword removal itu tidak semuanya ada. bisa array(2){[1]=> "Aku",[3]=> "lala"}
        $stopwords_removal  = $this->preprocessing->stopwords_removal($tokenizing);
        $stopwords_removal = array_filter($stopwords_removal, function($v) {return count($v) <= 0 ? false : true;});
        return $stopwords_removal;
    }

    /**
     *  Method ini digunakan untuk melakukan proses training.
     *  @author Ayu Lestari
     *  @return bobot setiap kata

    */
    public function training(){
        // baca file 
        $pendapat_positif = $this->preprocessing->read_file_by_line('positif');
        $pendapat_negatif = $this->preprocessing->read_file_by_line('negatif');

        
        // CONTOH PERHITUNGAN DULU

        // Insert Data Latih

        $pendapat_positif = [
            'Saya sangat menyukai dunia Informatika, dan sebenarnya dari kecil itu saya sangat suka tentang hal-hal yang berbau komputer.',
            'Makanya saya berniat untuk masuk ke Jurusan Komputer.'
        ];

        $pendapat_negatif = [
            'Saya menyesal masuk jurusan teknik informatika, karena logika saya lemah.',
            'Saya salah masuk jurusan ke Teknik Informatika'
        ];

        // lakukan praproses data
        $praproses_pendapat_positif = $this->praproses_data($pendapat_positif);
        $praproses_pendapat_negatif = $this->praproses_data($pendapat_negatif);


        // Perhitungan Kategori Positif

        // Hitung probabilitas positif

        $jum_doc_positif = 2;
        $data_latih = 4;

        $probab_positif = $jum_doc_positif/$data_latih;
        $jumlah_kata_unik = 0;

        // Hitung probabilitas kata pada kategori positif

        $jumlah_kata_positif = 0; // n
        $frek_kata_positif = []; //nk

        // Hitung Jumlah Kata Positif
        foreach($praproses_pendapat_positif as $row){
            $jumlah_kata_positif += count($row);
            
            foreach($row as $col){
                if(!isset($frek_kata_positif[$col])){
                    $frek_kata_positif[$col] = 1;
                }
                else {
                    $frek_kata_positif[$col]++;
                }
            }
        }

        // untuk menghapus elemen array dengan key empty string 
        unset($frek_kata_positif[""]);


        // Hitung probabilitas kata pada kategori negatif

        $jumlah_kata_negatif = 0; // n
        $frek_kata_negatif = []; //nk

        foreach($praproses_pendapat_negatif as $row){
            // $jumlah_kata_negatif += count($row);
            
            foreach($row as $col){
                if(!isset($frek_kata_negatif[$col])){
                    $frek_kata_negatif[$col] = 1;
                }
                else {
                    $frek_kata_negatif[$col]++;
                }
            }
        }

        // untuk menghapus elemen array dengan key empty string 
        unset($frek_kata_negatif[""]);
        $jumlah_kata_positif = count($frek_kata_positif);
        $jumlah_kata_negatif = count($frek_kata_negatif);
        $jumlah_kata_unik = count($frek_kata_positif) + count($frek_kata_negatif);
        $jumlah_kata_semua_kategori = $jumlah_kata_positif+$jumlah_kata_negatif; // kosakata

        $probab_kata = [];

        // foreach ($frek_kata_positif as $key => $value) {
        //     $probab_kata[$key]['positif'] = ($value + 1)/($jumlah_kata_positif+$jumlah_kata_semua_kategori);
        // }

        // foreach ($frek_kata_negatif as $key => $value) {
        //     $probab_kata[$key]['negatif'] = ($value + 1)/($jumlah_kata_negatif+$jumlah_kata_semua_kategori);
        // }

        $this->dump($frek_kata);
        exit;
       
        $this->data['title'] = 'Input Pendapat';
        $this->data['content'] = 'input_pendapat';
        $this->template($this->data, 'input');
    }

    public function training2(){
        // baca file 
        $pendapat_positif = $this->preprocessing->read_file_by_line('positif');
        $pendapat_negatif = $this->preprocessing->read_file_by_line('negatif');

        
        // CONTOH PERHITUNGAN DULU

        // Insert Data Latih

        // cari prior probability
        $total_dokumen = count($pendapat_positif) + count($pendapat_negatif);
        $total_dokumen_positif = count($pendapat_positif);
        $total_dokumen_negatif = count($pendapat_negatif);

        $prior_probability['+'] = (float)$total_dokumen_positif / (float)$total_dokumen;
        $prior_probability['-'] = (float)$total_dokumen_negatif / (float)$total_dokumen;

        // lakukan praproses data
        $praproses_pendapat_positif = $this->praproses_data($pendapat_positif);
        $praproses_pendapat_negatif = $this->praproses_data($pendapat_negatif);

        $frekuensi_kata = [];
        $frekuensi_kata_positif = [];
        $frekuensi_kata_negatif = [];

        foreach ($praproses_pendapat_positif as $dokumen)
        {
            foreach ($dokumen as $kata)
            {
                if (!isset($frekuensi_kata[$kata]))
                {
                    $frekuensi_kata[$kata] = 1;
                }
                else
                {
                    $frekuensi_kata[$kata]++;
                }

                if (!isset($frekuensi_kata_positif[$kata]))
                {
                    $frekuensi_kata_positif[$kata] = 1;
                }
                else
                {
                    $frekuensi_kata_positif[$kata]++;
                }
            }
        }

        foreach ($praproses_pendapat_negatif as $dokumen)
        {
            foreach ($dokumen as $kata)
            {
                if (!isset($frekuensi_kata[$kata]))
                {
                    $frekuensi_kata[$kata] = 1;
                }
                else
                {
                    $frekuensi_kata[$kata]++;
                }

                if (!isset($frekuensi_kata_negatif[$kata]))
                {
                    $frekuensi_kata_negatif[$kata] = 1;
                }
                else
                {
                    $frekuensi_kata_negatif[$kata]++;
                }
            }
        }

        $total_kata_unik = count($frekuensi_kata);
        $total_kata_unik_positif = count($frekuensi_kata_positif);
        $total_kata_unik_negatif = count($frekuensi_kata_negatif);

        $posterior_probability = [];
        foreach ($frekuensi_kata as $kata => $frekuensi)
        {
            $frekuensi_pos = 0;
            $frekuensi_neg = 0;
            if (isset($frekuensi_kata_positif[$kata]))
            {
                $frekuensi_pos = $frekuensi_kata_positif[$kata];
            }
            if (isset($frekuensi_kata_negatif[$kata]))
            {
                $frekuensi_neg = $frekuensi_kata_negatif[$kata];
            }

            $posterior_probability[$kata]['+'] = (float)($frekuensi_pos + 1) / (float)($total_kata_unik_positif + $total_kata_unik);
            $posterior_probability[$kata]['-'] = (float)($frekuensi_neg + 1) / (float)($total_kata_unik_negatif + $total_kata_unik);
        }

        $this->dump($posterior_probability);
        $this->load->model('data_m');
        foreach ($posterior_probability as $kata => $probability)
        {
            $check_posterior = $this->data_m->get_row(['kata' => $kata]);
            if ($check_posterior)
            {
                 $this->data_m->update_where(['kata' => $kata], [
                    'bobot_positif' => $probability['+'],
                    'bobot_negatif' => $probability['-']
                ]);
            }
            else
            {
                $this->data_m->insert([
                    'kata'          => $kata,
                    'bobot_positif' => $probability['+'],
                    'bobot_negatif' => $probability['-']
                ]);
            }
        }

        // $this->dump($frekuensi_kata);
        // $this->dump($frekuensi_kata_positif);
        // $this->dump($frekuensi_kata_negatif);
    }

    public function testing2()
    {
        $pendapat_positif = $this->preprocessing->read_file_by_line('positif');
        $pendapat_negatif = $this->preprocessing->read_file_by_line('negatif');

        
        // CONTOH PERHITUNGAN DULU

        // Insert Data Latih

        // cari prior probability
        $total_dokumen = count($pendapat_positif) + count($pendapat_negatif);
        $total_dokumen_positif = count($pendapat_positif);
        $total_dokumen_negatif = count($pendapat_negatif);

        $prior_probability['+'] = (float)$total_dokumen_positif / (float)$total_dokumen;
        $prior_probability['-'] = (float)$total_dokumen_negatif / (float)$total_dokumen;

        // ===============================

        $this->load->model('data_m');
        $pendapat = 'Saya ingin pindah kejurusan lain, karena informatika sangat sulit bagi saya';
        echo $pendapat . '<br>';
        $pendapat = $this->preprocessing->casefolding($pendapat);
        $pendapat = $this->preprocessing->stem($pendapat);
        $pendapat = $this->preprocessing->tokenizing2($pendapat, ' ');
        $pendapat = $this->preprocessing->stopwords_removal2($pendapat);
        $pos_probability = 1 * $prior_probability['+'];
        $neg_probability = 1 * $prior_probability['-'];
        foreach ($pendapat as $kata)
        {
            $posterior = $this->data_m->get_row(['kata' => $kata]);
            if ($posterior)
            {
                $pos_probability *= $posterior->bobot_positif;
                $neg_probability *= $posterior->bobot_negatif;
            }
        }


        if ($pos_probability > $neg_probability)
        {
            echo '+';
        }
        else
        {
            echo '-';
        }
    }
}
