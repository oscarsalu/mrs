<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("pagination");
	}
	public function index()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='payment';
		$id = $this->session->userdata('id');
		$data['patient'] = $this->payment_model->show($id);
		$this->_render_page('payments/method', $data);
	}
	public function cash()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$id = $this->session->userdata('id');
		$date=date('Y-M-D H:m:s', strtotime($this->input->post('date')));
		$data['patient'] = $this->payment_model->show($id);
		$data['single_bill'] = $this->payment_model->show_id($id);
		$this->_render_page('payments/cash', $data);
	}
	public function check()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$id = $this->session->userdata('id');
		//save date to the db
		$date=date('Y-M-D H:m:s', strtotime($this->input->post('date')));
		$data['patient'] = $this->payment_model->show($id);
		$data['single_bill'] = $this->payment_model->show_id($id);
		$this->_render_page('payments/check', $data);
	}
	public function corporate()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$id = $this->session->userdata('id');
		//save date to the db
		$date=date('Y-M-D H:m:s', strtotime($this->input->post('date')));
		$data['patient'] = $this->payment_model->show($id);
		$data['single_bill'] = $this->payment_model->show_id($id);
		$this->_render_page('payments/corporate', $data);
	}
	public function credit()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$id = $this->session->userdata('id');
		//save date to the db
		$date=date('Y-M-D H:m:s', strtotime($this->input->post('date')));
		$data['patient'] = $this->payment_model->show($id);
		$data['single_bill'] = $this->payment_model->show_id($id);
		$this->_render_page('payments/credit', $data);
	}
	public function mpesa()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$id = $this->session->userdata('id');
		//save date to the db
		$date=date('Y-M-D H:m:s', strtotime($this->input->post('date')));
		$data['patient'] = $this->payment_model->show($id);
		$data['single_bill'] = $this->payment_model->show_id($id);
		$this->_render_page('payments/mpesa', $data);
	}
	public function cashinsert()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='payment';
		$data['error_message'] = '';
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('amount_paid','Amount Paid', 'required');
	if ($this->form_validation->run() === FALSE) 
	{
		$this->data['error_message'] = validation_errors();
		$this->_render_page('payments/cash', $this->data);
	}
	else
	{
		$id = $this->session->userdata('id');
		$this->payment_model->insertcash($id);
		$this->transaction();
	}
	}
	public function checkinsert()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='payment';
		$data['error_message'] = '';
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('amount_paid','Amount Paid', 'required');
	if ($this->form_validation->run() === FALSE) 
	{
		$this->data['error_message'] = validation_errors();
		$this->_render_page('payments/check', $this->data);
	}
	else
	{
		$id = $this->session->userdata('id');
		$this->payment_model->insertcheck($id);
		$this->_render_page('services/index', $this->data);
	}
	}
	public function corporateinsert()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='payment';
		$data['error_message'] = '';
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('amount_paid','Amount Paid', 'required');
	if ($this->form_validation->run() === FALSE) 
	{
		$this->data['error_message'] = validation_errors();
		$this->_render_page('payments/corporate', $this->data);
	}
	else
	{
		$id = $this->session->userdata('id');
		$this->payment_model->insertcorporate($id);
		$this->_render_page('services/index', $this->data);
	}
	}
	public function creditinsert()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='payment';
		$data['error_message'] = '';
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('amount_paid','Amount Paid', 'required');
	if ($this->form_validation->run() === FALSE) 
	{
		$this->data['error_message'] = validation_errors();
		$this->_render_page('payments/credit', $this->data);
	}
	else
	{
		$id = $this->session->userdata('id');
		$this->payment_model->insertcredit($id);
		$this->_render_page('services/index', $this->data);
	}
	}
	public function mpesainsert()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='payment';
		$data['error_message'] = '';
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('amount_paid','Amount Paid', 'required');
	if ($this->form_validation->run() === FALSE) 
	{
		$this->data['error_message'] = validation_errors();
		$this->_render_page('payments/mpesa', $this->data);
	}
	else
	{
		$id = $this->session->userdata('id');
		$this->payment_model->insertcredit($id);
		$this->_render_page('services/index', $this->data);
	}
	}
	public function transaction()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='payment';
		$id = $this->session->userdata('id');
		$data['transaction'] = $this->payment_model->show_id($id);
		$this->_render_page('payments/transaction', $data);
	}
}
