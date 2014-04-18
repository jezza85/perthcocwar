<?php
class Wars extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('wars_model');
		$this->load->model('battles_model');
		$this->load->model('members_model');
		$this->load->library('table');
	}

	public function viewAll()
	{
		$data['wars'] = $this->wars_model->get_wars();
		$this->load->view('wars/viewAll', $data);
	}

	public function view($warId)
	{
		$data['war'] = $this->wars_model->get_wars($warId)[0];
		$data['battles'] = $this->battles_model->get_battles($warId);
		$data['active_members'] = $this->members_model->get_active_members();

		$this->load->view('wars/view', $data);
	}

	public function addWar()
	{
		$this->wars_model->insertWarFromPost();

		$data['wars'] = $this->wars_model->get_wars();
		$this->load->view('wars/viewAll', $data);
	}

	public function addWarBattles($warId)
	{
		$this->wars_model->insertBulkWarBattlesFromPost($warId);
		$this->view($warId);
	}
}
?>