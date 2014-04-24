<?php
/**
 * 
 * NEWSLETTER FORM BY CONTACTUS.COM
 * 
 * Initialization Newsletter Custom Form Placement View
 * @since 1.0 First time this was introduced into Newsletter Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2014 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140127
 * */
?>

<?php
if (!function_exists('cUsNL_renderFormType')) {
    /*
     * Method in charge to render form types
     * @param string $form_type Form type to validate
     * @since 1.0
     * @return string Return Html into wp admin header
     */

    function cUsNL_renderFormType($form_Type, $cUsNL_API_getFormKeys, $createform) {

        $cUsNL_api = new cUsComAPI_NL(); //CONTACTUS.COM API
        $aryUserCredentials = get_option('cUsNL_settings_userCredentials'); //get the values, wont work the first time
        $cUs_API_Account = $aryUserCredentials['API_Account'];
        $cUs_API_Key = $aryUserCredentials['API_Key'];
        
        if ($cUsNL_API_getFormKeys) {

            //$form_Type = 'contact_us';

            $cUs_json = json_decode($cUsNL_API_getFormKeys);
            switch ($cUs_json->status) {
                case 'success':
                    ?>
                    <div class="user_form_templates">
                        <?php
                        $nCF = 1;
                        foreach ($cUs_json->data as $oForms => $oForm) {

                            if (cUsNL_allowedFormType($oForm->form_type) && $oForm->form_type == $form_Type) {
                                $formID = $oForms;
                                ?>

                                <div class="form_templates_box">
                                    <h3><?php echo $oForm->form_name ?></h3>
                                    <div class="template-thumb">
                                        <span class="thumb"><img src="<?php echo $oForm->template_desktop_form_thumbnail ?>" class="form_thumb_<?php echo $formID; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" width="130" /></span>
                                        <span class="tab_thumb"><img src="<?php echo $oForm->template_desktop_tab_thumbnail ?>" class="tab_thumb_<?php echo $formID; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" /></span>
                                    </div>
                                    <div class="form_key"><b>FORM KEY:</b> <?php echo $oForm->form_key ?></div>
                                    <div class="form_zoom setLabels" data-id="<?php echo $oForm->form_id; ?>" title="View form settings"><div class="fs">Form Settings</div><div class="zoom"></div></div>
                                </div>

                                <div class="form_description hidden" id="form_description_<?php echo $oForm->form_id; ?>">

                                    <h2>Form Name: <?php echo $oForm->form_name ?></h2>
                                    <?php if (strlen($oForm->website_url)) { ?><p><b>Website URL:</b> <?php echo $oForm->website_url ?></p> <?php } ?>
                                    
                                    <div class="form-template">
                                        <span class="thumb"><img src="<?php echo $oForm->template_desktop_form_thumbnail ?>" class="form_thumb_<?php echo $formID; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" /></span>
                                        <p><b>Form Template:</b> <?php echo $oForm->template_desktop_form ?></p>
                                    </div>
                                    <div class="form-template">
                                        <span class="thumb"><img src="<?php echo $oForm->template_mobile_form_thumbnail ?>"  /></span>
                                        <p><b>Mobile Form Template:</b> <?php echo $oForm->template_mobile_form ?></p>
                                    </div>
                                    <div class="form-template">
                                        <span class="thumb"><img src="<?php echo $oForm->template_desktop_tab_thumbnail ?>" class="tab_thumb" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" /></span>
                                        <p><b>Tab Template:</b> <?php echo $oForm->template_desktop_tab ?></p>
                                    </div>
                                    
                                    <div class="form_templates_tools">
                                        <h4>Instructions on how to build short codes and theme snippets <a href="javascript:;" class="blue_link" onclick="jQuery('#cUsNL_tabs').tabs({active: 2})"> Here. </a></h4>
                                        <h3>Form Tools</h3>
                                        <div>
                                            <div class="Template_Contact_Form">
                                                <div class="button_set">
                                                    <?php
                                                    $default_deep_link = $oForm->deep_link_view;
                                                    $ablink = $cUsNL_api->parse_deeplink($default_deep_link);
                                                    $ablink = $ablink . '?pageID=90&do=view&formID=' . $oForm->form_id;
                                                    ?>

                                                    <?php if ($form_Type == 'contact_us') { ?><a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($default_deep_link)); ?>%26expand=14%26newTemplate=genericTemplate2" target="_blank" class="btn lightblue abutton cf setLabels" title="Add Custom Form Fields on a ContactUs.com Custom Form to Make It Your Own">Custom Fields</a> <?php } ?>
                                                    <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($default_deep_link)); ?>%26expand=1" target="_blank" class="btn lightblue abutton confF setLabels" title="For the use your own hyperlink/event. You can create your own link to open the form instead. Automatically open form or on Exit Intent">Events & Triggers</a>
                                                    <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($default_deep_link)); ?>%26expand=4" target="_blank" class="btn lightblue abutton confF setLabels" title="Our beautiful form templates are built by designers who have extensive experience in generating online web leads for websites. Change It From Here.">Configure Form</a>
                                                    <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($default_deep_link)); ?>%26expand=5" target="_blank" class="btn lightblue abutton ct setLabels" title="They’re designed by our web conversion rate experts to catch the attention of those looking to take the next step in contacting you. Change It From Here.">Configure Tab</a>
                                                    <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($ablink)); ?>" target="_blank" class="btn lightblue abutton AbTest setLabels" title="ContactUs.com lets websites simply set-up and run A/B experiments with the sole purpose of increase your website’s engagements.">A/B Test</a>                                                                                               
                                                   
                                                </div>
                                                <h4>Instructions on how to use Delayed Pop-up &  Exit Intent Triggers</h4>
                                                <ul class="hints" style="margin-left:50px;">
                                                    <li><a href="http://www.contactus.com/page-load-triggers/" target="_blank"> Delayed Pop-up Triggers </a></li>
                                                    <li><a href="http://www.contactus.com/exit-intent-triggers/" target="_blank"> Exit Intent Triggers </a></li>
                                                </ul>
                                                
                                                <hr />
                                                <hr />
                                                <p><strong>NOTE:</strong> You will be redirected to your ContactUs.com admin panel to edit your form configurations.</p>

                                            </div>
                                        </div>

                                        <h3>Delivery Options / 3rd Party services</h3>
                                        <div>
                                            <div class="delivery_options">
                                                <div class="button_set">
                                                    <?php $default_deep_link = $oForm->deep_link_view; ?>
                                                    <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo $cUs_API_Key; ?>&confirmed=1&redir_url=<?php echo urlencode(trim($default_deep_link)); ?>%26expand=103" target="_blank" rel="toDash" class="btn lightblue abutton setLabels" title="Integration with popular CRM and email marketing software services">3rd Party Integrations</a>                                                                                                
                                                </div>
                                                <p>How to manage or configure your software integration services? <a href="http://help.contactus.com/hc/en-us/articles/200676336-Configuring-Lead-Deliveries-to-3rd-Party-Services" class="blue_link" target="_blank">Click here</a></p>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <?php
                                $nCF++;
                                //END IF ALLOWED TYPES
                            }
                        }
                        ?>
                    </div>
                    <?php
                    break;
            } //endswitch;

            if ($nCF <= 1) {
                ?>
                <a href="<?php echo cUsNL_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo urlencode(trim($createform)) . $form_Type; ?>" target="_blank" class="deep_link_action">Add New Form <span>+</span></a>
                <?php
            }
        }
    }

}
?>

<script>
    //PLUGIN cUsNL_myjq ENVIROMENT (cUsNL_myjq)
    var cUsWoof_myjq = jQuery.noConflict();

    //ON READY DOM LOADED
    cUsWoof_myjq(document).ready(function($) {

        try {
            $('.form_zoom').click(function() {
                var form_id = $(this).attr('data-id');
                var el_id = "#form_description_" + form_id;
                $.colorbox({inline: true, width: "65%", open: true, href: el_id, transition: 'fade', className: 'forms_box',
                    onClosed: function() {
                        $(el_id).hide();
                    },
                    onOpen: function() {
                        $(el_id).show();
                    }
                });

                console.log(el_id);
            });
        } catch (err) {
            console.log(err);
        }

    });//ready
</script>