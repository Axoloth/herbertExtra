<?php

use Axoloth\HerbertExtra\Router\ExtraRouter;


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
		return '@HerbertExtra/bootstrap_3_layout.html.twig';
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


/**
 * Renvoi l'url correspondant à une route
 * $routeName doit etre former comme MonPluginName::MaRouteAlias
 * $methode : GET OU POST, (PUT et DELETE)
 * $arg : tableau de parametres en plus concatenes à l'url renvoyee, il faut que ces 
 * parametres correspondent au pattern de l'uri de la route
 * par exemple : si la route suivante existe: 
 * 
 * $router->get([
 *		'as'   => 'maRoute',
 *		'uri'  => '/urlDeMaRoute/{id}',
 *		'uses' => __NAMESPACE__ . '\Controllers\MonController@monAction'
 *	]);
 * 
 * getRouteUrl( 'MonPluginsName::maRoute', 'GET', ['id'=>1] )
 * 
 * renverra http://monDNS/urlDeMaRoute/1
 * 
 */
if ( ! function_exists('getRouteUrl')){

	function getRouteUrl( $routeName, $method, $args=null ){
		if (!isset($routeName)) return null;
		if (!isset($method)) return null;
		
		$method = strtoupper($method);
		if (!isset($method) || !in_array($method, ['GET','POST','DELETE','PUT'])){
			return null;
		}
		$router = new ExtraRouter();
		$route = null;
		$routes = $router->getRoutes();
		
		if ( ! isset($routes[$method . '::' . $routeName])){
			return null;
		}
		
		$route = $routes[$method . '::' . $routeName];
				
		$matches = [];
		preg_match_all('/{([\w\d]+)}/', $uri = $route['uri'], $matches);
		foreach ($matches[0] as $id => $match){
			$uri = preg_replace('/' . preg_quote($match) . '/', array_get($args, $matches[1][$id], $match), $uri, 1);
		}
		
		return home_url() . '/' . $uri;
	}
}
