<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_log extends CI_Controller {

	private $userData;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('session_log_model', 'model');

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

		$role = $this->login->role($this->userData, 'session_log');
		if(!$role['result']){
			redirect('dashboard/');
		}
	}

	public function index()
	{
		$this->load->view('session_log');
	}

	public function datatable()
	{
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param		= $_GET;
		$response 	= $this->model->datatable($param);
		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	public function delete()
	{
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

}