<?php echo datatables(); ?>
	.search-box {
</style>
	$().ready(function () {
		var oTable = $('#tabel').DataTable({
				url: '<?php echo site_url('transaksi/penjualan/simpan'); ?>',
				data: {data:data, qty:totalQty, total:total, no:no_nota},
				type: 'post',
				dataType: 'json',
				success: function (result) {
				}
			});
	});
</script>
		</div>
	</form>
</div>
	<thead>
</table>