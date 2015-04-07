<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Library
 *
 * My own Library for CodeIgniter 1.7.2
 *
 * @package		MY_Library
 * @author		Arga Dinata
 * @email		arga_dinata@yahoo.com
 * @copyright	Copyright (c) 2012
 * @since		Version 2.0
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * MY_Library 	MY_Grid Class
 *
 * Class to display CRUD table, along with pagination and sorting
 *
 * @package		MY_Library
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Arga Dinata
 */
class MY_Grid {

	/**
	 * You have to initialize these following properties
	 */
	private $_base_url		= '';		// page base URL
	private $_act_url		= '';		// action base URL
	private $_act_params	= '';		// action parameters
	private $_simple		= FALSE;	// simple table without pagination and sorting
	private $_sorting		= TRUE;		// sorting
	private $_pagination	= TRUE;		// pagination
	private $_num_rows		= 0;		// number of all data
	private $_uri_segment	= 3;		// uri segment containing page number
	private $_page			= 1;		// current page
	private $_limit			= 20;		// number of data displayed on a page
	private $_items			= array();	// array of item
	private $_item			= '';		// field to be sorted
	private $_order			= 'asc';	// type of order, ascending or descending
	private $_act_link		= FALSE;	// action link with pagination and order parameters
	
	// -----------------------------------
	
	private $_offset		= 0;		// first displayed row's offset
	private $_start			= 1;		// first page link number
	private $_end			= 0;		// end page link number
	private $_num_link		= 7;		// number of page link displayed
										// 2 * $_num_link + 1
	private $_num_page		= 0;		// page total number
	private $_source		= NULL;		// grid data source
	private $_checkbox		= TRUE;		// checkbox
	private $_row_num		= TRUE;		// row number
	private $_num_act		= 0;		// number of actions
	private $_warning		= '';		// warning item
	
	private $_actions = array (
		'ubah'	=> array('show' => TRUE, 'title' => 'Ubah', 'icon' => 'edit'),
		'hapus'	=> array('show' => TRUE, 'title' => 'Hapus', 'icon' => 'times'),
	);
	
	
	/**
	 * Grid initialization
	 *
	 * @param	array
	 */
	function init($config = array())
	{
		foreach ($config as $key => $value) {
			$property 			= "_$key";
			$this->$property	= $value;
		}
		
		// set the pagination and sorting config
		$CI =& get_instance();
		$base_segment = $this->_uri_segment;
		
		$page 	= $CI->uri->segment($base_segment, 0);
		$limit	= $CI->uri->segment($base_segment + 1, 0);
		
		if ($this->_pagination) {
			$item	= $CI->uri->segment($base_segment + 2);
			$order	= $CI->uri->segment($base_segment + 3);
		}
		else {
			$item	= $CI->uri->segment($base_segment);
			$order	= $CI->uri->segment($base_segment + 1);
		}
		
		$this->_page	= $page == 0 ? 1 : $page;
		$this->_limit	= $limit == 0 ? $this->_limit : $limit;
		$this->_item	= $item == FALSE ? $this->_item : $item;
		$this->_order	= $order == FALSE ? $this->_order : $order;
		
		// simple grid, turn off the pagination
		if ($this->_simple) {
			$this->_pagination = FALSE;
		}
		
		// using pagination, count the offset and page number
		if ($this->_pagination) {
			$this->_offset = ($this->_page - 1) * $this->_limit;
			$this->_num_page = ceil($this->_num_rows / $this->_limit);
		}
		
		// count the actions
		$this->_count_act();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count available action
	 */
	function _count_act()
	{
		$this->_num_act = 0;
		
		foreach ($this->_actions as $action => $properties) {
			if ($properties['show']) {
				$this->_num_act++;
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get limit
	 */
	function limit()
	{
		return $this->_limit;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get offset
	 */
	function offset()
	{
		return $this->_offset;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get params
	 */
	function params()
	{
		$params = array (
			'num_rows'	=> $this->_num_rows,
			'offset' 	=> $this->_offset,
			'limit'		=> $this->_limit,
			'item'		=> $this->_item,
			'order'		=> $this->_order,
		);
		
		return $params;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add actions parameters
	 *
	 * @param	array
	 */
	function act_params($params)
	{
		foreach ($params as $param) {
			$this->_act_params .= '/'.$param;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Disable all actions
	 */
	function disable_all_acts()
	{
		$this->_num_act = 0;
		
		foreach ($this->_actions as $action => $properties) {
			$properties['show'] = FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Construct page link
	 *
	 * @return	string
	 */
	function page_link()
	{
		$show = 5;
		$half = floor($show / 2);
		$countdown = $show - 1;
		
		// tidak ada data
		if ($this->_num_page == 0) return '';
		
		// buka ul
		$retval = '<div class="pagination"><ul>';
		
		// link 'sebelumnya'
		if ($this->_page > 1) {
			$prev = $this->_page - 1;
			$retval .= '<li><a href="'.$this->_base_url.'/'.$prev.'">&lsaquo; Previous</a></li>';
		}
		
		// print halaman 1
		$current = ($this->_page == 1 ? ' id="current-page"' : '');
		$retval .= '<li'.$current.'><a href="'.$this->_base_url.'/1">1</a></li>';
		
		// halaman kedua
		if ($this->_page >= ($this->_num_page - $half)) {
			$counter = $this->_num_page - $countdown;
		}
		else {
			$counter = $this->_page - $half;
		}
		
		if ($counter <= 1) {
			$show--;
			$counter = 2;
		}
		
		if ($counter > 2) {
			$retval .= '<li>.....</li>';
		}
		
		$stop = ($counter >= $this->_num_page);
		
		while ( ! $stop) {
			$current = ($this->_page == $counter ? ' id="current-page"' : '');
			$retval .= '<li'.$current.'><a href="'.$this->_base_url.'/'.$counter.'">'.$counter.'</a></li>';
			$show--;
			$counter++;
			$stop = ($show == 0 OR $counter == $this->_num_page);
		}
		
		// halaman terakhir
		$second_last = $this->_num_page - 1;
		if ($counter <= $second_last) {
			$retval .= '<li>.....</li>';
		}
		
		if ($counter <= $this->_num_page) {
			$current = ($this->_page == $this->_num_page ? ' id="current-page"' : '');
			$retval .= '<li'.$current.'><a href="'.$this->_base_url.'/'.$this->_num_page.'">'.$this->_num_page.'</a></li>';
		}
		
		// link 'selanjutnya'
		if ($this->_page < $this->_num_page) {
			$next = $this->_page + 1;
			$retval .= '<li><a href="'.$this->_base_url.'/'.$next.'">Next &rsaquo;</a></li>';
		}
		
		// tutup ul dan return
		$retval .= '</ul></div>';
		return $retval;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set source
	 *
	 * @param	object
	 */
	function source($source)
	{
		$this->_source = $source;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set warning item
	 *
	 * @param	string
	 */
	function warning($item)
	{
		$this->_warning = $item;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add actions
	 *
	 * @param	array
	 */
	function add_actions($actions)
	{
		foreach ($actions as $action => $properties) {
			$this->_actions[$action] = $properties;
		}
		
		$this->_count_act();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set show properties of action
	 *
	 * @param	array
	 */
	function action_show($is_show = array())
	{
		foreach ($is_show as $action => $show) {
			$this->_actions[$action]['show'] = $show;
		}
		
		$this->_count_act();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Construct grid header
	 *
	 * @return	string
	 */
	function _thead()
	{
		if ($this->_order == 'asc') {
			$items[$this->_item]['order'] = 'desc';
		}
		
		$thead = '<tr>';
		
		if ($this->_checkbox) {
			$thead .=
				'<th align="center" width="15px">'.
				'<input type="checkbox" class="checkbox" '. 
				'onclick="select_all(this, document.getElementsByName(\'row_id[]\'))" />' .
				'</th>';
		}
		
		if ($this->_row_num) {
			$thead .= '<th width="10px">No</th>';
		}
		
		foreach ($this->_items as $item => $value) {
			
			$width = '';
		
			if (array_key_exists('width', $value)) {
				$width = 'width="'.$value['width'].'%"';
			}
		
			if ($this->_simple OR ! $this->_sorting) {
				$thead .= '<th '.$width.'>'.$value['text'].'</th>';
			}
			else {
				if ($item == $this->_item) {
					if ($this->_order == 'asc')	{
						$order = 'desc';
					}
					else if ($this->_order == 'desc') {
						$order = 'asc';
					}
					
					if ($this->_pagination)	{
						$link = $this->_base_url.'/'.$this->_page.'/'.$this->_limit.'/'.$item.'/'.$order;
					}
					else {
						$link = $this->_base_url.'/'.$item.'/'.$order;
					}
					
					$class = $this->_order == 'asc' ? 'asc' : 'dsc';
					
					$thead .= 
						'<th scope="col" '.$width.'><span class="'.$class.'">'.
						'<a href="'.$link.'">'.$value['text'].'</a>'.
						'</span></th>';
				}
				else {
					$order = 'asc';
				
					if (array_key_exists('order', $value)) {
						$order = $value['order'];
					}
					
					if ($this->_pagination)	{
						$link = $this->_base_url.'/'.$this->_page.'/'.$this->_limit.'/'.$item.'/'.$order;
					}
					else {
						$link = $this->_base_url.'/'.$item.'/'.$order;
					}
					
					$thead .= '<th '.$width.'><a href="'.$link.'">'.$value['text'].'</a></th>';
				}
			}
		}
		
		if ($this->_num_act > 0) {
			if ($this->_num_act == 1) {
				$thead .= '<th>Aksi</th>';
			}
			else {
				$thead .= '<th colspan="'.$this->_num_act.'">Aksi</th>';
			}
		}
		
		$thead .= "</tr>";
		
		return $thead;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Construct actions column
	 *
	 * @param	int
	 * @param	string
	 * @return	string
	 */
	function _action_cols($id, $warning_row = '')
	{
		$cols = '';
		
		if ($this->_num_act > 0) {
			foreach ($this->_actions as $action => $properties)	{
				$warning = '';
			
				if ($action == 'hapus') {
					$warning_row = addslashes($warning_row);
					$warning = 'onclick="return del_confirm(\''.$warning_row.'\')"';
				}
				
				if ($properties['show']) {
					$link = $this->_act_url.'/'.$action.$this->_act_params.'/'.$id;
					
					if ($this->_act_link) {
						if ($this->_simple) {
							$link .= '';
						}
						else if ($this->_pagination) {
							$link .= '/'.$this->_page.'/'.$this->_limit.'/'.$this->_item.'/'.$this->_order;
						}
						else {
							$link .= '/'.$this->_item.'/'.$this->_order;
						}
					}
					
					if (array_key_exists('icon', $properties)) {
						$cols .=
							'<td class="ico">'.
							'<a href="'.$link.'" title="'.$properties['title'].'" '.$warning.'>'.
							'<i class="fa fa-'.$properties['icon'].' fa-lg"></i></a></td>';
					}
					else {
						$cols .=
							'<td align="center">'.
							'<a href="'.$link.'" title="'.$properties['title'].'" '.$warning.'>'.
							$properties['alt'].'</a></td>';
					}
				}
			}
		}
		
		return $cols;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Draw grid
	 *
	 * @param	array
	 * @return	string
	 */
	function draw()
	{
		$grid = '';
		
		if (count($this->_source->result()) === 0) {
			$grid .= '<div class="grid-info">Data tidak ditemukan</div>';
		}
		else {
			$grid .= '<table class="grid" cellspacing="0">'.$this->_thead();
			$i = $this->_offset + 1;
			$color = 1;
			
			foreach ($this->_source->result() as $row) {
				if ($color % 2 === 0) {
					$grid .= '<tr class="even">';
					
					if ($this->_checkbox) {
						$grid .=
							'<td align="center">' .
							'<input type="checkbox" name="row_id[]" class="checkbox" '.
							'onclick="chosen(this, \'even\')" value="'.$row->id.'" /></td>';
					}
				}
				else {
					$grid .= "<tr>";
					
					if ($this->_checkbox) {
						$grid .=
							'<td align="center">' .
							'<input type="checkbox" name="row_id[]" class="checkbox" '.
							'onclick="chosen(this, \'odd\')" value="'.$row->id.'" /></td>';
					}
				}
				
				if ($this->_row_num) {
					$grid .= '<td class="num">'.$i.'</td>';
				}
				
				foreach ($this->_items as $item => $properties) {
					$align = '';
					
					if (array_key_exists('align', $properties)) {
						$align = 'align="'.$properties['align'].'"';
					}
					
					$new_item = $row->$item;
					
					if (array_key_exists('func', $properties)) {
						$new_item = call_user_func($properties['func'], $new_item);
					}
					
					if (array_key_exists('link', $properties)) {
						$new_item = '<a href="'.$properties['link'].'/'.$row->id.'">'.$new_item.'</a>';
					}
					
					if (array_key_exists('ext', $properties)) {
						switch ($properties['ext'])
						{
							// put your code here
							default: '';
						}
					}
					
					$grid .= '<td '.$align.'>'.$new_item.'</td>';
				}
				
				$warning = $this->_warning;
				
				if ($warning === '') {
					$grid .= $this->_action_cols($row->id);
				}
				else {
					$grid .= $this->_action_cols($row->id, $row->$warning);
				}
				
				$grid .= '</tr>';
				$i++;
				$color++;
			}
			
			$grid .= '</table>';
		}
		
		return $grid;
	}
	
}
// END DN_Grid class

/* End of file Grid.php */
/* Location: ./application/libraries/Grid.php */
