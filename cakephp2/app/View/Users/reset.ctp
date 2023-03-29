<h1 align=center>パスワード再設定画面</h1>
<?= $this->Form->create('User'); ?>
<?= $this->Form->input('password', array('label' => '新しいパスワードを入力してください')); ?>
<?= $this->Form->end('更新'); ?>
<p><?= $this->Html->link('ログイン画面へ戻る', array('action' => 'login')); ?></p>
