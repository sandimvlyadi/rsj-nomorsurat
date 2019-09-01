<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

    function setting_nomor_mundur()
    {
        $result = 5;

        $q = "SELECT * FROM `setting` WHERE `nama` = 'nomor_mundur';";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result = intval($r[0]['nilai']);
        }

        return $result;
    }

    function setting_nomor_sppd()
    {
        $result = 1;

        $q = "SELECT * FROM `setting` WHERE `nama` = 'nomor_sppd';";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result = intval($r[0]['nilai']) + 1;
        }

        $q = "UPDATE `setting` SET `nilai` = '". $result ."' WHERE `nama` = 'nomor_sppd';";
        $this->db->simple_query($q);

        return $result;
    }

    function get_nomor($data = array())
    {
        $result = array(
            'result'    => true,
            'msg'       => '',
            'nomor'     => ''
        );

        $u = $data['userData'];
        $d = $data['postData'];
        $id_jenis_surat = $data['id_jenis_surat'];
        $id_bagian_surat = $d['id_bagian_surat'];
        $id_ujung_surat = $d['id_ujung_surat'];
        $bulan = substr($d['tanggal'], 0, 7);
        $tanggal = substr($d['tanggal'], 8, 2);
        $button_id = $d['button_id'];
        $nMundur = $this->setting_nomor_mundur();

        $q = "SELECT * FROM `nomor_surat` WHERE `id_jenis_surat` = '". $id_jenis_surat ."' AND `tanggal` LIKE '". $bulan ."%';";
        $r = $this->db->query($q, false)->result_array();
        $n = count($r);
        $nomor = '';
        if ($n > 0) {
            $nomor = str_pad($n+1+(intval($tanggal)*$nMundur-5), 3, '0', STR_PAD_LEFT);
            if (intval($tanggal) < intval(date('d'))) {
                $q = "SELECT * FROM `nomor_surat` WHERE `id_jenis_surat` = '". $id_jenis_surat ."' AND `tanggal` = '". $this->db->escape_str($d['tanggal']) ."' ORDER BY `id` DESC;";
                $r = $this->db->query($q, false)->result_array();
                if (count($r) > 0) {
                    $nomor = str_pad(intval(substr($r[0]['nomor'], 4, 3))+1, 3, '0', STR_PAD_LEFT);
                } else{
                    $nomor = '001';
                }
            }

            if ($button_id != 0) {
                $q = "SELECT * FROM `nomor_surat` WHERE `id` = '". $button_id ."' AND `deleted_at` IS NULL;";
                $r = $this->db->query($q, false)->result_array();
                if (count($r) > 0) {
                    $nomor = substr($r[0]['nomor'], 4, 3);
                }
            }
        } else{
            $nomor = '001';
        }

        $q = "SELECT * FROM `bagian_surat` WHERE `id` = '". $id_bagian_surat ."' AND `deleted_at` IS NULL;";
        $bagian = $this->db->query($q, false)->result_array();
        if(count($bagian) > 0){
            $result['nomor'] = $bagian[0]['kode'] . '/' . $nomor . '/';
        }
        
        $q = "SELECT * FROM `ujung_surat` WHERE `id` = '". $id_ujung_surat ."' AND `deleted_at` IS NULL;";
        $ujung = $this->db->query($q, false)->result_array();
        if(count($ujung) > 0){
            $result['nomor'] .= $ujung[0]['nama'];
        }

        return $result;
    }

}