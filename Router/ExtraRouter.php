<?php
namespace Axoloth\HerbertExtra\Router;


use Herbert\Framework\Router;

class ExtraRouter extends Router{
	
	private $router;
	
	public function __construct(){
		$this->router = herbert("router");
	}
	
	public function getRoutes(){
		return $this->router->routes['named'];
	}
	
	public function getMethods(){
		return parent::$methods;
	}
}