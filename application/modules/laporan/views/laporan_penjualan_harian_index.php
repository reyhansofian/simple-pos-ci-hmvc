<?php echo datatables(); ?>

<script type='text/javascript'>
	$().ready(function () {
		
		$('#tabel').DataTable({
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
	            $('td', row).eq(6).addClass('text-center');
	        }
		});
	});
</script>

<h1>Laporan Penjualan Harian</h1>

<div class="actions">
	
	&nbsp; &nbsp;
	
</div>

	<h2 class="text-center">Tanggal <?php echo text_date(date('Y-m-d')); ?></h2>

<br />
<br />
<table id="tabel" class="stripe hover row-border cell-border">
	<thead>
		<tr>
			<th>No.</th>
			<th>Tanggal</th>
			<th>No. Nota</th>
			<th>Qty</th>
			<th>Total</th>
			<th>Pegawai</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		<?php foreach ($grid->result() as $g): ?>
		<tr>
			<td><?php echo $i; ?>.</td>
			<td><?php echo text_date($g->tgl); ?></td>
			<td><?php echo $g->no_nota; ?></td>
			<td><?php echo angka($g->total_qty); ?></td>
			<td>Rp. <?php echo angka($g->total); ?></td>
			<td><?php echo $g->nama_pegawai; ?></td>
			<td><a href="<?php echo $this->page->base_url('detail/'.$g->id) ?>"><i class="fa fa-book"></i> Detail</a></td>
		</tr>
		<?php $i++; ?>
		<?php endforeach ?>
	</tbody>
	<tfoot>
		<tr>
			<th align="right" colspan="3">Total</th>
			<th align="center"></th>
			<th align="center"></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
</table>