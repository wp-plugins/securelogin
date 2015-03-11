<?php
/**
 * Plugin Name: SecureLogin
 * Plugin URI:  www.way2web.nl
 * Description: Login form for SecureLogin
 * Version: 1.2
 * Author: Way2Web
 * Author URI: http://www.way2web.nl/
 * License: GPL2
 */
require_once("Bootstrap.php");

$bootstrap = new \Bootstrap();
register_activation_hook(__FILE__, array($bootstrap, 'activate'));
register_deactivation_hook(__FILE__, array($bootstrap, 'deactivate'));
$bootstrap->run();

