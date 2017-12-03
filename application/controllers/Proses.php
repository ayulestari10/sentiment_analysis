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
     *  @author Dazzle
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
     *  Method ini digunakan untuk melakukan praproses file.
     *  @author Dazzle
     *  @return array dua dimensi
    */
    public function praproses_file($data){
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

    /**
     *  Method ini digunakan untuk melakukan praproses file.
     *  @author Dazzle
     *  @return array dua dimensi
    */
    public function praproses_pendapat($data){
        
        $data = $this->preprocessing->casefolding($data);
        $data = $this->preprocessing->stem($data);
        $data = $this->preprocessing->tokenizing2($data, ' ');
        $data = $this->preprocessing->stopwords_removal2($data);

        return $data;
    }

    /**
     *  Method ini digunakan untuk melakukan pelatihan.
     *  @author Dazzle
     *  @return void
    */
    public function training(){
        // Membaca data latih
        $pendapat_positif = $this->preprocessing->read_file_by_line('positif');
        $pendapat_negatif = $this->preprocessing->read_file_by_line('negatif');


        // cari prior probability
        $total_dokumen = count($pendapat_positif) + count($pendapat_negatif);
        $total_dokumen_positif = count($pendapat_positif);
        $total_dokumen_negatif = count($pendapat_negatif);

        $prior_probability['+'] = (float)$total_dokumen_positif / (float)$total_dokumen;
        $prior_probability['-'] = (float)$total_dokumen_negatif / (float)$total_dokumen;

        // lakukan praproses data
        $praproses_pendapat_positif = $this->praproses_file($pendapat_positif);
        $praproses_pendapat_negatif = $this->praproses_file($pendapat_negatif);

        $frekuensi_kata = []; // untuk semua kategori
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

        //$this->dump($posterior_probability);
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

        $this->flashmsg('Pelatihan telah selesai dilakukan!','success');
        redirect('Proses');

        // $this->dump($frekuensi_kata);
        // $this->dump($frekuensi_kata_positif);
        // $this->dump($frekuensi_kata_negatif);
    }

    /**
     *  Method ini digunakan untuk melakukan pengujian.
     *  @author Dazzle
     *  @return void
    */
    public function testing()
    {
        if($this->POST('submit-input')){
            $pendapat_awal = $this->POST('pendapat');

            $pendapat_positif = $this->preprocessing->read_file_by_line('positif');
            $pendapat_negatif = $this->preprocessing->read_file_by_line('negatif');

            // cari prior probability
            $total_dokumen = count($pendapat_positif) + count($pendapat_negatif);
            $total_dokumen_positif = count($pendapat_positif);
            $total_dokumen_negatif = count($pendapat_negatif);

            $prior_probability['+'] = (float)$total_dokumen_positif / (float)$total_dokumen;
            $prior_probability['-'] = (float)$total_dokumen_negatif / (float)$total_dokumen;

            // ===============================

            $this->load->model('data_m');
            $pendapat = $this->POST('pendapat');

            $pendapat = $this->praproses_pendapat($pendapat);
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
                $hasil = "Positif";
            }
            elseif($pos_probability < $neg_probability)
            {
                $hasil = "Negatif";
            }
            else
            {
                $hasil = "Netral";
            }

        }

        $this->data['title']    = 'Input Pendapat';
        $this->data['content']  = 'input_pendapat';
        $this->data['pendapat'] = $pendapat_awal;
        $this->data['hasil']    = $hasil;
        $this->data['nilai_positif']    = $pos_probability;
        $this->data['nilai_negatif']    = $neg_probability;
        $this->template($this->data, 'input');
    }

}
