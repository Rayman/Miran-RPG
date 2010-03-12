<table>
	<tr>
		<td style="padding-right: 20px;">Subject</td>
		<td><b><?=$message->subject?></b></td>
	</tr>
	<tr>
		<td>Sender</td>
		<td><?=$message->from?></td>
	</tr>
	<tr>
		<td>Date </td>
		<td><?=$message->received?></td>
	</tr>
</table>

<textarea rows="12" cols="55"><?=$message->body?></textarea>

<br /><br />

<a href="<?=site_url('/messages/inbox')?>">Back</a> -
<a href="<?=site_url('/messages/reply/' . $message->id)?>">Reply</a> -
<a href="<?=site_url('/messages/delete/' . $message->id)?>">Delete</a>
