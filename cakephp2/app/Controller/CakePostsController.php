<?php
class CakePostsController extends AppController {

	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Flash');

	public function index() {
		$data = $this->CakePost->find(
			'all',
			array('conditions' => array(
				'not' => array('CakePost.delete_flag' => 1)
			))
		);
		$this->set('cake_posts', $data);
		$this->set('logged_in', $this->Auth->user());
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->CakePost->create();
			$cakepost = $this->CakePost->save(
				array(
					'CakePost' => array(
						'user_id' => $this->Auth->user('id'),
						'title' => $this->request->data['CakePost']['title'],
						'body' => $this->request->data['CakePost']['body']
					)
				)
			);
			if ($cakepost) {
				$this->Flash->success(__('新規投稿しました'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('投稿できませんでした'));
			}
		}
	}

	public function edit($id = null) {
		if ($id) {
			$cake_post = $this->CakePost->find(
				'first',
				array('conditions' => array(
					'CakePost.id' => $id,
					'CakePost.delete_flag' => 0
				))
			);
			if (!$cake_post) {
				$this->Flash->error(__('この投稿は既に削除されています'));
				return $this->redirect(array('action' => 'index'));
			} elseif ($cake_post['CakePost']['user_id'] !== $this->Auth->user('id')) {
				$this->Flash->error(__('不正なアクセスです'));
				return $this->redirect(array('action' => 'index'));
			}
		} else {
			throw new NotFoundException(__('無効な投稿です'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->CakePost->id = $id;
			if ($this->CakePost->save($this->request->data)) {
				$this->Flash->success(__('更新しました'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('更新できませんでした'));
			}
		}
		if (!$this->request->data) {
			$this->request->data = $cake_post;
		}
	}

	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		$cake_post = $this->CakePost->find(
			'first',
			array('conditions' => array(
				'CakePost.id' => $id,
				'CakePost.delete_flag' => 0
			))
		);
		if (!$cake_post) {
			$this->Flash->error(__('この投稿は既に削除されています'));
			return $this->redirect(array('action' => 'index'));
		} elseif ($cake_post['CakePost']['user_id'] !== $this->Auth->user('id')) {
			$this->Flash->error(__('不正なアクセスです'));
			return $this->redirect(array('action' => 'index'));
		} else {
			$update = $this->CakePost->save(
				array(
					'CakePost' => array(
						'id' => $id,
						'delete_flag' => 1
					)
				)
			);
			$this->Flash->success(__('id: %s の投稿を削除しました', h($id)));
			return $this->redirect(array('action' => 'index'));
		}
	}
}
?>
