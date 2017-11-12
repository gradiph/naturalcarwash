<?php
function indo_currency($number)
{
	$indo_currency = number_format($number, 0, ',', '.');

	return $indo_currency;
}
?>
