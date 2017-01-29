<?php

$id = intval($a['id']);

$type = get_post_type($id);

if ($type == 'terms_and_cond') {
    $post = get_post($id);
    ?>

    <?php if (!empty($post)): ?>
        <section style="text-align: center;">
            <article><?php echo $post->post_content ?></article>
            <?php if (is_user_logged_in()): ?>
                <div style="width:80%;margin:auto;text-transform: uppercase;">
            <span>
                <a href="#" id="aceptar" data-postid=<?php echo $id; ?>><?php _e('Accept', 'terms-and-cond') ?></a>
            </span>
                    <span style="margin-left:100px;">
                <a href="<?php echo get_home_url() ?>" id="declinar"
                   data-postid=<?php echo $id; ?>><?php _e('Decline', 'terms-and-cond') ?></a>
            </span>
                </div>
            <?php endif; ?>
        </section>
        <div id="summary-tac" style="display: none;">
            <h3><?php _e('Summary', 'terms-and-cond') ?></h3>
            <?php echo $post->post_excerpt; ?>
        </div>

    <?php endif ?>

    <?php
}