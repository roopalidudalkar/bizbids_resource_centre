<?php
/**
 * 
 * NEWSLETTER FORM BY CONTACTUS.COM
 * 
 * Initialization Newsletter Defaut Form Placement View
 * @since 1.0 First time this was introduced into Newsletter Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2014 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140127
 * */
?>

<form method="post" action="admin.php?page=cUs_form_plugin" id="cUsNL_selectable" class="cus_versionform tab_version <?php echo ( strlen($cus_version) && $cus_version != 'tab') ? 'hidden' : ''; ?>" name="cUsNL_defaultformkey">
    <h3 class="form_title">Available Newsletter Forms</h3>
    <div class="pageselect_cont">
        <p>If you want use one of your default forms in all WordPress environment just select it as "Default" and will appear in you site.</p>
       

        <div class="loadingMessage def"></div><div class="advice_notice">Advice ....</div><div class="notice">Messages....</div>
        <ul class="selectable_pages defaultF">

            <?php
            /*
             * DEFAULT FORM TYPES
             * Render Forms Data
             */

            if ($cUsNL_API_getFormKeys) {
                $cUs_json = json_decode($cUsNL_API_getFormKeys);
                switch ($cUs_json->status) {
                    case 'success':
                        foreach ($cUs_json->data as $oForms => $oForm) {
                            if (cUsNL_allowedFormType($oForm->form_type)) {

                                //RE-ASSING DEFAULT FORM KEY
                                //$form_key = updateDefaultFormKey($oForm->form_key);
                                ?>

                                <li class="ui-widget-content <?php echo $oForm->form_type; ?>">
                                    <div class="page_title">
                                        <span class="name">Name: <strong><?php echo $oForm->form_name ?></strong></span>  | 
                                        <span class="key">Key: <?php echo $oForm->form_key; ?></span>
                                    </div>

                                    <div class="options">
                                        <input type="radio" name="defaultformkey[]" value="<?php echo $oForm->form_key; ?>" id="formkeyradio-<?php echo $oForm->form_id; ?>-1" class="setDefaulFormKey" <?php echo ($oForm->form_key == $form_key) ? 'checked' : '' ?> />
                                        <label class="setLabel label-<?php echo $oForm->form_id; ?>" for="formkeyradio-<?php echo $oForm->form_id; ?>-1" title="Set as Default, click to save"><?php echo ($oForm->form_key == $form_key) ? 'Default' : 'Set as Default' ?></label>
                                    </div>
                                </li>

                                <?php
                            }
                        }
                        break;
                } //endswitch;
            }
            ?>
        </ul>
    </div>
</form>

<form method="post" action="admin.php?page=cUs_form_plugin" id="cUsNL_button" class="cus_versionform tab_version <?php echo ( strlen($cus_version) && $cus_version != 'tab') ? 'hidden' : ''; ?>" name="cUsNL_button">

    <input type="hidden" class="tab_user" name="tab_user" value="1" />
    <input type="hidden" name="cus_version" value="tab" />
    <input type="hidden" value="settings" name="option" />

</form>