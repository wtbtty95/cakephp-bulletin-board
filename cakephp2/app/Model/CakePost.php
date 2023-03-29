<?php
class CakePost extends AppModel {

	public $validate = array(
		'title' => array(
			'rule' => 'notBlank'
		),
		'body' => array(
			'rule' => 'notBlank'
		)
	);

	public $belongsTo = array('User');
}
?>
