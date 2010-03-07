<?php echo $this->session->flashdata('message'); ?>

<table class="messages" width="96%">
	<thead>
		<tr><th>Sender</th><th width="50%">Subject</th><th>Received</th><th>Action</th></tr>
	</thead>
	<tbody>
<?php foreach($messages as $message):?>
		<tr class="row1">
			<td><?=$message->sender_id?></td>
			<td><a href="<?=site_url("messages/view/".$message->id)?>"><?=$message->subject?></a></td>
			<td><?=$message->received?></td>
			<td><a href="<?=site_url("messages/delete/".$message->id)?>">delete</a></td>
		</tr>
<?php endforeach;?>
	</tbody>
</table>
