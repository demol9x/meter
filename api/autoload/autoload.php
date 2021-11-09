<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

function formatMoney($mobey)
{
	return ($mobey < 100 && $mobey > (int)$mobey) ? number_format($mobey, 2, ',', '.') : number_format(floor($mobey), 0, ',', '.');
}

function formatCoin($coin)
{
	return ($coin > (int)$coin) ? number_format($coin, 2, ',', '.') : number_format($coin, 0, ',', '.');
}
