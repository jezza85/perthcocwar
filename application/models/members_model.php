<?php
class Members_Model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function get_active_members() {
		$query = $this->db->get_where('members', array('status' => 'active'));
		return $query->result_array();
	}

	public function getMemberByMemberName($memberName) {
		$query = $this->db->get_where('members', array('member_name' => $memberName));
		if( $query->num_rows > 0 ) {
			return $query->row_array();
		} else {
			return array();
		}
	}

	public function insertNewMember($memberName)
	{
		$data = array(
			'member_name' => $memberName,
			'status' => 'active'
		);
		$this->db->insert('members', $data);
		// return the member_id
		return $this->db->insert_id();
	}
}