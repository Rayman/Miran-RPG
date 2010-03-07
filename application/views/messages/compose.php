<?php echo form_open('messages/send'); ?>
	<table>
		<tr>
			<th><label for="id_to">Recipient:</label></th>
			<td>
				<?php echo form_input(array(
							'id'    => 'id_to',
							'name'  => 'to',
							'value' => set_value('to')
						));?>
				<span id="to_error"><?=form_error('to')?></span>
			</td>
		</tr>
		<tr>
			<th><label for="id_subject">Subject:</label></th>
			<td>
				<?php echo form_input(array(
							'id'    => 'id_subject',
							'name'  => 'subject',
							'value' => set_value('subject')
						));?>
				<span id="subject_error"><?=form_error('subject')?></span>
			</td>
		</tr>
		<tr>
			<th><label for="id_body">Body:</label></th>
			<td>
				<textarea id="id_body" rows="12" cols="55" name="body"><?=set_value('body')?></textarea>
				<p id="body_error"><?=form_error('body')?></p>
			</td>
		</tr>
	</table><?php echo form_submit('submit', 'Send'); ?>
<?=form_close()?>
