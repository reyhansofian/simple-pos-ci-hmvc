<?php echo datatables(); ?>

<style type="text/css" media="screen">
	dt {
		font-weight: bold;
	}
	
	#cetak {
		margin-top: -5px;
	}
</style>

<script type='text/javascript'>
	
	$().ready(function () {
				
		// Initiate table
		var oTable = $('#tabel').DataTable({
		 	"bFilter": false,
		 	"bPaginate": false,
		 	"bInfo": false,
		 	"bSort": false,
		 	"bLengthChange": false,
		 	"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
	            /*
	             * Calculate the total market share for all browsers in this table (ie inc. outside
	             * the pagination)
	             */
	            var qtyTot = 0;
	            var subTot = 0;
	            for ( var i = 0 ; i < aaData.length ; i++ )
	            {
	                // Parsing harga menjadi integer
	                prs     = aaData[i][4].split('Rp. ').join('').split('.').join('');
	                subTot += prs*1;
	
	                qtyTot += aaData[i][3]*1;
	            }
	
	            /* Modify the footer row to match what we want */
	            var nCells = nRow.getElementsByTagName('th');
	            nCells[1].innerHTML = qtyTot;
	            nCells[2].innerHTML = 'Rp. '+Library.currency(subTot);
	        },
	        "fnRowCallback": function ( row, data, index ) {
	        	// Kolom nomor
	        	$('td', row).eq(0).addClass('text-center');
	        	// Kolom harga
	            $('td', row).eq(2).addClass('text-right');
	            // Kolom jumlah
	            $('td', row).eq(3).addClass('text-center');
	            // Kolom subtotal
	            $('td', row).eq(4).addClass('text-right');
	            // Kolom aksi
	            $('td', row).eq(5).addClass('text-center');
	        }
		 });
		 
		 $('#cetak').click(function () {
		 	var id = '<?php echo $id; ?>';
		 	
		 	window.open('<?php echo site_url("cetak/pdf/index/{$id}/penjualan"); ?>');
		 });
	});
</script>

<h1>Detail Penjualan</h1>

<div class="actions">
	<a href="<?php echo $back; ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
	&nbsp; &nbsp;
	<div class="search-box">
		<button class="btn btn-primary" id="cetak">Cetak</button>
	</div>
</div>

<?php echo form_open('', array('class' => 'crud-form')); ?>
	<dl>
		<dt>No. Nota</dt>
		<dd><?php echo $header->no_nota; ?></dd>
	</dl>
	<dl>
		<dt>Tanggal</dt>
		<dd><?php echo text_date($header->tgl); ?> <?php echo $header->jam; ?></dd>
	</dl>
	<dl>
		<dt>Pegawai</dt>
		<dd><?php echo $header->nama_pegawai; ?></dd>
	</dl>
<?php echo form_close(); ?>

<table id="tabel" class="stripe hover row-border cell-border">
	<thead>
		<tr>
			<th width="20px">No.</th>
			<th>Barang</th>
			<th>Harga</th>
			<th>Jumlah</th>
			<th>Subtotal</th>
		</tr>
	</thead>
	<tbody>
	<?php $i = 1; ?>
	<?php foreach ($detail->result() as $d) : ?>
		<tr>
			<td><?php echo $i; ?>.</td>
			<td><?php echo $d->nama_barang; ?></td>
			<td>Rp. <?php echo angka($d->harga); ?></td>
			<td><?php echo $d->qty; ?></td>
			<td>Rp. <?php echo angka($d->subtotal); ?></td>
		</tr>
	<?php $i++; ?>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="3">Total</th>
			<th></th>
			<th align="right"></th>
		</tr>
	</tfoot>
</table>