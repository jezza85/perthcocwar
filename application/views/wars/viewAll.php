<html>
<body>
<h1>War History</h1>
<?
	$this->table->set_heading('Enemy Clan','Date','Result','Score');
	$tmpl = array (
		'table_open' => '<table border="1" cellpadding="2" cellspacing="0">'
    );

	$this->table->set_template($tmpl);

	foreach($wars as $war) {

		$this->table->add_row(
				anchor('wars/view/'.$war['war_id'], $war['enemy_clan']),
				date('j-F-Y',strtotime($war['date'])),
				$war['result'],
				$war['score']
		);

	}
	echo $this->table->generate();

?>

<h1>Add War</h1>

<table>
	<? echo form_open('wars/addWar'); ?>
	<tr>
		<td>Enemy Clan</td>
		<td><? echo form_input('enemy_clan',''); ?></td>
	</tr>
	<tr>
		<td>Result</td>
		<td>
			Win <? echo form_radio('result', 'W', TRUE); ?>
			Loss <? echo form_radio('result', 'L', FALSE); ?>
			Tie <? echo form_radio('result', 'T', FALSE); ?>

		</td>
	</tr>
	<tr>
		<td>Score</td>
		<td><? echo form_input('score',''); ?></td>
	</tr>
	<tr>
		<td colspan='2'><? echo form_submit('addWar', 'Add War'); ?></td>
	</tr>
</table>

</body>
</html>