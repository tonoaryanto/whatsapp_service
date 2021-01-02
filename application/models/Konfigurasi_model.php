<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Konfigurasi_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model('grafik_model');
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

    function listdata(){
        return $this->grafik_model->list_data('allCAPITAL');
    }
    // function optimizeafterupload()
    // {
    //     if($this->session->userdata('optimizedata') == '1'){
    //         $this->db->select('kode_data AS id,nama_data AS text');
    //         $this->db->from('kode_data');
    //         $this->db->where(['aktif'=>'y']);
    //         $this->db->where("kategori_waktu IN ('2','3')");
    //         $this->db->order_by('urutan','ASC');
    //         $data1 = $this->db->get()->result();

    //         $dataini1 = [array('id'   => '','text' => '',)];
    //         $datsqlz = "DELETE FROM image2 WHERE kategori = 'DAY_1' OR nama_data NOT IN ('ansell'";
    //         //$datsqlz = "DELETE FROM image2 WHERE nama_data NOT IN ('ansell'";
    //         foreach ($data1 as $data1) {
    //             $datsqlz .= ",'".$data1->id."'";
    //         }
    //         $datsqlz .= ")";

    //         $this->db->query($datsqlz);
    //         $this->session->unset_userdata('optimizedata');
    //         // echo '<b>Optimize</b>';
    //     }
    //     // else{
    //     //     $inidata =  $this->db->query("SELECT id from image2")->result();
    //     //     $nomor = 0;
    //     //     foreach ($inidata as $value) {
    //     //         $nomor = $nomor + 1;
    //     //         $setesql = "UPDATE image2 SET id='".$nomor."' WHERE id = '".$value->id."'";
    //     //         $this->db->query($setesql);
    //     //     }
    //     //     $this->db->query("ALTER TABLE `image2` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=".$nomor);
    //     // }
    // }
}
