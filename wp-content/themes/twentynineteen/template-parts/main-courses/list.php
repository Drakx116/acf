<main id="main" class="site-main" style="display: flex; justify-content: center; flex-direction: row; background-color: <?php echo $bgColor; ?>">
    <?php
    // LAST 3 MAIN COURSES

    $args = [
        'post_type' => 'main-course',
        'posts_per_page' => 1,
        'orderby' => 'post_date',
        'order' => 'DESC'
    ];

    $mainCourses = new WP_Query($args);

    ?> <div><?php
        if ($mainCourses->have_posts()) : ?>
            <section style="display: flex; justify-content: center; flex-direction: row; background-color: <?php echo $bgColor; ?>"> <?php
                while ( $mainCourses->have_posts() ) : $mainCourses->the_post(); ?>
                    <div class="main-course-container" style="text-align: center; margin: 1em 3em; background-color: <?php echo $bgColor; ?>; color: <?php echo '#FFF'; ?>">
                        <?php
                        $image = get_field('main_course_picture', get_the_ID());
                        $diet = get_field('main_course_diet', get_the_ID());
                        $ingredients = get_field('main_course_ingredients', get_the_ID());
                        $price = get_field('main_course_price', get_the_ID());

                        echo wp_get_attachment_image($image['ID'], 'medium') . '<br>';
                        foreach ($ingredients as $key => $value) {
                            $ingredient = $value['main_course_single_ingredient'];
                            ?><span> Ingrédient <?php echo $key+1 ?> - <b><?php echo $ingredient ?></b></span><br><?php
                        }

                        echo '<span> Prix <b>' . $price . ' €</b></span>'
                        ?></div>
                <?php endwhile; ?>
            </section>

            <div style="display: flex; align-items: center; flex-direction: column;"> <?php
                previous_posts_link('Previous');
                next_posts_link('Next', $mainCourses->max_num_pages);
            ?> </div>
        <?php else:
            echo 'No more results.';
        endif;
        ?></div>
</main>
