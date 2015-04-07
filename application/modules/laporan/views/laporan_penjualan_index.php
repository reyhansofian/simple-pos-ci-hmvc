<?php echo jquery_zebra_datepicker(); ?>

<script type='text/javascript'>
	$().ready(function () {
		$('#start').Zebra_DatePicker({
			show_icon : false,
			format: 'd F Y',
			offset: [-350, 230],
			months : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
			onSelect : function(view, elements){
				$(this).val(view);
				$("input[name='start_hide']").val(elements);
			}
		});
		$('#end').Zebra_DatePicker({
			show_icon : false,
			format: 'd F Y',
			offset: [-350, 230],
			months : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
			onSelect : function(view, elements){
				$(this).val(view);
				$("input[name='end_hide']").val(elements);
			}
		});
		
		$('#grid').find('tr td a[title="Cetak Nota Penjualan"]').click(function() {
			id = $(this).attr('href').split('/').pop();
			
			window.open('<?php echo site_url('cetak/pdf/index') ?>/'+id+'/'+'penjualan');
			
			return false;
		});
	});
</script>

<h1>Laporan Penjualan</h1>
<?php echo $awal; ?>
<div class="actions">
	
	&nbsp; &nbsp;
	<div class="search-box tanggal">
		<?php echo form_open($search); ?>
		<input type="text" name="start" placeholder="Tanggal awal" value="<?php echo text_month($awal); ?>" id="start"/> - 
		<input type="text" name="end" placeholder="Tanggal akhir" value="<?php echo text_month($akhir); ?>" id="end"/>
		<input type="hidden" name="start_hide" value="<?php echo $awal; ?>" id="start_hide"/>
		<input type="hidden" name="end_hide" value="<?php echo $akhir; ?>" id="end_hide"/>
		<input type="submit" value="Cari" />
		<?php echo form_close(); ?>
	</div>
</div>

<?php echo form_open('', array('id' => 'grid')); ?>
<?php echo $grid; ?>
<?php echo form_close(); ?>
<?php echo $page_link; ?>