
<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>

<div class="row login">
    <!-- login box on left side -->
    <div class="col-lg-6 login-box">
        <h2>Залогиниться</h2>
        <form action="<?php echo Config::get('URL'); ?>login/login" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="user_name" placeholder="Username or email" required />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="user_password" placeholder="Password" required />
            </div>
            <div class="form-group">
                <label for="set_remember_me_cookie" class="remember-me-label">
                    <input type="checkbox" name="set_remember_me_cookie" class="remember-me-checkbox" />
                    Запомнить на 2 недели
                </label>
            </div>
            <?php if (!empty($this->redirect)) { ?>
                <input type="hidden" name="redirect" value="<?php echo $this->encodeHTML($this->redirect); ?>" />
            <?php } ?>
                        <!--
                            set CSRF token in login form, although sending fake login requests mightn't be interesting gap here.
                            If you want to get deeper, check these answers:
                                1. natevw's http://stackoverflow.com/questions/6412813/do-login-forms-need-tokens-against-csrf-attacks?rq=1
                                2. http://stackoverflow.com/questions/15602473/is-csrf-protection-necessary-on-a-sign-up-form?lq=1
                                3. http://stackoverflow.com/questions/13667437/how-to-add-csrf-token-to-login-form?lq=1
                        -->
                        <input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>" />
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Войти"/>
            </div>
        </form>
        <div class="link-forgot-my-password">
            <a class="pull-right" href="<?php echo Config::get('URL'); ?>login/requestPasswordReset">Я забыл свой пароль</a>
        </div>
    </div>

    <!-- register box on right side -->
    <div class="col-lg-6 register-box">
        <h2>Ещё не зарегистрированны?</h2>
        <a class="btn btn-primary btn-block" href="<?php echo Config::get('URL'); ?>register/index">Регистрация</a>
    </div>
</div>
