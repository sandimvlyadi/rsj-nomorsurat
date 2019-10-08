<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nomor_sp_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama` AS `nama_jenis_surat`, c.`nama` AS `nama_bagian_surat`, d.`display_name` FROM `nomor_surat` a LEFT JOIN `jenis_surat` b ON a.`id_jenis_surat` = b.`id` LEFT JOIN `bagian_surat` c ON a.`id_bagian_surat` = c.`id` LEFT JOIN `pengguna` d ON a.`id_pengguna` = d.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (b.`nama_jenis_surat` LIKE '%". $s ."%' OR c.`nama_bagian_surat` LIKE '%". $s ."%' OR d.`display_name` LIKE '%". $s ."%' OR a.`nomor` LIKE '%". $s ."%' OR a.`tujuan` LIKE '%". $s ."%' OR a.`perihal` LIKE '%". $s ."%' OR a.`tanggal` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL AND a.`id_jenis_surat` = 2 ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL AND a.`id_jenis_surat` = 2 ";
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
                    d.`display_name`,
                    e.`tempat`,
                    e.`tanggal_sppd`,
                    e.`nama_petugas`
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
                LEFT JOIN
                    `surat_perintah_detail` e
                        ON
                    a.`id` = e.`id_nomor_surat`
                WHERE
                    a.`id` = '". $this->db->escape_str($id) ."'
                ;";
        $r = $this->db->query($q)->result_array();
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
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
                            `tanggal`,
                            `keterangan`,
                            `id_pengguna`
                        )
                    VALUES
                        (
                            NOW(),
                            '2',
                            '". $this->db->escape_str($f['id_bagian_surat']) ."',
                            '". $this->db->escape_str($f['id_ujung_surat']) ."',
                            '". $this->db->escape_str($f['nomor']) ."',
                            '". $this->db->escape_str($f['tujuan']) ."',
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
            
            if ($id == 0) {
                $id = $this->db->insert_id();
            }

            $q = "SELECT * FROM `surat_perintah_detail` WHERE `id_nomor_surat` = '". $id ."';";
            $r = $this->db->query($q, false)->result_array();
            for ($i=0; $i < count($r); $i++) { 
                $hapus = true;
                foreach ($f['nama_petugas'] as $key => $value) {
                    if ($value == $r[$i]['nama_petugas']) {
                        $hapus = false;
                        break;
                    }
                }

                if ($hapus) {
                    $q = "DELETE FROM `surat_perintah_detail` WHERE `id_nomor_surat` = '". $id ."' AND `nama_petugas` = '". $this->db->escape_str($r[$i]['nama_petugas']) ."';";
                    $this->db->simple_query($q);
                }
            }

            foreach ($f['nama_petugas'] as $key => $value) {
                $q = "SELECT * FROM `surat_perintah_detail` WHERE `id_nomor_surat` = '". $id ."' AND `nama_petugas` = '". $this->db->escape_str($value) ."';";
                $r = $this->db->query($q, false)->result_array();
                if (count($r) > 0) {
                    $q =    "UPDATE 
                                `surat_perintah_detail` 
                            SET 
                                `tempat` = '". $f['tempat'] ."',
                                `tanggal_sppd` = '". $f['tanggal_sppd'] ."' 
                            WHERE 
                                `id` = '". $r[0]['id'] ."'
                            ;";
                    $this->db->simple_query($q);
                } else{
                    $q =    "INSERT INTO 
                                `surat_perintah_detail` 
                                (
                                    `id_nomor_surat`,
                                    `tempat`,
                                    `tanggal_sppd`,
                                    `nama_petugas`
                                )
                            VALUES
                                (
                                    '". $id ."',
                                    '". $this->db->escape_str($f['tempat']) ."',
                                    '". $this->db->escape_str($f['tanggal_sppd']) ."',
                                    '". $this->db->escape_str($value) ."'
                                )
                            ;";
                    $this->db->simple_query($q); 
                }
            }
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

}