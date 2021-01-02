<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Konfigurasi_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


    // get data by id
    function set($nama){
        $this->db->where('nama_setting', $nama);
        $isi = $this->db->get('setting_app')->row_array();
        return $isi['value_setting'];
    }

    function cek_url(){
        if ($this->session->userdata('id_user') == '') {
            redirect(base_url('login/keluar'));
        }
    }

    function cek_js(){
        if ($this->session->userdata('id_user') == '') {
            return 0;
        }else{
            return 1;
        }
    }

    function no_direct(){
        if ($this->session->userdata('id_user') == '') {
            redirect('error_408');
        }
    }

    function cek_akses($data){
       if ($data == 'admin') {
           if ($this->session->userdata('status_user') != '2') {
               redirect(base_url('login/keluar'));
            }
        }else{
            if ($this->session->userdata('status_user') != '1') {
                redirect(base_url('login/keluar'));
             } 
        }
    }

}
