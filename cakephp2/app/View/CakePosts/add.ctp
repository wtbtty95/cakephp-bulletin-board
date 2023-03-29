<h1 align=center>新規投稿</h1>
<?= $this->Form->create('CakePost'); ?>
<?= $this->Form->input('title', array('label' => 'タイトル')); ?>
<?= $this->Form->input('body', array('rows' => '3', 'label' => '本文')); ?>
<?= $this->Form->end('投稿する'); ?>
<p><?= $this->Html->link('投稿一覧へ戻る', array('action' => 'index')); ?></p>
