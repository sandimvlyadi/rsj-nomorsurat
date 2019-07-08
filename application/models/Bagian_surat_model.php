<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bagian_surat_model extends CI_Model {

	function _get($data = array())
    {
    	$q = "SELECT a.*, b.`nama` AS `nama_jenis_surat` FROM `bagian_surat` a LEFT JOIN `jenis_surat` b ON a.`id_jenis_surat` = b.`id` ";

        if ($data['search']['value'] && !isset($data['all'])) {
        	$s = $this->db->escape_str($data['search']['value']);
            $q .= "WHERE (b.`nama` LIKE '%". $s ."%' OR a.`kode` LIKE '%". $s ."%' OR a.`nama` LIKE '%". $s ."%' OR a.`keterangan` LIKE '%". $s ."%') AND a.`deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE a.`deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = $this->db->escape_str($data['order'][0]['dir']);
        	$col = $this->db->escape_str($data['columns'][$data['order'][0]['column']]['data']);
        	if ($data['order'][0]['column'] != 0) {
                if ($col == 'nama_jenis_surat') {
                    $q .= "ORDER BY b.`nama` ". $dir ." ";
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
            'msg'       => 'Data bagian surat tidak ditemukan.'
        );

        $q =    "SELECT
                    a.*,
                    b.`nama` AS `nama_jenis_surat`
                FROM
                    `bagian_surat` a
                LEFT JOIN
                    `jenis_surat` b
                        ON
                    a.`id_jenis_surat` = b.`id`
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
                        `bagian_surat`
                        (
                            `created_at`,
                            `kode`,
                            `nama`,
                            `keterangan`,
                            `id_jenis_surat`
                        )
                    VALUES
                        (
                            NOW(),
                            '". $this->db->escape_str($f['kode']) ."',
                            '". $this->db->escape_str($f['nama']) ."',
                            '". $this->db->escape_str($f['keterangan']) ."',
                            '". $this->db->escape_str($f['id_jenis_surat']) ."'
                        )
                    ;";
		} else{
            $q =    "UPDATE
                        `bagian_surat`
                    SET
                        `modified_at` = NOW(),
                        `kode` = '". $this->db->escape_str($f['kode']) ."',
                        `nama` = '". $this->db->escape_str($f['nama']) ."',
                        `keterangan` = '". $this->db->escape_str($f['keterangan']) ."',
                        `id_jenis_surat` = '". $this->db->escape_str($f['id_jenis_surat']) ."'
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
		$q = "UPDATE `bagian_surat` SET `deleted_at` = NOW() WHERE `id` = '". $this->db->escape_str($id) ."';";
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
            $q = "SELECT * FROM `bagian_surat` WHERE `deleted_at` IS NULL;";
        } else{
            $q = "SELECT * FROM `bagian_surat` WHERE `id` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
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

    function select_by_id_jenis_surat($id = 0)
    {
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $q = "";
        if ($id == 0) {
            $q = "SELECT * FROM `bagian_surat` WHERE `deleted_at` IS NULL;";
        } else{
            $q = "SELECT * FROM `bagian_surat` WHERE `id_jenis_surat` = '". $this->db->escape_str($id) ."' AND `deleted_at` IS NULL;";
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

}