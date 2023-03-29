<h1 align=center>ログイン画面</h1>
<div class="users form">
<?= $this->Flash->render('auth'); ?>
<?= $this->Form->create('User'); ?>
<fieldset>
<legend>
<?= __('登録されたメールアドレスとパスワードを入力してください'); ?>
</legend>
<?= $this->Form->input('email', array('label' => 'メールアドレス')); ?>
<?= $this->Form->input('password', array('label' => 'パスワード')); ?>
</fieldset>
<?= $this->Form->end(__('ログイン')); ?>
<p><?= $this->Html->link('パスワードを忘れた方はこちら', array('action' => 'send')); ?></p>
<p><?= $this->Html->link('新規会員登録', array('action' => 'add')); ?></p>
<p><?= $this->Html->link('投稿一覧へ戻る', array('controller' => 'cake_posts', 'action' => 'index')); ?></p>
</div>
