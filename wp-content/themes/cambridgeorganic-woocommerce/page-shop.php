<?php
/*Template name: Cambridge Shop*/
?>
<?php get_header(); ?>

<?php
$page_id = is_user_logged_in() ? 2 : 1097;


if ( class_exists('\Elementor\Plugin') ) {

    // Load Elementor frontend assets
    \Elementor\Plugin::$instance->frontend->enqueue_styles();
    \Elementor\Plugin::$instance->frontend->enqueue_scripts();

    // Load this specific post's CSS
    $css_file = new \Elementor\Core\Files\CSS\Post($page_id);
    echo '<style>' . $css_file->get_content() . '</style>';

    // Render content
    echo \Elementor\Plugin::instance()
        ->frontend
        ->get_builder_content_for_display($page_id);

} else {
    echo apply_filters('the_content', get_post_field('post_content', $page_id));
}
?>

<?php get_footer(); ?>
