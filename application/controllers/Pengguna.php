<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	private $userData;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('Pengguna_model', 'model');

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
	}

	private function role()
	{
		$role = $this->login->role($this->userData, 'pengguna');
		if(!$role['result']){
			redirect('dashboard/');
		}
	}

	public function index()
	{
		$this->role();
		$this->load->view('pengguna');
	}

	public function edit($id = 0)
	{
		$this->role();
		$response = $this->model->edit($id);
		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	public function datatable()
	{
		$this->role();
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param		= $_GET;
		$response 	= $this->model->datatable($param);
		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	public function save()
	{
		$this->role();
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param = array(
			'userData' => $this->userData,
			'postData' => $this->security->xss_clean($_POST)
		);
		$response = $this->model->save($param);

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	public function delete()
	{
		$this->role();
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param = array(
			'userData' => $this->userData,
			'postData' => $this->security->xss_clean($_POST)
		);
		$response = $this->model->delete($param);

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	public function select($id = 0)
	{
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$response = $this->model->select($id);

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	public function select_by_id_level_pengguna($id = 0)
	{
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$response = $this->model->select_by_id_level_pengguna($id);

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

}