<h1 align=center>掲示板</h1>
<?= $this->Html->link('新規投稿', array('action' => 'add')); ?>
<?php if (is_null($logged_in)): ?>
<p align=right><?= $this->Html->link('新規会員登録', array('controller' => 'users', 'action' => 'add')); ?></p>
<p align=right><?= $this->Html->link('ログイン', array('controller' => 'users', 'action' => 'login')); ?></p>
<?php else: ?>
<p align=right><?= $logged_in['username']; ?>さんがログイン中</p>
<p align=right><?= $this->Html->link('ログアウト', array('controller' => 'users', 'action' => 'logout')); ?></p>
<?php endif; ?>
<table>
<tr>
<th>投稿id</th>
<th>投稿者</th>
<th>タイトル</th>
<th>本文</th>
<th>投稿日</th>
</tr>

<!-- ここから、$cake_posts配列をループして、投稿記事の情報を表示 -->

<?php foreach ($cake_posts as $cake_post): ?>
<tr>
<td><?= $cake_post['CakePost']['id']; ?></td>
<td><?= $this->Html->link($cake_post['User']['username'], array('controller' => 'users', 'action' => 'admin', 'id' => $cake_post['CakePost']['user_id'])); ?></td>
<td>
<?= $cake_post['CakePost']['title']; ?>
<?php if ($logged_in['id']): ?>
<?php if ($logged_in['id'] === $cake_post['CakePost']['user_id']): ?>
<?= $this->Html->link('編集', array('action' => 'edit', $cake_post['CakePost']['id'])); ?>
<?= $this->Form->postLink('削除', array('action' => 'delete', $cake_post['CakePost']['id']), array('confirm' => '削除してよろしいですか？')); ?>
<?php endif; ?>
<?php endif; ?>
</td>
<td><?= $cake_post['CakePost']['body']; ?></td>
<td><?= $cake_post['CakePost']['created']; ?></td>
</tr>
<?php endforeach; ?>
</table>
