<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function jadi_tanggal($data){
	return date_format (date_create($data), 'Y-m-d');
}

function jadi_tanggal_akhir($bulan,$tahun){
	return date_format (date_create($tahun.'-'.$bulan.'-01'), 'Y-m-t');
}

function tgl_indo($day){
 $day = explode ("-",$day);
 switch ($day[1]){
 case 1:
 $day[1] = "Januari";
 break;
 case 2:
 $day[1] = "Februari";
 break;
 case 3:
 $day[1] = "Maret";
 break;
 case 4:
 $day[1] = "April";
 break;
 case 5:
 $day[1] = "Mei";
 break;
 case 6:
 $day[1] = "Juni";
 break;
 case 7:
 $day[1] = "Juli";
 break;
 case 8:
 $day[1] = "Agustus";
 break;
 case 9:
 $day[1] = "September";
 break;
 case 10:
 $day[1] = "Oktober";
 break;
 case 11:
 $day[1] = "November";
 break;
 case 12:
 $day[1] = "Desember";
 break; 
 }
 $day_indo = $day[2]." ".$day[1]." ".$day[0];
 return $day_indo;
}

function tgl_eng($day){
	$day = explode ("-",$day);
	switch ($day[1]){
	case 1:
	$day[1] = "January";
	break;
	case 2:
	$day[1] = "February";
	break;
	case 3:
	$day[1] = "March";
	break;
	case 4:
	$day[1] = "April";
	break;
	case 5:
	$day[1] = "May";
	break;
	case 6:
	$day[1] = "June";
	break;
	case 7:
	$day[1] = "July";
	break;
	case 8:
	$day[1] = "August";
	break;
	case 9:
	$day[1] = "September";
	break;
	case 10:
	$day[1] = "October";
	break;
	case 11:
	$day[1] = "November";
	break;
	case 12:
	$day[1] = "December";
	break; 
	}
	$day_indo = $day[2]." ".$day[1]." ".$day[0];
	return $day_indo;
   }   

function tgl_indo_terbalik($day){
 $day = explode ("-",$day);
 switch ($day[1]){
 case 1:
 $day[1] = "Januari";
 break;
 case 2:
 $day[1] = "Februari";
 break;
 case 3:
 $day[1] = "Maret";
 break;
 case 4:
 $day[1] = "April";
 break;
 case 5:
 $day[1] = "Mei";
 break;
 case 6:
 $day[1] = "Juni";
 break;
 case 7:
 $day[1] = "Juli";
 break;
 case 8:
 $day[1] = "Agustus";
 break;
 case 9:
 $day[1] = "September";
 break;
 case 10:
 $day[1] = "Oktober";
 break;
 case 11:
 $day[1] = "November";
 break;
 case 12:
 $day[1] = "Desember";
 break; 
 }
 $day_indo = $day[0]." ".$day[1]." ".$day[2];
 return $day_indo;
}

function tgl_indo_noday($day){
 $day = explode ("-",$day);
 switch ($day[1]){
 case 1:
 $day[1] = "Januari";
 break;
 case 2:
 $day[1] = "Februari";
 break;
 case 3:
 $day[1] = "Maret";
 break;
 case 4:
 $day[1] = "April";
 break;
 case 5:
 $day[1] = "Mei";
 break;
 case 6:
 $day[1] = "Juni";
 break;
 case 7:
 $day[1] = "Juli";
 break;
 case 8:
 $day[1] = "Agustus";
 break;
 case 9:
 $day[1] = "September";
 break;
 case 10:
 $day[1] = "Oktober";
 break;
 case 11:
 $day[1] = "November";
 break;
 case 12:
 $day[1] = "Desember";
 break; 
 }
 $day_indo = $day[1]." ".$day[0];
 return $day_indo;
}

function bulan($day){
 switch ($day){
 case 1:
 $day = "Januari";
 break;
 case 2:
 $day = "Februari";
 break;
 case 3:
 $day = "Maret";
 break;
 case 4:
 $day = "April";
 break;
 case 5:
 $day = "Mei";
 break;
 case 6:
 $day = "Juni";
 break;
 case 7:
 $day = "Juli";
 break;
 case 8:
 $day = "Agustus";
 break;
 case 9:
 $day = "September";
 break;
 case 10:
 $day = "Oktober";
 break;
 case 11:
 $day = "November";
 break;
 case 12:
 $day = "Desember";
 break; 
 }
 $day_indo = $day;
 return $day_indo;
}

function hari($day){
 switch ($day){
 case 'Mon':
 $day = "Senin";
 break;
 case 'Tue':
 $day = "Selasa";
 break;
 case 'Wed':
 $day = "Rabu";
 break;
 case 'Thu':
 $day = "Kamis";
 break;
 case 'Fri':
 $day = "Jum'at";
 break;
 case 'Sat':
 $day = "Sabtu";
 break;
 case 'Sun':
 $day = "Minggu";
 break;
 }
 $day_indo = $day;
 return $day_indo;
}

function tgl_indo_hari($day){
 $raw_hari = date_format(date_create($day), 'D');
 $hari = hari($raw_hari);

 $day = explode ("-",$day);
 switch ($day[1]){
 case 1:
 $day[1] = "Januari";
 break;
 case 2:
 $day[1] = "Februari";
 break;
 case 3:
 $day[1] = "Maret";
 break;
 case 4:
 $day[1] = "April";
 break;
 case 5:
 $day[1] = "Mei";
 break;
 case 6:
 $day[1] = "Juni";
 break;
 case 7:
 $day[1] = "Juli";
 break;
 case 8:
 $day[1] = "Agustus";
 break;
 case 9:
 $day[1] = "September";
 break;
 case 10:
 $day[1] = "Oktober";
 break;
 case 11:
 $day[1] = "November";
 break;
 case 12:
 $day[1] = "Desember";
 break; 
 }

 $day_indo = $hari.', '.$day[2]." ".$day[1]." ".$day[0];

 return $day_indo;
}

?>