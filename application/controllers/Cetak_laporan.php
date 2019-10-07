<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak_laporan extends CI_Controller {

	private $userData;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('cetak_laporan_model', 'model');

		$this->userData = array(
			'session'	=> $this->session->userdata('userSession'),
			'host'		=> $this->input->get_request_header('Host', TRUE),
			'referer'	=> $this->input->get_request_header('Referer', TRUE),
			'agent'		=> $this->input->get_request_header('User-Agent', TRUE),
			'ipaddr'	=> $this->input->ip_address()
		);

		$auth = $this->login->auth($this->userData);
		if(!$auth['result']){
			redirect('login/');
		}

		$role = $this->login->role($this->userData, 'cetak_laporan');
		if(!$role['result']){
			redirect('dashboard/');
		}
	}

	public function index()
	{
		$this->load->view('cetak_laporan');
    }
    
    public function cetak()
    {
        $response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param = array(
			'userData' => $this->userData,
			'postData' => $this->security->xss_clean($_POST)
		);
		$response = $this->model->cetak($param);

		echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function print()
    {
        if (!isset($_GET['id_jenis_surat']) || !isset($_GET['tanggal_dari']) || !isset($_GET['tanggal_sampai'])) {
            redirect('cetak-laporan/');
        }

        $param = array(
			'userData' => $this->userData,
			'postData' => $this->security->xss_clean($_POST)
		);
        $response = $this->model->print($param);
        
        if (!$response['result']) {
            redirect('cetak-laporan/');
        }

        $this->load->view('print_laporan', $response);
    }

}