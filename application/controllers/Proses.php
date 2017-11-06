<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Proses extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->data['id_role'] = $this->session->userdata('id_role');
        // if (!isset($this->data['id_role']) || $this->data['id_role'] != 1)
        // {
        //     $this->session->unset_userdata('username');
        //     $this->session->unset_userdata('id_role');
        //     $this->flashmsg('Anda harus login dulu','warning');
        //     redirect('login');
        //     exit;
        // }

    }

    public function index()
    {
        $this->data['title'] = 'Input Pendapat';
        $this->data['content'] = 'input_pendapat';
        $this->template($this->data, 'input');
    }


    /*
        Method ini digunakan untuk melakukan proses input pendapat dan analisis.

        @author Ayu Lestari
        @return msg (positif, negatif, netral)

    */
    public function input(){
        
        if($this->POST('submit-input')){
            $data = $this->POST('text_input');
            $casefolding = $this->casefolding($data);
            // echo $casefolding.'<br><br>';

            $sentence_splitter= $this->sentence_splitter($data);
            // print_r($sentence_splitter);
            
            $tokenizing = $this->tokenizing($sentence_splitter, ' ');
            // echo "<br><br>";
            // print_r($tokenizing);
            // exit;

            $this->data['sentence_splitter']    = $sentence_splitter;
            $this->data['casefolding']          = $casefolding;
            $this->data['tokenizing']           = $tokenizing;
            // redirect('Proses/input');
            // $this->load->view('input_pendapat', $hasil_praproses);

            // exit;
        }
        // else{
        //     $this->flashmsg('Anda harus mengisi pendapat anda','danger');
        //     // exit;
        // }

        $this->data['title'] = 'Input Pendapat';
        // $this->data['sentence_splitter'] = $sentence_splitter;
        $this->data['content'] = 'input_pendapat';
        $this->template($this->data, 'input');
    }

    /*
        Method ini digunakan untuk praproses casefolding.

        @author Ayu Lestari
        @param data -> pendapat dalam kalimat atau paragraf
        @return data

    */
    public function casefolding($data){
        return strtolower($data);
    }


    /*
        Method ini digunakan untuk praproses data memisah paragraf menjadi kalimat.

        @author Ayu Lestari
        @param data -> pendapat
        @return array kalimat

    */
    public function sentence_splitter($data){
        $hasil = explode('.', $data);

        return $hasil;
    }

    /*
        Method ini digunakan untuk praproses tokenizing.

        @author Ayu Lestari
        @params data -> pendapat yang sudah dilakukan sentence splitter
        @params delimiter/pemisah
        @return assosiative array

    */
    public function tokenizing($data, $delimiter){
        $jmlh_kalimat = count($data);
        $hasil = [];

        if($jmlh_kalimat > 1){

            for ($i = 0; $i<count($data); $i++) {
                $hasil[$i] = explode($delimiter, $data[$i]); 
            }
        }
        else {
            $hasil = explode($delimiter, $data); 
        }
        
        return $hasil;
    }

    /*
        Method ini digunakan untuk praproses stopword_removal.

        @author Ayu Lestari
        @params data -> token2
        @return array

    */
    public function stopwords_removal($data){
        //var_dump($data);exit;

        $kamus = [];
        $hasil = [];

        $kamus = $this->read_file_by_line("kamus_stopwords_removal");
        var_dump($kamus);exit;

        foreach($data as $kata){
            $hasil[] = array_diff($kata, $kamus);
        }            
        
        print_r($hasil);
    }

    /*
        Method ini digunakan untuk membaca file.

        @author Ayu Lestari
        @param nama file
        @return konten dalam file

    */

    public function read_file($filename){
        $myfile = "assets/doc/$filename.txt";
        $handle = fopen($myfile, "r") or die("Unable to open file!");
        $contents = fread($handle, filesize($myfile));
        fclose($handle);

        return $contents;
    }

    /*
        Method ini digunakan untuk membaca konten file perbaris.

        @author Ayu Lestari
        @param nama file
        @return array setiap baris konten dokumen

    */

    public function read_file_by_line($filename){
        $hasil = [];

        $handle = @fopen("assets/doc/$filename.txt", "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $hasil[] = $buffer;
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }

        return $hasil;
    }

    public function coba(){
        //var_dump(array_diff(["ada", "apa", "cinta"], ["ada", "aku", "cantik", "apa"]));exit;

        $data = $this->sentence_splitter("ada apa. dengan cinta.");
        $token = $this->tokenizing($data, ' ');
        $this->stopwords_removal($token);
        //$this->read_file_by_line("kamus_stopwords_removal");
    }
}
