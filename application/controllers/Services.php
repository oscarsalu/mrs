<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	// retrieving services
	public function index()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		 $this->data['services']=$this->service_model->get_services()->result();
		 $this->_render_page('services/index',$this->data);
		
		 
	}
	public function create()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$data['error_message'] = '';
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('service_name','Service Name', 'required');
		$this->form_validation->set_rules('service_category','Service Category', 'required');
		$this->form_validation->set_rules('service_cost','Service Cost', 'required');
	if ($this->form_validation->run() === FALSE) 
	{
		$this->data['error_message'] = validation_errors();
		$this->_render_page('services/create', $this->data);
	}
	else
	{
		$this->data['services']=$this->service_model->insert();
		$this->_render_page('services/index', $this->data);
	}
	}
	public function show_service_id()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$id = $this->uri->segment(3);
		$data['service'] = $this->service_model->show_service();
		$data['single_service'] = $this->service_model->show_service_id($id);
		$this->_render_page('services/edit', $data);
	}
	public function edit()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$id = $this->input->post('service_id');
		$data = array(
			'service_name' => $this->input->post('service_name'),
            'service_cat'  => $this->input->post('service_category'),
            'service_cost' => $this->input->post('service_cost'),
             );
		$this->service_model->edit($id,$data);
		$this->index();
	}
	public function register()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$this->data['services']=$this->service_model->get_services()->result();
		$this->_render_page('services/register',$this->data);
		$data=array();

    if ($this->input->post()) {
        $data['service_name']=$this->input->post('service_name',true);
        $data['service_cost']=$this->input->post('service_cost',true);
        $id = $this->session->userdata('id');
        $dateit = date("Y-m-d");
        $this->service_model->insert_register($data, $id, $dateit);

        	$this->service_model->selected($id, $dateit);
    } 
    
	     
	}
	public function waiting()
	{
		$id = $this->session->userdata('id');
		$this->service_model->waiting_list($id);
		$this->show_list();
	}
	public function show_list()
	{
		$this->data['token']='home';
    	$this->data['sub_token']='profile';
		$this->data['patient']=$this->service_model->get_list()->result();
		$this->_render_page('patient/waiting', $this->data);
	}
}