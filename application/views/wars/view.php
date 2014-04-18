<html>
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="<?php echo base_url();?>application/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/js/jquery-ui.min.js"></script>
<script>
  $(function() {
    var activeMembers = [
<? foreach ($active_members as $active_member): ?>
        "<? echo $active_member['member_name']; ?>",
<? endforeach ?>
    ];
    $( "#members*" ).autocomplete({
      source: activeMembers,
      messages: {
        noResults: '',
        results: function() {}
      },
      autoFocus: true,
      delay: 0
    });
  });
</script>
</head>
<body>

<h1>Enemy Clan: <? echo $war['enemy_clan']; ?></h1>
<h3>Date: <? echo date('j-F-Y',strtotime($war['date'])); ?></h2>
<h3>Result: <? echo $war['result']; ?></h2>
<h3>Score: <? echo $war['score']; ?></h2>

<?
	function renderImg($fileName) {
		return '<img src="' . base_url('images/'.$fileName) . '"/>';
	}

	function renderStars($numStars) {
		if(!($numStars === NULL)) {
			if( $numStars == '0' ) {
				return renderImg('nostar.png') . renderImg('nostar.png') . renderImg('nostar.png');
			} else if ($numStars == '1') {
				return renderImg('star.png') . renderImg('nostar.png') . renderImg('nostar.png');
			} else if ($numStars == '2') {
				return renderImg('star.png') . renderImg('star.png') . renderImg('nostar.png');
			} else {
				return renderImg('star.png') . renderImg('star.png') . renderImg('star.png');
			}

		}
	}

	$this->table->set_heading('MemberId','Member','Attack 1','Attack 2','Defense','Net');
	$tmpl = array (
		'table_open' => '<table border="1" cellpadding="2" cellspacing="0">'
    	);

	$this->table->set_template($tmpl);

	foreach($battles as $battle) {

		$net = $battle['attack_1'] + $battle['attack_2'] - $battle['defense'];
		if( $net > 0 ) {
			$net = '+' . $net;
		}

		$this->table->add_row(
			$battle['member_id'],
			$battle['member_name'],
			renderStars($battle['attack_1']),
			renderStars($battle['attack_2']),
			renderStars($battle['defense']),
			$net
			// $battle['battle_id']
		);

	}
	echo $this->table->generate();

?>

<h2>---[ Add Results ]---</h2>

<?
	$star_options = array(
 		''  => '',
		'0' => '0 stars',
		'1' => '1 star',
		'2' => '2 stars',
		'3' => '3 stars');

	$this->table->clear();
	$tmpl = array (
		'table_open' => '<table border="1" cellpadding="2" cellspacing="0">'
	);
	$this->table->set_template($tmpl);

	$this->table->set_heading('#','Member','Attack 1','Attack 2','Defense');
	
	for( $i=0 ; $i < 50 ; $i++ ) {
		$this->table->add_row(
			$i+1,
			form_input('members['.$i.']','','id="members"'),
			form_dropdown('firstAttacks['.$i.']', $star_options),
			form_dropdown('secondAttacks['.$i.']', $star_options),
			form_dropdown('defenses['.$i.']', $star_options)
		);
	}

	echo form_open('wars/addWarBattles/' . $war['war_id']);
	echo $this->table->generate();
	echo form_submit('submit', 'Submit');

?>
</body>
</html>