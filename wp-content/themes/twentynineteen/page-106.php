<?php
    get_header();
    global $wp_query;

    $image = get_field('contact_image', 'acf-contact');
    $title = get_field('contact_title', 'acf-contact');
    $users = get_field('contact_users', 'acf-contact');
    $bgColor = get_field('contact_background_color', 'acf-contact');
    $textColor = get_field(' contact_text_color', 'acf-contact');
?>

<div id="primary" class="content-area">
    <header style="text-align: center;">
        <?php echo wp_get_attachment_image($image['ID'], 'large') . '<br>'; ?>
        <p style="font-size: 1.8em; font-weight: bold;"> <?php echo $title; ?></p>

        <div class="form" style="display: flex; margin: 3em; justify-content: center;" >
            <form style="min-width: 30%;" id="form-contact" method="post">
                <label for="contact"><b> Contact </b></label><br>
                <select name="contact" id="contact">
                    <?php foreach ($users as $user):
                        $name = $user['contact_user_name'];
                        $email = $user['contact_user_email']; ?>
                        <option value="<?php echo $email?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <label for="title"><b> Title </b></label><br>
                <input id="title" name="title" type="text" style="width: 100%;"><br><br>

                <label for="message"><b> Message </b></label><br>
                <textarea id="message" name="message" type="text"></textarea><br><br>

                <input type="submit" name="validate-contact" value="Send">

                <br><br>
                <div id="contact-response"></div>
            </form>
        </div>
    </header>

    <main id="main" class="site-main" style="display: flex; justify-content: center; flex-direction: row; background-color: <?php echo $bgColor; ?>">
        <?php
        // LAST 3 MAIN COURSES

        $args = [
            'post_type' => 'main-course',
            'posts_per_page' => 3,
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
            <?php else:
                echo 'No more results.';
            endif;
        ?></div>
    </main>
</div>

<?php
