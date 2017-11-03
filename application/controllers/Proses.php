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

    public function input(){
        $input = $this->POST('submit-input');
        if(isset($input)){
            $data = $this->POST('text_input');

            $casefolding = $this->casefolding($data);
            echo $casefolding.'<br><br>';

            $sentence_splitter= $this->sentence_splitter($data);
            print_r($sentence_splitter);
            
            $tokenizing = $this->tokenizing($sentence_splitter);
            echo "<br><br>";
            print_r($tokenizing);
            exit;

            redirect('Proses/input');
            //$this->load->view('input_pendapat', $hasil_praproses);

            exit;
        }
        else{
            $this->flashmsg('Anda harus mengisi pendapat anda','danger');
            exit;
        }

        $this->data['title'] = 'Input Pendapat';
        $this->data['sentence_splitter'] = $sentence_splitter;
        $this->data['content'] = 'input_pendapat';
        $this->template($this->data, 'input');
    }

    public function casefolding($data){
        return strtolower($data);
    }
    public function sentence_splitter($data){
        $hasil = explode('.', $data);

        return $hasil;
    }

    public function tokenizing($data){
        for ($i = 0; $i<count($data); $i++) {
            $hasil[$i] = explode(' ', $data[$i]); 
        }
        
        return $hasil;
    }


}
