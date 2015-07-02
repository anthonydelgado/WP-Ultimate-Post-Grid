<?php

class WPUPG_Css {

    public function __construct()
    {
        add_action( 'wp_head', array( $this, 'custom_css' ), 20 );
    }

    public function custom_css()
    {
        if( WPUltimatePostGrid::option( 'custom_code_public_css', '' ) !== '' ) {
            echo '<style type="text/css">';
            echo WPUltimatePostGrid::option( 'custom_code_public_css', '' );
            echo '</style>';
        }
    }
}