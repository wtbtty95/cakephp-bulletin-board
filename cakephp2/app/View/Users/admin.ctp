<h1 align=center>ユーザー情報</h1>
<?php if ($logged_in['id']): ?>
<?php if ($logged_in['id'] === $users['User']['id']): ?>
<?= $this->Html->link('編集', array('action' => 'edit', 'id' => $users['User']['id'])); ?>
<?php endif; ?>
<?php endif; ?>
<table>
<tr>
<th>ユーザー名</th>
<th>ユーザー画像</th>
<th>メールアドレス</th>
<th>一言コメント</th>
</tr>
<tr>
<td><?= $users['User']['username']; ?></td>
<?php if ($users['User']['image_name'] == '未登録'): ?>
<td><?= $users['User']['image_name']; ?></td>
<?php elseif ($users['User']['image_name'] == null): ?>
<td><?= '未登録'; ?></td>
<?php else: ?>
<td><?= $this->Html->image($users['User']['image_name']); ?></td>
<?php endif; ?>
<td><?= $users['User']['email']; ?></td>
<td><?= $users['User']['comment']; ?></td>
</tr>
</table>
<p><?= $this->Html->link('投稿一覧へ戻る', array('controller' => 'cake_posts', 'action' => 'index')); ?></p>
