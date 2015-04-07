<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nota {
    
	var $_pdf = NULL;
	private $_orientation = 'P';
	private $_size        = 'A4';
	private $_lang        = 'en';

	function __construct()
	{
		require_once("html2pdf/html2pdf.class.php");
		if(is_null($this->_pdf)){
			$width_in_inches = 8.5;
			$height_in_inches = 6;
			
			// $width_in_mm = $width_in_inches * 25.4; 
			// $height_in_mm = $height_in_inches * 25.4;
			$width_in_mm = 105;
			$height_in_mm = 165;
			
			$this->_pdf = new HTML2PDF($this->_orientation, array($width_in_mm, $height_in_mm), $this->_lang);
		}
	}

	function create_pdf($html, $title)
	{
		$this->_pdf->pdf->SetDisplayMode('fullpage');
		$this->_pdf->pdf->SetTitle($title);
		$this->_pdf->pdf->SetAuthor('POS - Reyhan Sofian');

		$this->_pdf->WriteHTML($html);
		$this->_pdf->Output($title.'.pdf');
	}

}
/* End of file Session.php */
/* Location: ./application/libraries/Session.php */