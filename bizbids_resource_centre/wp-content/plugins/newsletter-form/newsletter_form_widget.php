<?php

/**
 * 
 * NEWSLETTER FORM BY CONTACTUS.COM
 * 
 * Initialization Newsletter Form Widget Class from WP_Widget
 * @since 3.0 First time this was introduced into Newsletter Form Plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2013 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140311
 **/

//Contact Subscribe Box widget extend 
class cUsNL_newsletter_form_Widget extends WP_Widget {

	function cUsNL_newsletter_form_Widget() {
		$widget_ops = array( 
			'description' => __('Displays Newsletter Form by ContactUs.com', 'contactus_form')
		);
		$this->WP_Widget('cUsNL_newsletter_form_Widget', __('Newsletter Form by ContactUs.com', 'contactus_form'), $widget_ops);
	}

	function widget( $args, $instance ) {
		if (!is_array($instance)) {
			$instance = array();
		}
		ccUsNL_newsletter_form(array_merge($args, $instance));
	}
}
/*
* Method in charge to retrive ContactUs.com user's Default Form Key and render widget
* @param array $args Widget options 
* @since 3.0
* @return string HTML into the widget area
*/
function ccUsNL_newsletter_form($args = array()) {
    extract($args);
    $cUs_form_key = get_option('cUsNL_settings_form_key'); //get the saved form key
    
    if(strlen($cUs_form_key)){
        $xHTML  = '<div id="cUsNL_form_widget" style="width:100%;overflow:hidden;clear:both;min-height:250px;margin:10px auto;">';
        $xHTML .= '<script type="text/javascript" src="' . cUsNL_ENV_URL . $cUs_form_key . '/inline.js"></script>';
        $xHTML .= '</div>';
        
        echo $xHTML;
    }
}
