<?php
/*
 * Created by Artureanec
*/

namespace Neuros\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\REPEATER;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Neuros_Blog_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_blog_listing';
    }

    public function get_title() {
        return esc_html__('Blog Listing', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_categories() {
        return ['neuros_widgets'];
    }

    public function get_script_depends() {
        return ['elementor_widgets', 'wp-mediaelement', 'mediaelement-vimeo'];
    }

    public function get_style_depends() {
        return ['wp-mediaelement'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Blog Listing', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label'     => esc_html__('Type', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'classic',
                'options'   => [
                    'classic'   => esc_html__('Classic', 'neuros_plugin'),
                    'grid'      => esc_html__('Grid', 'neuros_plugin'),
                    'list'      => esc_html__('List', 'neuros_plugin'),
                ]
            ]
        );

        $this->add_control(
            'columns_number',
            [
                'label'     => esc_html__('Columns Number', 'neuros_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3,
                'min'       => 1,
                'max'       => 6,
                'condition' => [
                    'listing_type'  => 'grid'
                ]
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'     => esc_html__('Items Per Page', 'neuros_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3,
                'min'       => 1
            ]
        );

        $this->add_control(
            'filter_by',
            [
                'label'     => esc_html__('Filter by:', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => [
                    'none'      => esc_html__('None', 'neuros_plugin'),
                    'cat'       => esc_html__('Category', 'neuros_plugin'),
                    'tag'       => esc_html__('Tag', 'neuros_plugin'),
                    'id'        => esc_html__('ID', 'neuros_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'category',
            [
                'label'         => esc_html__('Categories', 'neuros_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of categories.', 'neuros_plugin'),
                'options'       => neuros_get_all_taxonomy_terms('post', 'category'),
                'condition'     => [
                    'filter_by'     => 'cat'
                ]
            ]
        );

        $this->add_control(
            'tag',
            [
                'label'         => esc_html__('Tags', 'neuros_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of tags.', 'neuros_plugin'),
                'options'       => neuros_get_all_taxonomy_terms('post', 'post_tag'),
                'condition'     => [
                    'filter_by'     => 'tag'
                ]
            ]
        );

        $this->add_control(
            'ids',
            [
                'label'         => esc_html__('IDs', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'Enter ID', 'neuros_plugin' ),
                'description'   => esc_html('Comma separated', 'neuros_plugin'),
                'default'       => '',
                'condition'     => [
                    'filter_by'     => 'id'
                ]
            ]
        );

        $this->add_control(
            'post_order_by',
            [
                'label'     => esc_html__('Order By', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'date',
                'options'   => [
                    'date'      => esc_html__('Post Date', 'neuros_plugin'),
                    'rand'      => esc_html__('Random', 'neuros_plugin'),
                    'ID'        => esc_html__('Post ID', 'neuros_plugin'),
                    'title'     => esc_html__('Post Title', 'neuros_plugin')
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'post_order',
            [
                'label'     => esc_html__('Order', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'desc',
                'options'   => [
                    'desc'      => esc_html__('Descending', 'neuros_plugin'),
                    'asc'       => esc_html__('Ascending', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'show_cat',
            [
                'label'         => esc_html__('Categories', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'separator'     => 'before',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_media',
            [
                'label'         => esc_html__('Media', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes', 
                'condition' => [
                    'listing_type!' => 'list'
                ]
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label'         => esc_html__('Author', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label'         => esc_html__('Date', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_tags',
            [
                'label'         => esc_html__('Tags', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'no',
                'return_value'  => 'yes',
                'condition' => [
                    'listing_type!' => 'list'
                ]
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'         => esc_html__('Title', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'         => esc_html__('Excerpt', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'     => esc_html__('Excerpt Length, in symbols', 'neuros_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 0,
                'default'   => 190,
                'condition' => [
                    'show_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label'         => esc_html__("'Read More' Button", 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes',
                'condition' => [
                    'listing_type!' => 'list'
                ]
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'         => esc_html__('Button Text', 'neuros_plugin'),
                'placeholder'   => esc_html__('Enter text', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Read More', 'neuros_plugin'),
                'condition'     => [
                    'listing_type!' => 'list',
                    'show_read_more'    => 'yes'
                ]
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label'         => esc_html__('Pagination', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'separator'     => 'before',
                'return_value'  => 'yes'
            ]
        );

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- General Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'general_settings_section',
            [
                'label' => esc_html__('General Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_spacing_horizontal',
            [
                'label'     => esc_html__('Horizontal Space Between Items', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 40
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-listing' =>
                        'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .grid-listing .grid-item' => 'padding-right: calc({{SIZE}}{{UNIT}}/2); padding-left: calc({{SIZE}}{{UNIT}}/2);'
                ],
                'condition' => [
                    'listing_type' => 'grid'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_spacing_vertical',
            [
                'label'     => esc_html__('Vertical Space Between Items', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 30
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-listing' =>
                        'margin-top: calc(-{{SIZE}}{{UNIT}}/2); margin-bottom: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .grid-listing .grid-item' => 'padding-top: calc({{SIZE}}{{UNIT}}/2); padding-bottom: calc({{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .classic-listing .standard-blog-item-wrapper:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .list-listing .list-item-wrapper:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label'     => esc_html__('Item Border Width', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 10
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 1
                ],
                'selectors' => [
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item:before, 
                    {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item:before' => 
                    'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .list-item-wrapper .blog-item' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_spacing_vertical',
            [
                'label'     => esc_html__('Content Spacing Vertical', 'neuros_plugin'),
                'type'      => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'placeholder' => [
                    'top' => '',
                    'right' => 'auto',
                    'bottom' => '',
                    'left' => 'auto',
                ],
                'selectors' => [
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item' =>
                        'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-media-wrapper, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-media-wrapper' =>
                        'margin-top: -{{TOP}}{{UNIT}};',
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-media-wrapper:last-child, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-media-wrapper:last-child' =>
                        'margin-bottom: -{{BOTTOM}}{{UNIT}};',
                    '{{WRAPPER}} .list-item-wrapper .blog-item' =>
                        'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'content_spacing_horizontal',
            [
                'label'     => esc_html__('Content Spacing Horizontal', 'neuros_plugin'),
                'type'      => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'horizontal',
                'placeholder' => [
                    'top' => 'auto',
                    'right' => '',
                    'bottom' => 'auto',
                    'left' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-meta-header:first-child, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-meta-header:first-child' =>
                        'margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-title, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-title' =>
                        'margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-content, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-content' =>
                        'margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-labels, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-labels' =>
                        'margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-meta-item-tags, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-meta-item-tags' =>
                        'margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}} .standard-blog-item-wrapper .blog-item .post-more-button, {{WRAPPER}} .grid-blog-item-wrapper .blog-item .post-more-button' => 
                        'margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type!' => 'list'
                ]   
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label'     => esc_html__('Item Border Radius', 'neuros_plugin'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item, {{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-media-wrapper picture, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item .post-media-wrapper picture' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .post-quote' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'listing_type!' => 'list'
                ]
            ]
        );

        $this->start_controls_tabs('general_colors_tabs');

            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_general_colors_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'post_bg_color',
                    [
                        'label'     => esc_html__('Item Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .blog-item' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type!' => 'list'
                        ]
                    ]
                );

                $this->add_control(
                    'post_bd_color',
                    [
                        'label'     => esc_html__('Item Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item:before, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item:before' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .list-item-wrapper .blog-item' => 'border-color: {{VALUE}};',
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'post_shadow',
                        'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} .blog-item',
                        'condition' => [
                            'listing_type!' => 'list'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_general_colors_active',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'post_bg_hover',
                    [
                        'label'     => esc_html__('Item Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .blog-item:hover' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'listing_type!' => 'list'
                        ]
                    ]
                );

                $this->add_control(
                    'post_bd_hover',
                    [
                        'label'     => esc_html__('Item Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .standard-blog-item-wrapper:not(.neuros-format-quote) .blog-item:hover:before, {{WRAPPER}} .grid-blog-item-wrapper:not(.neuros-format-quote) .blog-item:hover:before' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .list-item-wrapper .blog-item:hover' => 'border-color: {{VALUE}};',
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'post_hover_shadow',
                        'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} .blog-item:hover',
                        'condition' => [
                            'listing_type!' => 'list'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'content_settings_section',
            [
                'label'         => esc_html__('Content Settings', 'neuros_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'conditions'    => [
                    'relation'      => 'or',
                    'terms'         => [
                        [
                            'name'      => 'show_author',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_date',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_tags',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_title',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_excerpt',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_read_more',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .blog-item .post-title',
                'condition' => [
                    'show_title'    => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('content_title_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_title_normal',
                [
                    'label'     => esc_html__('Normal', 'neuros_plugin'),
                    'condition' => [
                        'show_title'    => 'yes'
                    ]
                ]
            );
                $this->add_control(
                    'title_color_normal',
                    [
                        'label'     => esc_html__('Title Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .blog-item .post-title, {{WRAPPER}} .blog-item .post-title a' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after',
                        'condition' => [
                            'show_title'    => 'yes'
                        ]
                    ]
                );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_title_hover',
                [
                    'label'     => esc_html__('Hover', 'neuros_plugin'),
                    'condition' => [
                        'show_title'    => 'yes'
                    ]
                ]
            );
                $this->add_control(
                    'title_color_hover',
                    [
                        'label'     => esc_html__('Title Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .blog-item .post-title a:hover' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_title'    => 'yes'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'excerpt_typography',
                'label'     => esc_html__('Excerpt Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .post-content',
                'condition' => [
                    'show_excerpt' => 'yes'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__('Excerpt Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-content' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'show_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'meta_typography',
                'label'         => esc_html__('Meta Typography', 'neuros_plugin'),
                'selector'      => '{{WRAPPER}} .post-meta-header',
                'exclude'       => ['line_height'],
                'conditions'    => [
                    'relation'      => 'and',
                    'terms'         => [
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name'      => 'show_author',
                                    'operator'  => '===',
                                    'value'     => 'yes',
                                ],
                                [
                                    'name'      => 'show_date',
                                    'operator'  => '===',
                                    'value'     => 'yes',
                                ]
                            ]                            
                        ],
                        [
                            'terms' => [
                                [
                                    'name'      => 'listing_type',
                                    'operator'  => '!==',
                                    'value'     => 'list',
                                ],
                            ]
                        ]
                    ]
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'list_meta_typography',
                'label'         => esc_html__('Month/Year Typography', 'neuros_plugin'),
                'selector'      => '{{WRAPPER}} .post-meta-item-month-year',
                'condition'    => [
                    'listing_type' => 'list',
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'list_meta_day_typography',
                'label'         => esc_html__('Day Typography', 'neuros_plugin'),
                'selector'      => '{{WRAPPER}} .post-meta-item-day',
                'condition'    => [
                    'listing_type' => 'list',
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'list_author_typography',
                'label'         => esc_html__('Author Typography', 'neuros_plugin'),
                'selector'      => '{{WRAPPER}} .post-meta-item-author',
                'condition'    => [
                    'listing_type' => 'list',
                    'show_author' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'meta_separator_color',
            [
                'label'     => esc_html__('Meta Separator Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-header .post-meta-item:not(:last-child):after' => 'color: {{VALUE}};'
                ],
                'conditions' => [
                    'relation'      => 'and',
                    'terms'         => [
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name'      => 'show_author',
                                    'operator'  => '===',
                                    'value'     => 'yes',
                                ],
                                [
                                    'name'      => 'show_date',
                                    'operator'  => '===',
                                    'value'     => 'yes',
                                ]
                            ]                            
                        ],
                        [
                            'terms' => [
                                [
                                    'name'      => 'listing_type',
                                    'operator'  => '!==',
                                    'value'     => 'list',
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        );

        $this->start_controls_tabs('content_meta_tabs', [
            'conditions' => [
                'relation'      => 'and',
                'terms'         => [
                    [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name'      => 'show_author',
                                'operator'  => '===',
                                'value'     => 'yes',
                            ],
                            [
                                'name'      => 'show_date',
                                'operator'  => '===',
                                'value'     => 'yes',
                            ]
                        ]                            
                    ],
                    [
                        'terms' => [
                            [
                                'name'      => 'listing_type',
                                'operator'  => '!==',
                                'value'     => 'list',
                            ],
                        ]
                    ]
                ]
            ]
        ]);
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_meta_normal',
                [
                    'label'         => esc_html__('Normal', 'neuros_plugin')
                ]
            );
                $this->add_control(
                    'meta_color_normal',
                    [
                        'label'     => esc_html__('Meta Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-meta-header .post-meta-item, {{WRAPPER}} .post-meta-header .post-meta-item a' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_meta_hover',
                [
                    'label'         => esc_html__('Hover', 'neuros_plugin'),
                ]
            );
                $this->add_control(
                    'meta_color_hover',
                    [
                        'label'     => esc_html__('Meta Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-meta-header .post-meta-item a:hover' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'list_day_color',
            [
                'label'     => esc_html__('Day Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .list-item-wrapper .post-meta-item-day' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'listing_type' => 'list',
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'list_month_year_color',
            [
                'label'     => esc_html__('Month/Year Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .list-item-wrapper .post-meta-item-month-year' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'listing_type' => 'list',
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('list_meta_tabs', [
            'condition' => [
                'listing_type' => 'list',
                'show_author' => 'yes'
            ]
        ]);
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'list_meta_normal',
                [
                    'label'         => esc_html__('Normal', 'neuros_plugin')
                ]
            );

            $this->add_control(
                'author_color_normal',
                [
                    'label'     => esc_html__('Author Color', 'neuros_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .list-item-wrapper .post-meta-item-author, {{WRAPPER}} .list-item-wrapper .post-meta-item-author a' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'list_meta_hover',
                [
                    'label'         => esc_html__('Hover', 'neuros_plugin')
                ]
            );

            $this->add_control(
                'author_color_hover',
                [
                    'label'     => esc_html__('Author Color', 'neuros_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .list-item-wrapper .post-meta-item-author a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();
            $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'more_typography',
                'label'     => esc_html__('More Button Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .post-more-button a',
                'condition' => [
                    'listing_type!' => 'list',
                    'show_read_more' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'more_color',
            [
                'label'     => esc_html__('More Button Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-more-button a'       => 'color: {{VALUE}};',
                    '{{WRAPPER}} .post-more-button a span'  => 'background-image: linear-gradient(0deg, {{VALUE}} 0%, {{VALUE}} 100%);',
                    '{{WRAPPER}} .post-more-button a svg'   => 'stroke: {{VALUE}};'
                ],
                'condition' => [
                    'listing_type!' => 'list',
                    'show_read_more' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'tags_typography',
                'label'     => esc_html__('Tags Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .post-meta-item-tags',
                'condition' => [
                    'listing_type!' => 'list',
                    'show_tags' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('content_tags_tabs', [
            'condition' => [
                'listing_type!' => 'list',
                'show_tags' => 'yes'
            ]
        ]);

            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_tags_normal',
                [
                    'label'     => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'tags_color_normal',
                    [
                        'label'     => esc_html__('Tags Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-meta-item-tags, {{WRAPPER}} .post-meta-item-tags a' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_tags_hover',
                [
                    'label'     => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'tags_color_hover',
                    [
                        'label'     => esc_html__('Tags Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-meta-item-tags a:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // ----------------------------------------- //
        // ---------- Pagination Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'pagination_settings_section',
            [
                'label'     => esc_html__('Pagination Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'pagination_typography',
                'label'     => esc_html__('Pagination Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .content-pagination .page-numbers, {{WRAPPER}} .content-pagination .post-page-numbers',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'pagination_bd_style',
            [
                'label' => esc_html__( 'Pagination Border Style', 'neuros_plugin' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'gradient',
                'options' => [
                    'gradient' => esc_html__( 'Gradient', 'neuros_plugin' ),
                    'solid' => esc_html__( 'Solid', 'neuros_plugin' ),
                ],
                'prefix_class' => 'listing-pagination-border-style-',
            ]
        );

        $this->add_control(
            'pagination_bg_style',
            [
                'label' => esc_html__( 'Pagination Background Style', 'neuros_plugin' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'gradient' => esc_html__( 'Gradient', 'neuros_plugin' ),
                    'solid' => esc_html__( 'Solid', 'neuros_plugin' ),
                ],
                'prefix_class' => 'listing-pagination-background-style-',
            ]
        );

        $this->start_controls_tabs('pagination_tags_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_pagination_normal',
                [
                    'label'     => esc_html__('Normal', 'neuros_plugin'),
                    'condition' => [
                        'pagination' => 'yes'
                    ]
                ]
            );

                $this->add_control(
                    'pagination_color',
                    [
                        'label'     => esc_html__('Pagination Text Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)' => 'color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'pagination_border_color',
                    [
                        'label'     => esc_html__('Pagination Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination_bd_style' => 'solid'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'pagination_border_color_gradient',
                        'fields_options' => [
                            'background' => [
                                'label' => esc_html__( 'Border Color Gradient', 'neuros_plugin' )
                            ]                    
                        ],
                        'types' => [ 'gradient' ],
                        'selector' => '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover):after, {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover):after',
                        'condition' => [
                            'pagination_bd_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_control(
                    'pagination_background_color',
                    [
                        'label'     => esc_html__('Pagination Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination_bg_style' => 'solid'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'pagination_bg_color_gradient',
                        'fields_options' => [
                            'background' => [
                                'label' => esc_html__( 'Background Color Gradient', 'neuros_plugin' )
                            ]                    
                        ],
                        'types' => [ 'gradient' ],
                        'selector' => '{{WRAPPER}} .content-pagination .page-numbers .button-inner:before, {{WRAPPER}} .content-pagination .post-page-numbers .button-inner:before',
                        'condition' => [
                            'pagination_bg_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'pagination_shadow',
                        'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)'
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_pagination_active',
                [
                    'label'     => esc_html__('Active', 'neuros_plugin'),
                    'condition' => [
                        'pagination' => 'yes'
                    ]
                ]
            );

                $this->add_control(
                    'pagination_color_active',
                    [
                        'label'     => esc_html__('Pagination Text Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover' => 'color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'pagination_border_color_active',
                    [
                        'label'     => esc_html__('Pagination Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination_bd_style' => 'solid'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'pagination_border_color_gradient_active',
                        'fields_options' => [
                            'background' => [
                                'label' => esc_html__( 'Border Color Gradient', 'neuros_plugin' )
                            ]                    
                        ],
                        'types' => [ 'gradient' ],
                        'selector' => '{{WRAPPER}} .content-pagination .page-numbers.current:after, {{WRAPPER}} .content-pagination .page-numbers:hover:after, {{WRAPPER}} .content-pagination .post-page-numbers.current:after, {{WRAPPER}} .content-pagination .post-page-numbers:hover:after',
                        'condition' => [
                            'pagination_bd_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_control(
                    'pagination_background_color_active',
                    [
                        'label'     => esc_html__('Pagination Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'pagination_bg_style' => 'solid'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'pagination_bg_color_gradient_active',
                        'fields_options' => [
                            'background' => [
                                'label' => esc_html__( 'Background Color Gradient', 'neuros_plugin' )
                            ]                    
                        ],
                        'types' => [ 'gradient' ],
                        'selector' => '{{WRAPPER}} .content-pagination .page-numbers .button-inner:after, {{WRAPPER}} .content-pagination .post-page-numbers .button-inner:after',
                        'condition' => [
                            'pagination_bg_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'pagination_shadow_active',
                        'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover'
                    ]
                );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        // ----------------------------------------- //
        // ---------- Categories Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'categories_settings_section',
            [
                'label'     => esc_html__('Categories Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cat'  => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cat_typography',
                'label'     => esc_html__('Categories Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .post-categories .post-category-item',
                'separator' => 'before'
            ]
        );

        $this->start_controls_tabs('content_cat_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_cat_normal',
                [
                    'label'     => esc_html__('Normal', 'neuros_plugin')
                ]
            );
                $this->add_control(
                    'cat_color_normal',
                    [
                        'label'     => esc_html__('Categories Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-categories .post-category-item, {{WRAPPER}} .sticky .blog-item:after, {{WRAPPER}} .status-sticky .blog-item:after' => 'color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_cat_hover',
                [
                    'label'     => esc_html__('Hover', 'neuros_plugin')
                ]
            );
                $this->add_control(
                    'cat_color_hover',
                    [
                        'label'     => esc_html__('Categories Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .post-categories .post-category-item:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();

        $listing_type           = $settings['listing_type'];
        $columns_number         = ($listing_type == 'grid' && !empty($settings['columns_number']) ) ? (int)$settings['columns_number'] : 1;
        $posts_per_page         = (int)$settings['posts_per_page'];
        $post_order_by          = $settings['post_order_by'];
        $post_order             = $settings['post_order'];
        $pagination             = $settings['pagination'];
        $filter_by              = $settings['filter_by'];
        $category_filter        = !empty($settings['category']) && $filter_by == 'cat' ? implode(',', $settings['category']) : '';
        $tag_filter             = !empty($settings['tag']) && $filter_by == 'tag' ? implode(',', $settings['tag']) : '';
        $id_filter              = !empty($settings['ids']) && $filter_by == 'id' ? explode(',', str_replace(' ', '', $settings['ids'])) : '';

        global $wp;
        $base = home_url($wp->request);

        $ignore_sticky_posts    = !empty($settings['ids']) && $filter_by == 'id' ? true : false;

        $wrapper_class          = 'archive-listing-wrapper';
        if( $listing_type == 'grid' && !empty($columns_number) ) {
            $wrapper_class .= ' grid-listing columns-' . esc_attr($columns_number);
        } elseif( $listing_type == 'classic' ) {
            $wrapper_class .= ' classic-listing';
        } else {
            $wrapper_class .= ' list-listing';
        }

        $widget_params          = array(
            'listing_type'          => $listing_type,
            'excerpt_length'        => $settings['excerpt_length'],
            'show_cat'              => $settings['show_cat'],
            'show_media'            => $settings['show_media'],
            'show_author'           => $settings['show_author'],
            'show_date'             => $settings['show_date'],
            'show_title'            => $settings['show_title'],
            'show_tags'             => $settings['show_tags'],
            'show_excerpt'          => $settings['show_excerpt'],
            'show_read_more'        => $settings['show_read_more'],
            'read_more_text'        => $settings['read_more_text'],
            'columns_number'        => $columns_number,
            'show_pagination'       => $pagination
        );

        if( $listing_type == 'grid' ) {
            $widget_params['item_class'] = 'post grid-item grid-blog-item-wrapper';
        } elseif( $listing_type == 'classic' ) {
            $widget_params['item_class'] = 'post standard-blog-item-wrapper';
        } else {
            $widget_params['item_class'] = 'post list-item-wrapper';
        }
        $paged  = isset( $_GET[esc_attr($this->get_id()) . '-paged'] ) && $pagination == 'yes' ? (int)$_GET[esc_attr($this->get_id()) . '-paged'] : 1;

        $args   = array(
            'post_type'             => 'post',
            'posts_per_page'        => $posts_per_page,
            'orderby'               => $post_order_by,
            'order'                 => $post_order,
            'paged'                 => $paged,
            'category_name'         => $category_filter,
            'tag'                   => $tag_filter,
            'post__in'              => $id_filter,
            'ignore_sticky_posts'   => $ignore_sticky_posts,
            'link_base'             => esc_url($base)
        );

        $query = new \WP_Query($args);
        $ajax_data = wp_json_encode($args);
        $widget_data = wp_json_encode($widget_params);

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="archive-listing" data-ajax='<?php echo esc_attr($ajax_data); ?>' data-widget='<?php echo esc_attr($widget_data); ?>'>
            <div class="<?php echo esc_attr($wrapper_class); ?>">
                <?php
                    while( $query->have_posts() ){
                        $query->the_post();
                        get_template_part('content', null, $widget_params);
                    }
                    wp_reset_postdata();
                ?>
            </div>

            <?php
                if ( $pagination == 'yes' && $query->max_num_pages > 1 ) {
                    echo '<div class="content-pagination">';
                        echo '<nav class="navigation pagination" role="navigation">';
                            echo '<h2 class="screen-reader-text">' . esc_html__('Pagination', 'neuros_plugin') . '</h2>';
                            echo '<div class="nav-links">';                        
                                echo paginate_links( array(
                                    'format'    => '?' . esc_attr($this->get_id()) . '-paged=%#%',
                                    'current'   => max( 1, $paged ),
                                    'total'     => $query->max_num_pages,
                                    'end_size'  => 2,
                                    'before_page_number' => '<span class="button-inner"></span>',
                                    'prev_text' => esc_html__('Previous', 'neuros_plugin') . '<span class="button-inner"></span><span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>',
                                    'next_text' => esc_html__('Next', 'neuros_plugin') . '<span class="button-inner"></span><span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>'
                                ) );
                            echo '</div>';
                        echo '</nav>';
                    echo '</div>';
                }
            ?>
        </div>
        <?php
        wp_reset_query();
    }

    protected function content_template() {}

    public function render_plain_content() {}
}