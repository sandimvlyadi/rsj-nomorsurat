<?php
$session = $this->session->userdata('userSession');

if ($session['level'] == 'ADMIN') {
    $this->load->view('sidebar-admin');
} else{
    $this->load->view('sidebar-employee');
}