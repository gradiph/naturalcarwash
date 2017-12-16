<?php
function indo_date($date)
{
	$months = [
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember',
	];

	if(strlen($date) == 10)
	{
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);

		$indo_date = $day.' '.$months[$month].' '.$year;
	}
	else
	{
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);
		$hour = substr($date, 11, 2);
		$minute = substr($date, 14, 2);
		$second = substr($date, 17, 2);

		$indo_date = $day.' '.$months[$month].' '.$year.' '.$hour.'.'.$minute.'.'.$second;
	}

	return $indo_date;
}

function indo_short_date($date)
{
	$months = [
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember',
	];

	$year = substr($date, 0, 4);
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2);

	$indo_date = $day.' '.$months[$month].' '.$year;

	return $indo_date;
}

function indo_month($month)
{
	$months = [
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember',
	];

	$year = substr($month, 0, 4);
	$month = substr($month, 5, 2);

	$indo_month = $months[$month].' '.$year;

	return $indo_month;
}
?>
