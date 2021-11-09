<?php
function __addCss($css)
{
	$_SESSION['css_all_page'] = isset($_SESSION['css_all_page']) ? $_SESSION['css_all_page'] . $css : $css;
}
function __WriteCss()
{
	if (isset($_SESSION['css_all_page'])) {
		$css = $_SESSION['css_all_page'];
		$css = str_replace('<style>', '', $css);
		$css = str_replace('</style>', '', $css);
		$css = str_replace(PHP_EOL, '', $css);
		// $css = str_replace("\t", '', $css);
		// $css = str_replace("	", '', $css);
		$_SESSION['css_all_page'] = '';
		return $css;
	}
	return '';
}
