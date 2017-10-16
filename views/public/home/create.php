<section class="mdl-cell mdl-cell--12-col todo-create todo-form-section">

    <h1>Go, create your notes.</h1>
    <h5>You are the Chosen One. You will bring the balance to the Force!!!</h5>

    <form action="<?php echo URL; ?>home/store" method="post">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="title" type="text" id="form-title" value="<?php echo strip_tags( $this->title ); ?>" required />
            <label class="mdl-textfield__label" for="form-title">Text...</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield">
            <textarea class="mdl-textfield__input" name="text" type="text" rows= "3" id="form-text" required><?php echo strip_tags( $this->text ); ?></textarea>
            <label class="mdl-textfield__label" for="form-text">Text lines...</label>
        </div>

        <input type="hidden" name="nonce" value="<?php echo $this->nonce; ?>">
        <input type="hidden" name="create_item" value="1">

        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" type="submit">
            Create
        </button>
    </form>

</section>