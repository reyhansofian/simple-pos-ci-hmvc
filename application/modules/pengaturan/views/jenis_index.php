<h1>Jenis Barang</h1>

<div class="actions">
	<a href="<?php echo $add; ?>"><i class="fa fa-plus-square fa-lg"></i> Tambah</a>
	&nbsp; &nbsp;
	<a href="javascript:void(0)" onclick="multi_del_submit()"><i class="fa fa-times fa-lg"></i> Hapus</a>
	
	<div class="search-box">
		<?php echo form_open($search); ?>
		<input type="text" name="q" placeholder="Nama Jenis Barang..." value="<?php echo $q; ?>" />
		<input type="submit" value="Cari" />
		<?php echo form_close(); ?>
	</div>
</div>

<?php echo form_open($delete, array('id' => 'grid')); ?>
<?php echo $grid; ?>
<?php echo form_close(); ?>
<?php echo $page_link; ?>