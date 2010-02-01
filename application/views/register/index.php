<?php
function custom_form_input($field, $input_password = false)
{
  if(!$input_password)
  {
    $result = form_input(array(
      'id'    => 'input_'.$field,
      'name'  => $field,
      'value' => set_value($field)
    ));
  }
  else
  {
    $result = form_password(array(
      'id'    => 'input_'.$field,
      'name'  => $field,
      'value' => set_value($field)
    ));
  }
  return $result . "\n              <span id=\"{$field}_error\">".form_error($field)."</span>";
}
?>

<script type="text/javascript">
	window.addEvent('domready', function (){
	
		var fields = Array('username', 'email', 'password');
		fields.each(function(field){
		  $('input_'+field).addEvent('blur', function(){
		  
		    $(field+'_error').innerHTML = 'Loading...';
		    var ajax = new Request({
		      url: '<?=site_url('register/check')?>',
		      onSuccess: function(responseText, responseXML){
		        $(field+'_error').innerHTML = responseText;
		      }
		    });
		    
		    ajax.send(field+'='+$('input_'+field).value);
		  });
		});
	});
</script>

<?php echo form_open('register/newuser'); ?>

  <table style="border: 1px solid">
    <tr>
      <td>
        <table>
          <tr>
            <td colspan="2"><strong>Miran Registration</strong></td>
          </tr>
          <tr>
            <td>Email:</td>
            <td>
              <?=custom_form_input('email')?>

            </td>
          </tr>
          <tr>
            <td>Username:</td>
            <td>
              <?=custom_form_input('username')?>

            </td>
          </tr>
          <tr>
            <td>Password:</td>
            <td>
              <?=custom_form_input('password', true)?>

            </td>
          </tr>
          <tr>
            <td>Confirm Password:</td>
            <td>
              <?=custom_form_input('passconf', true)?>

            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo form_submit('submit', 'Register'); ?> Or go to the <a href="<?=site_url('login')?>">Login</a> page</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?=form_close()?>

