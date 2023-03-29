<h1>編集画面</h1>
<?= $this->Form->create('CakePost'); ?>
<?= $this->Form->input('title', array('label' => 'タイトル')); ?>
<?= $this->Form->input('body', array('rows' => '3', 'label' => '本文')); ?>
<?= $this->Form->input('id', array('type' => 'hidden')); ?>
<?= $this->Form->end('更新する'); ?>
<p><?= $this->Html->link('投稿一覧へ戻る', array('action' => 'index')); ?></p>
