<?php $this->renderFeedbackMessages(); ?>

<div class="register-form">
    <h2>Регистрация</h2>

    <form method="post" action="<?php echo Config::get('URL'); ?>register/register_action">
        <!-- the user name input field uses a HTML5 pattern check -->
        <input class="form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" placeholder="Имя пользователя (буквы/цифры, 2-64 символов)" required />
        <input class="form-control" type="text" name="user_email" placeholder="email адрес (реальный)" required />
        <input class="form-control" type="text" name="user_email_repeat" placeholder="повтор email адреса (чтобы не ошибиться)" required />
        <input class="form-control" type="password" name="user_password_new" pattern=".{6,}" placeholder="Пароль (6+ символов)" required autocomplete="off" />
        <input class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required placeholder="Повтор пароля" autocomplete="off" />

        <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
        <img id="captcha" src="<?php echo Config::get('URL'); ?>register/showCaptcha" />
        <input class="form-control" type="text" name="captcha" placeholder="Please enter above characters" required />

        <!-- quick & dirty captcha reloader -->
        <a href="#" style="display: block; font-size: 11px; margin: 5px 0 15px 0; text-align: center"
           onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL'); ?>register/showCaptcha?' + Math.random(); return false">Другая картинка</a>

        <input class="btn btn-primary btn-block" type="submit" value="Зарегестрироваться" />
    </form>
</div>
