<script type='text/javascript'>
	function checkPasswordMatch() {
	    var password = $('input[name=password]').val();
	    var confirmPassword = $('input[name=retype]').val();
	
	    if (password != confirmPassword) {
	    	$('#check').removeClass('message-success');
	    	$('#check').addClass('message-err');
	        $("#check").html("Passwords do not match!");
	        return false;
	    } else {
	    	$('#check').removeClass('message-err');
	    	$('#check').addClass('message-success');
	        $("#check").html("Passwords match!");
	        return true;	
        }
	}
	
	$().ready(function () {
		$('input[name=retype]').keyup(checkPasswordMatch);
		$('form').submit(checkPasswordMatch);
	});
</script>

<h1>Form Master Pegawai</h1>
<div class="actions">
	<a href="<?php echo $back; ?>"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
</div>
<?php echo form_open($action, array('class' => 'crud-form')); ?>
	<dl>
		<dt>Nomor Pegawai</dt>
		<dd><input type="text" name="no_pegawai" value="<?php echo $nomor; ?>" class="validate[required]" /></dd>
	</dl>
	<dl>
		<dt>Nama Pegawai</dt>
		<dd><input type="text" name="nama" value="<?php echo $pegawai->nama; ?>" class="validate[required]" /></dd>
	</dl>
	<?php if ($aksi == 'insert') : ?>
	<dl>	
		<dt>Password</dt>
		<dd><input type="password" name="password" class="validate[required]" /></dd>
	</dl>
	<dl>
		<dt>Konfirmasi Password</dt>
		<dd><input type="password" name="retype" class="validate[required]" /> <span id="check"></span></dd>
	</dl>
	<?php endif; ?>
	<dl>
		<dt>&nbsp;</dt>
		<dd><input type="submit" value="Simpan" /></dd>
	</dl>
<?php echo form_close(); ?>