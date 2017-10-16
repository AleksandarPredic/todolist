<?php
if ( ! is_array($this->items) ) {
    return;
}

foreach ($this->items as $item) {

    $active = $item['active'] != 0;
    ?>
    <div class="card-square mdl-card mdl-shadow--2dp mdl-cell mdl-cell mdl-cell--4-cols<?php echo ! $active ? ' mdl-card--deactivated' : ''; ?>">

        <div class="mdl-card__title mdl-card--expand">
            <h2 class="mdl-card__title-text"><?php echo isset( $item['title'] ) ? filter_var( $item['title'], FILTER_SANITIZE_STRING ) : 'No title'; ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            <p>
                <?php echo isset( $item['description'] ) ? filter_var( $item['description'], FILTER_SANITIZE_STRING ) : 'No description'; ?>
            </p>
            <p class="mdl-card__date">
                <?php echo Carbon\Carbon::createFromTimestamp(strtotime($item['create_date']))->toDayDateTimeString(); ?>
            </p>
        </div>
        <div class="mdl-card__actions mdl-card--border">

            <?php if ( $active ) : ?>
            <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect"
               href="<?php echo URL; ?>home/deactivate?item_id=<?php echo intval($item['item_id']) ?>&nonce=<?php echo $this->nonce; ?>">
                Deactivate
            </a>
            <?php else : ?>
            <span class="mdl-button mdl-button--colored">Card deactivated</span>
            <?php endif; ?>

            <!-- Right aligned menu on top of button  -->
            <button id="mdl-card__menu-top-right--<?php echo intval($item['item_id']) ?>"
                    class="mdl-button mdl-js-button mdl-button--icon">
                <i class="material-icons">more_vert</i>
            </button>

            <ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
                data-mdl-for="mdl-card__menu-top-right--<?php echo intval($item['item_id']) ?>">
                <li class="mdl-menu__item mdl-js-ripple-effect">
                    <a class="mdl-navigation__link" href="<?php echo URL; ?>home/destroy?item_id=<?php echo intval($item['item_id']) ?>&nonce=<?php echo $this->nonce; ?>">
                        Delete
                    </a>
                </li>
            </ul>

        </div>

    </div>
    <?php

}

echo $this->paginationHtml;