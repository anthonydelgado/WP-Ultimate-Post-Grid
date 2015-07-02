<?php

class WPUPG_Grid {

    private $post;
    private $meta;
    private $fields = array(
        'wpupg_centered',
        'wpupg_images_only',
        'wpupg_filter_match_parents',
        'wpupg_filter_multiselect',
        'wpupg_filter_multiselect_type',
        'wpupg_filter_type',
        'wpupg_pagination_type',
        'wpupg_post_types',
        'wpupg_layout_mode',
        'wpupg_limit_posts',
        'wpupg_link_type',
        'wpupg_order_by',
        'wpupg_order',
        'wpupg_template',
    );

    // Pagination fields with defaults
    private $pagination_fields = array(
        'pages' => array(
            'posts_per_page'    => 20,
        ),
        'load_more' => array(
            'initial_posts'     => 20,
            'posts_on_click'    => 20,
            'button_text'       => 'Load More',
        ),
    );

    private $pagination_style_fields = array(
        'background_color'          => '#2E5077',
        'background_active_color'   => '#1C3148',
        'background_hover_color'    => '#1C3148',
        'text_color'                => '#FFFFFF',
        'text_active_color'         => '#FFFFFF',
        'text_hover_color'          => '#FFFFFF',
        'border_color'              => '#1C3148',
        'border_active_color'       => '#1C3148',
        'border_hover_color'        => '#1C3148',
        'border_width'              => '1',
        'margin_vertical'           => '5',
        'margin_horizontal'         => '5',
        'padding_vertical'          => '5',
        'padding_horizontal'        => '10',
        'alignment'                 => 'left',
    );

    // Filter style fields with defaults
    private $filter_style_fields = array(
        'isotope' => array(
            'background_color'          => '#2E5077',
            'background_active_color'   => '#1C3148',
            'background_hover_color'    => '#1C3148',
            'text_color'                => '#FFFFFF',
            'text_active_color'         => '#FFFFFF',
            'text_hover_color'          => '#FFFFFF',
            'border_color'              => '#1C3148',
            'border_active_color'       => '#1C3148',
            'border_hover_color'        => '#1C3148',
            'border_width'              => '1',
            'margin_vertical'           => '5',
            'margin_horizontal'         => '5',
            'padding_vertical'          => '5',
            'padding_horizontal'        => '10',
            'alignment'                 => 'left',
        ),
    );

    public function __construct( $post )
    {
        // Get associated post
        if( is_object( $post ) && $post instanceof WP_Post ) {
            $this->post = $post;
        } else if( is_numeric( $post ) ) {
            $this->post = get_post( $post );
        } else {
            throw new InvalidArgumentException( 'Grids can only be instantiated with a Post object or Post ID.' );
        }

        // Get metadata
        $this->meta = get_post_custom( $this->post->ID );
    }

    public function is_present( $field )
    {
        switch( $field ) {
            default:
                $val = $this->meta( $field );
                return isset( $val ) && trim( $val ) != '';
        }
    }

    public function meta( $field )
    {
        if( isset( $this->meta[$field] ) ) {
            return $this->meta[$field][0];
        }

        return null;
    }

    public function fields()
    {
        return $this->fields;
    }

    public function filter_style_fields()
    {
        return $this->filter_style_fields;
    }

    public function pagination_fields()
    {
        return $this->pagination_fields;
    }

    public function pagination_style_fields()
    {
        return $this->pagination_style_fields;
    }

    /**
     * Grid fields
     */

    public function centered()
    {
        return $this->meta( 'wpupg_centered' );
    }

    public function filter()
    {
        return $this->meta( 'wpupg_filter' );
    }

    public function filter_taxonomies()
    {
        $filter_taxonomies = unserialize( $this->meta( 'wpupg_filter_taxonomies' ) );
        return is_array( $filter_taxonomies ) ? $filter_taxonomies : array();
    }

    public function filter_style()
    {
        $filter_style = unserialize( $this->meta( 'wpupg_filter_style' ) );
        $filter_style = is_array( $filter_style ) ? $filter_style : array();

        // Set defaults
        foreach( $this->filter_style_fields() as $type => $defaults ) {
            $filter_style[$type] = isset( $filter_style[$type] ) ? $filter_style[$type] + $defaults : $defaults;
        }

        return $filter_style;
    }

    public function filter_match_parents()
    {
        return $this->meta( 'wpupg_filter_match_parents' );
    }

    public function filter_multiselect()
    {
        if( WPUltimatePostGrid::is_premium_active() ) {
            return $this->meta( 'wpupg_filter_multiselect' );
        } else {
            return false;
        }
    }

    public function filter_multiselect_type()
    {
        return $this->meta( 'wpupg_filter_multiselect_type' );
    }

    public function filter_type()
    {
        return $this->meta( 'wpupg_filter_type' );
    }

    public function ID()
    {
        return $this->post->ID;
    }

    public function images_only()
    {
        return $this->meta( 'wpupg_images_only' );
    }

    public function layout_mode()
    {
        $layout_mode = $this->meta( 'wpupg_layout_mode' );
        return $layout_mode ? $layout_mode : 'masonry';
    }

    public function limit_posts()
    {
        return $this->meta( 'wpupg_limit_posts' );
    }

    public function limit_rules()
    {
        $limit_rules = unserialize( $this->meta( 'wpupg_limit_rules' ) );
        return is_array( $limit_rules ) ? $limit_rules : array();
    }

    public function link_type()
    {
        $link_type = $this->meta( 'wpupg_link_type' );
        return $link_type ? $link_type : '_self';
    }

    public function order()
    {
        return $this->meta( 'wpupg_order' );
    }

    public function order_by()
    {
        return $this->meta( 'wpupg_order_by' );
    }

    public function pagination()
    {
        $pagination = unserialize( $this->meta( 'wpupg_pagination' ) );
        $pagination = is_array( $pagination ) ? $pagination : array();

        // Set defaults
        foreach( $this->pagination_fields() as $type => $defaults ) {
            $pagination[$type] = isset( $pagination[$type] ) ? $pagination[$type] + $defaults : $defaults;
        }

        return $pagination;
    }

    public function pagination_style()
    {
        $pagination_style = unserialize( $this->meta( 'wpupg_pagination_style' ) );
        $pagination_style = is_array( $pagination_style ) ? $pagination_style : array();

        // Set defaults
        $pagination_style = $pagination_style + $this->pagination_style_fields();

        return $pagination_style;
    }

    public function pagination_type()
    {
        return $this->meta( 'wpupg_pagination_type' );
    }

    public function posts()
    {
        $posts = unserialize( $this->meta( 'wpupg_posts' ) );
        return is_array( $posts ) ? $posts : array();
    }

    public function post()
    {
        return $this->post;
    }

    public function post_status() // TODO
    {
        return 'publish';
    }

    public function post_types()
    {
        $post_types = unserialize( $this->meta( 'wpupg_post_types' ) );
        return is_array( $post_types ) ? $post_types : array();
    }

    public function slug()
    {
        return $this->post->post_name;
    }

    public function template()
    {
        return WPUltimatePostGrid::addon( 'custom-templates' )->get_template( $this->template_id() );
    }

    public function template_id()
    {
        return $this->meta( 'wpupg_template' );
    }

    public function title()
    {
        return $this->post->post_title;
    }

    /**
     * Helper functions
     */

    public function get_posts( $page = 0 )
    {
        $grid_posts = $this->posts();
        $post_ids = $grid_posts['all'];

        if( count( $post_ids ) == 0 ) return array();

        $posts_per_page = -1;

        if( $this->pagination_type() == 'pages' ) {
            $pagination = $this->pagination();
            $posts_per_page = $pagination['pages']['posts_per_page'];
        }

        $offset = 0;
        if( $page > 0 ) {
            $offset = $page * $posts_per_page;
        }

        $args = array(
            'post_type' => 'any',
            'orderby' => $this->order_by(),
            'order' => $this->order(),
            'posts_per_page' => $posts_per_page,
            'offset' => $offset,
            'post__in' => $post_ids,
        );

        $args = apply_filters( 'wpupg_get_posts_args', $args, $page, $this );

        if( $args['posts_per_page'] == -1 ) {
            $args['nopaging'] = true;
        }

        $query = new WP_Query( $args );
        $posts = $query->have_posts() ? $query->posts : array();

        return $posts;
    }

    public function draw_posts( $page = 0 )
    {
        $output = '';
        $grid_posts = $this->posts();
        $posts = $this->get_posts( $page );

        foreach( $posts as $post ) {
            $post_id = $post->ID;

            $classes = array(
                'wpupg-item',
                'wpupg-page-' . $page,
                'wpupg-post-' . $post_id,
                'wpupg-type-' . $post->post_type,
            );

            if( isset( $grid_posts['terms'][$post_id] ) ) {
                foreach( $grid_posts['terms'][$post_id] as $taxonomy => $terms ) {
                    foreach( $terms as $term ) {
                        $classes[] = 'wpupg-tax-' . $taxonomy . '-' . $term;
                    }
                }
            }

            $classes = apply_filters( 'wpupg_output_grid_classes', $classes, $this );
            $template = apply_filters( 'wpupg_output_grid_template', $this->template(), $this );
            $post = apply_filters( 'wpupg_output_grid_post', $post, $this );

            $output .= apply_filters( 'wpupg_output_grid_html', $template->output_string( $post, $classes ), $template, $post, $classes );
        }

        return $output;
    }

    public function draw_pagination()
    {
        $output = '';

        $grid_posts = $this->posts();
        $nbr_posts = count( $grid_posts['all'] );

        $pagination = $this->pagination();
        $pagination_type = $this->pagination_type();

        $pagination = $pagination[$pagination_type];

        if( $pagination_type == 'pages' ) {
            $nbr_pages = ceil( $nbr_posts / floatval( $pagination['posts_per_page'] ) );

            for( $page = 0; $page < $nbr_pages; $page++ ) {
                $active = $page == 0 ? ' active' : '';
                $output .= '<div class="wpupg-pagination-term wpupg-page-' . $page . $active . '" data-page="' . $page . '">' . ($page+1) . '</div>';
            }
        }
        return $output;
    }
}