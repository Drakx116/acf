<?php
    get_header();
    global $wp_query;

    $diets = acf_get_field('main_course_diet')['choices'];
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="form" style="display: flex; justify-content: center;">
            <form action="/custom-restaurant" method="get" style="text-align: center">
                <h3 style="margin: 0;"> Main Course Research </h3><br>

                <label for="diet"><b> Diet </b></label>
                <select name="diet" id="diet">
                    <option value=""> --- No filter --- </option>
                    <?php foreach ($diets as $diet) {
                        ?><option value="<?php echo strtolower($diet); ?>"><?php echo $diet; ?></option><?php
                    } ?>
                </select><br>

                <label for="price"><b> Order By Price </b></label>
                <select name="price" id="price">
                    <option value=""> --- No filter --- </option>
                    <option value="ASC">ASC</option>
                    <option value="DESC">DESC</option>
                </select>
                <br>
                <a href="/custom-restaurant"> Reset filters </a>
                <br>
                <input type="submit" value="Search">
            </form>
        </div>

        <?php

        $paged = absint(get_query_var('paged')) ?? 1;

        $diet = $_GET['diet'] ?? null;
        $order = $_GET['price'] ?? null;

        $args = [
            'post_type' => 'main-course',
            'posts_per_page' => 2,
            'paged' => $paged
        ];

        if ($diet) {
            $args['meta_query'] = [[
                'key' => 'main_course_diet',
                'value' => $diet
            ]];
        }

        if ($order) {
            $args['meta_key'] = 'main_course_price';
            $args['orderby'] = 'meta_value';
            $args['order'] = $order;
        }

        $mainCourses = new WP_Query($args);

        if ($mainCourses->have_posts()) : ?>
            <section style="display: flex; justify-content: center; flex-direction: row;"> <?php
                while ( $mainCourses->have_posts() ) : $mainCourses->the_post(); ?>
                    <div class="main-course-container" style="margin: 1em; text-align: center;">
                        <?php
                            $image = get_field('main_course_picture', get_the_ID());
                            $diet = get_field('main_course_diet', get_the_ID());
                            $ingredients = get_field('main_course_ingredients', get_the_ID());
                            $price = get_field('main_course_price', get_the_ID());
                        ?>
                            <span><b> <?php the_title(); ?> - <?php echo ucfirst($diet)?> </b></span><br>
                        <?php

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

?>


    </main>
</div>

<?php
