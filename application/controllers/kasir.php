<?php

    class Kasir extends CI_Controller {
        public function __construct(){
            parent::__construct();

            if(!$this->session->userdata('logged_in')){
                redirect('login/index');
            }
        }
    
        public function index(){
            $data['produks'] = $this->m_produk->get_all_produk();
            $this->load->view('kasir/index', $data);
        }

        function get_penjualan(){
            $id_penjualan = $this->input->post('id_penjualan');
            $data = $this->m_penjualan->get_penjualan_by_id($id_penjualan);
            echo json_encode($data);
        }

        function get_produk(){
            $id_produk = $this->input->post('id_produk');
            $data = $this->m_produk->get_produk_by_id($id_produk);
            echo json_encode($data);
        }

        public function create_penjualan(){
            // $this->form_validation->set_rules('pj_bayar','Uang Pembayaran','trim|required');
            
            // if($this->form_validation->run() == FALSE){
            //     $data['produks'] = $this->m_produk->get_all_produk();
            //     $this->load->view('kasir/index',$data);
            // } else {
                // Insert Penjualan
                $id_penjualan = $this->m_penjualan->kode_penjualan();              
                $data = array(
                    'id_penjualan' => $id_penjualan,
                    'id_pegawai' => $this->session->userdata('id_pegawai'), //indikasi error
                    'pj_total' => $this->input->post('pj_total'),
                    'pj_bayar' => $this->input->post('pj_bayar'),
                    'pj_kembalian' => $this->input->post('pj_total') - $this->input->post('pj_bayar'),
                    'pj_tgl' => date('Y-m-d')
                );
      
                if($this->m_penjualan->create_penjualan($data)){
                    redirect("kasir/index");
                }
        }


    }

?>