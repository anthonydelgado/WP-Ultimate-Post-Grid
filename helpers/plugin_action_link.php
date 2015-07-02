<?php

class WPUPG_Plugin_Action_Link {

    public function __construct()
    {
        add_filter( 'plugin_action_links_wp-ultimate-post-grid/wp-ultimate-post-grid.php', array( $this, 'action_links' ) );
    }

    public function action_links( $links )
    {
        //$links[] = '<a href="'. get_admin_url(null, 'edit.php?post_type=recipe&page=wpupg_admin') .'">'.__( 'Settings', 'wp-ultimate-recipe' ).'</a>';
        $links[] = '<a href="http://bootstrapped.ventures" target="_blank">'.__( 'More information', 'wp-ultimate-post-grid' ).'</a>';

        return $links;
    }
}