<section class="mdl-cell mdl-cell--12-col todo-login todo-form-section">

    <h1>Do login. Or do not. There is no try.</h1>

    <form action="<?php echo URL; ?>users/signIn" method="post">

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="login" type="text" id="form-login" value="<?php echo strip_tags( $this->login ); ?>" required />
            <label class="mdl-textfield__label" for="form-login">Login...</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="password" type="password" id="form-password" value="" required />
            <label class="mdl-textfield__label" for="form-password">Password...</label>
        </div>

        <input type="hidden" name="nonce" value="<?php echo $this->nonce; ?>">
        <input type="hidden" name="login_user" value="1">

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="captcha" type="text" id="form-captcha" value="" required />
            <label class="mdl-textfield__label" for="form-captcha"><?php echo $this->capthca; ?></label>
        </div>

        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" type="submit">
            Login
        </button>
    </form>

    <p class="margin-top-30">
        If you are not a Jedi, but wish to become one, please <a class="bold" href="<?php echo URL . 'users/registration' ?>">register</a>.
    </p>

</section>