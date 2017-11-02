<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Admin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->data['id_role'] = $this->session->userdata('id_role');
        if (!isset($this->data['id_role']) || $this->data['id_role'] != 1)
        {
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('id_role');
            $this->flashmsg('Anda harus login dulu','warning');
            redirect('login');
            exit;
        }

        $this->load->model('Pemohon_m');
    }

    public function index()
    {
        $this->load->model('senjata_api_m');
        $this->load->model('amunisi_m');
        $this->load->model('berita_acara_m');
        $this->data['title']        = 'Dashboard Admin';
        $this->data['pemohon']      = $this->Pemohon_m->get();
        $this->data['amunisi']      = $this->amunisi_m->get();
        $this->data['berita_acara'] = $this->berita_acara_m->get();
        $this->data['senpi']        = $this->senjata_api_m->get();
        $this->data['content']      = 'admin/dashboard';
        $this->template($this->data);
    }

    public function pemohon()
    {
        if($this->POST('change'))
        {
            $nrp = $this->POST('nrp');
            $cek_pemohon = $this->Pemohon_m->get_row(['nrp' => $nrp]);

            if ($cek_pemohon->status == '1')
            {
                $this->Pemohon_m->update($nrp, ['status' => '0']);
                echo '<button class="btn btn-danger" onclick="changeStatus('.$nrp.')"><i class="fa fa-close"></i> Tidak</button>';
                exit;
            }
            else
            {
                $this->Pemohon_m->update($nrp, ['status' => '1']);
                echo '<button class="btn btn-success" onclick="changeStatus('.$nrp.')"><i class="fa fa-check"></i> Iya</button>'; 
                exit;
            }
        }

        $this->load->model('senjata_api_m');

        if ($this->POST('add'))
        {
            $this->data['pemohon'] = [
                'nrp'           => $this->POST('nrp'),
                'nama_anggota'  => $this->POST('nama_anggota'),
                'pangkat'       => $this->POST('pangkat'),
                'jabatan'       => $this->POST('jabatan'),
                'kesatuan'      => $this->POST('kesatuan'),
                'kelengkapan'   => $this->POST('kelengkapan'),
                'no_senpi'      => $this->POST('no_senpi'),
                'jumlah_amunisi'=> $this->POST('jumlah_amunisi')
            ];
            $this->Pemohon_m->insert($this->data['pemohon']);
            $this->flashmsg('<i class="glyphicon glyphicon-success"></i> Data pemohon berhasil ditambah');
            redirect('admin/pemohon');
            exit;
        }

        if ($this->POST('edit'))
        {
            $this->data['pemohon'] = [
                'nrp'           => $this->POST('nrp'),
                'nama_anggota'  => $this->POST('nama_anggota'),
                'pangkat'       => $this->POST('pangkat'),
                'jabatan'       => $this->POST('jabatan'),
                'kesatuan'      => $this->POST('kesatuan'),
                'kelengkapan'   => $this->POST('kelengkapan'),
                'no_senpi'      => $this->POST('no_senpi'),
                'jumlah_amunisi'=> $this->POST('jumlah_amunisi')
            ];
            $this->Pemohon_m->update($this->POST('old_nrp'), $this->data['pemohon']);
            $this->flashmsg('<i class="glyphicon glyphicon-success"></i> Data pemohon berhasil di-edit');
            redirect('admin/pemohon');
            exit;
        }

        if ($this->input->get('nrp'))
        {
            $this->data['pemohon'] = $this->Pemohon_m->get_row(['nrp' => $this->input->get('nrp')]);
            $no_senpi = [];
            $this->data['senpi']    = $this->senjata_api_m->get();
            foreach ($this->data['senpi'] as $senpi)
                $no_senpi[$senpi->no_senpi] = $senpi->no_senpi;
            $this->data['pemohon']->dropdown = form_dropdown('no_senpi', $no_senpi, $this->data['pemohon']->no_senpi, ['class' => 'form-control']);
            echo json_encode($this->data['pemohon']);
            exit;
        }

        if ($this->POST('delete')) 
        {
            $this->Pemohon_m->delete($this->POST('nrp'));
        }



        $this->data['senpi']    = $this->senjata_api_m->get();
        $this->data['title']    = 'Data Pemohon Senjata Api';
        $this->data['pemohon']  = $this->Pemohon_m->get();
        $this->data['content']  = 'admin/pemohon';
        $this->template($this->data);
    }

    public function senpi()
    {
        $this->load->model('senjata_api_m');
        $this->data['title']    = 'Senjata Api di Gudang';
        $this->data['senpi']    = $this->senjata_api_m->get();
        $this->data['content']  = 'admin/senpi';
        $this->template($this->data);
    }

    public function stok_amunisi()
    {
        $this->load->model('amunisi_m');
        $this->data['title']    = 'Stok Amunisi';
        $this->data['amunisi']  = $this->amunisi_m->get();
        $this->data['content']  = 'admin/amunisi';
        $this->template($this->data);
    }

    public function paur_log()
    {
        $this->load->model('berita_acara_m');
        $this->load->model('pemohon_m');
        $this->load->model('senjata_api_m');
        $this->load->model('amunisi_m');

        if ($this->POST('no_ba') && $this->POST('delete'))
        {
            $this->berita_acara_m->delete($this->POST('no_ba'));
        }

        if ($this->POST('add'))
        {
            $this->data['berita_acara'] = [
                'no_ba'     => $this->POST('no_ba'),
                'nrp'       => $this->POST('nrp'),
                'no_senpi'  => $this->POST('no_senpi'),
                'no_amunisi'=> $this->POST('no_amunisi')
            ];
            $this->berita_acara_m->insert($this->data['berita_acara']);
            $this->flashmsg('<i class="glyphicon glyphicon-success"></i> Data berita acara berhasil ditambah');
            redirect('admin/paur-log');
            exit;
        }

        if ($this->POST('edit') && $this->POST('old_no_ba'))
        {
            $this->data['berita_acara'] = [
                'no_ba'     => $this->POST('no_ba'),
                'nrp'       => $this->POST('nrp'),
                'no_senpi'  => $this->POST('no_senpi'),
                'no_amunisi'=> $this->POST('no_amunisi')
            ];
            $this->berita_acara_m->update($this->POST('old_no_ba'), $this->data['berita_acara']);
            $this->flashmsg('<i class="glyphicon glyphicon-success"></i> Data berita acara berhasil di-edit');
            redirect('admin/paur-log');
            exit;
        }

        if ($this->input->get('no_ba'))
        {
            $this->data['berita_acara'] = $this->berita_acara_m->get_row(['no_ba' => $this->input->get('no_ba')]);
            $no_senpi = [];
            $this->data['senpi']    = $this->senjata_api_m->get();
            foreach ($this->data['senpi'] as $senpi)
                $no_senpi[$senpi->no_senpi] = $senpi->no_senpi;
            $this->data['berita_acara']->dropdown_senpi = form_dropdown('no_senpi', $no_senpi, $this->data['berita_acara']->no_senpi, ['class' => 'form-control']);
            $nrp = [];
            $this->data['pemohon']    = $this->pemohon_m->get();
            foreach ($this->data['pemohon'] as $pemohon)
                $nrp[$pemohon->nrp] = $pemohon->nrp;
            $this->data['berita_acara']->dropdown_nrp = form_dropdown('nrp', $nrp, $this->data['berita_acara']->nrp, ['class' => 'form-control']);
            $no_amunisi = [];
            $this->data['amunisi']    = $this->amunisi_m->get();
            foreach ($this->data['amunisi'] as $amunisi)
                $no_amunisi[$amunisi->no_amunisi] = $amunisi->no_amunisi;
            $this->data['berita_acara']->dropdown_amunisi = form_dropdown('no_amunisi', $no_amunisi, $this->data['berita_acara']->no_amunisi, ['class' => 'form-control']);
            echo json_encode($this->data['berita_acara']);
            exit;
        }

        $this->data['pemohon']          = $this->pemohon_m->get();
        $this->data['senpi']            = $this->senjata_api_m->get();
        $this->data['amunisi']          = $this->amunisi_m->get();
        $this->data['title']            = 'Berita Acara';
        $this->data['berita_acara']     = $this->berita_acara_m->get();
        $this->data['content']          = 'admin/berita_acara';
        $this->template($this->data);
    }
}
