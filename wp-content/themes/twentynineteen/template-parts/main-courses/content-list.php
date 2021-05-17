<?php

$bgColor = get_field('contact_background_color', 'acf-contact');
$textColor = get_field('contact_text_color', 'acf-contact');
$mainCourses = get_query_var('main-courses');

?> <div><?php
    if ($mainCourses->have_posts()) : ?>
        <section id="main-courses-list-container" style="display: flex; justify-content: center; flex-direction: row; background-color: <?php echo $bgColor; ?>"> <?php
            while ( $mainCourses->have_posts() ) : $mainCourses->the_post(); ?>
                <div class="main-course-container" style="text-align: center; margin: 1em 3em; background-color: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>">
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

                    echo '<span> Prix <b>' . $price . ' €</b></span>';
                ?></div>
            <?php endwhile; ?>
        </section>

        <div style="display: flex; align-items: center; flex-direction: column;"> <?php
            previous_posts_link('<div class="main-courses-btn btn-previous"> Previous </div>');
            next_posts_link('<div class="main-courses-btn btn-next"> Next </div>', $mainCourses->max_num_pages);
        ?> </div>
    <?php else:
        echo 'No more results.';
    endif;
?></div>
