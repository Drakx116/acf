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

    <?php get_template_part('template-parts/main-courses/content', 'list'); ?>
</div>

<?php
