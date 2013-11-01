<?php
	$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("track") or die("Couldnt find database");	
	
	if(date_default_timezone_set('GMT') !== FALSE)
	{
		$day = idate("z");
		$mon = idate("m");
		$year = idate("y");
	}
	
	$monarr = array($mon,$mon-1,$mon-2,$mon-3,$mon-4,$mon-5,$mon-6,$mon-7,$mon-8,$mon-9,$mon-10,$mon-11);
	$datearr = array($year, $year, $year, $year, $year, $year, $year, $year, $year, $year, $year, $year);
	$arr = array();
	
	$data1 = '';
	$data2 = '';
	$data3 = '';
	$data4 = '';
	$data6 = array();
	$data5 = array();
	$data7 = array();
	$dataHowTo = '';
	$data8 = '';
	$months = '';
	
	for($i=11; $i >= 0; $i--)
	{
		if($monarr[$i] < 1)
		{
			$monarr[$i] += 12;
			$datearr[$i]--;
		}
		if(strlen($monarr[$i]) == 1)
		{
			$monarr[$i] = '0'.$monarr[$i];
		}
				
		$query1 = mysql_query('SELECT click FROM clickM'.$monarr[$i].$datearr[$i].' WHERE page="index"');
		$list1 = mysql_fetch_array($query1);
	
		if($list1['click'] !== null)
		{
			$data1 .= $list1['click'].',';
		}
		if($list1['click'] === null)
		{
			$data1 .= '0,';
		}
		
		$query2 = mysql_query('SELECT SUM(click) FROM clickM'.$monarr[$i].$datearr[$i].' WHERE page="c"');
		$list2 = mysql_fetch_array($query2);
		
		$query2Dupe = mysql_query("SELECT click FROM clickM".$monarr[$i].$datearr[$i]." WHERE page='c=f095d68c'");
		
		$list2Dupe = mysql_fetch_array($query2Dupe);
	
		if($list2[0] !== null)
		{
			$data2 .= ($list2[0]-$list2Dupe[0]).',';
		}
		if($list2[0] === null)
		{
			$data2 .= '0,';
		}
		
		$query3 = mysql_query('SELECT click FROM clickM'.$monarr[$i].$datearr[$i].' WHERE page="about"');
		$list3 = mysql_fetch_array($query3);
	
		if($list3['click'] !== null)
		{
			$data3 .= $list3['click'].',';
		}
		if($list3['click'] === null)
		{
			$data3 .= '0,';
		}
		
		$query4 = mysql_query('SELECT click FROM clickM'.$monarr[$i].$datearr[$i].' WHERE page="faq"');
		$list4 = mysql_fetch_array($query4);
	
		if($list4['click'] !== null)
		{
			$data4 .= $list4['click'].',';
		}
		if($list4['click'] === null)
		{
			$data4 .= '0,';
		}
		
		$queryHowTo = mysql_query('SELECT click FROM clickM'.$monarr[$i].$datearr[$i].' WHERE page="howto"');
		$listHowTo = mysql_fetch_array($queryHowTo);
	
		if($listHowTo['click'] !== null)
		{
			$dataHowTo .= $listHowTo['click'].',';
		}
		if($listHowTo['click'] === null)
		{
			$dataHowTo .= '0,';
		}
		
		$queryTots = mysql_query("SELECT SUM(click) FROM clickM".$monarr[$i].$datearr[$i]." WHERE NOT page LIKE 'c=%'");
	
		$listTots = mysql_fetch_array($queryTots);
	
		if($listTots[0] !== null)
		{
			$dataTots .= ($listTots[0]-$list2Dupe[0]).',';
		}
		if($listTots[0] === null)
		{
			$dataTots .= '0,';
		}
		
		$query5 = mysql_query("SELECT * FROM clickM".$monarr[$i].$datearr[$i]." WHERE page LIKE 'c=%'");
		
		$bool = false;
		
		while($list5 = mysql_fetch_array($query5))
		{
			$bool = false;
			$j = 0;
			foreach($data7 as $arr)
			{
				if(strcmp(str_replace('c=', '', $list5['page']), $arr[0]) == 0)
				{
					$data7[$j][$i+1] = $list5['click'];
					$bool = true;
				}
				
				$j++;
			}
			
			if($bool === false)
			{
				$arr2 = array(str_replace('c=', '', $list5['page']), 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
				$arr2[$i+1] = $list5['click'];
				array_push($data7, $arr2);
			}
		}
		
		if($monarr[$i] == '01')
		{$months .= '"Jan",';}
		else if($monarr[$i] == '02')
		{$months .= '"Feb",';}
		else if($monarr[$i] == '03')
		{$months .= '"Mar",';}
		else if($monarr[$i] == '04')
		{$months .= '"Apr",';}
		else if($monarr[$i] == '05')
		{$months .= '"May",';}
		else if($monarr[$i] == '06')
		{$months .= '"Jun",';}
		else if($monarr[$i] == '07')
		{$months .= '"Jul",';}
		else if($monarr[$i] == '08')
		{$months .= '"Aug",';}
		else if($monarr[$i] == '09')
		{$months .= '"Sep",';}
		else if($monarr[$i] == '10')
		{$months .= '"Oct",';}
		else if($monarr[$i] == '11')
		{$months .= '"Nov",';}
		else if($monarr[$i] == '12')
		{$months .= '"Dec",';}
	}
	
	$months = substr($months, 0, -1);
	$data1 = substr($data1, 0, -1);
	$data2 = substr($data2, 0, -1);
	$data3 = substr($data3, 0, -1);
	$data4 = substr($data4, 0, -1);
	$dataHowTo = substr($dataHowTo, 0, -1);
	
	mysql_select_db("causes") or die("Couldnt find database");	
	
	$data9 = array();
	
	foreach($data7 as $arr)
	{
		$avg = ($arr[1] + $arr[2] + $arr[3] + $arr[4] + $arr[5] + $arr[6] + $arr[7] + $arr[8] + $arr[9] + $arr[10] + $arr[11] + $arr[12])/12;
		array_push($data9, array($arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7], $arr[8], $arr[9], $arr[10], $arr[11], $arr[12], $avg));
	}
	$data7 = $data9;

	function cmp($a, $b)
	{
		return strcmp($b[13], $a[13]);
	}
	
	usort($data7, "cmp");
	
	foreach($data7 as $arr)
	{
		$code = $arr[0];
		if(strlen($code) == 8)
		{
			$query6 = mysql_query("SELECT name FROM causes WHERE code='$code' LIMIT 1");
			$list6 = mysql_fetch_array($query6);
			$name = $list6['name'];
			
			
			if($name != '' && $name != 'Dans Fund' && $name != 'Jatna Example')
			{
				if(($arr[12] + $arr[11] + $arr[10] + $arr[9] + $arr[8] + $arr[7] + $arr[6] + $arr[5] + $arr[4] + $arr[3] + $arr[2] + $arr[1]) > 1)
				{
					$data8 .= '{
					name: "'.$name.'",
					data: ['.$arr[12].', '.$arr[11].', '.$arr[10].', '.$arr[9].', '.$arr[8].', '.$arr[7].', '.$arr[6].', '.$arr[5].', '.$arr[4].', '.$arr[3].', '.$arr[2].', '.$arr[1].']
					},';
				}
			}
		}
	}
	
	$data8 = substr($data8, 0, -1);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	mysql_select_db("track") or die("Couldnt find database");	
	
	$datearrx = array($day,$day-1,$day-2,$day-3,$day-4,$day-5,$day-6,$day-7,$day-8,$day-9,$day-10,$day-11,$day-12,$day-13,$day-14,$day-15,$day-16,$day-17,$day-18,$day-19,$day-20,$day-21,$day-22,$day-23,$day-24,$day-25,$day-26,$day-27,$day-28,$day-29);
	$arr = array();
	
	$data10 = '';
	$data12 = '';
	$data13 = '';
	$data14 = '';
	$data16 = array();
	$data15 = array();
	$data17 = array();
	$data18 = '';
	$days = '';
	
	for($i=29; $i >= 0; $i--)
	{
		while(strlen($datearrx[$i]) != 3)
		{
			$datearrx[$i] = '0'.$datearrx[$i];
		}
		
		$num = $i + 1;
		$days .= '"'.$num.'",';
				
		$queryTotsD = mysql_query("SELECT SUM(click) FROM clickD".$datearrx[$i]." WHERE NOT page LIKE 'c=%'");
		$listTotsD = mysql_fetch_array($queryTotsD);
		
		$query12Dupe = mysql_query("SELECT click FROM clickD".$datearrx[$i]." WHERE page='c=f095d68c'");
		$list12Dupe = mysql_fetch_array($query12Dupe);
	
		if($listTotsD[0] !== null)
		{
			$dataTotsD .= ($listTotsD[0]-$list12Dupe[0]).',';
		}
		if($listTotsD[0] === null)
		{
			$dataTotsD .= '0,';
		}
		
		$query11 = mysql_query('SELECT click FROM clickD'.$datearrx[$i].' WHERE page="index"');
		$list11 = mysql_fetch_array($query11);
	
		if($list11['click'] !== null)
		{
			$data11 .= $list11['click'].',';
		}
		if($list11['click'] === null)
		{
			$data11 .= '0,';
		}
		
		$query12 = mysql_query("SELECT SUM(click) FROM clickD".$datearrx[$i]." WHERE page='c'");
		$list12 = mysql_fetch_array($query12);
		
		
	
		if($list12[0] !== null)
		{
			$data12 .= ($list12[0]-$list12Dupe[0]).',';
		}
		if($list12[0] === null)
		{
			$data12 .= '0,';
		}
		
		$query13 = mysql_query('SELECT click FROM clickD'.$datearrx[$i].' WHERE page="about"');
		$list13 = mysql_fetch_array($query13);
	
		if($list13['click'] !== null)
		{
			$data13 .= $list13['click'].',';
		}
		if($list13['click'] === null)
		{
			$data13 .= '0,';
		}
		
		$query14 = mysql_query('SELECT click FROM clickD'.$datearrx[$i].' WHERE page="faq"');
		$list14 = mysql_fetch_array($query14);
	
		if($list14['click'] !== null)
		{
			$data14 .= $list14['click'].',';
		}
		if($list14['click'] === null)
		{
			$data14 .= '0,';
		}
		
		$query1HowTo = mysql_query('SELECT click FROM clickD'.$datearrx[$i].' WHERE page="howto"');
		$list1HowTo = mysql_fetch_array($query1HowTo);
	
		if($list1HowTo['click'] !== null)
		{
			$data1HowTo .= $list1HowTo['click'].',';
		}
		if($list1HowTo['click'] === null)
		{
			$data1HowTo .= '0,';
		}
	
		
		$query15 = mysql_query('SELECT * FROM clickD'.$datearrx[$i].' WHERE page LIKE "c=%"');
		
		$bool = false;
		
		while($list15 = mysql_fetch_array($query15))
		{
			$bool = false;
			$j = 0;
			foreach($data17 as $arr)
			{
				if(strcmp(str_replace('c=', '', $list15['page']), $arr[0]) == 0)
				{
					if($list15['click'] > 1)
					{
						$data17[$j][$i+1] = $list15['click'];
					}
					$bool = true;
				}
				
				$j++;
			}
			
			if($bool === false)
			{
				if($list15['click'] > 1)
				{
					$arr12 = array(str_replace('c=', '', $list15['page']), 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
				
					$arr12[$i+1] = $list15['click'];
					array_push($data17, $arr12);
				}
			}
		}
	}
	
	$days = substr($days, 0, -1);
	$data11 = substr($data11, 0, -1);
	$data12 = substr($data12, 0, -1);
	$data13 = substr($data13, 0, -1);
	$data14 = substr($data14, 0, -1);
	
	mysql_select_db("causes") or die("Couldnt find database");	
	
	$data19 = array();
	
	foreach($data17 as $arr3)
	{
		$arr4 = array();
		$arr4 = $arr3;
		array_shift($arr3);
		$avg = array_sum($arr3)/30;
		array_push($arr4, $avg);
		array_push($data19, $arr4);
	}
	
	$data17 = $data19;

	function cmp2($a, $b)
	{
		return strcmp($b[31], $a[31]);
	}
	
	usort($data17, "cmp2");
	
	$data18 = '';
	
	foreach($data17 as $arr2)
	{
		$code = $arr2[0];
		
		if(strlen($code) == 8)
		{
			$query16 = mysql_query("SELECT name FROM causes WHERE code='$code' LIMIT 1");
			$list16 = mysql_fetch_array($query16);
			$name = $list16['name'];
			if($name != '' && $name != 'Dans Fund' && $name != 'Jatna Example')
			{
				$data18 .= '{
					name: "'.$name.'",
					data: ['.$arr2[30].', '.$arr2[29].', '.$arr2[28].', '.$arr2[27].', '.$arr2[26].', '.$arr2[25].', '.$arr2[24].', '.$arr2[23].', '.$arr2[22].', '.$arr2[21].', '.$arr2[20].', '.$arr2[19].', '.$arr2[18].', '.$arr2[17].', '.$arr2[16].', '.$arr2[15].', '.$arr2[14].', '.$arr2[13].', '.$arr2[12].', '.$arr2[11].', '.$arr2[10].', '.$arr2[9].', '.$arr2[8].', '.$arr2[7].', '.$arr2[6].', '.$arr2[5].', '.$arr2[4].', '.$arr2[3].', '.$arr2[2].', '.$arr2[1].']
				},';
			}
		}
	}
	
	$data18 = substr($data18, 0, -1);/**/
	
	mysql_select_db("track") or die("Couldnt find database");	
	
	$desktop = 0;
	$tablet = 0;
	$iphone = 0;
	$ipod = 0;
	$android = 0;
	$blackberry = 0;
	$mobile = 0;
	
	if(strlen($mon) == 1)
	{
		$mon= '0'.$mon;
	}
	
	$queryD = mysql_query("SELECT * FROM device$mon$year");
	$totalD = 0;
	while($listD = mysql_fetch_array($queryD))
	{
		if(strcmp($listD['device'], 'Desktop') == 0)
		{
			$desktop = $listD['click'];
		}
		else if(strcmp($listD['device'], 'Tablet') == 0)
		{
			$tablet = $listD['click'];
		}
		else if(strcmp($listD['device'], 'iPhone') == 0)
		{
			$iphone = $listD['click'];
		}
		else if(strcmp($listD['device'], 'Android') == 0)
		{
			$android = $listD['click'];
		}
		else if(strcmp($listD['device'], 'Blackberry') == 0)
		{
			$blackberry = $listD['click'];
		}
		else if(strcmp($listD['device'], 'iPod') == 0)
		{
			$ipod = $listD['click'];
		}
		else if(strcmp($listD['device'], 'Mobile Phone') == 0)
		{
			$mobile = $listD['click'];
		}
	}
	
	$totalD = $desktop + $tablet + $iphone + $android + $blackberry + $ipod;
	
	$chrome = 0;
	$safari = 0;
	$firefox = 0;
	$ie = 0;
	$opera = 0;
	
	$queryB = mysql_query("SELECT * FROM browser$mon$year");
	$totalB = 0;
	while($listB = mysql_fetch_array($queryB))
	{
		if(strcmp($listB['browser'], 'Chrome') == 0)
		{
			$chrome = $listB['click'];
		}
		else if(strcmp($listB['browser'], 'Safari') == 0)
		{
			$safari = $listB['click'];
		}
		else if(strcmp($listB['browser'], 'Firefox') == 0)
		{
			$firefox = $listB['click'];
		}
		else if(strcmp($listB['browser'], 'IE') == 0)
		{
			$ie = $listB['click'];
		}
		else if(strcmp($listB['browser'], 'Opera') == 0)
		{
			$opera = $listB['click'];
		}
	}
	
	$totalB = $chrome + $safari + $firefox + $ie + $opera;
	
	function state_code_to_state( $code )
	{
		$state1 = $code;
		if( $code == 'AL' ) $state1 = 'Alabama';
		if( $code == 'AK' ) $state1 = 'Alaska';
		if( $code == 'AZ' ) $state1 = 'Arizona';
		if( $code == 'AR' ) $state1 = 'Arkansas';
		if( $code == 'CA' ) $state1 = 'California';
		if( $code == 'CO' ) $state1 = 'Colorado';
		if( $code == 'CT' ) $state1 = 'Connecticut';
		if( $code == 'DE' ) $state1 = 'Delaware';
		if( $code == 'DC' ) $state1 = 'District Of Columbia';
		if( $code == 'FL' ) $state1 = 'Florida';
		if( $code == 'GA' ) $state1 = 'Georgia';
		if( $code == 'HI' ) $state1 = 'Hawaii';
		if( $code == 'ID' ) $state1 = 'Idaho';
		if( $code == 'IL' ) $state1 = 'Illinois';
		if( $code == 'IN' ) $state1 = 'Indiana';
		if( $code == 'IA' ) $state1 = 'Iowa';
		if( $code == 'KS' ) $state1 = 'Kansas';
		if( $code == 'KY' ) $state1 = 'Kentucky';
		if( $code == 'LA' ) $state1 = 'Louisiana';
		if( $code == 'ME' ) $state1 = 'Maine';
		if( $code == 'MD' ) $state1 = 'Maryland';
		if( $code == 'MA' ) $state1 = 'Massachusetts';
		if( $code == 'MI' ) $state1 = 'Michigan';
		if( $code == 'MN' ) $state1 = 'Minnesota';
		if( $code == 'MS' ) $state1 = 'Mississippi';
		if( $code == 'MO' ) $state1 = 'Missouri';
		if( $code == 'MT' ) $state1 = 'Montana';
		if( $code == 'NE' ) $state1 = 'Nebraska';
		if( $code == 'NV' ) $state1 = 'Nevada';
		if( $code == 'NH' ) $state1 = 'New Hampshire';
		if( $code == 'NJ' ) $state1 = 'New Jersey';
		if( $code == 'NM' ) $state1 = 'New Mexico';
		if( $code == 'NY' ) $state1 = 'New York';
		if( $code == 'NC' ) $state1 = 'North Carolina';
		if( $code == 'ND' ) $state1 = 'North Dakota';
		if( $code == 'OH' ) $state1 = 'Ohio';
		if( $code == 'OK' ) $state1 = 'Oklahoma';
		if( $code == 'OR' ) $state1 = 'Oregon';
		if( $code == 'PA' ) $state1 = 'Pennsylvania';
		if( $code == 'RI' ) $state1 = 'Rhode Island';
		if( $code == 'SC' ) $state1 = 'South Carolina';
		if( $code == 'SD' ) $state1 = 'South Dakota';
		if( $code == 'TN' ) $state1 = 'Tennessee';
		if( $code == 'TX' ) $state1 = 'Texas';
		if( $code == 'UT' ) $state1 = 'Utah';
		if( $code == 'VT' ) $state1 = 'Vermont';
		if( $code == 'VA' ) $state1 = 'Virginia';
		if( $code == 'WA' ) $state1 = 'Washington';
		if( $code == 'WV' ) $state1 = 'West Virginia';
		if( $code == 'WI' ) $state1 = 'Wisconsin';
		if( $code == 'WY' ) $state1 = 'Wyoming';
		return $state1;
	}
				
	function country_code_to_country( $code )
	{
		$country1 = '';
		if( $code == 'AF' ) $country1 = 'Afghanistan';
		if( $code == 'AX' ) $country1 = 'Aland Islands';
		if( $code == 'AL' ) $country1 = 'Albania';
		if( $code == 'DZ' ) $country1 = 'Algeria';
		if( $code == 'AS' ) $country1 = 'American Samoa';
		if( $code == 'AD' ) $country1 = 'Andorra';
		if( $code == 'AO' ) $country1 = 'Angola';
		if( $code == 'AI' ) $country1 = 'Anguilla';
		if( $code == 'AQ' ) $country1 = 'Antarctica';
		if( $code == 'AG' ) $country1 = 'Antigua and Barbuda';
		if( $code == 'AR' ) $country1 = 'Argentina';
		if( $code == 'AM' ) $country1 = 'Armenia';
		if( $code == 'AW' ) $country1 = 'Aruba';
		if( $code == 'AU' ) $country1 = 'Australia';
		if( $code == 'AT' ) $country1 = 'Austria';
		if( $code == 'AZ' ) $country1 = 'Azerbaijan';
		if( $code == 'BS' ) $country1 = 'Bahamas the';
		if( $code == 'BH' ) $country1 = 'Bahrain';
		if( $code == 'BD' ) $country1 = 'Bangladesh';
		if( $code == 'BB' ) $country1 = 'Barbados';
		if( $code == 'BY' ) $country1 = 'Belarus';
		if( $code == 'BE' ) $country1 = 'Belgium';
		if( $code == 'BZ' ) $country1 = 'Belize';
		if( $code == 'BJ' ) $country1 = 'Benin';
		if( $code == 'BM' ) $country1 = 'Bermuda';
		if( $code == 'BT' ) $country1 = 'Bhutan';
		if( $code == 'BO' ) $country1 = 'Bolivia';
		if( $code == 'BA' ) $country1 = 'Bosnia and Herzegovina';
		if( $code == 'BW' ) $country1 = 'Botswana';
		if( $code == 'BV' ) $country1 = 'Bouvet Island';
		if( $code == 'BR' ) $country1 = 'Brazil';
		if( $code == 'IO' ) $country1 = 'British Indian Ocean Territory';
		if( $code == 'VG' ) $country1 = 'British Virgin Islands';
		if( $code == 'BN' ) $country1 = 'Brunei Darussalam';
		if( $code == 'BG' ) $country1 = 'Bulgaria';
		if( $code == 'BF' ) $country1 = 'Burkina Faso';
		if( $code == 'BI' ) $country1 = 'Burundi';
		if( $code == 'KH' ) $country1 = 'Cambodia';
		if( $code == 'CM' ) $country1 = 'Cameroon';
		if( $code == 'CA' ) $country1 = 'Canada';
		if( $code == 'CV' ) $country1 = 'Cape Verde';
		if( $code == 'KY' ) $country1 = 'Cayman Islands';
		if( $code == 'CF' ) $country1 = 'Central African Republic';
		if( $code == 'TD' ) $country1 = 'Chad';
		if( $code == 'CL' ) $country1 = 'Chile';
		if( $code == 'CN' ) $country1 = 'China';
		if( $code == 'CX' ) $country1 = 'Christmas Island';
		if( $code == 'CC' ) $country1 = 'Cocos Islands';
		if( $code == 'CO' ) $country1 = 'Colombia';
		if( $code == 'KM' ) $country1 = 'The Comoros';
		if( $code == 'CD' ) $country1 = 'Congo';
		if( $code == 'CG' ) $country1 = 'TheCongo';
		if( $code == 'CK' ) $country1 = 'Cook Islands';
		if( $code == 'CR' ) $country1 = 'Costa Rica';
		if( $code == 'CI' ) $country1 = 'Cote d\'Ivoire';
		if( $code == 'HR' ) $country1 = 'Croatia';
		if( $code == 'CU' ) $country1 = 'Cuba';
		if( $code == 'CY' ) $country1 = 'Cyprus';
		if( $code == 'CZ' ) $country1 = 'Czech Republic';
		if( $code == 'DK' ) $country1 = 'Denmark';
		if( $code == 'DJ' ) $country1 = 'Djibouti';
		if( $code == 'DM' ) $country1 = 'Dominica';
		if( $code == 'DO' ) $country1 = 'Dominican Republic';
		if( $code == 'EC' ) $country1 = 'Ecuador';
		if( $code == 'EG' ) $country1 = 'Egypt';
		if( $code == 'SV' ) $country1 = 'El Salvador';
		if( $code == 'GQ' ) $country1 = 'Equatorial Guinea';
		if( $code == 'ER' ) $country1 = 'Eritrea';
		if( $code == 'EE' ) $country1 = 'Estonia';
		if( $code == 'ET' ) $country1 = 'Ethiopia';
		if( $code == 'FO' ) $country1 = 'Faroe Islands';
		if( $code == 'FK' ) $country1 = 'Falkland Islands';
		if( $code == 'FJ' ) $country1 = 'Fiji';
		if( $code == 'FI' ) $country1 = 'Finland';
		if( $code == 'FR' ) $country1 = 'France';
		if( $code == 'GF' ) $country1 = 'French Guiana';
		if( $code == 'PF' ) $country1 = 'French Polynesia';
		if( $code == 'TF' ) $country1 = 'French Southern Territories';
		if( $code == 'GA' ) $country1 = 'Gabon';
		if( $code == 'GM' ) $country1 = 'The Gambia';
		if( $code == 'GE' ) $country1 = 'Georgia';
		if( $code == 'DE' ) $country1 = 'Germany';
		if( $code == 'GH' ) $country1 = 'Ghana';
		if( $code == 'GI' ) $country1 = 'Gibraltar';
		if( $code == 'GR' ) $country1 = 'Greece';
		if( $code == 'GL' ) $country1 = 'Greenland';
		if( $code == 'GD' ) $country1 = 'Grenada';
		if( $code == 'GP' ) $country1 = 'Guadeloupe';
		if( $code == 'GU' ) $country1 = 'Guam';
		if( $code == 'GT' ) $country1 = 'Guatemala';
		if( $code == 'GG' ) $country1 = 'Guernsey';
		if( $code == 'GN' ) $country1 = 'Guinea';
		if( $code == 'GW' ) $country1 = 'Guinea-Bissau';
		if( $code == 'GY' ) $country1 = 'Guyana';
		if( $code == 'HT' ) $country1 = 'Haiti';
		if( $code == 'HM' ) $country1 = 'Heard Island and McDonald Islands';
		if( $code == 'VA' ) $country1 = 'Vatican City';
		if( $code == 'HN' ) $country1 = 'Honduras';
		if( $code == 'HK' ) $country1 = 'Hong Kong';
		if( $code == 'HU' ) $country1 = 'Hungary';
		if( $code == 'IS' ) $country1 = 'Iceland';
		if( $code == 'IN' ) $country1 = 'India';
		if( $code == 'ID' ) $country1 = 'Indonesia';
		if( $code == 'IR' ) $country1 = 'Iran';
		if( $code == 'IQ' ) $country1 = 'Iraq';
		if( $code == 'IE' ) $country1 = 'Ireland';
		if( $code == 'IM' ) $country1 = 'Isle of Man';
		if( $code == 'IL' ) $country1 = 'Israel';
		if( $code == 'IT' ) $country1 = 'Italy';
		if( $code == 'JM' ) $country1 = 'Jamaica';
		if( $code == 'JP' ) $country1 = 'Japan';
		if( $code == 'JE' ) $country1 = 'Jersey';
		if( $code == 'JO' ) $country1 = 'Jordan';
		if( $code == 'KZ' ) $country1 = 'Kazakhstan';
		if( $code == 'KE' ) $country1 = 'Kenya';
		if( $code == 'KI' ) $country1 = 'Kiribati';
		if( $code == 'KP' ) $country1 = 'Korea';
		if( $code == 'KR' ) $country1 = 'Korea';
		if( $code == 'KW' ) $country1 = 'Kuwait';
		if( $code == 'KG' ) $country1 = 'Kyrgyz Republic';
		if( $code == 'LA' ) $country1 = 'Lao';
		if( $code == 'LV' ) $country1 = 'Latvia';
		if( $code == 'LB' ) $country1 = 'Lebanon';
		if( $code == 'LS' ) $country1 = 'Lesotho';
		if( $code == 'LR' ) $country1 = 'Liberia';
		if( $code == 'LY' ) $country1 = 'Libyan Arab Jamahiriya';
		if( $code == 'LI' ) $country1 = 'Liechtenstein';
		if( $code == 'LT' ) $country1 = 'Lithuania';
		if( $code == 'LU' ) $country1 = 'Luxembourg';
		if( $code == 'MO' ) $country1 = 'Macao';
		if( $code == 'MK' ) $country1 = 'Macedonia';
		if( $code == 'MG' ) $country1 = 'Madagascar';
		if( $code == 'MW' ) $country1 = 'Malawi';
		if( $code == 'MY' ) $country1 = 'Malaysia';
		if( $code == 'MV' ) $country1 = 'Maldives';
		if( $code == 'ML' ) $country1 = 'Mali';
		if( $code == 'MT' ) $country1 = 'Malta';
		if( $code == 'MH' ) $country1 = 'Marshall Islands';
		if( $code == 'MQ' ) $country1 = 'Martinique';
		if( $code == 'MR' ) $country1 = 'Mauritania';
		if( $code == 'MU' ) $country1 = 'Mauritius';
		if( $code == 'YT' ) $country1 = 'Mayotte';
		if( $code == 'MX' ) $country1 = 'Mexico';
		if( $code == 'FM' ) $country1 = 'Micronesia';
		if( $code == 'MD' ) $country1 = 'Moldova';
		if( $code == 'MC' ) $country1 = 'Monaco';
		if( $code == 'MN' ) $country1 = 'Mongolia';
		if( $code == 'ME' ) $country1 = 'Montenegro';
		if( $code == 'MS' ) $country1 = 'Montserrat';
		if( $code == 'MA' ) $country1 = 'Morocco';
		if( $code == 'MZ' ) $country1 = 'Mozambique';
		if( $code == 'MM' ) $country1 = 'Myanmar';
		if( $code == 'NA' ) $country1 = 'Namibia';
		if( $code == 'NR' ) $country1 = 'Nauru';
		if( $code == 'NP' ) $country1 = 'Nepal';
		if( $code == 'AN' ) $country1 = 'Netherlands Antilles';
		if( $code == 'NL' ) $country1 = 'The Netherlands';
		if( $code == 'NC' ) $country1 = 'New Caledonia';
		if( $code == 'NZ' ) $country1 = 'New Zealand';
		if( $code == 'NI' ) $country1 = 'Nicaragua';
		if( $code == 'NE' ) $country1 = 'Niger';
		if( $code == 'NG' ) $country1 = 'Nigeria';
		if( $code == 'NU' ) $country1 = 'Niue';
		if( $code == 'NF' ) $country1 = 'Norfolk Island';
		if( $code == 'MP' ) $country1 = 'Northern Mariana Islands';
		if( $code == 'NO' ) $country1 = 'Norway';
		if( $code == 'OM' ) $country1 = 'Oman';
		if( $code == 'PK' ) $country1 = 'Pakistan';
		if( $code == 'PW' ) $country1 = 'Palau';
		if( $code == 'PS' ) $country1 = 'Palestine';
		if( $code == 'PA' ) $country1 = 'Panama';
		if( $code == 'PG' ) $country1 = 'Papua New Guinea';
		if( $code == 'PY' ) $country1 = 'Paraguay';
		if( $code == 'PE' ) $country1 = 'Peru';
		if( $code == 'PH' ) $country1 = 'Philippines';
		if( $code == 'PN' ) $country1 = 'Pitcairn Islands';
		if( $code == 'PL' ) $country1 = 'Poland';
		if( $code == 'PT' ) $country1 = 'Portugal';
		if( $code == 'PR' ) $country1 = 'Puerto Rico';
		if( $code == 'QA' ) $country1 = 'Qatar';
		if( $code == 'RE' ) $country1 = 'Reunion';
		if( $code == 'RO' ) $country1 = 'Romania';
		if( $code == 'RU' ) $country1 = 'Russia';
		if( $code == 'RW' ) $country1 = 'Rwanda';
		if( $code == 'BL' ) $country1 = 'Saint Barthelemy';
		if( $code == 'SH' ) $country1 = 'Saint Helena';
		if( $code == 'KN' ) $country1 = 'Saint Kitts and Nevis';
		if( $code == 'LC' ) $country1 = 'Saint Lucia';
		if( $code == 'MF' ) $country1 = 'Saint Martin';
		if( $code == 'PM' ) $country1 = 'Saint Pierre and Miquelon';
		if( $code == 'VC' ) $country1 = 'Saint Vincent and the Grenadines';
		if( $code == 'WS' ) $country1 = 'Samoa';
		if( $code == 'SM' ) $country1 = 'San Marino';
		if( $code == 'ST' ) $country1 = 'Sao Tome and Principe';
		if( $code == 'SA' ) $country1 = 'Saudi Arabia';
		if( $code == 'SN' ) $country1 = 'Senegal';
		if( $code == 'RS' ) $country1 = 'Serbia';
		if( $code == 'SC' ) $country1 = 'Seychelles';
		if( $code == 'SL' ) $country1 = 'Sierra Leone';
		if( $code == 'SG' ) $country1 = 'Singapore';
		if( $code == 'SK' ) $country1 = 'Slovakia';
		if( $code == 'SI' ) $country1 = 'Slovenia';
		if( $code == 'SB' ) $country1 = 'Solomon Islands';
		if( $code == 'SO' ) $country1 = 'Somalia';
		if( $code == 'ZA' ) $country1 = 'South Africa';
		if( $code == 'GS' ) $country1 = 'South Georgia and the South Sandwich Islands';
		if( $code == 'ES' ) $country1 = 'Spain';
		if( $code == 'LK' ) $country1 = 'Sri Lanka';
		if( $code == 'SD' ) $country1 = 'Sudan';
		if( $code == 'SR' ) $country1 = 'Suriname';
		if( $code == 'SJ' ) $country1 = 'Svalbard & Jan Mayen Islands';
		if( $code == 'SZ' ) $country1 = 'Swaziland';
		if( $code == 'SE' ) $country1 = 'Sweden';
		if( $code == 'CH' ) $country1 = 'Switzerland';
		if( $code == 'SY' ) $country1 = 'Syria';
		if( $code == 'TW' ) $country1 = 'Taiwan';
		if( $code == 'TJ' ) $country1 = 'Tajikistan';
		if( $code == 'TZ' ) $country1 = 'Tanzania';
		if( $code == 'TH' ) $country1 = 'Thailand';
		if( $code == 'TL' ) $country1 = 'Timor-Leste';
		if( $code == 'TG' ) $country1 = 'Togo';
		if( $code == 'TK' ) $country1 = 'Tokelau';
		if( $code == 'TO' ) $country1 = 'Tonga';
		if( $code == 'TT' ) $country1 = 'Trinidad and Tobago';
		if( $code == 'TN' ) $country1 = 'Tunisia';
		if( $code == 'TR' ) $country1 = 'Turkey';
		if( $code == 'TM' ) $country1 = 'Turkmenistan';
		if( $code == 'TC' ) $country1 = 'Turks and Caicos Islands';
		if( $code == 'TV' ) $country1 = 'Tuvalu';
		if( $code == 'UG' ) $country1 = 'Uganda';
		if( $code == 'UA' ) $country1 = 'Ukraine';
		if( $code == 'AE' ) $country1 = 'United Arab Emirates';
		if( $code == 'GB' ) $country1 = 'United Kingdom';
		if( $code == 'US' ) $country1 = 'United States';
		if( $code == 'UM' ) $country1 = 'United States Minor Outlying Islands';
		if( $code == 'VI' ) $country1 = 'United States Virgin Islands';
		if( $code == 'UY' ) $country1 = 'Uruguay';
		if( $code == 'UZ' ) $country1 = 'Uzbekistan';
		if( $code == 'VU' ) $country1 = 'Vanuatu';
		if( $code == 'VE' ) $country1 = 'Venezuela';
		if( $code == 'VN' ) $country1 = 'Vietnam';
		if( $code == 'WF' ) $country1 = 'Wallis and Futuna';
		if( $code == 'EH' ) $country1 = 'Western Sahara';
		if( $code == 'YE' ) $country1 = 'Yemen';
		if( $code == 'ZM' ) $country1 = 'Zambia';
		if( $code == 'ZW' ) $country1 = 'Zimbabwe';
		if( $country1 == '') $country1 = $code;
		return $country1;
	}
	
	$queryP = mysql_query("SELECT city,country,click FROM user".$mon.$year." ORDER BY country");
	$dataP = '';
	$totalP = 0;
	$arrp = array();
	$arrp1 = array();
	while($listP = mysql_fetch_array($queryP))
	{
		$country = country_code_to_country($listP['country']);
		$clicks = $listP['click'];
		
		$bool = false;
		
		for($i=0; $i < count($arrp); $i++)
		{
			if(strcmp($country, $arrp[$i][0]) == 0)
			{
				$arrp[$i][1] += $clicks;
				$bool = true;
			}
		}
		
		if($bool === false)
		{
			$arrpx = array($country, $clicks);
			array_push($arrp, $arrpx);
		}
		
		$totalP += $clicks;
		
		if($listP['country'] == 'US')
		{
			$state = state_code_to_state(substr($listP['city'], -2));
			
			$bool1 = false;
		
			
			for($i=0; $i < count($arrp1); $i++)
			{
				if(strcmp($state, $arrp1[$i][0]) == 0)
				{
					$arrp1[$i][1] += $clicks;
					$bool1 = true;
				}
			}
			
			if($bool1 === false)
			{
				$arrpx1 = array($state, $clicks);
				array_push($arrp1, $arrpx1);
			}
			
			$totalP1 += $clicks;
		}
	}
	
	$piearr = array();
	$piearr1 = array();
	
	foreach ($arrp as $arr) 
	{    
		$piearr[] = $arr[1];
	}
	
	foreach ($arrp1 as $arr1) 
	{    
		$piearr1[] = $arr1[1];
	}
	
	array_multisort($piearr, SORT_DESC, $arrp);
	array_multisort($piearr1, SORT_DESC, $arrp1);
	
	$clik1 = 0;
	$clik3 = 0;
	$dataP1 = '';
	$dataP3 = '';
	
	foreach($arrp1 as $arr)
	{
		$stat = $arr[0];
		$clik2 = $arr[1]; 
		if($clik2/$totalP1 >= .015)
		{
			$dataP2 .= "['$stat', $clik2],";
		}
		else
		{
			$clik3 += $clik2;
			$decimal = round(100*$clik2/$totalP1, 2);
			
			$arrp3 = explode('.', $decimal);
			$newdec = $arrp3[1];
			
			while(strlen($newdec) != 2)
			{
				$newdec .= '0';
			}
			
			$dataP3 .= $stat.': '.$arrp3[0].'.'.$newdec.' %<br/>';
		}
	}
	
	foreach($arrp as $arr)
	{
		$coun = $arr[0];
		$clik = $arr[1]; 
		if($clik/$totalP >= .015)
		{
			$dataP .= "['$coun', $clik],";
		}
		else
		{
			$clik1 += $clik;
			$decimal = round(100*$clik/$totalP, 2);
			
			$arrp2 = explode('.', $decimal);
			$newdec = $arrp2[1];
			
			while(strlen($newdec) != 2)
			{
				$newdec .= '0';
			}
			
			$dataP1 .= $coun.': '.$arrp2[0].'.'.$newdec.' %<br/>';
		}
	}
	
	if($clik1 > 1)
	{
		$dataP .= "['Others', $clik1],";
	}
	
	if($clik3 > 1)
	{
		$dataP2 .= "['Others', $clik3],";
	}
	$dataP = substr($dataP, 0, -1);
	$dataP2 = substr($dataP2, 0, -1);
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta name="description" content="Jatna is an online fundraising platform that makes fundraising for charities, schools, churches, spiritual groups, clubs, events, non-profit organizations, and for-profit organizations very simple. Jatna is free and easy to use."/>
	<meta name="keywords" content="about,jatnaabout,jatna,jatna.com,fundraising,online fundraising,team fundraising,fundraising ideas,fundraiser,community,free,donate,simple,charity,school,donation,cause,nonprofit,unique,church,fund,simple fundraising,charity fundraising,school fundraising,donation fundraising,cause fundraising,nonprofit fundraising,unique fundraising,church fundraising,fund fundraising"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Jatna - Reports</title>
	<link rel="SHORTCUT ICON" href="images/favicon.ico">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript">

		$(function () {
			var chart1;
			$(document).ready(function() {
				chart1 = new Highcharts.Chart({
					chart: {
						renderTo: 'container1',
						type: 'line',
						marginRight: 130,
						marginBottom: 25
					},
					title: {
						text: 'Static Page Views',
						x: -20 //center
					},
					subtitle: {
						text: 'Monthly',
						x: -20
					},
					xAxis: {
						categories: [<? echo $months;?>]
					},
					yAxis: {
						title: {
							text: 'Page Views'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
								return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y;
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -10,
						y: 100,
						borderWidth: 0
					},
					exporting: {
						buttons: 
						{ 
							exportButton: 
							{
								enabled:false
							},
							printButton: 
							{
								enabled:false
							}

						}
					},
					series: [
					{
						name: 'Total',
						data: [<?echo $dataTots;?>]
					},{
						name: 'Index',
						data: [<?echo $data1;?>]
					}, {
						name: 'Causes',
						data: [<? echo $data2;?>]
					}, {
						name: 'About',
						data: [<? echo $data3;?>]
					}, {
						name: 'FAQ',
						data: [<? echo $data4;?>]
					}, {
						name: 'HowTo',
						data: [<? echo $dataHowTo;?>]
					}],
			credits:{
				enabled:false
			}
				});
			});
			
		});
		
		$(function () {
			var chart3;
			$(document).ready(function() {
				chart3 = new Highcharts.Chart({
					chart: {
						renderTo: 'container3',
						type: 'line',
						marginRight: 400,
						marginBottom: 25
					},
					title: {
						text: 'Cause Page Views',
						x: -20 //center
					},
					subtitle: {
						text: 'Monthly',
						x: -20
					},
					xAxis: {
						categories: [<? echo $months;?>]
					},
					yAxis: {
						title: {
							text: 'Page Views'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
								return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y;
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -10,
						y: 100,
						borderWidth: 0
					},
					exporting: {
						buttons: 
						{ 
							exportButton: 
							{
								enabled:false
							},
							printButton: 
							{
								enabled:false
							}

						}
					},
					series: [<? echo $data8;?>],
			credits:{
				enabled:false
			}
				});
			});
			
		});
		
		$(function () {
			var chart2;
			$(document).ready(function() {
				chart2 = new Highcharts.Chart({
					chart: {
						renderTo: 'container2',
						type: 'line',
						marginRight: 130,
						marginBottom: 25
					},
					title: {
						text: 'Static Page Views',
						x: -20 //center
					},
					subtitle: {
						text: 'Daily',
						x: -20
					},
					xAxis: {
						categories: [<? echo $days;?>]
					},
					yAxis: {
						title: {
							text: 'Page Views'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
								return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y;
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -10,
						y: 100,
						borderWidth: 0
					},
					exporting: {
						buttons: 
						{ 
							exportButton: 
							{
								enabled:false
							},
							printButton: 
							{
								enabled:false
							}

						}
					},
					series: [{
						name: 'Total',
						data: [<?echo $dataTotsD;?>]
					},{
						name: 'Index',
						data: [<?echo $data11;?>]
					}, {
						name: 'Causes',
						data: [<? echo $data12;?>]
					}, {
						name: 'About',
						data: [<? echo $data13;?>]
					}, {
						name: 'FAQ',
						data: [<? echo $data14;?>]
					}, {
						name: 'HowTo',
						data: [<? echo $data1HowTo;?>]
					}],
			credits:{
				enabled:false
			}
				});
			});
			
		});
		
		$(function () {
			var chart4;
			$(document).ready(function() {
				chart4 = new Highcharts.Chart({
					chart: {
						renderTo: 'container4',
						type: 'line',
						marginRight: 400,
						marginBottom: 25
					},
					title: {
						text: 'Cause Page Views',
						x: -20 //center
					},
					subtitle: {
						text: 'Daily',
						x: -20
					},
					xAxis: {
						categories: [<? echo $days;?>]
					},
					yAxis: {
						title: {
							text: 'Page Views'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
								return '<b>'+ this.series.name +'</b><br/>'+
								this.x +': '+ this.y;
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -10,
						y: 100,
						borderWidth: 0
					},
					exporting: {
						buttons: 
						{ 
							exportButton: 
							{
								enabled:false
							},
							printButton: 
							{
								enabled:false
							}

						}
					},
					series: [<?echo $data18;?>],
			credits:{
				enabled:false
			}
				});
			});
			
		});
		$(function () {
    var chart5;
    $(document).ready(function() {
        chart5 = new Highcharts.Chart({
            chart: {
                renderTo: 'container5',
                type: 'column',
				marginRight: 150
            },
            title: {
                text: 'Device Usage',
				x: -40
            },
			subtitle: {
						text: 'Monthly',
						x: -40
			},
            xAxis: {
                categories: ['Desktop', 'Mobile Phone', 'Tablet']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Device Usage Percentage'
                },
                stackLabels: {
                    enabled: true,
                    style: {
						fontWeight: 'bold',
						color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -10,
				y: 100,
				
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
					if(this.series.name == 'iPhone')
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y +'% (' + <?echo $iphone;?> + ')<br/>'+
						'Total: '+ this.point.stackTotal + '% (' + <?echo $mobile;?> + ')';
					else if(this.series.name == 'iPod')	
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y +'% (' + <?echo $ipod;?> + ')<br/>'+
						'Total: '+ this.point.stackTotal + '% (' + <?echo $mobile;?> + ')';
					else if(this.series.name == 'BlackBerry')	
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y +'% (' + <?echo $blackberry;?> + ')<br/>'+
						'Total: '+ this.point.stackTotal + '% (' + <?echo $mobile;?> + ')';
					else if(this.series.name == 'Android')	
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y +'% (' + <?echo $android;?> + ')<br/>'+
						'Total: '+ this.point.stackTotal + '% (' + <?echo $mobile;?> + ')';
					else if(this.x == 'Desktop')		
							return '<b>'+ this.x +'</b><br/>'+
							this.series.name +': '+ this.y + '% (' + <?echo $desktop;?> + ')';
					else
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y + '% (' + <?echo $tablet;?> + ')';
                }
            },
			exporting: {
				buttons: 
				{ 
					exportButton: 
					{
						enabled:false
					},
					printButton: 
					{
						enabled:false
					}

				}
			},
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
				showInLegend: false,
                name: 'Total',
                data: [<?echo round(100*($desktop/$totalD), 2);?>, null, <? echo round(100*($tablet/$totalD), 2);?>]
            },{
                name: 'iPhone',
                data: [null, <?if($iphone != 0){echo round(100*($iphone/$totalD), 2);}else{echo 'null';}?>, null]
            }, {
                name: 'iPod',
                data: [null, <?if($ipod != 0){echo round(100*($ipod/$totalD), 2);}else{echo 'null';}?>, null]
            }, {
                name: 'Blackberry',
                data: [null, <?if($blackberry != 0){echo round(100*($blackberry/$totalD), 2);}else{echo 'null';}?>, null]
            }, {
                name: 'Android',
                data: [null, <?if($android != 0){echo round(100*($android/$totalD), 2);}else{echo 'null';}?>, null]
            }],
			credits:{
				enabled:false
			}
        });
    });
    
});
$(function () {
  var chart6;
    $(document).ready(function() {
        chart6 = new Highcharts.Chart({
            chart: {
                renderTo: 'container6',
                type: 'column',
				marginRight: 0
            },
            title: {
                text: 'Browser Usage',
				x: -40
            },
			subtitle: {
						text: 'Monthly',
						x: -40
			},
            xAxis: {
                categories: [
                    'Chrome',
                    'Firefox',
                    'Internet Explorer',
                    'Safari',
                    'Opera'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Browser Usage Percentage'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
			exporting: {
				buttons: 
				{ 
					exportButton: 
					{
						enabled:false
					},
					printButton: 
					{
						enabled:false
					}

				}
			},
            legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -10,
				y: 100,
				
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false,
				enabled: false
            },
            tooltip: {
                formatter: function() {
					if(this.x == 'Internet Explorer')
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y + '% (' + <?echo $ie;?> + ')';
					else if(this.x == 'Firefox')	
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y + '% (' + <?echo $firefox;?> + ')';
					else if(this.x == 'Chrome')	
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y + '% (' + <?echo $chrome;?> + ')';
					else if(this.x == 'Safari')	
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y + '% (' + <?echo $safari;?> + ')';
					else if(this.x == 'Opera')		
						return '<b>'+ this.x +'</b><br/>'+
						this.series.name +': '+ this.y + '% (' + <?echo $opera;?> + ')';
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: 'Usage',
                data: [
				{y:<? echo round(100*($chrome/$totalB), 2);?>, color: '#4572A7'}, 
				{y:<? echo round(100*($firefox/$totalB), 2);?>, color: '#AA4643'},
				{y:<? echo round(100*($ie/$totalB), 2);?>, color: '#89A54E'},
				{y:<? echo round(100*($safari/$totalB), 2);?>, color: '#80699B'},
				{y:<? echo round(100*($opera/$totalB), 2);?>, color: '#3D96AE'}
				]
            }
			],
			credits:{
				enabled:false
			}
        });
    });
    
});
$(function () {
    var chart7;
    $(document).ready(function() {
    	
    	// Radialize the colors
		Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
		// Build the chart
        chart7 = new Highcharts.Chart({
            chart: {
                renderTo: 'container7',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'International Viewership Spread'
            },
            tooltip: {
        	    //pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	//percentageDecimals: 2
				backgroundColor: 'rgba(255,255,255,1)',
				formatter: function() {
					if(this.point.name != 'Others')
					{
						return '<b>'+ this.point.name +'</b><br/>Viewership: '+ this.percentage.toFixed(2) +' %';;
					}
					else
						return "<b>"+ this.point.name +"</b><br/>" + <?echo '"'.$dataP1.'"';?>;
				}
			},
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
								return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                        }
                    }
                }
            },
			exporting: {
				buttons: 
				{ 
					exportButton: 
					{
						enabled:false
					},
					printButton: 
					{
						enabled:false
					}

				}
			},
            series: [{
                type: 'pie',
                name: 'International Viewership Spread',
                data: [<?echo $dataP;?>
                ]
            }],
			credits:{
				enabled:false
			}
        });
    });
    
});
$(function () {
    var chart8;
    $(document).ready(function() {
   
		// Build the chart
        chart8 = new Highcharts.Chart({
            chart: {
                renderTo: 'container8',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'United States Viewership Spread'
            },
            tooltip: {
        	    //pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	//percentageDecimals: 2
				backgroundColor: 'rgba(255,255,255,1)',
				formatter: function() {
					if(this.point.name != 'Others')
					{
						return '<b>'+ this.point.name +'</b><br/>Viewership: '+ this.percentage.toFixed(2) +' %';;
					}
					else
						return "<b>"+ this.point.name +"</b><br/>" + <?echo '"'.$dataP3.'"';?>;
				}
			},
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
								return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                        }
                    }
                }
            },
			exporting: {
				buttons: 
				{ 
					exportButton: 
					{
						enabled:false
					},
					printButton: 
					{
						enabled:false
					}

				}
			},
            series: [{
                type: 'pie',
                name: 'United States Viewership Spread',
                data: [<?echo $dataP2;?>
                ]
            }],
			credits:{
				enabled:false
			}
        });
    });
    
});
				</script>
	</head>
	<body>
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/modules/exporting.js"></script>

		<div id="container1" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
		<div id="container2" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
		<div id="container3" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
		<div id="container4" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
		<div id="container5" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
		<div id="container6" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
		<div id="container7" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
		<div id="container8" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	</body>
</html>
