<?php
/**
 * 
 * NEWSLETTER FORM BY CONTACTUS.COM
 * 
 * Initialization Newsletter Signup Form View
 * @since 1.0 First time this was introduced into Newsletter Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2014 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140127
 * */
/*
 * SINGUP FORM - SIGNUP WIZARD - STEP 1
 * @since 1.0
 */
?>

<form method="post" action="admin.php?page=cUs_form_plugin" id="cUsNL_userdata" name="cUsNL_userdata" class="steps step1" onsubmit="return false;">
    <h3 class="step_title">Register for your ContactUs.com Account</h3>

    <table class="form-table">
        <tr>
            <th><label class="labelform" for="cUsNL_first_name">First Name</label></th>
            <td><input type="text" class="inputform text" placeholder="First Name" name="cUsNL_first_name" id="cUsNL_first_name" value="<?php echo (isset($_POST['cUsNL_first_name']) && strlen($_POST['cUsNL_first_name'])) ? $_POST['cUsNL_first_name'] : $current_user->user_firstname; ?>" /></td>
        </tr>
        <tr>
            <th><label class="labelform" for="cUsNL_last_name">Last Name</label></th>
            <td><input type="text" class="inputform text" placeholder="Last Name" name="cUsNL_last_name" id="cUsNL_last_name" value="<?php echo (isset($_POST['cUsNL_last_name']) && strlen($_POST['cUsNL_last_name'])) ? $_POST['cUsNL_last_name'] : $current_user->user_lastname; ?>"/></td>
        </tr>
        <tr>
            <th><label class="labelform" for="cUsNL_email">Email</label></th>
            <td><input type="text" class="inputform text" placeholder="Email" name="cUsNL_email" id="cUsNL_email" value="<?php echo (isset($_POST['cUsNL_email']) && strlen($_POST['cUsNL_email'])) ? $_POST['cUsNL_email'] : $current_user->user_email; ?>"/></td>
        </tr>
        <tr>
            <th><label class="labelform" for="cUsNL_phone">Phone</label></th>
            <td><input type="text" class="inputform text" placeholder="Phone (optional)" name="cUsNL_phone" id="cUsNL_phone" value=""/></td>
        </tr>
        <tr>
            <th><label class="labelform" for="cUsNL_password">Password</label></th>
            <td><input type="password" class="inputform text" name="cUsNL_password" id="cUsNL_password" value=""/></td>
        </tr>
        <tr>
            <th><label class="labelform" for="cUsNL_password_r">Confirm Password</label></th>
            <td><input type="password" class="inputform text" name="cUsNL_password_r" id="cUsNL_password_r" value=""/></td>
        </tr>
        <tr>
            <th><label class="labelform" for="cUsNL_web">Website</label></th>
            <td><input type="text" class="inputform text" placeholder="Website (http://www.example.com)" name="cUsNL_web" id="cUsNL_web" value="http://<?php echo $_SERVER['HTTP_HOST']; ?>"/></td>
        </tr>
        <tr>
            <th></th><td>
                <input id="cUsNL_CreateCustomer" class="btn orange" value="Next >>" type="submit" />
                <div class="loadingMessage"></div>
            </td>
        </tr>
        <tr>
            <th></th><td>By creating a ContactUs.com account, you agree that: <b>a)</b> You have read and accepted our <a href="http://www.contactus.com/terms-of-service/" class="blue_link" target="_blank">Terms</a> and our <a href="http://www.contactus.com/privacy-security/" class="blue_link" target="_blank">Privacy Policy</a> and <b>b)</b> You may receive communications from <a href="http://www.contactus.com/" class="blue_link"  target="_blank">ContactUs.com</a></td>
        </tr>
    </table>
</form>


<?php
/*
 * SINGUP FORM - SIGNUP WIZARD - STEP 2 TEMPLATES
 * @since 1.0
 */
?>
<form method="post" action="admin.php?page=cUs_form_plugin" id="cUsNL_templates" name="cUsNL_templates" class="steps step2" onsubmit="return false;">
    <h3 class="step_title">Let's Create Your First Form</h3>

    <div class="signup_templates">
        <h4>Select your Form Template</h4>

        <div>
            <div class="terminology_c Template_Contact_Form form_templates">

                <div class="template_slider slider_forms template_slider_def">
                    <?php
                    /*
                     * GET FREE FORM TEMPLATES
                     */

                    $contacFormTemplates = $cUsNL_api->getTemplatesDataAll('newsletter', 'template_desktop_form');
                    $contacFormTemplates = json_decode($contacFormTemplates);
                    $contacFormTemplates = $contacFormTemplates->data;

                    if (is_array($contacFormTemplates)) {

                        foreach ($contacFormTemplates as $formTpl) {
                            if ($formTpl->free) {
                                ?>

                                <span class="tpl item template-form" rel="<?php echo $formTpl->id; ?>">
                                    <img src="<?php echo $formTpl->thumbnail; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $formTpl->name; ?>" />
                                    <span class="captions">
                                        <p>Form Name:<?php echo $formTpl->name; ?></p>
                                    </span>
                                    <span class="def_bak"></span>
                                </span>

                                <?php
                            }
                        }
                    }
                    ?>
                </div>

            </div>

            <script>
                jQuery('.template-form').click(function() {
                    jQuery('#Template_Desktop_Form').val(jQuery(this).attr('rel'));
                    jQuery('.slider_forms .item').removeClass('default');
                    jQuery(this).addClass('default');
                });
            </script>

        </div>
        <h4>Select your Tab Template</h4>
        <div>
            <div class="terminology_c Template_Contact_Form form_templates">

                <div class="template_slider slider_tabs template_slider_def">

                    <?php
                    /*
                     * GET FREE TAB TEMPLATES
                     */

                    $contacFormTabTemplates = $cUsNL_api->getTemplatesDataAll('newsletter', 'template_desktop_tab');
                    $contacFormTabTemplates = json_decode($contacFormTabTemplates);
                    $contacFormTabTemplates = $contacFormTabTemplates->data;

                    if (is_array($contacFormTabTemplates)) {

                        foreach ($contacFormTabTemplates as $formTpl) {
                            if ($formTpl->free) {
                                ?>

                                <span class="tpl item template-tab" rel="<?php echo $formTpl->id; ?>">
                                    <img src="<?php echo $formTpl->thumbnail; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $formTpl->name; ?>" />
                                    <span class="captions">
                                        <p>Tab Name:<?php echo $formTpl->name; ?></p>
                                    </span>
                                    <span class="def_bak"></span>
                                </span>

                                <?php
                            } //endif
                        } //endforeach
                    }
                    ?>

                </div>
            </div>

            <script>
                jQuery('.template-tab').click(function() {
                    jQuery('#Template_Desktop_Tab').val(jQuery(this).attr('rel'));
                    jQuery('.slider_tabs .item').removeClass('default');
                    jQuery(this).addClass('default');
                });
            </script>

        </div>

    </div> 
    <table class="form-table">
        <tr>
            <th></th><td><input id="cUsNL_SendTemplates" href="#cats_selection" class="btn orange" value="Create my account" type="submit" /></td>
        </tr>
        <tr>
            <th></th><td>By creating a ContactUs.com account, you agree that: <b>a)</b> You have read and accepted our <a href="http://www.contactus.com/terms-of-service/" class="blue_link" target="_blank">Terms</a> and our <a href="http://www.contactus.com/privacy-security/" class="blue_link" target="_blank">Privacy Policy</a> and <b>b)</b> You may receive communications from <a href="http://www.contactus.com/" class="blue_link"  target="_blank">ContactUs.com</a></td>
        </tr>
        <input type="hidden" value="" name="Template_Desktop_Form" id="Template_Desktop_Form" />
        <input type="hidden" value="" name="Template_Desktop_Tab" id="Template_Desktop_Tab" />
    </table>
</form>

<?php
global $current_user;
get_currentuserinfo();
?>

<!-- CATS SUBCATS AND GOALS -->
<div id="cats_container" style="display:none;">

    <div id="cats_selection">
        <div class="loadingMessage"></div><div class="advice_notice">Advices....</div><div class="notice">Ok....</div>
        <form action="/" onsubmit="return false;">

            <div id="customer-categories-box" class="questions-box">

                <div class="cc-headline">Hi <?php echo $current_user->user_login; ?></div>
                <img src="<?php echo plugins_url('../assets/style/images/contactus-users.png', __FILE__); ?>" class="user-graphic">
                <div class="cc-message">We’re working on new ways to personalize your account</div>
                <div class="cc-message-small">Please take 7 seconds to tell us about your website, which helps us identify the best tools for your needs:</div>

                <h4 class="cc-title" id="category-message">Select the Category of Your Website:</h4>

                <?php
                /*
                 * GET CATEGORIES AND SUBCATEGORIES
                 */
                $aryCategoriesAndSub = $cUsNL_api->getCategoriesSubs();

                if (is_array($aryCategoriesAndSub)) {
                    ?>
                    <ul id="customer-categories">
                        <?php foreach ($aryCategoriesAndSub as $category => $arySubs) { ?>

                            <li class="parent-category"><span data-maincat="<?php echo $category; ?>" id="<?php echo str_replace(' ', '-', $category); ?>" class="parent-title"><?php echo trim($category); ?></span>
                                <?php if (is_array($arySubs)) { ?>
                                    <ul class="sub-category">
                                        <?php foreach ($arySubs as $Sub) { ?>
                                            <li data-subcat="<?php echo $Sub; ?>"><span><?php echo trim($Sub); ?></span></li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>

                        <?php } ?>
                    </ul>
                <?php } ?>

                <div class="int-navigation">
                    <button class="btn next btn-skip">Skip</button>
                    <img src="<?php echo plugins_url('../assets/style/images/ajax-loader.gif', __FILE__); ?>" width="16" height="16" alt="Loading . . ." style="display:none; vertical-align:middle;" class="img_loader" />
                    <div class="next btn unactive" id="open-intestes">Next Question</div>
                </div>

            </div>

            <div id="user-interests-box" class="questions-box">
                <div class="cc-headline">Hi <?php echo $current_user->user_login; ?></div>
                <div class="cc-message">What are your goals for your ContactUs.com form?</div>

                <?php
                /*
                 * GET GOALS
                 */
                $aryGoals = $cUsNL_api->getGoals();

                if (is_array($aryGoals)) {
                    ?>
                    <ul id="user-interests">
                        <?php foreach ($aryGoals as $Goal) { ?>
                            <li data-goals="<?php echo trim($Goal); ?>" <?php if ($Goal === 'Other') { ?>id="other"<?php } ?>><span <?php if (strpos($Goal, 'to my email') !== false) { ?> class="grey" <?php } ?>><?php echo trim($Goal); ?></span></li>
                        <?php } ?>
                    </ul>
                <?php } ?>

                <div id="other-interest">Please tell us <input type="text" name="other" id="other_goal" value="" /></div>

                <div class="int-navigation">
                    <button class="btn next btn-skip">Skip</button>
                    <div class="next btn unactive btn-skip" id="save">Save Preferences</div>
                    <img src="<?php echo plugins_url('../assets/style/images/ajax-loader.gif', __FILE__); ?>" width="16" height="16" alt="Loading . . ." style="display:none; vertical-align:middle;" class="img_loader" />
                </div>

            </div>

            <!-- input the category and subcategory data -->
            <input type="hidden" value="" name="CU_category" id="CU_category" />
            <input type="hidden" value="" name="CU_subcategory" id="CU_subcategory" />
            <!-- <input type="hidden" value="" name="CU_goals" id="CU_goals" /> -->

            <div id="goals_added"></div>

        </form>
        <br /><br /><br />
    </div>
</div>
<!-- / CATS SUBCATS AND GOALS -->