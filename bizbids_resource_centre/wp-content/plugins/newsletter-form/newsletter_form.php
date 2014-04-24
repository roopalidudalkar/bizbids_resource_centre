<?php
/*
  Plugin Name: Newsletter Form by ContactUs
  Version: 1.0
  Plugin URI:  http://help.contactus.com/hc/en-us/sections/200369993-Newsletter-Form-Plugin-by-ContactUs-com
  Description: Newsletter Sign Up Form by ContactUs.com Plugin for Wordpress.
  Author: contactus.com
  Author URI: http://www.contactus.com/
  License: GPLv2 or later
 */

/*
  Copyright 2014  ContactUs.com  ( email: support@contactuscom.zendesk.com )
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

//INCLUDE WP HOOKS ACTIONS & FUNCTIONS
require_once('newsletter_form_functions.php');

/*
 * Method in charge to render plugin layout
 * @since 1.0
 * @return string Render HTML layout into WP admin
 */
if (!function_exists('cUsNL_menu_render')) {
    function cUsNL_menu_render() {
        
        $cUsNL_api          = new cUsComAPI_NL(); //CONTACTUS.COM API
        $aryUserCredentials = get_option('cUsNL_settings_userCredentials'); //get the values, wont work the first time
        $options            = get_option('cUsNL_settings_userData'); //get the values, wont work the first time
        $old_options        = get_option('contactus_settings'); //GET THE OLD OPTIONS
        $formOptions        = get_option('cUsNL_settings_FORM');//GET THE NEW FORM OPTIONS
        $form_key           = get_option('cUsNL_settings_form_key');
        $default_deep_link  = get_option('cUsNL_settings_default_deep_link_view');
        $cus_version        = $formOptions['cus_version'];
        $boolTab            = $formOptions['tab_user'];
        $cUs_API_Account    = $aryUserCredentials['API_Account'];
        $cUs_API_Key        = $aryUserCredentials['API_Key'];
        
        if(!strlen($form_key)) $form_key = $old_options['form_key'];
        if(!strlen($cus_version)) $cus_version = $old_options['cus_version'];
        if(!strlen($boolTab)) $boolTab = $old_options['tab_user'];
        
        
        ?>

        <div id="dialog-message"></div>
        <div class="plugin_wrap">
            
            <div class="cUsNL_header">
                
                <h2><?php echo cUsNL_PLUGINNAME; ?> <span> by</span><a href="http://www.contactus.com/" target="_blank"><img src="<?php echo plugins_url('assets/style/images/header-logo.png', __FILE__) ;  ?>"/></a> </h2>
                
                <div class="social_shares">
                    <a class="setLabels" href="https://www.facebook.com/ContactUscom" target="_blank" title="Follow Us on Facebook for new product updates"><img src="<?php echo plugins_url('assets/style/images/cu-facebook-m.png', __FILE__) ;  ?> " alt="Follow Us on Facebook for new product updates"/></a>
                    <a class="setLabels" href="https://plus.google.com/u/0/117416697174145120376" target="_blank" title="Follow Us on Google+"><img src="<?php echo plugins_url('assets/style/images/cu-googleplus-m.png', __FILE__) ;  ?> " /></a>
                    <a class="setLabels" href="http://www.linkedin.com/company/2882043" target="_blank" title="Follow Us on LinkedIn"><img src="<?php echo plugins_url('assets/style/images/cu-linkedin-m.png', __FILE__) ;  ?> " /></a>
                    <a class="setLabels" href="https://twitter.com/ContactUsCom" target="_blank" title="Follow Us on Twitter"><img src="<?php echo plugins_url('assets/style/images/cu-twitter-m.png', __FILE__) ;  ?> " /></a>
                    <a class="setLabels" href="http://www.youtube.com/user/ContactUsCom" target="_blank" title="Find tutorials on our Youtube channel"><img src="<?php echo plugins_url('assets/style/images/cu-youtube-m.png', __FILE__) ;  ?> " alt="Find tutorials on our Youtube channel" /></a>
                </div>
            </div>
            
            <div class="cUsNL_formset">
                <div class="cUsNL_preloadbox"><div class="cUsNL_loadmessage"><span class="loading"></span></div></div>
                <div id="cUsNL_tabs">
                    <ul>
                        <?php
                        /*
                        * CHECK USER LOGIN STATUS strlen($cUs_API_Account)
                        * @since 1.0
                        */  
                        ?>
                        
                        <?php if ( !strlen($form_key) ){ ?><li><a href="#tabs-1">Newsletter Form</a></li><?php } ?>
                        <?php if ( strlen($form_key) && strlen($cUs_API_Account) ){ ?><li><a href="#tabs-1">Form Placement</a></li><?php } ?>
                        <?php if ( strlen($form_key) && strlen($cUs_API_Account) ){ ?><li><a href="#tabs-2">Form Settings</a></li><?php } ?>
                        <?php if ( strlen($form_key) && strlen($cUs_API_Account) ){ ?><li><a href="#tabs-3">Shortcodes</a></li><?php } ?>
                        <?php if ( strlen($form_key) && strlen($cUs_API_Account) ){ ?><li class="gotohelp"><a href="http://help.contactus.com/hc/en-us/sections/200369993-Newsletter-Form-Plugin-by-ContactUs-com" target="_blank">Documentation</a></li><?php } ?>
                        <?php if ( strlen($form_key) && strlen($cUs_API_Account) ){ ?><li><a href="#tabs-4">Account</a></li><?php } ?>
                        <?php if ( strlen($form_key) && strlen($cUs_API_Account) ){ ?><li class="gotohelp"><a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo $cUs_API_Key; ?>&confirmed=1" target="_blank" rel="toDash" class="goToDashTab">Form Control Panel</a></li><?php } ?>
                    </ul>

                    <?php
                    /*
                    * USER LOGIN STATUS : NOT LOGGED
                    * SHOW LOGIN OR SIGNUP BUTTONS 
                    * @since 1.0
                    */
                    if (!strlen($form_key)){
                        
                        global $current_user;
                        get_currentuserinfo();
                        
                        ?>
                        <div id="tabs-1">
                            
                            <div class="left-content">
                                
                                <div class="first_step">
                                    <h2>Are You Already a ContactUs.com User?</h2>
                                    <button id="cUsNL_yes" class="btn" type="button" ><span>Yes</span> Set Up My Form</button>
                                    <button id="cUsNL_no" class="btn mc_lnk"><span>No</span>Signup Free Now</button>
                                    <p>The Newsletter Form by ContactUs.com is designed for existing ContactUs.com users. If you are not yet a Newsletter Form user, click on the "No, Signup Free Now" button above.</p>
                                </div>
                                
                                <div id="cUsNL_settings">

                                    <div class="loadingMessage"></div><div class="advice_notice">Advices....</div><div class="notice">Ok....</div>
                                    
                                    <?php
                                    
                                        if( !$cUsNL_api->_isCurl() ){ ?>
                                            <div class="advice_notice_curl">
                                                <p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com.</a></p>
                                                <p>Error: cURL is NOT installed on this server.</a></p>
                                            </div>
                                        <?php }
                                        
                                    ?>
                                    
                                    <?php
                                    /*
                                    * LOGIN FORM
                                    * @since 1.0
                                    */
                                        //if( $cUsNL_api->_isCurl() )
                                            require_once( cUsNL_DIR . 'views/newsletter-login-form.php');
                                    ?>
                                    
                                    <?php
                                    /*
                                    * SINGUP FORM - SIGNUP WIZARD
                                    * @since 1.0
                                    */
                                        //if( $cUsNL_api->_isCurl() )
                                        require_once( cUsNL_DIR . 'views/newsletter-signup-form.php');
                                    ?>

                                </div>
                                <div class="contaus_features">
                                    <div class="col-md-12 why-contactuscom">
                                        <h3 class="lb_title feat_box">What do you get with a ContactUs.com account?</h3>
                                        <div class="row"><div class="col-md-6 "><div class="panel"><div class="text-center"><img alt="" src="https://www.contactus.com/wp-content/uploads/2013/11/1383815658_app_48.png" /></div><h4 class="heading">Create beautiful, conversion-optimized forms to engage your users and customers.</h4><p>Choose from one of our standard, conversion-optimized design templates for Newsletter Forms and signup forms. Premium users of ContactUs.com can unlock customized, premium form designs.</p></div></div><div class="col-md-6"><div class="panel"><div class="text-center"><img alt="" src="https://www.contactus.com/wp-content/uploads/2013/11/1383816749_Setup.png" /></div><h4 class="heading">Easily set-up and customize your forms.</h4><p>All ContactUs.com tabs and forms start with simple and effective designs. You can also customize your call-to-actions, button text, confirmation page messaging, add your business information (for Newsletter Forms), social media links and even business hours!</p></div></div></div><div class="row"><div class="col-md-6"><div class="panel"><div class="text-center"><img alt="" src="https://www.contactus.com/wp-content/uploads/2013/11/1383817424_graph.png" /></div><h4 class="heading">Gain actionable intelligence on your online marketing with integrated web analytics.</h4><p>Track how leads got to your site, and what information they read or viewed before contacting you. Where your leads have been will give you actionable intelligence on where they are going.</p></div></div><div class="col-md-6 "><div class="panel"><div class="text-center"><img alt="" src="https://www.contactus.com/wp-content/uploads/2013/11/1383817662_docs_cloud_connect.png" /></div><h4 class="heading">Seamless integration with 3rd-party software.</h4><p>Use ContactUs.com as your gateway to other great CRM and marketing tools. Automatically deliver your form submissions for MailChimp, Constant Contact, iContact, Zendesk, Zoho CRM, Google Docs and many other web services. Use extensions such as WordPress plugins to easily install on your site!</p></div></div></div>
                                    </div>
                                </div>
                                
                            </div><!-- // TAB LEFT -->
                            
                            <div class="right-content">
                                <?php
                                /*
                                 * SIDEBAR VIDEO & SUPPORT
                                 * @since 1.0
                                 */
                                    include( cUsNL_DIR . 'views/newsletter-sidebar-video.php');
                                ?>
                            </div><!-- // TAB RIGHT -->

                        </div> <!-- // TAB 1 -->
                        
                    <?php }else{
                        
                        global $current_user;
                        get_currentuserinfo();   

                        //API CREDENTIALAS STORED
                        if (strlen($cUs_API_Account)) {
                            
                            /*
                            * Get Forms Data // all FORM TYPES
                            */
                            $cUsNL_API_getFormKeys = $cUsNL_api->getFormKeysData($cUs_API_Account, $cUs_API_Key); //api hook;
                            
                            $default_deep_link = $cUsNL_api->parse_deeplink ( $default_deep_link );
                            if( !strlen($default_deep_link) ){
                                $default_deep_link = $cUsNL_api->getDefaultDeepLink( $cUs_API_Account, $cUs_API_Key ); // get a default deeplink
                                update_option('cUsNL_settings_default_deep_link_view', $default_deep_link );
                            }
                            
                            $acount = $default_deep_link.'?pageID=7';
                            $reports = $default_deep_link.'?pageID=12';
                            $upgrade = $default_deep_link.'?pageID=82';
                            $createform = $default_deep_link.'?pageID=81&id=0&do=addnew&formType=';
                            
                    ?>    
                        
                    <div id="tabs-1">
                            
                            <div class="left-content">
                                <h2>Forms Placement & Position</h2>
                                
                                <div class="versions_options">
                                    
                                    <div class="button_set_tabs_fp">
                                        <button class="form_version btn_tab tab_button <?php echo ( $cus_version == 'tab' )?'green':'gray'; ?>" value="tab_version" <?php echo ( $cus_version == 'tab' )?'disabled="disabled"':''; ?>>DEFAULT FORM</button> 
                                        <button class="form_version btn_tab custom <?php echo ( $cus_version == 'selectable' )?'green':'gray'; ?>" value="select_version" <?php echo ( $cus_version == 'selectable' )?'disabled="disabled"':''; ?> >CUSTOM</button>
                                        <span class="sc_message">Do you want use Shortcodes? <br/>Go to <a href="#tabs-3" class="goto_shortcodes">Shortcode Instructions</a></span>
                                    </div>
                                    
                               </div>
                                
                               <div id="message" class="updated fade notice_success"></div>
                               <div class="advice_notice"></div>
                               <div class="loadingMessage"></div>
                                
                               <div>    
                                    <p>If you just want a simple Newsletter Form on all pages, use your default Newsletter Form.</p>
                                    <p>When you activate custom form Settings, your default form is deactivated automatically. Select the pages you want the form to be shown in, and customize the form for every page. If you already clicked on custom, click the default form button to reinstate default settings.</p>
                                    
                               </div>
                               
                               <div class="cUsNL_DefatulFP">
                                    <?php
                                     /*
                                      * FORM PLACEMENT DEFAULT
                                      * @since 1.0
                                      */
                                         require_once( cUsNL_DIR . 'views/newsletter-formplace-default.php');
                                     ?>
                               </div>
                               
                               <div class="cUsNL_CustomFP">
                                    <?php
                                     /*
                                      * FORM PLACEMENT DEFAULT
                                      * @since 1.0
                                      */
                                         require_once( cUsNL_DIR . 'views/newsletter-formplace-custom.php');
                                     ?>
                                </div>
                                
                            </div><!-- // TAB LEFT -->
                            
                            <div class="right-content">
                                <?php
                                /*
                                 * SIDEBAR VIDEO & SUPPORT
                                 * @since 1.0
                                 */
                                    include( cUsNL_DIR . 'views/newsletter-sidebar-video.php');
                                ?>
                            </div><!-- // TAB RIGHT -->
                            
                        </div>
                        
                        <div id="tabs-2">
                            
                                <div class="left-content">
                                    <h2>Configure your form settings</h2>
                                    
                                    <div class="versions_options versions_options_fs">
                                        
                                        <p>Manage your forms here. You have a default Newsletter Form. You can create more forms Newsletter forms by clicking the "Add a New Newsletter Form" butotn bellow.</p>
                                        
                                        <div class="advice_notice">Advices....</div>
                                        
                                        <?php
                                        /*
                                        * FORM TYPES RENDER
                                        * @since 1.0
                                        */
                                           require_once( cUsNL_DIR . 'views/newsletter-formsettings-forms.php');
                                        ?>
                                        
                                        <!-- NEWSLETTER FORMS-->
                                        <div class="gray_box">
                                            <h3 class="form_title">Newsletter Signup Form <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($createform)); ?>newsletter" target="_blank">Add a New Newsletter Form <span>+</span></a></h3>
                                           
                                                <?php
                                                /*
                                                 * Get Forms Data // newsletter FORM TYPES
                                                 */
                                               
                                                echo cUsNL_renderFormType('newsletter', $cUsNL_API_getFormKeys, $createform);
                                                
                                                ?>
                                        </div>
                                        <!-- NEWSLETTER FORMS-->

                                    </div>
                                </div>
                            
                                <div class="right-content">
                                    <?php
                                    /*
                                     * SIDEBAR SOCIAL & SHARE
                                     * @since 1.0
                                     */
                                        include( cUsNL_DIR . 'views/newsletter-sidebar-share.php');
                                    ?>
                                </div><!-- // TAB RIGHT -->
                            
                        
                        </div>
                        
                        <div id="tabs-3">
                            <div class="left-content">
                                
                                <h2>WordPress Shortcodes and Snippets</h2>
                                <div>
                                    <div class="terminology_c">
                                        <h4>Copy this code into your template, post, page to place the form wherever you want it.  If you use this advanced method, do not select any pages from the page section on the form settings or you may end up with the form displayed on your page twice.</h4>
                                        <h4>Note: You can find the Form Key alongside form thumbnails in the form settings tab.</h4>
                                        <hr/>
                                        <ul class="hints">
                                            <li><b>Inline</b>
                                                <br/>WP Shortcode:<br/> <code> [show-newsletter-form formkey="FORM KEY HERE" version="inline"] </code>
                                                <br/>Php Snippet:<br/> <code>&#60;&#63;php echo do_shortcode('[show-newsletter-form formkey="FORM KEY HERE" version="inline"]'); &#63;&#62;</code>
                                            </li>
                                            <li><b>Tab</b>
                                                <br/>WP Shortcode:<br/> <code> [show-newsletter-form formkey="FORM KEY HERE" version="tab"] </code>
                                                <br/>Php Snippet:<br/> <code>&#60;&#63;php echo do_shortcode('[show-newsletter-form formkey="FORM KEY HERE" version="tab"]'); &#63;&#62;</code>
                                            </li>
                                            <li><b>Widget Tool</b><br/><p>Go to <a href="widgets.php"><b>Widgets here </b></a> and drag the ContactUs.com widget into one of your widget areas</p></li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="right-content">
                                <?php
                                /*
                                 * SIDEBAR SOCIAL & SHARE
                                 * @since 1.0
                                 */
                                    include( cUsNL_DIR . 'views/newsletter-sidebar-share.php');
                                ?>
                            </div><!-- // TAB RIGHT -->
                            
                        </div>
                        
                        <div id="tabs-4">
                            
                            <div class="left-content">
                                <h2>Your ContactUs.com Account</h2>
                                
                                <div class="button_set_tabs">
                                    <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($reports)); ?>" target="_blank" class="deep_link_action_tab rep">Contact Management</a>
                                    <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($acount)); ?>" target="_blank" class="deep_link_action_tab ac">Account Information</a>
                                    <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($upgrade)); ?>" target="_blank" class="deep_link_action_tab ac">Upgrade Account</a>
                                </div>
                                
                                <div class="iRecomend">
                                    <form method="post" action="admin.php?page=cUs_malchimp_plugin" id="cUsNL_data" name="cUsNL_sendkey" class="steps" onsubmit="return false;">
                                        
                                        <table class="form-table">
                                            
                                            <?php if( @strlen($options['fname']) || @strlen($options['lname']) || @strlen($current_user->first_name) ) { ?>
                                            <tr>
                                                <th><label class="labelform">Name</label><br>
                                                <td>
                                                    <span class="cus_names">
                                                        <?php echo ( @strlen($options['fname']) || @strlen($options['lname']) ) ? @$options['fname'] . " " . $options['lname'] : $current_user->first_name . " " . $current_user->last_name ; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <th><label class="labelform">Email</label><br>
                                                <td><span class="cus_email"><?php echo @$options['email'];?></span></td>
                                            </tr>

                                            <tr><th></th>
                                                <td>
                                                    <hr/>
                                                    <input id="logoutbtn" class="btn orange cUsNL_LogoutUser" value="Unlink Account" type="button">
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                
                            </div>
                            
                            <div class="right-content">
                                <?php
                                    /*
                                     * SIDEBAR SOCIAL & SHARE
                                     * @since 1.0
                                     */
                                        include( cUsNL_DIR . 'views/newsletter-sidebar-share.php');
                                    ?>
                            </div><!-- // TAB RIGHT -->
                            
                        </div>
                        <?php }
                        
                        } ?>
            </div>
        </div>

        <?php
    } //END IF

} // END IF FUNCTION RENDER
