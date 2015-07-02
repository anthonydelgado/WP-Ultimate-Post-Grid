<?php

class WPUPG_Template_Container extends WPUPG_Template_Block {

    public $editorField = 'container';

    public function __construct( $type = 'container' )
    {
        parent::__construct( $type );

        // This is always the starting point of the template
        $this->parent = -1;
        $this->row = 0;
        $this->column = 0;
        $this->order = 0;
    }

    public function output( $post, $args = array() )
    {
        if( !$this->output_block( $post, $args ) ) return '';

        // Default arguments
        $args['desktop'] = true;
        $args['max_width'] = 9999;
        $args['max_height'] = 9999;

        $args['max_width'] = $this->max_width && $args['max_width'] > $this->max_width ? $this->max_width : $args['max_width'];
        $args['max_height'] = $this->max_height && $args['max_height'] > $this->max_height ? $this->max_height : $args['max_height'];

        if( isset( $args['classes'] ) ) {
            $this->classes = $args['classes'];
        }

        $output = $this->before_output();

        ob_start();
?>
<div id="wpupg-container-post-<?php echo $post->ID; ?>" data-permalink="<?php echo get_post_permalink( $post->ID ); ?>" <?php echo $this->style(); ?>>
    <?php $this->output_children( $post, 0, 0, $args ) ?>
</div>
<?php
        $output .= ob_get_contents();
        ob_end_clean();

        return $this->after_output( $output, $post );
    }
}