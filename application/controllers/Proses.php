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
        // $this->data['id_role'] = $this->session->userdata('id_role');
        // if (!isset($this->data['id_role']) || $this->data['id_role'] != 1)
        // {
        //     $this->session->unset_userdata('username');
        //     $this->session->unset_userdata('id_role');
        //     $this->flashmsg('Anda harus login dulu','warning');
        //     redirect('login');
        //     exit;
        // }

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
}
