<?php get_header(); ?>

<div id="primary" class="content-area">
    <header>
        <div class="form" style="display: flex; margin: 1em;" >
    </header>

    <main id="main" class="site-main">
        <h1 style="font-size: 32px;">Tous les évènements</h1>

        <?php
            $query = new WP_Query([
                'post_type' => 'reservation',
                'meta_key' => 'reservation_date',
                'meta_value' => (new DateTime())->format('Y/m/d H:i:s'),
                'meta_compare' => '>',
                'orderby' => 'reservation_date',
                'order' => 'ASC',
            ]);

        ?>
        <section style="display: flex; justify-content: space-between; flex-wrap: wrap; margin-top: 2em; width: 90%; margin-left: 5%;"><?php
            while ($query->have_posts()):
                $query->the_post();
                $title = get_the_title();
                $image = get_field('reservation_image', get_the_ID());
                $description = get_field('reservation_description', get_the_ID());
                $date = get_field('reservation_date', get_the_ID());

                ?> <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: calc(33.33% - 2em); margin: 1em; padding: 1em; border: 3px solid black; text-align: center;">
                    <?php
                        echo '<b>' . get_the_title() . '</b>';
                        echo wp_get_attachment_image($image['ID'], [ '400', '200' ]);
                        echo $description . '<br>';
                        echo '<b>' . $date . '</b>';
                        echo '<button class="reservation-btn" data-reservation="' . get_the_ID() . '"> I want to be in ! </button>';


                        ?>
                        <br>
                        <label for="phone-<?php echo get_the_ID(); ?>"> Téléphone  </label>
                        <input id="phone-<?php echo get_the_ID(); ?>" type="tel">

                        <label for="people-<?php echo get_the_ID(); ?>"> Personnes </label>
                        <select id="people-<?php echo get_the_ID(); ?>" name="">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>

                        <label for="email-<?php echo get_the_ID(); ?>"> Email </label>
                        <input id="email-<?php echo get_the_ID(); ?>" type="email">
                    </div>
                <?php
            endwhile;
        ?></section>
    </main>
</div>

<?php
