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

            $data               = $this->POST('text_input');
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
     *  Method ini digunakan untuk melakukan proses training.
     *  @author Ayu Lestari
     *  @return bobot setiap kata

    */
    public function training(){
        // baca file 
        //$pendapat_negatif = $this->preprocessing->read_file_by_line('negatif');
        
        // CONTOH PERHITUNGAN DULU

        
        // lakukan praproses 

        $pendapat_positif = [
            'barang bagus sesuai dengan gambar, thanks',
            'barang sampai dengan selamat, kemasan rapi dan tidak cacat sama sekali',
            'barang datang lebih cepat dari perkiraan dan memuaskan, thanks',
            'hari ini pesan lusa datang, barang berfungsi sempurna sesuai gambar',
            'warna dan tampilannya oke, barang nyaman di pakai'
        ];

        $stem = [];

        $casefolding        = $this->preprocessing->casefolding($pendapat_positif);

        $sentence_splitter  = $this->preprocessing->sentence_splitter($casefolding);

        foreach($sentence_splitter as $sentence){
            $stem[] = $this->preprocessing->stem($sentence);
        }

        $tokenizing         = $this->preprocessing->tokenizing($stem, ' ');
        $stopwords_removal  = $this->preprocessing->stopwords_removal($tokenizing);

        $this->dump($stopwords_removal);exit;

        $kata = [];
        foreach($stopwords_removal as $row){
            $kata = $row;
        }
        //$this->dump($kata);exit;
        // array hasil stopword removal itu tidak semuanya ada. bisa array(2){[1]=> "Aku",[3]=> "lala"}

        $jum_doc = 5;
        $data_latih = 10;

        for($i=1; $i<count($kata)+1; $i++){
            //echo $kata[$i].'<br>';
        }

        $this->data['title'] = 'Input Pendapat';
        $this->data['content'] = 'input_pendapat';
        $this->template($this->data, 'input');
    }
}
