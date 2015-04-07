<?php echo jquery_zebra_datepicker(); ?>
<?php echo jquery_select2(); ?>
<?php echo datatables(); ?>

<style type="text/css" media="screen">
	.Zebra_DatePicker_Icon_Wrapper {
		
			width: 16%;
	}
	.select2-container {
		top: -2px;
	}
	.select2-container.select2-allowclear .select2-choice abbr {
		top: 7px;
	}
	#s2id_pegawai {
		width: 250px !important;
	}
</style>

<script type='text/javascript'>
	$().ready(function () {
		
		$('#pegawai').select2({
			allowClear: true
		});
		
		$('#start').Zebra_DatePicker({
			show_icon : true,
			format: 'd F Y',
			<?php if ($q == 'na') : ?>
			offset: [0, 170],
			<?php else: ?>
			offset: [-335, 230],
			<?php endif; ?>
			months : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
			onSelect : function(view, elements){
				$(this).val(view);
				$("input[name='start_hide']").val(elements);
			}
		});
		
		$('#end').Zebra_DatePicker({
			show_icon : true,
			format: 'd F Y',
			<?php if ($q == 'na') : ?>
			offset: [0, 170],
			<?php else: ?>
			offset: [-335, 230],
			<?php endif; ?>
			months : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
			onSelect : function(view, elements){
				$(this).val(view);
				$("input[name='end_hide']").val(elements);
			}
		});
		
		$('#tabel').DataTable({
			"bFilter": false,
		 	"bPaginate": false,
		 	"bInfo": false,
		 	// "bSort": false,
		 	"bLengthChange": false,
		 	"fnRowCallback": function ( row, data, index ) {
	        	// Kolom nomor
	        	$('td', row).eq(0).addClass('text-center');
	        	// Kolom tanggal
	            $('td', row).eq(1).addClass('text-center');
	        	// Kolom jam
	            $('td', row).eq(2).addClass('text-center');
	        	// Kolom stok awal
	            $('td', row).eq(3).addClass('text-center');
	            // Kolom stok masuk
	            $('td', row).eq(4).addClass('text-center');
	            // Kolom stok keluar
	            $('td', row).eq(5).addClass('text-center');
	        }
		});
	});
</script>

<h1>Laporan Detail Penjualan Pegawai</h1>

<div class="actions">
	<?php if ($q != 'na') : ?>
		<?php echo form_open($search); ?>
	<input type="text" name="start" placeholder="Tanggal awal" value="<?php echo text_month($awal); ?>" id="start"/> - 
	<input type="text" name="end" placeholder="Tanggal akhir" value="<?php echo text_month($akhir); ?>" id="end"/>
	<input type="hidden" name="start_hide" value="<?php echo $awal; ?>" id="start_hide"/>
	<input type="hidden" name="end_hide" value="<?php echo $akhir; ?>" id="end_hide"/>
	<br />
	<br />
	<select name="id_pegawai" id="pegawai" data-placeholder="Pilih pegawai">
		<option></option>
		<?php echo modules::run('pengaturan/pegawai/options', $id); ?>
	</select>
	<input type="submit" value="Cari" />
	<?php echo form_close(); ?>
	<?php endif; ?>
</div>

<?php if ($q == 'na') : ?>
	<h2>Silahkan pilih periode dan nama pegawai terlebih dahulu.</h2>
	<br />
	<?php echo form_open($search); ?>
	<input type="text" name="start" placeholder="Tanggal awal" value="<?php echo text_month($awal); ?>" id="start"/> - 
	<input type="text" name="end" placeholder="Tanggal akhir" value="<?php echo text_month($akhir); ?>" id="end"/>
	<input type="hidden" name="start_hide" value="<?php echo $awal; ?>" id="start_hide"/>
	<input type="hidden" name="end_hide" value="<?php echo $akhir; ?>" id="end_hide"/>
	<br />
	<br />
	<select name="id_pegawai" id="pegawai" data-placeholder="Pilih pegawai">
		<option></option>
		<?php echo modules::run('pengaturan/pegawai/options', $id); ?>
	</select>
	<input type="submit" value="Cari" />
	<?php echo form_close(); ?>
<?php else : ?>
	<?php echo form_open('', array('class' => 'crud-form')); ?>
	<dl>
		<dt>Nama Pegawai</dt>
		<dd><?php echo $header->nama; ?></dd>
	</dl>
	<?php echo form_close(); ?>
	
<table id="tabel" class="stripe hover row-border cell-border">
	<thead>
		<tr>
			<th>No.</th>
			<th>Tanggal</th>
			<th>Jenis</th>
			<th>Barang</th>
			<th>Qty</th>
			<th>Subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		<?php foreach ($grid->result() as $g): ?>
		<tr>
			<td><?php echo $i; ?>.</td>
			<td><?php echo text_date($g->tgl); ?></td>
			<td><?php echo $g->nama_jenis; ?></td>
			<td><?php echo $g->nama_barang; ?></td>
			<td><?php echo angka($g->qty); ?></td>
			<td>Rp. <?php echo angka($g->subtotal); ?></td>
		</tr>
		<?php $i++; ?>
		<?php endforeach ?>
	</tbody>
</table>
<?php endif; ?>
