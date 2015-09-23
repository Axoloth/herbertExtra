<?php

// Add the twig extensions for playing with WP theme parts...
herbert('Twig_Environment')->addExtension(new TestHerbert\TwigExtension\WordpressTemplateExtension());

// set constants for SymfonyForm
define('DEFAULT_FORM_THEME', 'form_div_layout.html.twig');
define('VENDOR_DIR', realpath(__DIR__ . '/../vendor'));
define('VENDOR_FORM_DIR', VENDOR_DIR . '/symfony/form');
define('VENDOR_VALIDATOR_DIR', VENDOR_DIR . '/symfony/validator');
define('VENDOR_TWIG_BRIDGE_DIR', VENDOR_DIR . '/symfony/twig-bridge');
define('VIEWS_DIR', realpath(__DIR__ . '/../reources/views'));
