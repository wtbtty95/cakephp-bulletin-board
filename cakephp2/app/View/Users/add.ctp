<iv class="users form">
<?= $this->Form->create('User'); ?>
<fieldset>
<legend><?= __('新規会員登録'); ?></legend>
<?= $this->Form->input('username', array('label' => 'ユーザー名')); ?>
<?= $this->Form->input('email', array('label' => 'メールアドレス')); ?>
<?= $this->Form->input('password', array('label' => 'パスワード')); ?>
</fieldset>
<?= $this->Form->end(__('登録する')); ?>
<p><?= $this->Html->link('登録がお済みの方はこちらからログイン', array('action' => 'login')); ?></p>
<p><?= $this->Html->link('投稿一覧へ戻る', array('controller' => 'cake_posts', 'action' => 'index')); ?></p>
</div>
