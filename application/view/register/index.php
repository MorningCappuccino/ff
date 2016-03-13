<?php $this->renderFeedbackMessages(); ?>

<div class="register-box">
    <h2>Register a new account</h2>

    <form method="post" action="<?php echo Config::get('URL'); ?>register/register_action">
        <!-- the user name input field uses a HTML5 pattern check -->
        <input class="form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" placeholder="Username (letters/numbers, 2-64 chars)" required />
        <input class="form-control" type="text" name="user_email" placeholder="email address (a real address)" required />
        <input class="form-control" type="text" name="user_email_repeat" placeholder="repeat email address (to prevent typos)" required />
        <input class="form-control" type="password" name="user_password_new" pattern=".{6,}" placeholder="Password (6+ characters)" required autocomplete="off" />
        <input class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required placeholder="Repeat your password" autocomplete="off" />

        <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
        <img id="captcha" src="<?php echo Config::get('URL'); ?>register/showCaptcha" />
        <input class="form-control" type="text" name="captcha" placeholder="Please enter above characters" required />

        <!-- quick & dirty captcha reloader -->
        <a href="#" style="display: block; font-size: 11px; margin: 5px 0 15px 0; text-align: center"
           onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL'); ?>register/showCaptcha?' + Math.random(); return false">Reload Captcha</a>

        <input class="btn btn-primary btn-block" type="submit" value="Register" />
    </form>
</div>
