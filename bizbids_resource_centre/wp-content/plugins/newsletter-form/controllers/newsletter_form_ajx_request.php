<?php

// loginAlreadyUser handler function...
/*
 * Method in charge to login user via ajax post request vars
 * @since 1.0
 * @return array jSon encoded array
 */
add_action('wp_ajax_cUsNL_loginAlreadyUser', 'cUsNL_loginAlreadyUser_callback');
function cUsNL_loginAlreadyUser_callback() {
    
    $cUsNL_api = new cUsComAPI_NL();
    $cUs_email = $_REQUEST['email'];
    $cUs_pass = $_REQUEST['pass'];
    
    //API CALL TO getAPICredentials
    $cUsNL_API_credentials = $cUsNL_api->getAPICredentials($cUs_email, $cUs_pass); //api hook;
    
    if($cUsNL_API_credentials){
        $cUs_json = json_decode($cUsNL_API_credentials);
        
        //SWITCH API STATUS RESPONSE
        switch ( $cUs_json->status  ) {
            case 'success':
                
                $cUs_API_Account    = $cUs_json->api_account;
                $cUs_API_Key        = $cUs_json->api_key;
                
                if(strlen(trim($cUs_API_Account)) && strlen(trim($cUs_API_Key))){
                    
                    $aryUserCredentials = array(
                        'API_Account' => $cUs_API_Account,
                        'API_Key'     => $cUs_API_Key
                    );
                    update_option('cUsNL_settings_userCredentials', $aryUserCredentials);
                    
                    $cUsNL_API_getKeysResult = $cUsNL_api->getFormKeysData($cUs_API_Account, $cUs_API_Key); //api hook;
                    
                    $old_options = get_option('contactus_settings'); //GET THE OLD OPTIONS
                    
                    $cUs_jsonKeys = json_decode($cUsNL_API_getKeysResult);
                
                    if($cUs_jsonKeys->status == 'success' ){
                        
                        $postData = array( 'email' => $cUs_email, 'credential'    => $cUs_pass);
                        update_option('cUsNL_settings_userData', $postData);
                        
                        $cUsNL_deeplinkview = $cUsNL_api->get_deeplink( $cUs_jsonKeys->data );
                        
                        // get a default deeplink
                        update_option('cUsNL_settings_default_deep_link_view', $cUsNL_deeplinkview ); // DEFAULT FORM KEYS
                        
                        foreach ($cUs_jsonKeys->data as $oForms => $oForm) {
                            if ($oForm->default == 1){ //GET DEFAULT CONTACT FORM KEY
                               $defaultFormKey = $oForm->form_key;
                               $deeplinkview   = $oForm->deep_link_view;
                               $defaultFormId  = $oForm->form_id;
                               break;
                            }
                        } 
                            
                        if(!strlen($defaultFormKey)){
                                //echo 2; //NO ONE CONTACT FORM 
                                
                                $aryResponse = array(
                                    'status' => 2,
                                    'cUs_API_Account' 	=> $cUs_API_Account,
                                    'cUs_API_Key' 	=> $cUs_API_Key,
                                    'deep_link_view'	=> $cUsNL_deeplinkview
                                );
                                
                               
                        }else if(empty($old_options)){
                            
                            $aryFormOptions = array('tab_user' => 1,'cus_version' => 'tab'); //DEFAULT SETTINGS / FIRST TIME
                            
                            update_option('cUsNL_settings_FORM', $aryFormOptions );//UPDATE FORM SETTINGS
                            update_option('cUsNL_settings_form_key', $defaultFormKey);//DEFAULT FORM KEYS
                            update_option('cUsNL_settings_form_keys', $cUs_jsonKeys); // ALL FORM KEYS
                            update_option('cUsNL_settings_form_id', $defaultFormId); // DEFAULT FORM KEYS
                            update_option('cUsNL_settings_default_deep_link_view', $deeplinkview); // DEFAULT FORM KEYS
                            
                            $aryResponse = array('status' => 1);
                            
                        }else{
                            
                            //MIGRATION PROCESS
                            //FROM previous 2.0 versions
                            
                            if(strlen($old_options['form_key'])){
                               
                                update_option('cUsNL_settings_FORM', $old_options );//UPDATE FORM SETTINGS
                                
                                $aryTabPages = get_option('contactus_settings_tabpages');
                                $aryInlinePages = get_option('contactus_settings_inlinepages');
                                
                                update_option('cUsNL_settings_form_key', $old_options['form_key']);//DEFAULT FORM KEYS
                                
                                if(!empty($aryTabPages) && is_array($aryTabPages)){
                                    
                                    update_option( 'cUsNL_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
                                    
                                    foreach ($aryTabPages as $pageID){
                                        
                                        $aryFormOptions = array( //LOAD OLD PAGE SETTINGS / FIRST TIME
                                            'tab_user'          => 1,
                                            'form_key'          => $old_options['form_key'],   
                                            'cus_version'       => 'tab'
                                        );

                                        if($pageID != 'home'){
                                            update_post_meta($pageID, 'cUsNL_FormByPage_settings', $aryFormOptions);//SAVE DATA ON POST TYPE PAGE METAS
                                        }else{
                                            update_option('cUsNL_HOME_settings', $aryFormOptions );//UPDATE FORM SETTINGS 
                                        }
                                        
                                    } 
                                    
                                }
                                    
                                
                                if(!empty($aryInlinePages) && is_array($aryInlinePages)){
                                    
                                    update_option( 'cUsNL_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
                                
                                    foreach ($aryInlinePages as $pageID){
                                        
                                        $aryFormOptions = array( //LOAD OLD PAGE SETTINGS / FIRST TIME
                                            'tab_user'          => 0,
                                            'form_key'          => $old_options['form_key'],   
                                            'cus_version'       => 'inline'
                                        );

                                        if($pageID != 'home'){
                                            update_post_meta($pageID, 'cUsNL_FormByPage_settings', $aryFormOptions);//SAVE DATA ON POST TYPE PAGE METAS
                                        }else{
                                            update_option('cUsNL_HOME_settings', $aryFormOptions );//UPDATE FORM SETTINGS 
                                        }
                                        
                                    }
                                }
                                    
                                $aryResponse = array('status' => 1);
                                
                            }
                            
                            
                        } 

                            //echo 1;
                        
                    }else{
                        $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                    } 
                    
                }else{
                    $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                }
                
                break;

            case 'error':
                $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                break;
        }
    }
    
    echo json_encode($aryResponse);
    
    die();
}


// cUsNL_verifyCustomerEmail handler function...
/*
 * Method in charge to verify if the email exist via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsNL_verifyCustomerEmail', 'cUsNL_verifyCustomerEmail_callback');
function cUsNL_verifyCustomerEmail_callback() {
    
    if      ( !strlen(filter_input(INPUT_POST, 'fName',FILTER_SANITIZE_STRING)) ){      echo 'Missing First Name, is required field';      die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'lName',FILTER_SANITIZE_STRING)) ){      echo 'Missing Last Name, is required field';       die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'Email',FILTER_VALIDATE_EMAIL)) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'website')) ){    echo 'Missing Website, is required field';         die();
    }else{
        
        $cUsNL_api = new cUsComAPI_NL(); //CONTACTUS.COM API
        
        $postData = array(
            'fname' => filter_input(INPUT_POST, 'fName',FILTER_SANITIZE_STRING),
            'lname' => filter_input(INPUT_POST, 'lName',FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'Email',FILTER_VALIDATE_EMAIL),
            'phone' => filter_input(INPUT_POST, 'Phone', FILTER_SANITIZE_NUMBER_INT),
            'credential' => filter_input(INPUT_POST, 'credential'),
            'website' => filter_input(INPUT_POST, 'website')
        );

        $cUsNL_API_EmailResult = $cUsNL_api->verifyCustomerEmail(filter_input(INPUT_POST, 'Email',FILTER_VALIDATE_EMAIL)); //EMAIL VERIFICATION
        if($cUsNL_API_EmailResult) {
            $cUsNL_jsonEmail = json_decode($cUsNL_API_EmailResult);
            
            switch ($cUsNL_jsonEmail->result){
                case 0 :
                    //echo 'No Existe';
                    echo 1;
                    update_option('cUsNL_settings_userData', $postData);
                    break;
                case 1 :
                    //echo 'Existe';
                    echo 2;//ALREDY CUS USER
                    delete_option('cUsNL_settings_userData');
                    break;
            }
            
        }else{
            echo 'Unfortunately there has being an error during the application, please try again';
            exit();
        }
         
    }
    
    die();
}


// cUsNL_createCustomer handler function...
/*
 * Method in charge to create a contactus.com user via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsNL_createCustomer', 'cUsNL_createCustomer_callback');
function cUsNL_createCustomer_callback() {
    
    $cUsNL_userData = get_option('cUsNL_settings_userData'); //get the saved user data
    
    if      ( !strlen($cUsNL_userData['fname']) ){      echo 'Missing First Name, is required field';      die();
    }elseif  ( !strlen($cUsNL_userData['lname']) ){      echo 'Missing Last Name, is required field';       die();
    }elseif  ( !strlen($cUsNL_userData['email']) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen($cUsNL_userData['website']) ){    echo 'Missing Website, is required field';         die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'Template_Desktop_Form',FILTER_SANITIZE_STRING)) ){    echo 'Missing Form Template';         die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'Template_Desktop_Tab',FILTER_SANITIZE_STRING)) ){    echo 'Missing Tab Template';         die();
    }else{
        
        $cUsNL_api = new cUsComAPI_NL(); //CONTACTUS.COM API
        
        $postData = array(
            'fname' => $cUsNL_userData['fname'],
            'lname' => $cUsNL_userData['lname'],
            'email' => $cUsNL_userData['email'],
            'website' => $cUsNL_userData['website'],
            'phone' => preg_replace('/[^0-9]+/i', '', $cUsNL_userData['phone']),
            'Template_Desktop_Form' => filter_input(INPUT_POST, 'Template_Desktop_Form',FILTER_SANITIZE_STRING),
            'Template_Desktop_Tab' => filter_input(INPUT_POST, 'Template_Desktop_Tab',FILTER_SANITIZE_STRING),
            'Main_Category' => filter_input(INPUT_POST, 'CU_category',FILTER_SANITIZE_STRING),
            'Sub_Category' => filter_input(INPUT_POST, 'CU_subcategory',FILTER_SANITIZE_STRING),
            'Goals' => filter_input(INPUT_POST, 'CU_goals',FILTER_SANITIZE_STRING)
        );
        
        $cUsNL_API_result = $cUsNL_api->createCustomer($postData, $cUsNL_userData['credential']);
        if($cUsNL_API_result) {

            $cUs_json = json_decode($cUsNL_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    
                    echo 1;//GREAT
                    update_option('cUsNL_settings_form_key', $cUs_json->form_key ); //finally get form key form contactus.com // SESSION IN
                    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
                        'tab_user'          => 1,
                        'cus_version'       => 'tab'
                    ); 
                    update_option('cUsNL_settings_FORM', $aryFormOptions );//UPDATE FORM SETTINGS
                    update_option('cUsNL_settings_userData', $postData);
                    
                    $cUs_API_Account    = $cUs_json->api_account;
                    $cUs_API_Key        = $cUs_json->api_key;
                    
                    $aryUserCredentials = array(
                        'API_Account' => $cUs_API_Account,
                        'API_Key'     => $cUs_API_Key
                    );
                    update_option('cUsNL_settings_userCredentials', $aryUserCredentials);
                    
                    // ********************************
                    // get here the default deeplink after creating customer
                    $cUsNL_API_getKeysResult = $cUsNL_api->getFormKeysData($cUs_API_Account, $cUs_API_Key); //api hook;
                    
                    $cUs_jsonKeys = json_decode( $cUsNL_API_getKeysResult );
                    $cUsNL_deeplinkview = $cUsNL_api->get_deeplink( $cUs_jsonKeys->data );
                    // get the default contact form deeplink
                    if( strlen( $cUsNL_deeplinkview ) ){
                        update_option('cUsNL_settings_default_deep_link_view', $cUsNL_deeplinkview ); // DEFAULT FORM KEYS
                    }
                    // save the form id for this donation new user
                    update_option( 'cUsNL_settings_form_id', $cUs_jsonKeys->data[0]->form_id );

                break;

                case 'error':

                    if($cUs_json->error == 'Email exists'){
                        echo 2;//ALREDY CUS USER
                        //$cUsNL_api->resetData(); //RESET DATA
                    }else{
                        //ANY ERROR
                        echo $cUs_json->error;
                        //$cUsNL_api->resetData(); //RESET DATA
                    }
                    
                break;


            }
            
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsNL_api->resetData(); //RESET DATA
        }
        
         
    }
    
    die();
}


// LoadDefaultKey handler function...
/*
 * Method in charge to set default form key by user via ajax post request vars
 * @since 2.0
 * @return array jSon encoded array
 */
add_action('wp_ajax_cUsNL_LoadDefaultKey', 'cUsNL_LoadDefaultKey_callback');
function cUsNL_LoadDefaultKey_callback() {
    
    $cUsNL_api = new cUsComAPI_NL();
    $cUsNL_userData = get_option('cUsNL_settings_userData'); //get the saved user data
    $cUs_email = $cUsNL_userData['email'];
    $cUs_pass = $cUsNL_userData['credential'];
    
    $cUsNL_API_result = $cUsNL_api->getFormKeysData($cUs_email, $cUs_pass); //api hook;
    if($cUsNL_API_result){
        $cUs_json = json_decode($cUsNL_API_result);

        switch ( $cUs_json->status  ) {
            case 'success':
                
                foreach ($cUs_json->data as $oForms => $oForm) {
                    if ($oForms !='status' && $oForm->form_type == 0 && $oForm->default == 1){//GET DEFAULT CONTACT FORM KEY
                       $defaultFormKey = $oForm->form_key;
                    }
                }
                
                update_option('cUsNL_settings_form_key', $defaultFormKey); 
                
                echo 1;
                break;

            case 'error':
                echo $cUs_json->error;
                //$cUsNL_api->resetData(); //RESET DATA
                break;
        }
    }
    
    die();
}

// cUsNL_setDefaulFormKey handler function...
/*
 * Method in charge to set default form key in all WP environment via ajax post request vars
 * @since 4.0.1
 * @return atring Status value array
 */
add_action('wp_ajax_cUsNL_setDefaulFormKey', 'cUsNL_setDefaulFormKey_callback');
function cUsNL_setDefaulFormKey_callback() {
    
    if(isset($_REQUEST['formKey'])){
       update_option('cUsNL_settings_form_key', $_REQUEST['formKey']);
       echo 1;//GREAT
    }
    
    die();
}

// cUsNL_createCustomer handler function...
/*
 * Method in charge to update user form templates via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsNL_UpdateTemplates', 'cUsNL_UpdateTemplates_callback');
function cUsNL_UpdateTemplates_callback() {
    
    $cUsNL_userData = get_option('cUsNL_settings_userData'); //get the saved user data
    
    if      ( !strlen($cUsNL_userData['email']) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Form']) ){    echo 'Missing Form Template';         die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Tab']) ){    echo 'Missing Tab Template';         die();
    }else{
        
        $cUsNL_api = new cUsComAPI_NL(); //CONTACTUS.COM API
        $form_key       = get_option('cUsNL_settings_form_key');
        $postData = array(
            'email' => $cUsNL_userData['email'],
            'credential' => $cUsNL_userData['credential'],
            'Template_Desktop_Form' => $_REQUEST['Template_Desktop_Form'],
            'Template_Desktop_Tab' => $_REQUEST['Template_Desktop_Tab']
        );
        
        $cUsNL_API_result = $cUsNL_api->updateFormSettings($postData, $form_key);
        if($cUsNL_API_result) {

            $cUs_json = json_decode($cUsNL_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUsNL_api->resetData(); //RESET DATA
                break;


            }
            
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsNL_api->resetData(); //RESET DATA
        }
         
    }
    
    die();
}

/*
 * Method in charge to chage user form templates via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsNL_changeFormTemplate', 'cUsNL_changeFormTemplate_callback');
function cUsNL_changeFormTemplate_callback() {
    
    $cUsNL_userData = get_option('cUsNL_settings_userCredentials'); //get the saved user data
   
    if      ( !strlen($cUsNL_userData['API_Account']) ){     echo 'Missing API Account';   die();
    }elseif  ( !strlen($cUsNL_userData['API_Key']) ){         echo 'Missing Form Key';         die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Form']) ){    echo 'Missing Form Template';         die();
    }elseif  ( !strlen($_REQUEST['form_key']) ){    echo 'Missing Form Key';         die();
    }else{
        
        $cUsNL_api = new cUsComAPI_NL(); //CONTACTUS.COM API
        $form_key = $_REQUEST['form_key'];
        
        $postData = array(
            'API_Account'       => $cUsNL_userData['API_Account'],
            'API_Key'           => $cUsNL_userData['API_Key'],
            'Template_Desktop_Form' => $_REQUEST['Template_Desktop_Form']
        );
        
        $cUsNL_API_result = $cUsNL_api->updateFormSettings($postData, $form_key);
        if($cUsNL_API_result) {

            $cUs_json = json_decode($cUsNL_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUsNL_api->resetData(); //RESET DATA
                break;


            } 
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsNL_api->resetData(); //RESET DATA
        } 
        
         
    } 
    
    die();
}

/*
 * Method in charge to update user tab templates via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsNL_changeTabTemplate', 'cUsNL_changeTabTemplate_callback');
function cUsNL_changeTabTemplate_callback() {
    
    $cUsNL_userData = get_option('cUsNL_settings_userCredentials'); //get the saved user data
   
    if       ( !strlen($cUsNL_userData['API_Account']) ){       echo 'Missing API Account';   die();
    }elseif  ( !strlen($cUsNL_userData['API_Key']) ){           echo 'Missing Form Key';      die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Tab']) ){    echo 'Missing Tab Template';  die();
    }elseif  ( !strlen($_REQUEST['form_key']) ){                echo 'Missing Form Key';      die();
    }else{
        
        $cUsNL_api = new cUsComAPI_NL(); //CONTACTUS.COM API
        $form_key = $_REQUEST['form_key'];
        
        $postData = array(
            'API_Account'       => $cUsNL_userData['API_Account'],
            'API_Key'           => $cUsNL_userData['API_Key'],
            'Template_Desktop_Tab' => $_REQUEST['Template_Desktop_Tab']
        );
        
        $cUsNL_API_result = $cUsNL_api->updateFormSettings($postData, $form_key);
        if($cUsNL_API_result) {

            $cUs_json = json_decode($cUsNL_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUsNL_api->resetData(); //RESET DATA
                break;


            } 
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsNL_api->resetData(); //RESET DATA
        } 
        
         
    }
    
    die();
}



// save custom selected pages handler function...
/*
 * Method in charge to save form settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsNL_saveCustomSettings', 'cUsNL_saveCustomSettings_callback');
function cUsNL_saveCustomSettings_callback() {
    
    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
        'tab_user'          => $_REQUEST['tab_user'],
        'cus_version'       => $_REQUEST['cus_version']
    ); 
    update_option('cUsNL_settings_FORM', $aryFormOptions );//UPDATE FORM SETTINGS
    
    cUsNL_page_settings_cleaner();
    
    delete_option( 'cUsNL_settings_inlinepages' );
    delete_option( 'cUsNL_settings_tabpages' );
   
    
    die();
}

// save custom selected pages handler function...
/*
 * Method in charge to remove page settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsNL_deletePageSettings', 'cUsNL_deletePageSettings_callback');
function cUsNL_deletePageSettings_callback() {
    
    $pageID = $_REQUEST['pageID'];
    
    delete_post_meta($pageID, 'cUsNL_FormByPage_settings');//reset values
    cUsNL_inline_shortcode_cleaner_by_ID($pageID); //RESET SC
    
    $aryTabPages = get_option('cUsNL_settings_tabpages');
    $aryTabPages = cUsNL_removePage($pageID,$aryTabPages);
    update_option( 'cUsNL_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            
    $aryInlinePages = get_option('cUsNL_settings_inlinepages');
    $aryInlinePages = cUsNL_removePage($pageID,$aryInlinePages);
    update_option( 'cUsNL_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
    
    die();
}

// save custom selected pages handler function...
/*
 * Method in charge to update user page settings from page selection via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsNL_changePageSettings', 'cUsNL_changePageSettings_callback');
function cUsNL_changePageSettings_callback() {
    
    $pageID = $_REQUEST['pageID'];
    delete_post_meta($pageID, 'cUsNL_FormByPage_settings');//reset values
    cUsNL_inline_shortcode_cleaner_by_ID($pageID); //RESET SC
    $aryTabPages = get_option('cUsNL_settings_tabpages');
    $aryInlinePages = get_option('cUsNL_settings_inlinepages');
    
    switch ($_REQUEST['cus_version']){
        case 'tab':
            
            $tabUser = 1;
            
            $aryTabPages[] = $pageID;
            $aryTabPages = array_unique($aryTabPages);
            update_option('cUsNL_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            
            if(!empty($aryInlinePages)){
                $aryInlinePages = cUsNL_removePage($pageID,$aryInlinePages);
                update_option( 'cUsNL_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
            }
            
            echo 1;
            
            break;
        case 'inline':
            
            $tabUser = 0;
            
            $aryInlinePages[] = $pageID;
            $aryInlinePages = array_unique($aryInlinePages);
            update_option( 'cUsNL_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
            
            if(!empty($aryTabPages)){
                $aryTabPages = cUsNL_removePage($pageID,$aryTabPages);
                update_option( 'cUsNL_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            }
            
            cUsNL_inline_shortcode_add($pageID); //ADDING SHORTCODE FOR INLINE PAGES
            
            echo 1;
            
            break;
    } 
    
    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
        'tab_user'          => $tabUser,
        'form_key'          => $_REQUEST['form_key'],   
        'cus_version'       => $_REQUEST['cus_version']
    );
    
    if($pageID != 'home'){
        update_post_meta($pageID, 'cUsNL_FormByPage_settings', $aryFormOptions);//SAVE DATA ON POST TYPE PAGE METAS
    }else{
       update_option('cUsNL_HOME_settings', $aryFormOptions );//UPDATE FORM SETTINGS 
    }
    
    die();
}

/*
 * Method in charge to remove page settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
function cUsNL_removePage($valueToSearch, $arrayToSearch){
    $key = array_search($valueToSearch,$arrayToSearch);
    if($key!==false){
        unset($arrayToSearch[$key]);
    }
    return $arrayToSearch;
}

// logoutUser handler function...
/*
 * Method in charge to remove wp options saved with this plugin via ajax post request vars
 * @since 1.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsNL_logoutUser', 'cUsNL_logoutUser_callback');
function cUsNL_logoutUser_callback() {
    
    $cUsNL_api = new cUsComAPI_NL();
    $cUsNL_api->resetData(); //RESET DATA
    
    delete_option( 'cUsNL_settings_api_key' );  
    delete_option( 'cUsNL_settings_form_key' );  
    delete_option( 'cUsNL_settings_list_Name' );  
    delete_option( 'cUsNL_settings_list_ID' );  
    
    echo 'Deleted.... User data'; //none list
    
    die();
}