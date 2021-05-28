<?php get_header(); ?>

<div id="primary" class="content-area">
    <header>
        <div class="form" style="display: flex; margin: 1em;" >
    </header>

    <main id="main" class="site-main">
        <p>Tous les évènements</p>
        <?php

            $query = new WP_Query([
                'post_type' => 'reservation',
                'meta_key' => 'reservation_date',
                'meta_value' => (new DateTime())->format('Y/m/d H:i:s'),
                'meta_compare' => '>',
                'orderby' => 'reservation_date',
                'order' => 'ASC',
            ]);

            while ($query->have_posts()):
                $query->the_post();
                $title = get_the_title();
                $image = get_field('reservation_image', get_the_ID());
                $description = get_field('reservation_description', get_the_ID());
                $date = get_field('reservation_date', get_the_ID());
                echo get_the_title() . '<br>';
                echo wp_get_attachment_image($image['ID'], 'medium') . '<br>';
                echo $description . '<br>';
                echo $date . '<br>';

                echo '<br>';
            endwhile; ?>
    </main>
</div>

<?php
