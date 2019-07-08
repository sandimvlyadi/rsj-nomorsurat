<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	private $userData;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model', 'login');
		$this->load->model('profile_model', 'model');

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

	public function index()
	{
		$id = $this->userData['session']['id'];
		$data = $this->model->data($id);

		$this->load->view('profile', $data);
	}

	public function save_data()
	{
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param = array(
			'userData' => $this->userData,
			'postData' => $this->security->xss_clean($_POST)
		);
		$response = $this->model->save_data($param);

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	public function save_password()
	{
		$response 	= array(
			'result'	=> false,
			'msg'		=> ''
		);

		$param = array(
			'userData' => $this->userData,
			'postData' => $this->security->xss_clean($_POST)
		);
		$response = $this->model->save_password($param);

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

}