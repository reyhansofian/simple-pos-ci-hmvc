<h1>Master Pegawai</h1>

<div class="actions">
	<a href="<?php echo $add; ?>"><i class="fa fa-plus-square fa-lg"></i> Tambah</a>
	&nbsp; &nbsp;
	<a href="javascript:void(0)" onclick="multi_del_submit()"><i class="fa fa-times fa-lg"></i> Hapus</a>
	
	<div class="search-box">
		<?php echo form_open($search); ?>
		<input type="text" name="q" placeholder="Nama Pegawai..." value="<?php echo $q; ?>" />
		<input type="submit" value="Cari" />
		<?php echo form_close(); ?>
	</div>
</div>

<?php if ($this->session->flashdata('status') == 'forbidden') : ?>
	<div class="err">Data 'Administrator' tidak boleh dihapus!</div>
<?php endif; ?>

<?php if ($this->session->flashdata('status') == 'success') : ?>
	<div class="success">Data berhasil disimpan!</div>
<?php endif; ?>

<?php echo form_open($delete, array('id' => 'grid')); ?>
<?php echo $grid; ?>
<?php echo form_close(); ?>
<?php echo $page_link; ?>