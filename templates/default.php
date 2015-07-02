<div class="wpupg-item <?php echo implode( ' ', $classes ); ?>">
    <div class="wpupg-thumbnail">
        <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
    </div>
    <div class="wpupg-title"><?php echo $post->post_title; ?></div>
</div>