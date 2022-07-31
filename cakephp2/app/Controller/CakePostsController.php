<?php
class CakePostsController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Flash');

	public function index() {
		$this->set('cake_posts', $this->CakePost->find('all'));
	}

	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}

		$cake_post = $this->CakePost->findById($id);
		if (!$cake_post) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->set('cake_post', $cake_post);
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->CakePost->create();
			if ($this->CakePost->save($this->request->data)) {
				$this->Flash->success(__('Your post has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error(__('Unable to add your post'));
		}
	}

	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}

		$cake_post = $this->CakePost->findById($id);
		if (!$cake_post) {
			throw new NotFoundException(__('Invalid post'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->CakePost->id = $id;
			if ($this->CakePost->save($this->request->data)) {
				$this->Flash->success(__('Your post has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error(__('Unable to update your post.'));
		}

		if (!$this->request->data) {
			$this->request->data = $cake_post;
		}
	}

	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		if ($this->CakePost->delete($id)) {
			$this->Flash->success(__('The post with id: %s has been deleted.', h($id)));
		} else {
			$this->Flash->error(__('The post with id: %s could not be deleted.', h($id)));
		}

		return $this->redirect(array('action' => 'index'));
	}
}
?>
