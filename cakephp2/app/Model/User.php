<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'ユーザー名を入力してください'
			)
		),
		'email' => array(
			'rule1' => array(
				'rule' => 'notBlank',
				'message' => 'メールアドレスを入力してください'
			),
			'rule2' => array(
				'rule' => 'isUnique',
				'message' => '既に使用されています'
			),
		),
		'password' => array(
			'rule1' => array(
				'rule' => 'notBlank',
				'message' => 'パスワードを入力してください'
			),
			'rule2' => array(
				'rule' => array('minLength', 4),
				'message' => '４文字以上入力してください'
			)
		)
	);

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		return true;
	}
}
?>
