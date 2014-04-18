<?php
class Battles_Model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_battles($warId = FALSE)
	{
		if ($warId === FALSE)
		{
			show_404();
		}

		$attack1Sql = 'case b.attack_1 when null then 0 else b.attack_1 end case';
		$attack2Sql = 'case b.attack_2 when null then 0 else b.attack_2 end case';
		$defenseSql = 'case b.defense when null then 0 else b.defense end case';
		$netSql = $attack1Sql . ' + ' . $attack2Sql . ' - ' . $defenseSql;

		$query = $this->db
			->select('b.*, m.member_name')
			->from('battles as b')
			->join('members as m', 'b.member_id = m.member_id', 'left inner')
			->where('war_id',$warId)
			->order_by('b.battle_id','asc')
			->get();

		return $query->result_array();
	}
}