<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * VL Date Select Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Trevor Davis
 * @link		http://trevordavis.net
 */

$plugin_info = array(
	'pi_name'		=> 'VL Date Selects',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Trevor Davis',
	'pi_author_url'	=> 'http://trevordavis.net',
	'pi_description'=> 'Provides Month / Day / Year Dropdowns',
	'pi_usage'		=> Vl_date_selects::usage()
);


class Vl_date_selects {

	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
		
		$end_year_offset_param = $this->EE->TMPL->fetch_param('end_year_offset', NULL);
		$start_year_offset_param = $this->EE->TMPL->fetch_param('start_year_offset', NULL);
		$tagdata = $this->EE->TMPL->tagdata;
		
		$months = '';
		$days = '';
		$years = '';
		$current_year = date('Y');
		$end_year = ($end_year_offset_param) ? $current_year - $end_year_offset_param : $current_year;
		$start_year = ($start_year_offset_param) ? $end_year - $start_year_offset_param : $end_year - 100;
		
		//Get months
		for($i = 1; $i <= 12; $i++)
		{
			$months .= '<option value="' . $i .'">' . $i .'</option>';
		}
		
		//Get days
		for($i = 1; $i <= 31; $i++)
		{
			$days .= '<option value="' . $i .'">' . $i .'</option>';
		}
		
		//Get years
		for($i = $end_year; $i >= $start_year; $i--) {
			$years .= '<option value="' . $i .'">' . $i .'</option>';
		}
		
		//Return the goods
		$variables[] = array(
			'months' => $months,
			'days' => $days,
			'years' => $years
		);

		$this->return_data = $this->EE->TMPL->parse_variables($tagdata, $variables);

	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

{exp:vl_date_selects start_year_offset="50" end_year_offset="21"}
	<label for="month">Month</label>
	<select name="month" id="month">
		{months}
	</select>
	
	<label for="day">Day</label>
	<select name="day" id="day">
		{days}
	</select>
	
	<label for="year">Year</label>
	<select name="year" id="year">
		{years}
	</select>
{/exp:vl_date_selects}

Parameters
- end_year_offset: number of years from the current year for the end range of years. If not specified, the current year will be used.

- start_year_offset: number of years from the calculated end year for the start range of years. If not specified, the start of the range will be 100 years less than the calculated end year.

<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.vl_date_selects.php */
/* Location: /system/expressionengine/third_party/vl_date_selects/pi.vl_date_selects.php */