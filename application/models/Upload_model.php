<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model {

	function display_picture($data = array())
    {
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $config['upload_path']      = './uploads/img/';
        $config['allowed_types']    = 'jpg|jpeg|png|gif';
        $config['max_size']         = 2048;
        $config['encrypt_name']     = TRUE;
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('file')){
            $result['result'] = false;
            $result['msg']    = $this->upload->display_errors();
        } else{
            $result['result'] = true;
            $result['data']   = $this->upload->data();
            $result['msg']    = 'File berhasil diunggah.';

            $session = $data['userData']['session'];
            $q =    "UPDATE 
                        `pengguna` 
                    SET 
                        `display_picture` = '". $result['data']['file_name'] ."' 
                    WHERE 
                        `id` = '". $this->db->escape_str($session['id']) ."'
                    ;";
            if (!$this->db->simple_query($q)) {
                $result['result']   = false;
                $result['msg']      = 'Terjadi kesalahan saat menyimpan data.';
            }
        }

        return $result;
    }

    function import_bagian($data = array())
    {
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $u = $data['userData'];
        $d = $data['postData'];
        $id = $d['id'];

        $config['upload_path']      = './uploads/csv/';
        $config['allowed_types']    = 'csv';
        $config['max_size']         = 2048;
        $config['encrypt_name']     = TRUE;
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('file')){
            $result['result'] = false;
            $result['msg']    = $this->upload->display_errors();
        } else{
            $result['result'] = true;
            $result['data']   = $this->upload->data();
            $result['msg']    = 'File berhasil diunggah.';

            $file = base_url('uploads/csv/'. $result['data']['file_name']);
            $i = 0;
            $handle = fopen($file, "r");
            while (($row = fgetcsv($handle, 2048))) {
                $i++;
                if ($i == 1) continue;
                    $kode = $row[1];
                    $nama = $row[2];

                    $q = "INSERT INTO `bagian_surat` (`kode`, `nama`, `id_jenis_surat`) VALUES ('". $kode ."', '". $nama ."', '". $this->db->escape_str($id) ."');";
                    if (!$this->db->simple_query($q)) {
                        $result['result']   = false;
                        $result['msg']      = 'Terjadi kesalahan saat menyimpan data.';
                    }
            }

            fclose($handle);
        }

        return $result;
    }

}