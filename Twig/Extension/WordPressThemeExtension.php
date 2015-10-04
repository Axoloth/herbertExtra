<?php
/**
 * (c) Axoloth - 2015
 * 
 * Twig extensions that allow to call WP part of template
 * in a twig view.
 * 
 * {{ header() }}
 * {{ sidebar('mySidebar') }}
 * {{ footer() }}
 * 
 */
namespace Axoloth\HerbertExtra\Twig\Extension;


class WordpressThemeExtension extends \Twig_Extension{

	public function getFunctions(){
	    return array(
	        'header' => new \Twig_SimpleFunction('header', array($this, 'header')),
	        'footer' => new \Twig_SimpleFunction('footer', array($this, 'footer')),
	        'sidebar' => new \Twig_SimpleFunction('sidebar', array($this, 'sidebar'))
	    );
	}

	public function header($string = null){
		return get_header( $string );
	}

	public function footer($string = null){
		return get_footer( $string );
	}

	public function sidebar($string = null){
		return dynamic_sidebar( $string );
	}

	public function getName(){
		return 'template';
	}
}