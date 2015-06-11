<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar_templete
{
	function __construct()
	{

	}

	function get_calendar_array($start_dt, $end_dt)
	{
		$result = array();

		$start_dt_array = explode('-', $start_dt);
		$start_time = mktime(0, 0, 0, $start_dt_array[1], $start_dt_array[2], $start_dt_array[0]);

		$end_dt_array = explode('-', $end_dt);
		$end_time = mktime(0, 0, 0, $end_dt_array[1], $end_dt_array[2], $end_dt_array[0]);

		$temp_day = 0;
		while($start_time <= $end_time) {
			$result[] = date('Y-m-d', $start_time);

			$temp_day++;
			$start_time = mktime(0, 0, 0, $start_dt_array[1], $start_dt_array[2] + $temp_day, $start_dt_array[0]);
		}

		return $result;
	}

	function get_advert_calendar_template($year = '', $month = '', $day = '', $max_day = 28, $min_day)
	{
		return $this->get_calendar_template($year, $month, $day, $max_day, $min_day);
	}

	function get_inventory_calendar_template($year = '', $month = '', $day = '', $max_day = 28, $min_week = '')
	{
		$min_day = '';
		if($min_week != '')
		{
			$today_index = date('w');
			$min_day = ($min_week * 7 + $today_index) * -1;
		}
		return $this->get_calendar_template($year, $month, $day, $max_day, $min_day);
	}

	function get_calendar_template($year = '', $month = '', $day = '', $max_day = 28, $min_day = '')
	{
		$result = array();

		$current_time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

		$today_index = date('w');
		$max_time = mktime(0, 0, 0, date('m'), date('d') + $max_day, date('Y'));
		if($min_day != '')
		{
			$min_time = mktime(0, 0, 0, date('m'), date('d') + $min_day, date('Y'));
		}

		$year = $year != '' ? $year : date("Y");
		$month = $month != '' ? sprintf('%02d', $month) : date("m");
		$day = $day != '' ? $day : date("d");

		$start_time = mktime(0, 0, 0, $month, 1, $year);
		$start_day_index = date('w', $start_time);
		$start_day = date('j', $start_time) - $start_day_index;

		$end_time = mktime(0, 0, 0, $month + 1, 0, $year);
		$end_day_index = date('w', $end_time);
		$end_day = date('z', $end_time - $start_time) + 7 - $end_day_index;
		if($end_day_index == 0)
		{
			$end_day -= 7;
		}

		$week_cnt = (int)(($end_day - $start_day + 1) / 7);

		$result['start_day'] = date('Y-m-d', mktime(0, 0, 0, $month, 1 - date('w', mktime(0, 0, 0, $month, 1, $year)), $year));
		$result['end_day'] = date('Y-m-d', mktime(0, 0, 0, $month + 1, 0 + 6 - date('w', mktime(0, 0, 0, $month + 1, 0, $year)), $year));

		$result['cur_year'] = $year;
		$result['cur_month'] = $month;
		$result['prev_year'] = date('Y', mktime(0, 0, 0, $month - 1, 1, $year));
		$result['prev_month'] = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
		$result['next_year'] = date('Y', mktime(0, 0, 0, $month + 1, 1, $year));
		$result['next_month'] = date('m', mktime(0, 0, 0, $month + 1, 1, $year));

		$total_cnt = 0;
		for($y = 0; $y < $week_cnt; $y++)
		{
			if(date('W', mktime(0, 0, 0, $month, $start_day + $total_cnt + 1, $year)) == date('W', mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"))))
			{
				$result['date'][$y]['bg'] = true;
			}
			else
			{
				$result['date'][$y]['bg'] = false;
			}

			for($x = 0; $x < 7; $x++)
			{
				$time = mktime(0, 0, 0, $month, $start_day + $total_cnt, $year);
				$date = date('Y-m-d', $time);

				if($x == 0)
				{
					$result['date'][$y]['day_array']['total']['date'] = $date;
					// $result[$y]['day_array']['total']['value'] = '';
					$result['date'][$y]['day_array']['total']['etc'] = false;
						
					if($time <= $max_time)
					{
						$result['date'][$y]['day_array']['total']['is_booking'] = true;
					}
					else
					{
						$result['date'][$y]['day_array']['total']['is_booking'] = false;
					}
				}
				else
				{
					$result['date'][$y]['day_array'][$x]['date'] = $date;

					$d = date('j', $time);
					if($d == 1)
					{
						$d = date('n.j', $time);
					}
					$result['date'][$y]['day_array'][$x]['value'] = $d;

					if($month != date('m', $time))
					{
						$result['date'][$y]['day_array'][$x]['etc'] = true;
					}
					else
					{
						$result['date'][$y]['day_array'][$x]['etc'] = false;
					}

					if($time <= $max_time && (isset($min_time) ? $time >= $min_time : TRUE))
					{
						$result['date'][$y]['day_array'][$x]['is_booking'] = true;
					}
					else
					{
						$result['date'][$y]['day_array'][$x]['is_booking'] = false;
					}
				}

				$total_cnt++;
			}
		}

		return $result;
	}

}

/* End of file calendar.php */
/* Location: ./application/admin/libraries/calendar.php */