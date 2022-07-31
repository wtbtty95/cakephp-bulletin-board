<h1>Blog cake_posts</h1>
<?= $this->Html->link('Add Post',array('action' => 'add')); ?>
<table>
	<tr>
		<th>Id</th>
		<th>Title</th>
		<th>Action</th>
		<th>Created</th>
	</tr>

	<!-- ここから、$cake_posts配列をループして、投稿記事の情報を表示 -->

	<?php foreach ($cake_posts as $cake_post): ?>
	<tr>
		<td><?= $cake_post['CakePost']['id']; ?></td>
		<td>
			<?= $this->Html->link($cake_post['CakePost']['title'], array('action' => 'view', $cake_post['CakePost']['id'])); ?>
		</td>
		<td>
			<?= $this->Form->postLink('Delete', array('action' => 'delete', $cake_post['CakePost']['id']), array('confirm' => 'Are you sure?')); ?>
		<td>
			<?= $this->Html->link('Edit', array('action' => 'edit', $cake_post['CakePost']['id'])); ?>
		</td>
		<td><?= $cake_post['CakePost']['created']; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
