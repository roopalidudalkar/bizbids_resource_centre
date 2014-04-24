<?php
/**
 * 
 * NEWSLETTER FORM BY CONTACTUS.COM
 * 
 * Initialization Newsletter Login Form View
 * @since 1.0 First time this was introduced into Newsletter Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2014 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140218
 * */
?>

<form method="post" action="admin.php?page=cUs_form_plugin" id="cUsNL_loginform" name="cUsNL_loginform" class="steps login_form" onsubmit="return false;">
    <h3>ContactUs.com Login</h3>

    <table class="form-table">

        <tr>
            <th><label class="labelform" for="login_email">Email</label><br>
            <td><input class="inputform" name="cUsNL_settings[login_email]" id="login_email" type="text"></td>
        </tr>
        <tr>
            <th><label class="labelform" for="user_pass">Password</label></th>
            <td><input class="inputform" name="cUsNL_settings[user_pass]" id="user_pass" type="password"></td>
        </tr>
        <tr><th></th>
            <td>
                <input id="loginbtn" class="btn lightblue cUsNL_LoginUser" value="Login" type="submit">
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <a href="http://www.contactus.com/login/#forgottenbox" target="_blank">I forgot my password</a>
            </td>
        </tr>

    </table>
</form>