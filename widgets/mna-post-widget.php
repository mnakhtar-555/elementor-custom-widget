<?php

class Custom_Posts_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom-posts-widget';
    }

    public function get_title() {
        return 'Custom Posts Widget';
    }

    public function get_icon() {
        return 'eicon-posts';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'mna_post_types',
            [
                'label' => __( 'Available Post Type', 'mnalang' ),
            ]
        );

        $this->add_control(
            'mna_posts',
            [
                'label' => __('Select Post Type', 'mnalang'),
                'type'  => \Elementor\Controls_Manager::SELECT,
                'options'=> $this->mna_get_post_types(),
                'default'=> '0'
            ]
        );
        $this->end_controls_section();

        // Featured Image Controls
        $this->start_controls_section(
            'section_featured_image',
            [
                'label' => __( 'Featured Image', 'your-text-domain' ),
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => __( 'Image Size', 'your-text-domain' ),
                'type'  => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
            ]
        );

        $this->add_control(
            'image_border',
            [
                'label' => __( 'Image Border', 'your-text-domain' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __( 'Offset', 'your-text-domain' ),
                'type'  => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );

        // Add more image controls as needed

        $this->end_controls_section();

        // Post Content Controls
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Post Content', 'your-text-domain' ),
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
			]
		);

        $this->add_control(
            'content_color',
            [
                'label' => __( 'Color', 'your-text-domain' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
            ]
        );

        // Add more content controls as needed

        $this->end_controls_section();

        // Post Container Controls
        $this->start_controls_section(
            'section_post_container',
            [
                'label' => __( 'Post Container', 'your-text-domain' ),
            ]
        );

        $this->add_control(
            'container_background',
            [
                'label' => __( 'Background Color', 'your-text-domain' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
            ]
        );

        $this->add_control(
            'container_border',
            [
                'label' => __( 'Border', 'your-text-domain' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            ]
        );

        // Add more container controls as needed

        $this->end_controls_section();

        // Recent Posts List
        $this->start_controls_section(
            'section_recent_posts',
            [
                'label' => __( 'Recent Posts', 'your-text-domain' ),
            ]
        );

        $this->add_control(
            'recent_posts_thumbnail_size',
            [
                'label' => __( 'Thumbnail Size', 'your-text-domain' ),
                'type'  => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
            ]
        );

        $this->end_controls_section();
        
        //Post Meta part
        $this->start_controls_section(
            'section_post_meta',
            [
                'label'     => __( 'Meta Info', 'your-text-domain' ),
            ]
        );
        $this->add_responsive_control(
            'post_meta_style',
            [
                'type'      => \Elementor\Controls_Manager::DIMENSIONS,
                'label'     => esc_html__( 'Margin', 'your-text-domain' ),
                'size_unites'=> [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors'  => [
                    '{{WRAPPER}} .meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ],
            ]
        );
    }

    protected function render() {
        $settings = $this->get_settings();
    
        // Output recent posts in two columns
        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 4,
        ];
    
        $query = new \WP_Query( $args );
    
        if ( $query->have_posts() ) {
            echo '<div class="blog-list">';
            while ( $query->have_posts() ) {
                $query->the_post();
                echo '<div class="blog-card">';
                echo '<div class="banner">';
                the_post_thumbnail( $settings['image_size']['width'], $settings['image_size']['height'] );
                echo '</div>';
                echo '<div class="content">';
                echo '<h2><a href="'.get_the_permalink().'">' . get_the_title() . '</a></h2>';
                echo '<p>' . get_the_content() . '</p>';
                echo '<div class="meta">';
                echo '<div class="custom-post-date">' . get_the_date() . '</div>';
                echo '<div class="custom-post-comments"><i class="fas fa-comments"></i> ' . get_comments_number() . '</div>';
                // Display share icon
                echo '<span class="share-icon"><i class="eicon-share"></i></span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            wp_reset_postdata();
        }
    }

    private function mna_get_post_types() {

        $post_types = array();

        $mna_post_types = get_post_types(array('public' => true), 'objects');
        $excluded_post_types = array('page', 'attachment', 'elementor_templates', 'landingpage');

        foreach ($mna_post_types as $post_type) {
            if (!in_array($post_type->name, $excluded_post_types)) {
                $post_types[$post_type->name] = $post_type->labels->singular_name;
            }
        }
        return $post_types;
    }
    
}
