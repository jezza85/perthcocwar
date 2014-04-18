<?php
class Members extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('members_model');
		$this->load->library('table');
	}

	public function viewAll()
	{
		$data['active_members'] = $this->members_model->get_active_members();

		$this->load->view('members/viewAll', $data);
	}
}
?>