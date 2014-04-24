<?php
/**
 * 
 * NEWSLETTER FORM BY CONTACTUS.COM
 * 
 * Initialization Newsletter Form Config File
 * @since 1.0 First time this was introduced into Newsletter Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2014 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140311
 **/

//PLUGIN NAME
$cUs_plug_name = 'Newsletter Form';

//DEBUG MODE OFF
error_reporting(0);
error_reporting(E_ERROR);

//DEBUG MODE ON
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$cus_dirbase = trailingslashit(basename(dirname(__FILE__)));
$cus_dir = trailingslashit(WP_PLUGIN_DIR) . $cus_dirbase;
$cus_url = trailingslashit(WP_PLUGIN_URL) . $cus_dirbase;

//LIVE ENVIROMENT
$cus_env_url = '//cdn.contactus.com/cdn/forms/';
$cus_par_url = 'https://admin.contactus.com/partners';
$cus_api_enviroment = 'https://api.contactus.com/api2.php';

//WP KEYS
$cus_api_ApiAccountKey = 'AC132f1ca7ff5040732b787564996a02b46cc4b58d';
$cus_api_ApiKey = 'cd690cf4f450950e857b417710b656923cf4b579';

//DEFINE GLOBAL ENVIROMENT VARS
define('cUsNL_DIR', $cus_dir);
define('cUsNL_URL', $cus_url);
define('cUsNL_ENV_URL', $cus_env_url);
define('cUsNL_PARTNER_URL', $cus_par_url);
define('cUsNL_API_ENV', $cus_api_enviroment);
define('cUsNL_API_ACC', $cus_api_ApiAccountKey);
define('cUsNL_API_AKY', $cus_api_ApiKey);
define('cUsNL_PLUGINNAME', $cUs_plug_name);