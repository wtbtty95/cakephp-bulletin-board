<h1 align=center>パスワード再発行申請画面</h1>
<?= $this->Form->create('User'); ?>
<?= $this->Form->input('email', array('type' => 'email', 'label' => '登録しているメールアドレスを入力してください')); ?>
<?= $this->Form->end('送信'); ?>
<p><?= $this->Html->link('ログイン画面へ戻る', array('action' => 'login')); ?></p>
