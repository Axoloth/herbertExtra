<?php

if ( ! function_exists('getMyPluginDir')){

	function getMyPluginDir(){
		return realpath( __DIR__ .'..\..\..\..').'\\';
	}
}

if ( ! function_exists('getVendorDir')){

	function getVendorDir(){
		return getMyPluginDir().'vendor\\';
	}
}

if ( ! function_exists('getRessourceDir')){

	function getRessourceDir(){
		return getMyPluginDir().'\resources\\';
	}
}

if ( ! function_exists('getDefaultFormTheme')){

	function getDefaultFormTheme(){
		return '@HerbertExtra/form_div_layout.html.twig';
	}
}

if ( ! function_exists('getViewsDir')){

	function getViewsDir(){
		return getRessourceDir().'views\\';
	}
}

if ( ! function_exists('getHerbertExtraDir')){

	function getHerbertExtraDir(){
		return getVendorDir().'axoloth\herbertextra\\';
	}
}