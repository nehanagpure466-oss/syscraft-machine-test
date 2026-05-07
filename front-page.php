<?php
get_header();
?>

<div class="homepage-books">

    <h2>Featured Books</h2>

    <div class="featured-books-slider">

        <?php

        $args = array(
            'post_type'      => 'book',
            'posts_per_page' => 5,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'genre',
                    'field'    => 'slug',
                    'terms'    => 'featured',
                ),
            ),
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :

            while ($query->have_posts()) :

                $query->the_post();

                ?>

                <div class="book-slide">

                    <a href="<?php the_permalink(); ?>">

                        <?php if (has_post_thumbnail()) : ?>

                            <?php the_post_thumbnail('medium'); ?>

                        <?php endif; ?>

                        <h3><?php the_title(); ?></h3>

                    </a>

                </div>

                <?php

            endwhile;

            wp_reset_postdata();

        endif;

        ?>

    </div>

</div>

<h2>Latest Blog Post</h2>

<?php

$blog_query = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 2
));

if ($blog_query->have_posts()) :

    while ($blog_query->have_posts()) :

        $blog_query->the_post();

        ?>

        <h3><?php the_title(); ?></h3>

        <?php the_excerpt(); ?>

        <?php

    endwhile;

    wp_reset_postdata();

endif;
?>

<?php bd_show_cached_books(); ?>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const slider = document.querySelector('.featured-books-slider');

    let scrollAmount = 0;

    function autoSlide() {

        if (
            scrollAmount >=
            slider.scrollWidth - slider.clientWidth
        ) {

            scrollAmount = 0;

        } else {

            scrollAmount += 270;
        }

        slider.scrollTo({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }

    setInterval(autoSlide, 3000);

});

</script>

<?php
get_footer();
?>