<?php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
?>

<div class="news-container">
    <?php
        $id = get_the_id();

        // Images
        $image = get_field('gutenberg-image', $id);
        $imageAlign = get_field('gutenberg-image-alignment', $id);
        $imageClass = 'image-' . $imageAlign;

        // Text
        $text = get_field('gutenberg-text', $id);
        $textAlign = get_field('gutenberg-text-alignment', $id);

        // Border
        $border = get_field('gutenberg-border', $id);

        // Colors
        $textColor = get_field('gutenberg-text-color', $id);
        $borderColor = get_field('gutenberg-border-color', $id);
        $backgroundColor = get_field('gutenberg-background-color', $id);

        ?>
            <div class="gutenberg-container"
                 style="<?php if ($border): ?>  border: 2px solid <?php echo $borderColor; endif; ?>;
                        background-color: <?php echo $backgroundColor; ?>
            ">
                <div class="<?php echo $imageClass; ?>">
                    <?php echo wp_get_attachment_image($image['ID'], 'large'); ?>
                </div>

                <div style="text-align: <?php echo $textAlign?>; color: <?php echo $textColor; ?>">
                    <?php echo $text; ?>
                </div>
            </div>
        <?php
    ?>
</div>

<?php
