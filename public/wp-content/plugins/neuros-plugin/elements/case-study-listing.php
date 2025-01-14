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
use Elementor\REPEATER;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Neuros_Case_Study_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_case_study_listing';
    }

    public function get_title() {
        return esc_html__('Case Study Listing', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-gallery-justified';
    }

    public function get_categories() {
        return ['neuros_widgets'];
    }

    public function get_script_depends() {
        return ['elementor_widgets', 'wp-mediaelement'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Case Study Listing', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label'     => esc_html__('Type', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'neuros_plugin'),
                    'classic'   => esc_html__('Classic', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'grid_columns_number',
            [
                'label'         => esc_html__('Columns Number', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => 1,
                'max'           => 6,
                'condition'     => [
                    'listing_type' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'         => esc_html__('Items Per Page', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => -1
            ]
        );

        $this->add_control(
            'post_order_by',
            [
                'label'         => esc_html__('Order By', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'date',
                'options'       => [
                    'date'          => esc_html__('Post Date', 'neuros_plugin'),
                    'rand'          => esc_html__('Random', 'neuros_plugin'),
                    'ID'            => esc_html__('Post ID', 'neuros_plugin'),
                    'title'         => esc_html__('Post Title', 'neuros_plugin')
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'post_order',
            [
                'label'         => esc_html__('Order', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'desc',
                'options'       => [
                    'desc'          => esc_html__('Descending', 'neuros_plugin'),
                    'asc'           => esc_html__('Ascending', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'filter_by',
            [
                'label'         => esc_html__('Filter by:', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'none',
                'options'       => [
                    'none'          => esc_html__('None', 'neuros_plugin'),
                    'cat'           => esc_html__('Category', 'neuros_plugin'),
                    'id'            => esc_html__('ID', 'neuros_plugin')
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'         => esc_html__('Categories', 'neuros_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of categories.', 'neuros_plugin'),
                'options'       => neuros_get_all_taxonomy_terms('neuros_case_study', 'neuros_case_study_category'),
                'condition'     => [
                    'filter_by'     => 'cat'
                ]
            ]
        );

        $this->add_control(
            'case_studies',
            [
                'label'         => esc_html__('Choose Case Study', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => neuros_get_all_post_list('neuros_case_study'),
                'label_block'   => true,
                'multiple'      => true,
                'condition'     => [
                    'filter_by'     => 'id'
                ]
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
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_name',
            [
                'label'         => esc_html__('Post Name', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes'
            ]
        );

        $this->add_control(
            'show_features',
            [
                'label'         => esc_html__('Features', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'default'       => 'yes',
                'return_value'  => 'yes',
                'condition'     => [
                    'listing_type' => 'classic'
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
                'condition'     => [
                    'listing_type' => 'classic'
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
                    'listing_type' => 'classic',
                    'show_read_more'    => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__('Show Pagination', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes'
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
            'item_spacing',
            [
                'label'     => esc_html__('Space between items', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 80
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 40
                ],
                'selectors' => [
                    '{{WRAPPER}} .case-study-grid-listing' =>
                        'margin: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .case-study-grid-listing .grid-blog-item-wrapper' => 'padding: calc({{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .case-study-classic-listing .classic-blog-item-wrapper:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'                   
                ]
            ]
        );

        $this->add_group_control(
           Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__( 'Item Border', 'neuros_plugin' ),
                'selector' => '{{WRAPPER}} .case-study-item',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'neuros_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .case-study-item, {{WRAPPER}} .post-media-wrapper picture' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',                    
                ],
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
                    '{{WRAPPER}} .case-study-item' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'post_shadow',
                'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .case-study-item'
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
                    '{{WRAPPER}} .case-study-item:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'post_hover_shadow',
                'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .case-study-item:hover'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Image Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'image_settings_section',
            [
                'label'         => esc_html__('Image Settings', 'neuros_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'    => [
                    'show_media' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'media_border_radius',
            [
                'label' => esc_html__( 'Image Border Radius', 'neuros_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .post-media-wrapper picture' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',                    
                ],
            ]
        );

        $this->add_responsive_control(
            'media_height',
            [
                'label' => esc_html__( 'Image Height', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case-study-listing-wrapper .case-study-item .post-media-wrapper > a' => 'padding-bottom: {{SIZE}}{{UNIT}} !important;',                 
                ],
            ]
        );

        $this->add_responsive_control(
            'media_height_add',
            [
                'label' => esc_html__( 'Image Height Additional', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .case-study-listing-wrapper.case-study-grid-listing.columns-2 .grid-blog-item-wrapper:nth-child(4n+1) .post-media-wrapper > a, 
                     {{WRAPPER}} .case-study-listing-wrapper.case-study-grid-listing.columns-2 .grid-blog-item-wrapper:nth-child(4n) .post-media-wrapper > a' => 'padding-bottom: {{SIZE}}{{UNIT}} !important;',                 
                ],
                'condition' => [
                    'show_media' => 'yes',
                    'listing_type' => 'grid',
                    'grid_columns_number' => 2
                ]
            ]
        );

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
                            'name'      => 'show_name',
                            'operator'  => '===',
                            'value'     => 'yes',
                        ],
                        [
                            'name'      => 'show_features',
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

        $this->add_responsive_control(
            'name_padding',
            [
                'label' => esc_html__( 'Post Name Padding', 'neuros_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .case-study-item .post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',                    
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'name_typography',
                'label'     => esc_html__('Post Name Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .case-study-item .post-title',
                'condition' => [
                    'show_name'    => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('content_name_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_name_normal',
                [
                    'label'     => esc_html__('Normal', 'neuros_plugin'),
                    'condition' => [
                        'show_name'    => 'yes'
                    ]
                ]
            );
                $this->add_control(
                    'name_color_normal',
                    [
                        'label'     => esc_html__('Post Name Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .case-study-item .post-title, {{WRAPPER}} .case-study-item .post-title a' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_name'    => 'yes'
                        ]
                    ]
                );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_name_hover',
                [
                    'label'     => esc_html__('Hover', 'neuros_plugin'),
                    'condition' => [
                        'show_name'    => 'yes'
                    ]
                ]
            );
                $this->add_control(
                    'name_color_hover',
                    [
                        'label'     => esc_html__('Post Name Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .case-study-item .post-title a:hover' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'show_name'    => 'yes'
                        ]
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'hr1',
            [
                'type'      => Controls_Manager::DIVIDER,
                'condition' => [
                    'show_name'    => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'features_typography',
                'label'     => esc_html__('Features Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .case-study-features',
                'condition' => [
                    'listing_type' => 'classic',
                    'show_features' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'features_color',
            [
                'label'     => esc_html__('Features Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .case-study-features' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'listing_type' => 'classic',
                    'show_features' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'hr2',
            [
                'type'      => Controls_Manager::DIVIDER,
                'condition' => [
                    'listing_type' => 'classic',
                    'show_features' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'month_year_typography',
                'label'         => esc_html__('Month/Year Typography', 'neuros_plugin'),
                'selector'      => '{{WRAPPER}} .post-meta-item-date .post-meta-item-month-year',
                'condition'    => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'day_typography',
                'label'         => esc_html__('Day Typography', 'neuros_plugin'),
                'selector'      => '{{WRAPPER}} .post-meta-item-date .post-meta-item-day',
                'condition'    => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('content_date_tabs');
        // ------ Normal Tab ------ //
        $this->start_controls_tab(
            'tab_content_date_normal',
            [
                'label'         => esc_html__('Normal', 'neuros_plugin'),
                'condition'    => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label'     => esc_html__('Date Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-date a' => 'color: {{VALUE}};'
                ],
                'condition'    => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'date_bg_color',
            [
                'label'     => esc_html__('Date Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-date a' => 'background-color: {{VALUE}};'
                ],
                'condition'    => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->end_controls_tab();

        // ------ Hover Tab ------ //
        $this->start_controls_tab(
            'tab_content_date_hover',
            [
                'label'         => esc_html__('Hover', 'neuros_plugin'),
                'condition'    => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'date_color_hover',
            [
                'label'     => esc_html__('Date Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-date a:hover' => 'color: {{VALUE}};'
                ],
                'condition'    => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'date_bg_color_hover',
            [
                'label'     => esc_html__('Date Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-date a:hover' => 'background-color: {{VALUE}};'
                ],
                'condition'    => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'hr3',
            [
                'type'      => Controls_Manager::DIVIDER,
                'condition'    => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'tags_typography',
                'label'     => esc_html__('Tags Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .post-meta-item-tags a',
                'condition' => [
                    'show_tags' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('content_tags_tabs');

        // ------ Normal Tab ------ //
        $this->start_controls_tab(
            'tab_content_tags_normal',
            [
                'label'     => esc_html__('Normal', 'neuros_plugin'),
                'condition' => [
                    'show_tags' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'tags_color_normal',
            [
                'label'     => esc_html__('Tags Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'show_tags' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-tags a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'tags_bg_color_normal',
            [
                'label'     => esc_html__('Tags Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'show_tags' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-tags a' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'tags_bd_color_normal',
            [
                'label'     => esc_html__('Tags Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'show_tags' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-tags a' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_tab();

        // ------ Hover Tab ------ //
        $this->start_controls_tab(
            'tab_content_tags_hover',
            [
                'label'     => esc_html__('Hover', 'neuros_plugin'),
                'condition' => [
                    'show_tags' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'tags_color_hover',
            [
                'label'     => esc_html__('Tags Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-tags a:hover' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'show_tags' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'tags_bg_color_hover',
            [
                'label'     => esc_html__('Tags Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'show_tags' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-tags a:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'tags_bd_color_hover',
            [
                'label'     => esc_html__('Tags Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'show_tags' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-meta-item-tags a:hover' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Button Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'listing_type' => 'classic'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Button Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .neuros-button'
            ]
        );

        $this->add_control(
            'button_border_width',
            [
                'label' => esc_html__( 'Border Width', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .neuros-button' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .neuros-button' => '--button-border-width: {{SIZE}}{{UNIT}};',                    
                ],
            ]
        );

        $this->add_control(
            'button_border_style',
            [
                'label' => esc_html__( 'Button Border Style', 'neuros_plugin' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'gradient',
                'options' => [
                    'gradient' => esc_html__( 'Gradient', 'neuros_plugin' ),
                    'solid' => esc_html__( 'Solid', 'neuros_plugin' ),
                ],
                'prefix_class' => 'neuros-button-border-style-',
            ]
        );

        $this->add_control(
            'button_background_style',
            [
                'label' => esc_html__( 'Button Background Style', 'neuros_plugin' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'gradient' => esc_html__( 'Gradient', 'neuros_plugin' ),
                    'solid' => esc_html__( 'Solid', 'neuros_plugin' ),
                ],
                'prefix_class' => 'neuros-button-bakground-style-',
            ]
        );

        $this->start_controls_tabs('button_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_button_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'button_color',
                    [
                        'label'     => esc_html__('Button Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros-button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_border_color',
                    [
                        'label'     => esc_html__('Button Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros-button' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'button_border_style' => 'solid'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'button_border_color_gradient',
                        'fields_options' => [
                            'background' => [
                                'label' => esc_html__( 'Border Color Gradient', 'neuros_plugin' )
                            ]                    
                        ],
                        'types' => [ 'gradient' ],
                        'selector' => '{{WRAPPER}} .neuros-button:after',
                        'condition' => [
                            'button_border_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_control(
                    'button_background_color',
                    [
                        'label'     => esc_html__('Button Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros-button' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'button_background_style' => 'solid'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'button_bg_color_gradient',
                        'fields_options' => [
                            'background' => [
                                'label' => esc_html__( 'Background Color Gradient', 'neuros_plugin' )
                            ]                    
                        ],
                        'types' => [ 'gradient' ],
                        'selector' => '{{WRAPPER}} .neuros-button .button-inner:before',
                        'condition' => [
                            'button_background_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow',
                        'selector' => '{{WRAPPER}} .neuros-button',
                        'condition' => [
                            'remove_box_shadow!' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_button_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'button_color_hover',
                    [
                        'label'     => esc_html__('Button Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_border_color_hover',
                    [
                        'label'     => esc_html__('Button Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros-button:hover' => 'border-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'button_border_style' => 'solid'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'button_border_color_gradient_hover',
                        'fields_options' => [
                            'background' => [
                                'label' => esc_html__( 'Border Color Gradient', 'neuros_plugin' )
                            ]                    
                        ],
                        'types' => [ 'gradient' ],
                        'selector' => '{{WRAPPER}} .neuros-button:hover:after',
                        'condition' => [
                            'button_border_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_control(
                    'button_background_color_hover',
                    [
                        'label'     => esc_html__('Button Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros-button:hover' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'button_background_style' => 'solid'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'button_bg_color_gradient_hover',
                        'fields_options' => [
                            'background' => [
                                'label' => esc_html__( 'Background Color Gradient', 'neuros_plugin' )
                            ]                    
                        ],
                        'types' => [ 'gradient' ],
                        'selector' => '{{WRAPPER}} .neuros-button .button-inner:after',
                        'condition' => [
                            'button_background_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow_hover',
                        'selector' => '{{WRAPPER}} .neuros-button',
                        'condition' => [
                            'remove_box_shadow!' => 'yes'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'remove_box_shadow',
            [
                'label'         => esc_html__('Remove Box Shadow', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'no',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'separator'     => 'before',
                'selectors_dictionary' => [
                    'yes' => 'box-shadow: none;',
                    'no' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .neuros-button' => '{{VALUE}}',
                    '{{WRAPPER}} .neuros-button:hover' => '{{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_radius',
            [
                'label'         => esc_html__('Border Radius', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .neuros-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'         => esc_html__('Button Padding', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .neuros-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .neuros-button:hover' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};'
                ]
            ]
        );

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
                    'show_pagination' => 'yes'
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
                        'show_pagination' => 'yes'
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
                        'show_pagination' => 'yes'
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

    }

    protected function render() {
        $settings       = $this->get_settings();

        $listing_type           = $settings['listing_type'];
        $post_order_by          = $settings['post_order_by'];
        $post_order             = $settings['post_order'];
        $filter_by              = $settings['filter_by'];
        $categories             = $settings['categories'];
        $case_studies           = $settings['case_studies'];
        $show_pagination        = $settings['show_pagination'];
        $paged                  = isset( $_GET[esc_attr($this->get_id()) . '-paged'] ) && $show_pagination == 'yes' ? (int)$_GET[esc_attr($this->get_id()) . '-paged'] : 1;

        $grid_columns_number    = ($listing_type === 'grid' && !empty($settings['grid_columns_number']) ) ? (int)$settings['grid_columns_number'] : 1;
        $posts_per_page         = $settings['posts_per_page'];

        $wrapper_class          = 'archive-listing-wrapper case-study-listing-wrapper';
        $widget_attr            = '';

        global $wp;
        $base = home_url($wp->request);

        $query_options          = [
            'post_type'             => 'neuros_case_study',
            'posts_per_page'        => ( !empty($posts_per_page) ? $posts_per_page : -1 ),
            'ignore_sticky_posts'   => true,
            'suppress_filters'      => false,
            'orderby'               => sanitize_key($post_order_by),
            'order'                 => sanitize_key($post_order),
            'link_base'             => esc_url($base),
            'paged'                 => $paged
        ];

        if ( $filter_by == 'cat' ) {
            $query_options = array_merge($query_options, [
                'neuros_case_study_category'  => $categories
            ]);
        } elseif ( $filter_by == 'id' ) {
            $query_options = array_merge($query_options, [
                'post__in'          => $case_studies
            ]);
        };

        $widget_options     = array(
            'show_media'            => $settings['show_media'],
            'show_date'             => $settings['show_date'],
            'show_name'             => $settings['show_name'],
            'show_tags'             => $settings['show_tags'],
            'listing_type'          => $listing_type,
            'show_pagination'       => $show_pagination
        );

        if ( $listing_type == 'classic' ) {
            $wrapper_class      .= ' case-study-classic-listing';
            $widget_options     = array_merge($widget_options, [
                'show_features'          => $settings['show_features'],
                'show_read_more'        => $settings['show_read_more'],
                'read_more_text'        => $settings['read_more_text'],
                'item_class'            => 'classic-blog-item-wrapper',
                'columns_number'        => 1,
            ]);          
        } else {
            $wrapper_class      .= ' case-study-grid-listing' . ( !empty($grid_columns_number) ? ' columns-' . esc_attr($grid_columns_number) : '' );
            $widget_options     = array_merge($widget_options, [
                'item_class'            => 'grid-blog-item-wrapper',
                'columns_number'        => absint($grid_columns_number),
            ]);
        }

        $query = new \WP_Query($query_options);
        $ajax_data = wp_json_encode($query_options);
        $widget_data = wp_json_encode($widget_options);

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

            <div class="archive-listing" data-ajax='<?php echo esc_attr($ajax_data); ?>' data-widget='<?php echo esc_attr($widget_data); ?>'>
                <div class="<?php echo esc_attr($wrapper_class); ?>">
                    <?php
                        while( $query->have_posts() ){
                            $query->the_post();
                            get_template_part('content', 'neuros_case_study', $widget_options);
                        };
                        wp_reset_postdata();
                    ?>
                </div>

                <?php
                    if ( $show_pagination == 'yes' && $query->max_num_pages > 1 ) {
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
    }

    protected function content_template() {}

    public function render_plain_content() {}
}