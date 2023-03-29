<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		// ユーザー自身による登録とログインとログアウトを許可する
		$this->Auth->allow('add', 'login', 'logout', 'send', 'reset');
	}

	public function login() {
		$this->User->set($this->request->data);
		if ($this->User->validates(array('fieldList' => array('password')))) {
			if ($this->request->is('post')) {
				if ($this->Auth->login()) {
					$this->Flash->success(__('ログインしました'));
					return $this->redirect($this->Auth->redirect());
				} else {
					$this->Flash->error(__('メールアドレスかパスワードが間違っています'));
				}
			} elseif ($this->Auth->user()) {
				$this->Flash->error(__('ログイン済みです'));
				return $this->redirect(array('controller' => 'cake_posts', 'action' => 'index'));
			}
		} else {
			$this->Flash->error(__('ログインできませんでした。再度お試しください。'));
		}
	}

	public function logout() {
		if ($this->Auth->user()) {
			$this->Flash->success(__('ログアウトしました'));
		} else {
			$this->Flash->error(__('ログアウト済みです'));
		}
		return $this->redirect($this->Auth->logout());
	}

	public function add() {
		if ($this->Auth->user()) {
			$this->Flash->error(__('ログイン済みです'));
			return $this->redirect(array('controller' => 'cake_posts', 'action' => 'index'));
		} else {
			if ($this->request->is('post')) {
				$email = $this->request->data['User']['email'];
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					$this->Flash->success(__('登録が完了しました'));
					return $this->redirect(array('action' => 'login'));
				} else {
					$this->Flash->error(__('登録できませんでした。再度お試しください。'));
				}
			}
		}
	}

	public function admin() {
		$this->set('logged_in', $this->Auth->user());
		$id = $this->params['named']['id'];
		$user = $this->User->findById($id);
		$this->set('users', $user);
	}

	public function edit() {
		$user1 = $this->User->findById($this->Auth->user());
		$this->set('users1', $user1);
		$id = $this->params['named']['id'];
		$user2 = $this->User->findById($id);
		$this->set('users2', $user2);
		if ($user2['User']['id'] !== $this->Auth->user('id')) {
			$this->Flash->error(__('不正なアクセスです'));
			return $this->redirect(array('controller' => 'cake_posts', 'action' => 'index'));
		}
		if ($this->request->is('post')) {
			if ($this->request->data['User']['image_name']['tmp_name']) {
				$file = $this->request->data['User']['image_name'];
				$tmp_path = $file['tmp_name'];
				$upload_dir = '../webroot/img/';
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime_type = finfo_file($finfo, $tmp_path);
				finfo_close($finfo);
				switch (strtolower($mime_type)) {
					case 'image/jpg':
						$ext = 'jpg';
						break;
					case 'image/jpeg':
						$ext = 'jpeg';
						break;
					case 'image/png':
						$ext = 'png';
						break;
					default:
						$ext = $mime_type;
				}
				$allow_ext = array('jpg', 'jpeg', 'png');
				if (!in_array($ext, $allow_ext)) {
					$this->Flash->error(__('アップロードできるのはjpg,jpeg,pngのみです'));
					$error = 'error';
				} else {
					$save_file_name = uniqid(mt_rand()) . '.' . $ext;
					if (move_uploaded_file($tmp_path, $upload_dir . $save_file_name)) {
						$image_name = $save_file_name;
						if($user2['User']['image_name'] !== '未登録' && !empty($user2['User']['image_name'])) {
							unlink($upload_dir . $user2['User']['image_name']);
						}
					} else {
						$this->Flash->error(__('ファイルがアップできませんでした'));
						$error = 'error';
					}
				}
			} else {
				if ($user2['User']['image_name']) {
					$image_name = $user2['User']['image_name'];
				} else {
					$image_name = '未登録';
				}
			}
			if (!empty($this->request->data['User']['comment'])) {
				$comment = $this->request->data['User']['comment'];
			} else {
				$comment = null;
			}
			if (empty($error)) {
				$this->User->create();
				$this->User->save(
					 array(
						'User' => array(
							'id' => $user2['User']['id'],
							'comment' => $comment,
							'image_name' => $image_name
						)
					)
				);
				$this->Flash->success(__('更新しました'));
			}
		}
	}

	public function send() {
		if ($this->request->is('post')) {
			$email = $this->request->data['User']['email'];
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$user = $this->User->find(
					'first',
					array('conditions' => array('User.email = ?' => $email))
				);
				if ($user) {
					$email = new CakeEmail();
					$email->transport('Mail');
					$email->from('procir@procir.com');
					$email->to($user['User']['email']);
					$email->subject('パスワード再設定について');
					$reset_key = uniqid(mt_rand());
					$url = 'https://procir-study.site/watabe474/main/task25/cakephp2/users/reset?key=';
					$body = '下記のURLからパスワードの再設定を行なってください' . "\n";
					$body .= $url . $reset_key;
					if ($email->send($body)) {
						$reset_date = date('Y-m-d H:i:s');
						$this->User->create();
						$this->User->save(
							array(
								'User' => array(
									'id' => $user['User']['id'],
									'reset_date' => $reset_date,
									'reset_key' => $reset_key
								)
							)
						);
						$this->Flash->success(__('メールを送信しました。記載されたパスワード再発行用URLから、３０分以内に新規パスワードを設定してください。'));
					}
				} else {
					$this->Flash->success(__('メールを送信しました。記載されたパスワード再発行用URLから、３０分以内に新規パスワードを設定してください。'));
				}
			} else {
				$this->Flash->error(__('メールアドレスではありません。再度入力してください。'));
			}
		}
	}

	public function reset() {
		$this->User->set($this->request->data);
		if ($this->User->validates(array('fieldList' => array('password')))) {
			if ($this->request->is('post')) {
				$password = $this->request->data['User']['password'];
				$reset_key = $this->request->query('key');
				$date = new DateTime('- 30 min');
				$access_date = $date->format('Y-m-d H:i:s');
				$user = $this->User->find(
					'first',
					array('conditions' => array(
						'User.reset_key = ? and reset_date >= ?' => array($reset_key, $access_date)
					))
				);
				if ($user) {
					$id = $user['User']['id'];
					$this->User->save(
						array(
							'User' => array(
								'id' => $id,
								'password' => $password,
								'reset_key' => null
							)
						)
					);
					$this->Flash->success(__('パスワードを変更しました。'));
					return $this->redirect(array('action' => 'login'));
				} else {
					$this->Flash->error(__('不正なアクセスです。再度お試しください'));
					return $this->redirect(array('action' => 'send'));
				}
			}
		} else {
			$this->Flash->error(__('変更できませんでした。再度お試しください'));
		}
	}

}
?>
