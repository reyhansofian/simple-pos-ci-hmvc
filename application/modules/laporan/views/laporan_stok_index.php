<?php echo jquery_select2(); ?>
<?php echo datatables(); ?>
<?php echo jquery_zebra_datepicker(); ?>

<style type="text/css" media="screen">
	.select2-container {
		top: -2px;
	}
	#s2id_barang{
		width: 150px !important;
		text-align: left;
	}
	.search-box {
		margin-top: -4px;
	}
	.select2-container.select2-allowclear .select2-choice abbr {
		top: 7px;
	}
	dt{
		font-weight: bold;
	}
</style>

<script type='text/javascript'>
	$().ready(function () {
		
		$('select[name=id_barang]').select2({
			allowClear: true
		});
		
		$('#stok').DataTable({
			"bFilter": false,
		 	"bPaginate": false,
		 	"bInfo": false,
		 	"bSort": false,
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
	            // Kolom stok total
	            $('td', row).eq(6).addClass('text-center');
	        }
		});
		
		$('#periode').Zebra_DatePicker({
			offset: [0, 170]
		});
		
		$('.radio').click(function () {
			var formats = '';
			var period = this.value;
			
			$('#periode').val('');
			
			if (period == 'months') {
				formats = 'F Y';
			} else {
				formats = 'Y';
			}
			
			$('#periode').Zebra_DatePicker({
				view: period,
				format: formats,
				months : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
				offset: [0, 170],
				onSelect : function(view, elements){
					$(this).val(view);
					$("input[name='periode_hide']").val(elements);
				}
			});
		});
	});
</script>

<h1>Laporan Kartu Stok Barang</h1>

<div class="actions">
	<?php if ($q != 'na') : ?>
		<?php echo form_open($search); ?>
		<input type="radio" name="radio" value="months" class="radio" id="bulan"/> Bulan
		<input type="radio" name="radio" value="years" class="radio" id="tahun"/> Tahun
		
		<br />
		<input type="text" name="periode" value="" id="periode"/>
		<input type="hidden" name="periode_hide" value="" id="periode_hide"/>
		<br />
		<br />
		<select name="id_barang" id="barang" data-placeholder="Pilih barang">
			<option></option>
			<?php echo modules::run('pengaturan/barang/options', $id_barang); ?>
		</select>
		<input type="submit" value="Cari" />
		<?php echo form_close(); ?>
	<?php endif; ?>
</div>

<?php if ($q != 'na') : ?>
	
<?php echo form_open('', array('class' => 'crud-form')); ?>
	<dl>
		<dt>Nama Barang</dt>
		<dd><?php echo $header->nama; ?></dd>
	</dl>
	<dl>
		<dt>Jenis Barang</dt>
		<dd><?php echo $header->nama_jenis; ?></dd>
	</dl>
	<dl>
		<dt>Harga</dt>
		<dd>Rp. <?php echo angka($header->harga); ?></dd>
	</dl>
<?php echo form_close(); ?>
	
	<div class="text-center">
		<?php if ($month != '0') : ?>
		<h2>Periode <?php echo num_to_month($month); ?> <?php echo $year; ?></h2>
		<?php else : ?>
		<h2>Periode <?php echo $year; ?></h2>	
		<?php endif; ?>
	</div>
	<br />
	<br />
	
<table id="stok" class="stripe hover row-border cell-border">
	<thead>
		<tr>
			<th>No.</th>
			<th>Tanggal</th>
			<th>Jam</th>
			<th>Stok Awal</th>
			<th>Stok Masuk</th>
			<th>Stok Keluar</th>
			<th>Stok Total</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		<?php $total = 0; ?>
		<?php foreach ($grid->result() as $g): ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo text_date($g->tgl); ?></td>
			<td><?php echo $g->jam; ?></td>
			<td><?php echo $total; ?></td>
			<td><?php echo $g->qty_masuk; ?></td>
			<td><?php echo $g->qty_keluar; ?></td>
			<td><?php echo $total += $g->qty_masuk - $g->qty_keluar; ?></td>
		</tr>
		<?php $i++; ?>
		<?php endforeach ?>
	</tbody>
</table>
<?php else : ?>
	<h2>Silahkan pilih periode dan nama barang terlebih dahulu.</h2>
	<br />
	<?php echo form_open($search); ?>
	<input type="radio" name="radio" value="months" class="radio" id="bulan"/> Bulan
	<input type="radio" name="radio" value="years" class="radio" id="tahun"/> Tahun
	
	<br />
	<input type="text" name="periode" value="" id="periode"/>
	<input type="hidden" name="periode_hide" value="" id="periode_hide"/>
	<br />
	<br />
	<select name="id_barang" id="barang" data-placeholder="Pilih barang">
		<option></option>
		<?php echo modules::run('pengaturan/barang/options', $id); ?>
	</select>
	<input type="submit" value="Cari" />
	<?php echo form_close(); ?>
<?php endif; ?>