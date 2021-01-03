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
        $tahun = substr($d['tanggal'], 0, 4);
        $bulan = substr($d['tanggal'], 5, 2);
        $tanggal = substr($d['tanggal'], 8, 2);
        $button_id = $d['button_id'];
        $nMundur = $this->setting_nomor_mundur();

        $q = "SELECT * FROM `nomor_surat` WHERE `id_jenis_surat` = '". $id_jenis_surat ."' AND `tanggal` LIKE '". $tahun ."%';";
        $r = $this->db->query($q, false)->result_array();
        $n = count($r);
        $nomor = '';
        if ($n > 0) {
            $nomor = str_pad($n+1, 4, '0', STR_PAD_LEFT);
            if ( strtotime($d['tanggal']) < strtotime(date('Y-m-d')) ) {
                $mundur = ["A","A1","A2","A3","A4","A5","A6","A7","A8","A9","B","B1","B2","B3","B4","B5","B6","B7","B8","B9","C","C1","C2","C3","C4","C5","C6","C7","C8","C9","D","D1","D2","D3","D4","D5","D6","D7","D8","D9","E","E1","E2","E3","E4","E5","E6","E7","E8","E9","F","F1","F2","F3","F4","F5","F6","F7","F8","F9","G","G1","G2","G3","G4","G5","G6","G7","G8","G9","H","H1","H2","H3","H4","H5","H6","H7","H8","H9","I","I1","I2","I3","I4","I5","I6","I7","I8","I9","J","J1","J2","J3","J4","J5","J6","J7","J8","J9","K","K1","K2","K3","K4","K5","K6","K7","K8","K9","L","L1","L2","L3","L4","L5","L6","L7","L8","L9","M","M1","M2","M3","M4","M5","M6","M7","M8","M9","N","N1","N2","N3","N4","N5","N6","N7","N8","N9","O","O1","O2","O3","O4","O5","O6","O7","O8","O9","P","P1","P2","P3","P4","P5","P6","P7","P8","P9","Q","Q1","Q2","Q3","Q4","Q5","Q6","Q7","Q8","Q9","R","R1","R2","R3","R4","R5","R6","R7","R8","R9","S","S1","S2","S3","S4","S5","S6","S7","S8","S9","T","T1","T2","T3","T4","T5","T6","T7","T8","T9","U","U1","U2","U3","U4","U5","U6","U7","U8","U9","V","V1","V2","V3","V4","V5","V6","V7","V8","V9","W","W1","W2","W3","W4","W5","W6","W7","W8","W9","X","X1","X2","X3","X4","X5","X6","X7","X8","X9","Y","Y1","Y2","Y3","Y4","Y5","Y6","Y7","Y8","Y9","Z","Z1","Z2","Z3","Z4","Z5","Z6","Z7","Z8","Z9"];
                $q = "SELECT * FROM `nomor_surat` WHERE `id_jenis_surat` = '". $id_jenis_surat ."' AND `tanggal` LIKE '". $tahun ."%' AND `nomor` LIKE '%.%';";
                $r = $this->db->query($q, false)->result_array();
                $n = count($r);
                $nomor .= '.'.$mundur[$n];
            }
        } else{
            $nomor = '0001';
            if ( strtotime($d['tanggal']) < strtotime(date('Y-m-d')) ) {
                $nomor .= '.A';
            }
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

        if ($button_id != 0) {
            $q = "SELECT * FROM `nomor_surat` WHERE `id` = '". $button_id ."' AND `deleted_at` IS NULL;";
            $r = $this->db->query($q, false)->result_array();
            if (count($r) > 0) {
                $result['nomor'] = $r[0]['nomor'];
            }
        }

        if ($id_jenis_surat == 1) {
            $result['nomor'] = $bagian[0]['kode'] . '/KEP.' . $nomor . '-' .$ujung[0]['nama'] . '/' . date('Y');
        }

        return $result;
    }

}