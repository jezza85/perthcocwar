<?php
class Wars_Model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->model('members_model');
	}

	public function get_wars($warId = FALSE)
	{
		if ($warId === FALSE)
		{
			$query = $this->db->get('wars');
			return $query->result_array();
		}

		$query = $this->db->get_where('wars', array('war_id' => $warId));
		return $query->result_array();
	}

	public function insertWarFromPost()
	{
		$data = array(
			'enemy_clan' => $this->input->post('enemy_clan'),
			'result' => $this->input->post('result'),
			'score' => $this->input->post('score')
		);
		return $this->db->insert('wars', $data);
	}

	public function insertBulkWarBattlesFromPost($warId)
	{
		$memberNames = $this->input->post('members');
		$attacks1 = $this->input->post('firstAttacks');
		$attacks2 = $this->input->post('secondAttacks');
		$defenses = $this->input->post('defenses');

		// Loop over the member names and lookup the corresponding member_id.
		// If it exists, then use that member_id - if not then create a new active user

		for($i = 0 ; $i < 50 ; $i++ ) {
			$memberName = $memberNames[$i];
			if( !empty($memberName) ) {
				$member = $this->members_model->getMemberByMemberName($memberName);
				if( empty($member) ) {
					$newMemberId = $this->members_model->insertNewMember($memberName);
					$this->insertWarBattle($warId, $newMemberId, $attacks1[$i], $attacks2[$i], $defenses[$i]);
				} else {
					$this->insertWarBattle($warId, $member['member_id'], $attacks1[$i], $attacks2[$i], $defenses[$i]);
				}
			}
		}

	}

	private function insertWarBattle($warId, $memberId, $attack1, $attack2, $defense) {

		// echo 'memberId=' . $memberId . ' attack1=' . $attack1 . ' attack2=' . $attack2 . ' defense=' . $defense;

		$data = array(
			'war_id' => $warId,
			'member_id' => $memberId,
			'attack_1' => empty($attack1) ? NULL : $attack1,
			'attack_2' => empty($attack2) ? NULL : $attack2,
			'defense' => empty($defense)? NULL : $defense
		);
		return $this->db->insert('battles', $data);
	}
}