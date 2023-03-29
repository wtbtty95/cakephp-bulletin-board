<h1 align=center>ユーザー情報編集画面</h1>
<?= $this->Form->create('User', array('type'=>'file')); ?>
<?= $this->Form->input('image_name', array('type' => 'file', 'label' => 'ユーザー画像')); ?>
<?= $this->Form->input('comment', array('default' => $users2['User']['comment'], 'rows' => '3', 'label' => '一言コメント')); ?>
<?= $this->Form->end('更新する'); ?>
<p><?= $this->Html->link('ユーザー情報へ戻る', array('action' => 'admin', 'id' => $users1['User']['id'])); ?></p>
<p><?= $this->Html->link('投稿一覧へ戻る', array('controller' => 'cake_posts', 'action' => 'index')); ?></p>
<?= $this->Form->input('id', array('type' => 'hidden')); ?>
