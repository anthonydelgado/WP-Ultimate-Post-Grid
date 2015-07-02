<?php

class WPUPG_Content {

    public function __construct()
    {
        add_filter( 'the_content', array( $this, 'content_filter' ), 10 );
    }

    public function content_filter( $content )
    {
        $ignore_query = !is_main_query();
        if ( apply_filters( 'wpupg_content_loop_check', $ignore_query ) ) {
            return $content;
        }

        if ( get_post_type() == WPUPG_POST_TYPE ) {
            remove_filter( 'the_content', array( $this, 'content_filter' ), 10 );

            $grid = new WPUPG_Grid( get_post() );

            $content .= '<div class="wpupg-grid">';
            $content .= $grid->draw_posts();
            $content .= '</div>';

            add_filter( 'the_content', array( $this, 'content_filter' ), 10 );
        }

        return $content;
    }
}