<?php
get_header();
?>

<div class="book-container" style="max-width:800px;margin:40px auto;padding:20px;">

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>

            <article class="book-single">

                <h1><?php the_title(); ?></h1>

                <?php if (is_user_logged_in()) : ?>

                    <?php $isbn = get_post_meta(get_the_ID(), '_bd_isbn', true); ?>

                    <?php if ($isbn) : ?>

                        <p>
                            <strong>ISBN:</strong>
                            <?php echo esc_html($isbn); ?>
                        </p>

                    <?php endif; ?>

                <?php endif; ?>

                <div class="book-content">

                    <?php the_content(); ?>

                </div>

            </article>

        <?php endwhile; ?>

    <?php endif; ?>

</div>

<?php
get_footer();
?>