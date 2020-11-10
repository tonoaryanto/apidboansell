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

    function cek_kode($kode,$value,$kategori=null){
        $cek = 0;
        if($value == 8888){$value == '';}
        switch ($kode) {
            case "4096":
                $kode = "req_temp";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "7218":
                $kode = "avg_temp";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "7197":
                $kode = "temp_1";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "7198":
                $kode = "temp_2";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "7199":
                $kode = "temp_3";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "7200":
                $kode = "temp_4";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "7203":
                $kode = "temp_out";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "3142":
                $kode = "humidity";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "3190":
                $kode = "fan";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "800":
                $kode = "growday";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "3259":
                $kode = "static_pressure";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "64760":
                $kode = "req_windspeed";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "64763":
                $kode = "windspeed";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "35967":
                $kode = "silo1";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "35969":
                $kode = "silo2";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "3154":
                $kode = "alarm1";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "3170":
                $kode = "alarm2";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "3708":
                $kode = "alarm3";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "1302":
                $kode = "water";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "1301":
                $kode = "feed";
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "62001":
                $kode = "max_windspeed";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
            case "62002":
                $kode = "min_windspeed";
                $value = $value / 10;
                if($kategori != null){
                    if($kategori == 'HOUR_1'){
                        $cek = 1;
                    }
                }else{
                    $cek = 1;
                }
                break;
        }
        return [
            '0' => $kode,
            '1' => $value,
            '2' => $cek
            ];
    }

    public function delete_multi($tabel,$record,$array){
        $this->db->where_in($record, $array);
        $this->db->delete($tabel);
    }    
}