<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nomor_nota_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama` AS `nama_jenis_surat`, c.`nama` AS `nama_bagian_surat`, d.`display_name` FROM `nomor_surat` a LEFT JOIN `jenis_surat` b ON a.`id_jenis_surat` = b.`id` LEFT JOIN `bagian_surat` c ON a.`id_bagian_surat` = c.`id` LEFT JOIN `pengguna` d ON a.`id_pengguna` = d.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (b.`nama_jenis_surat` LIKE '%". $s ."%' OR c.`nama_bagian_surat` LIKE '%". $s ."%' OR d.`display_name` LIKE '%". $s ."%' OR a.`nomor` LIKE '%". $s ."%' OR a.`tujuan` LIKE '%". $s ."%' OR a.`perihal` LIKE '%". $s ."%' OR a.`tanggal` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL AND a.`id_jenis_surat` = 3 ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL AND a.`id_jenis_surat` = 3 ";
        }

        if (strlen($data['filter_dari']) > 0) {
            $q .= "AND a.`tanggal` >= '". $data['filter_dari'] ."' ";
        }

        if (strlen($data['filter_sampai']) > 0) {
            $q .= "AND a.`tanggal` <= '". $data['filter_sampai'] ."' ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_jenis_surat') {
                    $q .= "ORDER BY b.`nama` ". $dir ." ";
                } elseif ($col == 'nama_bagian_surat') {
                    $q .= "ORDER BY c.`nama` ". $dir ." ";
                } elseif ($col == 'display_name') {
                    $q .= "ORDER BY d.`". $col ."` ". $dir ." ";
                } else{
                    $q .= "ORDER BY a.`". $col ."` ". $dir ." ";
                }
        	} else{
        		$q .= "ORDER BY a.`id` ". $dir ." ";
        	}
        } else{
        	$q .= "ORDER BY a.`id` DESC ";
        }

        return $q;
    }

    function _list($data = array())
    {
        $q = $this->_get($data);
        $q .= "LIMIT ". $this->db->escape_str($data['start']) .", ". $this->db->escape_str($data['length']);
        $r = $this->db->query($q, false)->result_array();

        return $r;
    }

    function _filtered($data = array())
    {
        $q = $this->_get($data);
        $r = $this->db->query($q, false)->result_array();

        return count($r);
    }

    function _all($data = array())
    {
        $data['all'] = true;
        $q = $this->_get($data);
        $r = $this->db->query($q)->result_array();

        return count($r);
    }

	function datatable($data = array())
	{
		$result = array(
            'draw'              => 1,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'data'              => array(),
            'result'            => false,
            'msg'               => ''
        );

        $list = $this->_list($data);
        if (count($list) > 0) {
            $result = array(
                'draw'              => $data['draw'],
                'recordsTotal'      => $this->_all($data),
                'recordsFiltered'   => $this->_filtered($data),
                'data'              => $list,
                'result'            => true,
                'msg'               => 'Loaded.',
                'start'             => (int) $data['start'] + 1
            );
        } else{
            $result['msg'] = 'No data left.';
        }

        return $result;
	}

    function edit($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => 'Data nomor surat tidak ditemukan.'
        );

        $q =    "SELECT
                    a.*,
                    b.`nama` AS `nama_jenis_surat`,
                    c.`nama` AS `nama_bagian_surat`,
                    d.`display_name`
                FROM
                    `nomor_surat` a
                LEFT JOIN
                    `jenis_surat` b
                        ON
                    a.`id_jenis_surat` = b.`id`
                LEFT JOIN
                    `bagian_surat` c
                        ON
                    a.`id_bagian_surat` = c.`id`
                LEFT JOIN
                    `pengguna` d
                        ON
                    a.`id_pengguna` = d.`id`
                WHERE
                    a.`id` = '". $this->db->escape_str($id) ."'
                ;";
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r[0];
        }

        return $result;
    }

	function save($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''
		);

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
		parse_str($d['form'], $f);

		$q = '';
		if ($id == 0) {
			$q =    "INSERT INTO
                        `nomor_surat`
                        (
                            `created_at`,
                            `id_jenis_surat`,
                            `id_bagian_surat`,
                            `id_ujung_surat`,
                            `nomor`,
                            `tujuan`,
                            `perihal`,
                            `tanggal`,
                            `keterangan`,
                            `id_pengguna`
                        )
                    VALUES
                        (
                            NOW(),
                            '3',
                            '". $this->db->escape_str($f['id_bagian_surat']) ."',
                            '". $this->db->escape_str($f['id_ujung_surat']) ."',
                            '". $this->db->escape_str($f['nomor']) ."',
                            '". $this->db->escape_str($f['tujuan']) ."',
                            '". $this->db->escape_str($f['perihal']) ."',
                            '". $this->db->escape_str($f['tanggal']) ."',
                            '". $this->db->escape_str($f['keterangan']) ."',
                            '". $this->db->escape_str($f['id_pengguna']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE
                        `nomor_surat`
                    SET
                        `modified_at` = NOW(),
                        `id_bagian_surat` = '". $this->db->escape_str($f['id_bagian_surat']) ."',
                        `id_ujung_surat` = '". $this->db->escape_str($f['id_ujung_surat']) ."',
                        `nomor` = '". $this->db->escape_str($f['nomor']) ."',
                        `tujuan` = '". $this->db->escape_str($f['tujuan']) ."',
                        `perihal` = '". $this->db->escape_str($f['perihal']) ."',
                        `tanggal` = '". $this->db->escape_str($f['tanggal']) ."',
                        `keterangan` = '". $this->db->escape_str($f['keterangan']) ."',
                        `id_pengguna` = '". $this->db->escape_str($f['id_pengguna']) ."'
                    WHERE
                        `id` = '". $this->db->escape_str($id) ."'
                    ;";
		}

		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil disimpan.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menyimpan data.';
		}

		return $result;
	}

	function delete($data = array())
	{
		$result = array(
			'result'    => false,
			'msg'		=> ''
		);

		$u = $data['userData'];
		$d = $data['postData'];
		$id = $d['id'];
		$q = "UPDATE `nomor_surat` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
		if ($this->db->simple_query($q)) {
			$result['result'] = true;
			$result['msg'] = 'Data berhasil dihapus.';
		} else{
			$result['msg'] = 'Terjadi kesalahan saat menghapus data.';
		}

		return $result;
	}

    function select($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `nomor_surat` WHERE `deleted_at` IS NULL;";
        } else{
            $q = "SELECT * FROM `nomor_surat` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
        }
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;

            if (count($r) == 1 && $id != 0) {
                $result['data'] = $r[0];
            }
        }

        return $result;
    }

    function upload($data = array())
    {
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $u = $data['userData'];
        $d = $data['postData'];
        $id = $d['id'];

        $config['upload_path']      = './uploads/files/';
        $config['allowed_types']    = '*';
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

            $q =    "UPDATE 
                        `nomor_surat` 
                    SET 
                        `file_upload` = '". $result['data']['file_name'] ."' 
                    WHERE 
                        `id` = '". $this->db->escape_str($id) ."'
                    ;";
            if (!$this->db->simple_query($q)) {
                $result['result'] = false;
                $result['msg']    = 'File gagal disimpan.';
            }
        }

        return $result;
    }

    function select_bagian()
    {
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $q = "SELECT * FROM `bagian_surat` WHERE `id_jenis_surat` = 0 AND `deleted_at` IS NULL;";
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        }

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
        $id_bagian_surat = $d['id_bagian_surat'];
        $id_ujung_surat = $d['id_ujung_surat'];
        $tanggal = substr($d['tanggal'], 0, 7);
        $button_id = $d['button_id'];

        $q = "SELECT * FROM `nomor_surat` WHERE `id_jenis_surat` = 3 AND `tanggal` LIKE '". $tanggal ."%';";
        $r = $this->db->query($q, false)->result_array();
        $n = count($r);
        $nomor = '';
        if ($n > 0) {
            $nomor = str_pad($n+1, 3, '0', STR_PAD_LEFT);

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