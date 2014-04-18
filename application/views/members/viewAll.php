<html>
<body>
<h1>Active Members</h1>
<?

	$this->table->set_heading('MemberId','Member');
	$tmpl = array (
		'table_open' => '<table border="1" cellpadding="2" cellspacing="0">'
    );

	$this->table->set_template($tmpl);

	foreach($active_members as $active_member) {

		$this->table->add_row(
				$active_member['member_id'],
				$active_member['member_name']
		);

	}
	echo $this->table->generate();

?>
</body>
</html>