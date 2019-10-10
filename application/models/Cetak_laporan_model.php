<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak_laporan_model extends CI_Model {

    function cetak($data = array())
    {
        $result = array(
			'result'    => false,
			'msg'		=> ''
		);

		$u = $data['userData'];
		$d = $data['postData'];
        $id_jenis_surat = $d['id_jenis_surat'];
        $tanggal_dari = $d['tanggal_dari'];
        $tanggal_sampai = $d['tanggal_sampai'];

        $q = "SELECT * FROM `nomor_surat` WHERE `id_jenis_surat` = '". $this->db->escape_str($id_jenis_surat) ."' AND `tanggal` >= '". $this->db->escape_str($tanggal_dari) ."' AND `tanggal` <= '". $this->db->escape_str($tanggal_sampai) ."' AND `deleted_at` IS NULL;";
        $r = $this->db->query($q, false)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['target'] = base_url('cetak-laporan/printt?id_jenis_surat='. $id_jenis_surat .'&tanggal_dari='. $tanggal_dari .'&tanggal_sampai='.$tanggal_sampai);
        } else{
            $result['msg'] = 'Tidak ada laporan tersedia untuk dicetak.';
        }

        return $result;
    }

    function printt($data = array())
    {
        $result = array(
			'result'    => true,
			'msg'		=> ''
		);

		$u = $data['userData'];
		$d = $data['postData'];
        $id_jenis_surat = $d['id_jenis_surat'];
        $tanggal_dari = $d['tanggal_dari'];
        $tanggal_sampai = $d['tanggal_sampai'];

        $this->db->where('id_jenis_surat', $id_jenis_surat);
        $this->db->where('tanggal >=', $tanggal_dari);
        $this->db->where('tanggal <=', $tanggal_sampai);
        $this->db->where('deleted_at IS NULL', NULL, FALSE);
        $get = $this->db->get('nomor_surat');

        if ($get->num_rows() > 0) {
            $result['result'] = true;
            $get = $get->result();
            foreach ($get as $key => $value) {
                $this->db->where('id_nomor_surat', $value->id);
                $detail = $this->db->get('surat_perintah_detail')->result();
                $get[$key]->detail = $detail;
            }
            $result['data'] = $get;
        }

        return $result;
    }

}