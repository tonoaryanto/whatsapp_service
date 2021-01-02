<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Umum_model extends CI_Model {

    function get($tabel,$where=null){
        if ($where != null) {
            $this->db->where($where);
        }
        return $this->db->get($tabel);
    }

    function insert($tabel,$data){
        $this->db->insert($tabel, $data);
    }

    function update($tabel,$data,$where){
        $this->db->where($where);
        $this->db->update($tabel, $data);
    }

    function delete($tabel,$where){
        $this->db->where($where);
        $this->db->delete($tabel);
    }

    function kode_acak(){
        $karakter = '0123456789ABCDEF'; 
        $string = '';
        for($i = 0; $i < 8; $i++) {   
        $pos = rand(0, strlen($karakter)-1);   
        $string .= $karakter{$pos};   
        }
        $kodejadi = $string;
        return $kodejadi;
    }

    function acak(){
        $karakter = '01234789'; 
        $string = '';
        for($i = 0; $i < 1; $i++) {   
        $pos = rand(0, strlen($karakter)-1);   
        $string .= $karakter{$pos};   
        }
        $kodejadi = $string;
        return $kodejadi;
    }

    function kode_warna(){
        $karakter = '0123456789ABCDEF'; 
        $string = '';
        for($i = 0; $i < 6; $i++) {   
        $pos = rand(0, strlen($karakter)-1);   
        $string .= $karakter{$pos};   
        }
        $kodejadi = "#".$string;
        return $kodejadi;
    }
}