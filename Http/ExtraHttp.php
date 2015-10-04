<?php
namespace Axoloth\HerbertExtra\Http;

use Symfony\Component\HttpFoundation\Request;

class ExtraHttp{
	
	private $request;
	
	public function __construct(){
		$server = $_SERVER;
		if ('cli-server' === php_sapi_name()) {
			if (array_key_exists('HTTP_CONTENT_LENGTH', $_SERVER)) {
				$server['CONTENT_LENGTH'] = $_SERVER['HTTP_CONTENT_LENGTH'];
			}
			if (array_key_exists('HTTP_CONTENT_TYPE', $_SERVER)) {
				$server['CONTENT_TYPE'] = $_SERVER['HTTP_CONTENT_TYPE'];
			}
		}
		
		$this->request = new Request($_GET, $_POST, array(), $_COOKIE, $_FILES, $server);

	}
	
	
	public function getRequest(){
		return $this->request;
	}
}