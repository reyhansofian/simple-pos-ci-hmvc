<style type="text/css" media="screen">
	#cari {
		margin-top: 1px;
	}
</style>

<h1>Form Pencarian</h1>
<div class="actions">
	&nbsp; &nbsp;
	<?php if ($status != 'na') : ?>
	<div class="search-box">
		<?php echo form_open($search); ?>
		<input type="text" name="q" placeholder="Nama Barang..." value="<?php echo $q; ?>" />
		<input type="submit" value="Cari" />
		<?php echo form_close(); ?>
	</div>
	<?php endif; ?>
</div>

<?php if ($status != 'na') : ?>

	<?php echo form_open($delete, array('id' => 'grid')); ?>
	<?php echo $grid; ?>
	<?php echo form_close(); ?>
	<?php echo $page_link; ?>
	
<?php else : ?>
	
	<h2>Silahkan memasukkan nama barang terlebih dahulu</h2>
	<br />
	<?php echo form_open($search); ?>
		<input type="text" name="q" placeholder="Nama Barang..." value="<?php echo $q; ?>" id="cari" />
		<input type="submit" value="Cari" />
	<?php echo form_close(); ?>
	
<?php endif; ?>