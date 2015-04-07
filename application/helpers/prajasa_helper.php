<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function angka($number)
{
	if ($number == '') $number = 0;
	return number_format($number, 0, ',', '.');
}

function check_icon($input)
{
	return $input == '1' ? '<i class="fa fa-check"></i>' : '-';
}

function form_data($names)
{
	$CI =& get_instance();

	foreach ($names as $name) {
		$prefix = substr($name, 0, 3);
	
		if ($prefix == 'num') {
			$name = substr($name, 4);
			$data[$name] = str_replace('.', '', $CI->input->post($name));
		}
		else {
			$data[$name] = $CI->input->post($name);
		}
	}
	
	return $data;
}

function jquery_select2()
{
	return
		'<link href="'.base_url('/js/select2/select2.css').'" rel="stylesheet" />'."\n".
		'<link href="'.base_url('/js/select2/select2.ext.css').'" rel="stylesheet" />'."\n".
		'<script type="text/javascript" src="'.base_url('/js/select2/select2.min.js').'"></script>'."\n";
}

function jquery_autocomplete()
{
	return
		'<link rel="stylesheet" href="'.base_url('/js/autocomplete/autocomplete.css').'" type="text/css" />'."\n".
		'<script type="text/javascript" src="'.base_url('js/autocomplete/jquery.autocomplete.min.js').'"></script>'."\n";
}

function jquery_zebra_datepicker()
{
	return
		'<link rel="stylesheet" href="'.base_url('/js/zebra_datepicker/zebra_datepicker.css').'" type="text/css" />'."\n".
		'<link rel="stylesheet" href="'.base_url('/js/zebra_datepicker/zebra_datepicker.ext.css').'" type="text/css" />'."\n".
		'<script type="text/javascript" src="'.base_url('js/zebra_datepicker/zebra_datepicker.js').'"></script>'."\n";
}

function jquery_noty()
{
	return
		'<script type="text/javascript" src="'.base_url('js/noty/packaged/jquery.noty.packaged.min.js').'"></script>'."\n";
}

function datatables()
{
	return
		'<link href="'.base_url('js/data-tables/jquery.dataTables.css').'" rel="stylesheet" type="text/css" media="all" />'."\n".
		// '<link href="'.base_url('js/datatables/media/css/jquery.dataTables.css').'" rel="stylesheet" type="text/css" media="all" />'."\n".
		// '<link href="'.base_url('js/datatables/extensions/TableTools/css/dataTables.tableTools.css').'" rel="stylesheet" type="text/css" />'."\n".
		// '<script type="text/javascript" src="'.base_url('js/datatables/media/js/jquery.dataTables.js').'"></script>'."\n".
		// '<script type="text/javascript" src="'.base_url('js/datatables/extensions/TableTools/js/dataTables.tableTools.js').'"></script>'."\n";
		'<script type="text/javascript" src="'.base_url('js/data-tables/jquery.dataTables.js').'"></script>'."\n";
}

function options($src, $id, $ref_val, $text_field)
{
	$options = '';
	foreach ($src->result() as $row) {
		$opt_value	= $row->$id;
		$text_value	= $row->$text_field;
		
		if ($row->$id == $ref_val) {
			$options .= '<option value="'.$opt_value.'" selected>'.$text_value.'</option>';
		}
		else {
			$options .= '<option value="'.$opt_value.'">'.$text_value.'</option>';
		}
	}
	return $options;
}

function password($raw_password)
{
	return MD5(SHA1($raw_password));
}

function uc_first($string)
{
	return ucfirst($string);
}
	
function login_check()
{
	$CI =& get_instance();

	if ($CI->session->userdata('nama')) {
		redirect(base_url('/dasbor'));
	}
}

function text_date($date = '')
{
	if ($date == '') $date = date('Y-m-d');
	$date_array = explode('-', $date);
	
	switch ($date_array[1]) {
		case '01': $month = 'Januari'; break;
		case '02': $month = 'Februari'; break;
		case '03': $month = 'Maret'; break;
		case '04': $month = 'April'; break;
		case '05': $month = 'Mei'; break;
		case '06': $month = 'Juni'; break;
		case '07': $month = 'Juli'; break;
		case '08': $month = 'Agustus'; break;
		case '09': $month = 'September'; break;
		case '10': $month = 'Oktober'; break;
		case '11': $month = 'November'; break;
		case '12': $month = 'Desember'; break;
	}
	return $date_array[2].' '.$month.' '.$date_array[0];
}

function num_to_month($num)
{
	switch ($num) {
		case  1	: return 'Januari';
		case  2	: return 'Februari';
		case  3	: return 'Maret';
		case  4	: return 'April';
		case  5	: return 'Mei';
		case  6	: return 'Juni';
		case  7	: return 'Juli';
		case  8	: return 'Agustus';
		case  9	: return 'September';
		case 10	: return 'Oktober';
		case 11	: return 'November';
		case 12	: return 'Desember';
		
		default : return NULL;
	}
}

function text_month($date)
{
	if ($date == '-') return '-';
	$date = explode('-', $date);
	
	if (count($date) == 1) return NULL;
	
	$year	= $date[0];
	$month	= $date[1];
	$day	= (int)$date[2];
	
	$month	= num_to_month($month);
	
	return "$day $month $year";
}

function strip_harga($text)
{
	$harga = str_replace('Rp. ', '', $text);
	$harga1 = str_replace('.', '', $harga);
	$harga2 = str_replace(',', '', $harga1);

	return $harga2;
}

/* End of file prajasa_helper.php */
/* Location: ./application/helpers/prajasa_helper.php */