<script type="text/javascript" src="<?php echo base_url('/js/currency.js'); ?>"></script>

<script type='text/javascript'>
	$().ready(function () {
		$('input[name=harga]').keyup(function() {
			$(this).val(Library.currency($(this).val().split('.').join('')));
		});
	});
</script>

<h1>Form Master Barang</h1>
<div class="actions">
	<a href="<?php echo $back; ?>"><i class="fa fa-arrow-left fa-lg"></i> Kembali</a>
</div>
<?php echo form_open($action, array('class' => 'crud-form')); ?>
	<dl>
		<dt>Nama Barang</dt>
		<dd><input type="text" name="nama" value="<?php echo $barang->nama; ?>" class="validate[required]" /></dd>
	</dl>
	<dl>
		<dt>Jenis Barang</dt>
		<dd>
			<select name="id_jnsbarang" class="validate[required]">
				<option value="">--- Pilih Jenis Barang ---</option>
				<?php echo modules::run('pengaturan/jenis/options', $barang->id); ?>
			</select>
		</dd>
	</dl>
	<dl>
		<dt>Qty</dt>
		<dd><input type="text" name="qty" value="<?php echo $barang->qty; ?>" class="validate[required]" /></dd>
	</dl>
	<dl>
		<dt>Harga</dt>
		<dd><input type="text" name="harga" value="<?php echo $barang->harga; ?>" class="validate[required]" /></dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd><input type="submit" value="Simpan" /></dd>
	</dl>
<?php echo form_close(); ?>