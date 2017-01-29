<?php get_header(); ?>
    <div style="height: 80px;display:block;background: #000;"></div>
    <div class="content">

        <?php
        if (have_posts()) {

            while (have_posts()) : the_post();
                $type = get_post_type(get_the_ID());
                if ($type == 'terms_and_cond') {
                    $showpost = true;
                } else {
                    $showpost = false;
                }

            endwhile;
        }
        ?>

        <?php if ($showpost): ?>
            <section style="text-align: center;margin-top:100px;margin-bottom: 100px;">

                <header>
                    <h1> <?php the_title(); ?></h1>
                </header>
                <article><?php the_content(); ?></article>
                <?php if (is_user_logged_in()): ?>
                    <div style="width:80%;margin:auto;text-transform: uppercase;">
            <span>
                <a href="#" id="aceptar"
                   data-postid=<?php echo get_the_ID(); ?>><?php _e('Accept', 'terms-and-cond') ?></a>
            </span>
                        <span style="margin-left:100px;">
                <a href="<?php echo get_home_url() ?>" id="declinar"
                   data-postid=<?php echo get_the_ID(); ?>><?php _e('Decline', 'terms-and-cond') ?></a>
            </span>
                    </div>
                <?php endif; ?>
            </section>
            <div id="summary-tac" style="display: none;">
                <h3><?php _e('Summary', 'terms-and-cond') ?></h3>
                <?php the_excerpt() ?>
            </div>
        <?php endif; ?>

    </div>
    <script>

    </script>
<?php
get_footer();
?>