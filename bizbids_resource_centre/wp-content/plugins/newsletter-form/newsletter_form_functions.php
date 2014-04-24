<?php

/**
 * 
 * NEWSLETTER FORM BY CONTACTUS.COM
 * 
 * Initialization Newsletter Form Functions
 * @since 3.1 First time this was introduced into Newsletter Form Plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2013 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140311
 **/

$cus_dirbase = trailingslashit(basename(dirname(__FILE__)));
$cus_dir = trailingslashit(WP_PLUGIN_DIR) . $cus_dirbase;
$cus_url = trailingslashit(WP_PLUGIN_URL) . $cus_dirbase;

//CONFIG VARS
require_once( $cus_dir . 'newsletter_form_conf.php');

//CUS API OBJECT
if (!class_exists('cUsComAPI_NL')) {
    require_once( cUsNL_DIR . 'libs/cusAPI.class.php');
}
//AJAX REQUEST HOOKS
require_once( cUsNL_DIR . 'controllers/newsletter_form_ajx_request.php');

// WIDGET CALL
include_once( cUsNL_DIR . 'newsletter_form_widget.php');
/*
* Method in charge to render widget into wp admin
* @since 1.0
* @return string Return Html into wp admin
*/
function cUsNL_register_widgets() {
    register_widget('cUsNL_newsletter_form_Widget');
}
add_action('widgets_init', 'cUsNL_register_widgets');

/* -----------------------CONTACTUS.COM--------------------------- */

if (!function_exists('cUsNL_admin_header')) {
   /*
    * Method in charge to render plugin js libraries and css
    * @since 1.0
    * @return string Return Html into wp admin header
    */
    function cUsNL_admin_header() {
        
        global $current_screen;

        if ($current_screen->id == 'toplevel_page_cUsNL_form_plugin') {
            
            wp_enqueue_style( 'cUsNL_Styles', plugins_url('assets/style/cUsNL_style.css', __FILE__), false, '1' );
            wp_enqueue_style( 'colorbox', plugins_url('assets/scripts/colorbox/colorbox.css', __FILE__), false, '1' );
            wp_enqueue_style( 'bxslider', plugins_url('assets/scripts/bxslider/jquery.bxslider.css', __FILE__), false, '1' );
            wp_enqueue_style( 'wp-jquery-ui-dialog' );

            wp_register_script( 'cUsNL_Scripts', plugins_url('assets/scripts/cUsNL_scripts.js?pluginurl=' . dirname(__FILE__), __FILE__), array('jquery'), '4.0', true);
            wp_localize_script( 'cUsNL_Scripts', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
            wp_register_script( 'cUsNL_cats_module', plugins_url('assets/scripts/cUsNL_cats_module.js?pluginurl=' . dirname(__FILE__), __FILE__), array('jquery'), '1.0', true);
            wp_register_script( 'colorbox', plugins_url('assets/scripts/colorbox/jquery.colorbox-min.js', __FILE__), array('jquery'), '1.4.33', true);
            wp_register_script( 'bxslider', plugins_url('assets/scripts/bxslider/jquery.bxslider.js', __FILE__), array('jquery'), '4.1.1', true);

            wp_enqueue_script( 'jquery' ); //JQUERY WP CORE
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-accordion' );
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'jquery-ui-button' );
            wp_enqueue_script( 'jquery-ui-selectable' );
            wp_enqueue_script( 'jquery-ui-dialog' );
            wp_enqueue_script( 'jquery-ui-tooltip' );
            wp_enqueue_script( 'colorbox' );
            wp_enqueue_script( 'bxslider' );
            wp_enqueue_script( 'cUsNL_Scripts' );
            wp_enqueue_script( 'cUsNL_cats_module' );
            
            //CONTACT FORM SUPPORT CHAT
            wp_register_script( 'cUsNL_support_chat', '//cdn.contactus.com/cdn/forms/MTEzZGIxMTI4MmQ,/contactus.js', array(), '2.7', true);
            wp_enqueue_script( 'cUsNL_support_chat' );
            
        }
        
    }

} 
add_action('admin_enqueue_scripts', 'cUsNL_admin_header'); // cUsNL_admin_header hook
//END CONTACTUS.COM PLUGIN STYLES CSS

//CONTACTUS.COM ADD FORM TO PLUGIN PAGE

// Add option page in admin menu
if (!function_exists('cUsNL_admin_menu')) {

    function cUsNL_admin_menu() {
        add_menu_page('Newsletter Form by ContactUs.com ', 'Newsletter Form', 'edit_themes', 'cUsNL_form_plugin', 'cUsNL_menu_render', plugins_url("assets/style/images/favicon.gif", __FILE__));
    }

}
add_action('admin_menu', 'cUsNL_admin_menu'); // cUsNL_admin_menu hook

/*
* Method in charge to render link to Help Center into wp plugins manager page
* @since 1.0
* @return string Return Html plugins manager page
*/
function cUsNL_plugin_links($links, $file) {
    $plugin_file = 'newsletter-form/newsletter_form.php';
    if ($file == $plugin_file) {
        $links[] = '<a target="_blank" style="color: #42a851; font-weight: bold;" href="http://help.contactus.com/">' . __("Get Support", "cus_plugin") . '</a>';
    }
    return $links;
} 
add_filter('plugin_row_meta', 'cUsNL_plugin_links', 10, 2);


/*
* Method in charge to create the setting button in plugins manager page
* @since 3.0
* @return string Return Html plugins manager page
*/
function cUsNL_action_links($links, $file) {
    $plugin_file = 'newsletter-form/newsletter_form.php';
    //make sure it is our plugin we are modifying
    if ($file == $plugin_file) {
        $settings_link = '<a href="' . admin_url('admin.php?page=cUsNL_form_plugin') . '">' . __('Settings', 'cus_plugin') . '</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
} 
add_filter("plugin_action_links", 'cUsNL_action_links', 10, 4);

//Display the validation errors and update messages

/*
 * Admin notices
 */

function cUsNL_admin_notices() {
    settings_errors();
} 
add_action('admin_notices', 'cUsNL_admin_notices');

/*
 * Method in charge to validate allowed form types
 * @since 3.2
 * @param string $form_type Form type to validate
 * @return boolean
 */
function cUsNL_allowedFormType($form_type){
    $aryAllowedFormTypes = array('contact_us', 'newsletter', 'donation', 'appointment');
    if( in_array($form_type, $aryAllowedFormTypes) ){
        return TRUE;
    }else{
        return FALSE;
    }
}

/*
 * Method in charge to update default form key
 * @since 4.01
 * @param string $form_key Form Key to validate
 * @return null
 */
function cUsNL_updateDefaultFormKey($form_key) {
    $default_form_key = get_option('cUsNL_settings_form_key');
    if ($default_form_key != $form_key) {
        update_option('cUsNL_settings_form_key', $form_key);
    }
    $form_key = get_option('cUsNL_settings_form_key');
    
    return $form_key;
}

/*
 * IMPORTANT
* Method in charge to render the contactus.com javascript snippet into the default wp theme
* @since 1.0
* @return string Return Html javascript snippet
*/
function cUsNL_JS_into_html() {
    if (!is_admin()) {
        
        $pageID = get_the_ID();
        $pageSettings = get_post_meta( $pageID, 'cUsNL_FormByPage_settings', false );
        
        if(is_array($pageSettings) && !empty($pageSettings)){ //NEW VERSION 3.0
            
            $boolTab        = $pageSettings[0]['tab_user'];
            $cus_version    = $pageSettings[0]['cus_version'];
            $form_key       = $pageSettings[0]['form_key'];
            
            if($cus_version == 'tab'){
                
                $userJScode = '<script type="text/javascript" src="' . cUsNL_ENV_URL . $form_key . '/contactus.js"></script>';
            
                echo $userJScode;
            }
            
        }else{ //PREVIOUS VERSIONS 2.5
            
            $formOptions    = get_option('cUsNL_settings_FORM');//GET THE NEW FORM OPTIONS
            $getTabPages    = get_option('cUsNL_settings_tabpages');
            
            $getInlinePages = get_option('cUsNL_settings_inlinepages');
            $form_key       = get_option('cUsNL_settings_form_key');
            $boolTab = $formOptions['tab_user'];
            $cus_version = $formOptions['cus_version'];
            
            if(!empty($getTabPages) && in_array('home', $getTabPages) && is_home() ){
                $getHomePage         = get_option('cUsNL_HOME_settings');
                $boolTab        = $getHomePage['tab_user'];
                $cus_version    = $getHomePage['cus_version'];
                $form_key       = $getHomePage['form_key'];
            }
            
            $userJScode = '<script type="text/javascript" src="' . cUsNL_ENV_URL . $form_key . '/contactus.js"></script>';

            //the theme must have the wp_footer() function included
            //include the contactUs.com JS before the </body> tag
            switch ($cus_version) {
                case 'tab':
                    if (strlen($form_key) && $boolTab){
                        echo $userJScode;
                    }
                    break;
                case 'selectable':
                    if (strlen($form_key) && is_array($getTabPages) && in_array($pageID, $getTabPages)){
                        echo $userJScode;
                    }
                    break;
            }
        }
    }
}
add_action('wp_footer', 'cUsNL_JS_into_html'); // ADD JS BEFORE BODY TAG

//SHORTCODE MANAGMENT ROUTINES
/*
 * IMPORTANT
* Method in charge to read wp shortcode and render the javascript snippet into the default wp theme
* @since 1.0
* @return string Return Html javascript snippet
*/
function cUsNL_shortcode_handler($aryFormParemeters) {
    
    $cUsNL_credentials = get_option('cUsNL_settings_userCredentials'); //GET USERS CREDENTIALS V3.0 API 1.9
    
    if(!empty($cUsNL_credentials)){ 
        
        $pageID = get_the_ID();
        $pageSettings = get_post_meta( $pageID, 'cUsNL_FormByPage_settings', false );
        $inlineJS_output = '';

        if(is_array($pageSettings) && !empty($pageSettings)){ //NEW VERSION 3.0

            $boolTab        = $pageSettings[0]['tab_user'];
            $cus_version    = $pageSettings[0]['cus_version'];
            $form_key       = $pageSettings[0]['form_key'];

            if(strlen($formkey)) $form_key = $formkey;

            if ($cus_version == 'inline' || $cus_version == 'selectable') {
               $inlineJS_output = '<div style="min-height: 300px; min-width: 340px; clear:both;"><script type="text/javascript" src="' . cUsNL_ENV_URL . $form_key . '/inline.js"></script></div>';
            }

        }elseif(is_array($aryFormParemeters)){

            if($aryFormParemeters['version'] == 'tab'){
                $Fkey = $aryFormParemeters['formkey'];
                update_option('cUsNL_settings_FormKey_SC', $Fkey);
                do_action('wp_footer', $Fkey);
                add_action('wp_footer', 'cUsNL_shortcodeTab'); // ADD JS BEFORE BODY TAG
            }else{
                $inlineJS_output = '<div style="min-height: 300px; min-width: 340px; clear:both;"><script type="text/javascript" src="'. cUsNL_ENV_URL  . $aryFormParemeters['formkey'] . '/inline.js"></script></div>';
            }

        }else{   //OLDER VERSION < 2.5 //UPDATE 
            $formOptions    = get_option('cUsNL_settings_FORM');//GET THE NEW FORM OPTIONS
            $form_key       = get_option('cUsNL_settings_form_key');
            $cus_version    = $formOptions['cus_version'];

            if ($cus_version == 'inline' || $cus_version == 'selectable') {
                $inlineJS_output = '<div style="min-height: 300px; min-width: 340px; clear:both;"><script type="text/javascript" src="' . cUsNL_ENV_URL . $form_key . '/inline.js"></script></div>';
            }

        }

        return $inlineJS_output;
    }else{
        
        return '<p>Newsletter Form by ContactUs.com user Credentials Missing . . . <br/>Please Login Again <a href="'.get_admin_url().'admin.php?page=cUsNL_form_plugin" target="_blank">here</a>, Thank You.</p>';
        
    }
}

/*
 * Method in charge to render the javascript snippet into the default wp theme like a tab
 * @since 1.0
 * @param array $Args Array with all shortcode options
 * @return string
 */
function cUsNL_shortcodeTab($Args) {
    
    $form_key = get_option('cUsNL_settings_FormKey_SC');
    
    if ( !is_admin() && strlen($form_key) ) {
        $userJScode = '<script type="text/javascript" src="' . cUsNL_ENV_URL . $form_key . '/contactus.js"></script>';
        echo $userJScode;
    }
}

/*
 * Method in charge to add the shortcode into the page content by page ID
 * @since 1.0
 * @param int $inline_req_page_id WP Page ID
 * @return array
 */
function cUsNL_inline_shortcode_add($inline_req_page_id) {
    
    if($inline_req_page_id != 'home'){
        $oPage = get_page($inline_req_page_id);
        $pageContent = $oPage->post_content;
        $pageContent = $pageContent . "\n[show-newsletter-form]";
        $aryPage = array();
        $aryPage['ID'] = $inline_req_page_id;
        $aryPage['post_content'] = $pageContent;
        return wp_update_post($aryPage);
    }
}

/*
 * Method in charge to remove page setting to all wp pages content by page ID
 * @since 1.0
 * @return null
 */
function cUsNL_page_settings_cleaner() {
    $aryPages = get_pages();
    foreach ($aryPages as $oPage) {
        delete_post_meta($oPage->ID, 'cUsNL_FormByPage_settings');//reset values
        cUsNL_inline_shortcode_cleaner_by_ID($oPage->ID); //RESET SC
    }
}
/*
 * Method in charge to remove the shortcode into the all wp pages content by page ID
 * @since 1.0
 * @return null
 */
function cUsNL_inline_shortcode_cleaner() {
    $aryPages = get_pages();
    foreach ($aryPages as $oPage) {
        $pageContent = $oPage->post_content;
        $pageContent = str_replace('[show-newsletter-form]', '', $pageContent);
        $aryPage = array();
        $aryPage['ID'] = $oPage->ID;
        $aryPage['post_content'] = $pageContent;
        wp_update_post($aryPage);
    }
}
/*
 * Method in charge to remove the shortcode into the wp page content by page ID
 * @since 1.0
 * @return null
 */
function cUsNL_inline_shortcode_cleaner_by_ID($inline_req_page_id) {
    $oPage = get_page( $inline_req_page_id );
    
    $pageContent = $oPage->post_content;
    $pageContent = str_replace('[show-newsletter-form]', '', $pageContent);
    $aryPage = array();
    $aryPage['ID'] = $oPage->ID;
    $aryPage['post_content'] = $pageContent;
    
    wp_update_post($aryPage);
    
}

add_shortcode("show-newsletter-form", "cUsNL_shortcode_handler"); //[show-newsletter-form]

//SHORTCODES

/*
 *  UPDATE NOTICES
 * 
 * Method in charge to display update notice into wp admin header
 * @since 1.0
 * @return string Html
 */
/* Display a notice that can be dismissed */
add_action('admin_notices', 'cUsNL_update_admin_notice');
function cUsNL_update_admin_notice() {
	
        global $current_user ;
        $user_id = $current_user->ID;
        
        $aryUserCredentials = get_option('cUsNL_settings_userCredentials');
        $form_key           = get_option('cUsNL_settings_form_key');
        $cUs_API_Account    = $aryUserCredentials['API_Account'];
        $cUs_API_Key        = $aryUserCredentials['API_Key'];
        
	if ( ! get_user_meta($user_id, 'cUsNL_ignore_notice') && !strlen($cUs_API_Account) && !strlen($cUs_API_Key) && strlen($form_key)) {
            echo '<div class="updated"><p>';
            printf(__('Newsletter Form has been updated!. Please take time to activate your new features <a href="%1$s">here</a>. | <a href="%2$s">Hide Notice</a>'), 'admin.php?page=cUsNL_form_plugin', '?cUsNL_ignore_notice=0');
            echo "</p></div>";
	}
        
}
add_action('admin_init', 'cUsNL_nag_ignore');
function cUsNL_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        if ( isset($_GET['cUsNL_ignore_notice']) && '0' == $_GET['cUsNL_ignore_notice'] ) {
             add_user_meta($user_id, 'cUsNL_ignore_notice', 'true', true);
	}
}

/*
 * --------------------------------------------------------------
 * 
 * UNISTALL ROUTINES
 * 
 * Method in charge to remove all plugin options and settings
 * @since 1.0
 * @return null
 */
if (!function_exists('cUsNL_plugin_db_uninstall')) {

    function cUsNL_plugin_db_uninstall() {

        $cUsNL_api = new cUsComAPI_NL();
        $cUsNL_api->resetData(); //RESET DATA
        
        cUsNL_page_settings_cleaner();
        
    }
    
}
register_uninstall_hook(__FILE__, 'cUsNL_plugin_db_uninstall');