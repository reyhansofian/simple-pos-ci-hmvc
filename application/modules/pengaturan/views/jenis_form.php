<h1>Form Jenis Barang</h1>
<div class="actions">
	<a href="<?php echo $back; ?>"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
</div>
<?php echo form_open($action, array('class' => 'crud-form')); ?>
	<dl>
		<dt>Jenis Barang</dt>
		<dd><input type="text" name="nama" value="<?php echo $jenis->nama; ?>" class="validate[required]" /></dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd><input type="submit" value="Simpan" /></dd>
	</dl>
<?php echo form_close(); ?>