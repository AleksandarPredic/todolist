<section class="mdl-cell mdl-cell--12-col todo-register todo-form-section">

    <h1>Register and begin your training my young apprentice!</h1>

    <form action="<?php echo URL; ?>users/addUser" method="post">

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="login" type="text" id="form-login" value="<?php echo strip_tags( $this->login ); ?>" required />
            <label class="mdl-textfield__label" for="form-login">Username...</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="email" type="email" id="form-email" value="<?php echo strip_tags( $this->email ); ?>" required />
            <label class="mdl-textfield__label" for="form-email">Email...</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="password" type="password" id="form-password" value="" required />
            <label class="mdl-textfield__label" for="form-password">Password...</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="password_confirm" type="password" id="form-password-confirm" value="" required />
            <label class="mdl-textfield__label" for="form-password-confirm">Confirm password...</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="captcha" type="text" id="form-captcha" value="" required />
            <label class="mdl-textfield__label" for="form-captcha"><?php echo $this->capthca; ?></label>
        </div>

        <input type="hidden" name="nonce" value="<?php echo $this->nonce; ?>">
        <input type="hidden" name="login_user" value="1">

        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" type="submit">
            Create
        </button>
    </form>

</section>