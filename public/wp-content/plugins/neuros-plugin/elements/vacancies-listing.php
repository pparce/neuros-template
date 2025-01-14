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

class Neuros_Vacancies_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_vacancies_listing';
    }

    public function get_title() {
        return esc_html__('Careers Listing', 'neuros_plugin');
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
                'label' => esc_html__('Careers Listing', 'neuros_plugin')
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
                'label'         => esc_html__('Career Departments', 'neuros_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of departments.', 'neuros_plugin'),
                'options'       => neuros_get_all_taxonomy_terms('neuros_vacancy', 'neuros_careers_department'),
                'condition'     => [
                    'filter_by'     => 'cat'
                ]
            ]
        );

        $this->add_control(
            'vacancies',
            [
                'label'         => esc_html__('Choose Careers', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => neuros_get_all_post_list('neuros_vacancy'),
                'label_block'   => true,
                'multiple'      => true,
                'condition'     => [
                    'filter_by'     => 'id'
                ]
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'     => esc_html__('Excerpt Length, in symbols', 'neuros_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 0,
                'default'   => 118
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


        // ----------------------------------- //
        // ---------- List Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_grid_settings',
            [
                'label'         => esc_html__('List Settings', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'grid_posts_per_page',
            [
                'label'         => esc_html__('Items Per Page', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => -1
            ]
        );

        $this->end_controls_section();


        // ----------------------------------- //
        // ---------- Item Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'item_settings_section',
            [
                'label'     => esc_html__('Item Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
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
                        'max'       => 60
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 34
                ],
                'selectors' => [
                    '{{WRAPPER}} .vacancy-listing-wrapper'                          => 'margin-top: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .vacancy-listing-wrapper .vacancy-item-wrapper'    => 'padding-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs('item_colors_tabs');

            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_item_colors_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'post_bd_color',
                    [
                        'label'     => esc_html__('Item Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .vacancy-item-wrapper' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'post_shadow',
                        'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} .vacancy-item-wrapper'
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_item_colors_active',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'post_bd_hover',
                    [
                        'label'     => esc_html__('Item Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .vacancy-item-wrapper:hover' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'post_hover_shadow',
                        'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} .vacancy-item-wrapper:hover'
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
                'label'     => esc_html__('Content Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'occupation_typography',
                'label'     => esc_html__('Occupation Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .vacancy-item .vacancy-occupation'
            ]
        );

        $this->add_control(
            'occupation_color',
            [
                'label'     => esc_html__('Occupation Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vacancy-item .vacancy-occupation' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'city_typography',
                'label'     => esc_html__('City Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .vacancy-item .vacancy-city'
            ]
        );

        $this->add_control(
            'city_color',
            [
                'label'     => esc_html__('City Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vacancy-item .vacancy-city' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'name_typography',
                'label'     => esc_html__('Name Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .vacancy-item .vacancy-post-title'
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label'     => esc_html__('Name Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vacancy-item .vacancy-post-title' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'excerpt_typography',
                'label'     => esc_html__('Excerpt Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .vacancy-item .vacancy-item-excerpt'
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__('Excerpt Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vacancy-item .vacancy-item-excerpt' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'salary_value_typography',
                'label'     => esc_html__('Salary Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .vacancy-item .vacancy-salary .vacancy-salary-value'
            ]
        );

        $this->add_control(
            'salary_value_color',
            [
                'label'     => esc_html__('Salary Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vacancy-item .vacancy-salary .vacancy-salary-value' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Button Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
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
                'type' => \Elementor\Controls_Manager::SLIDER,
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
                    'show_pagination'   => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'pagination_typography',
                'label'     => esc_html__('Pagination Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .content-pagination .page-numbers, {{WRAPPER}} .content-pagination .post-page-numbers'
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

    }

    protected function render() {
        $settings       = $this->get_settings();

        $post_order_by          = $settings['post_order_by'];
        $post_order             = $settings['post_order'];
        $filter_by              = $settings['filter_by'];
        $categories             = $settings['categories'];
        $vacancies              = $settings['vacancies'];
        $excerpt_length         = $settings['excerpt_length'];
        $pagination             = $settings['show_pagination'];
        $paged                  = isset( $_GET[esc_attr($this->get_id()) . '-paged'] ) && $pagination == 'yes' ? (int)$_GET[esc_attr($this->get_id()) . '-paged'] : 1;

        $grid_columns_number    = 1;
        $grid_posts_per_page    = $settings['grid_posts_per_page'];

        $widget_class           = 'neuros-vacancy-listing-widget';
        $wrapper_class          = 'archive-listing-wrapper vacancy-listing-wrapper';
        $widget_attr            = '';
        $wrapper_attr           = '';

        global $wp;
        $base = home_url($wp->request);

        $query_options          = [
            'post_type'             => 'neuros_vacancy',
            'ignore_sticky_posts'   => true,
            'suppress_filters'      => true,
            'orderby'               => sanitize_key($post_order_by),
            'order'                 => sanitize_key($post_order),
            'link_base'             => esc_url($base)
        ];

        if ( $filter_by == 'cat' ) {
            $query_options = array_merge($query_options, [
                'neuros_careers_department'  => $categories
            ]);
        } elseif ( $filter_by == 'id' ) {
            $query_options = array_merge($query_options, [
                'post__in'          => $vacancies
            ]);
        };

        $wrapper_class      .= ' vacancy-grid-listing' . ( !empty($grid_columns_number) ? ' columns-' . esc_attr($grid_columns_number) : '' );
        $widget_options     = array(
            'item_class'            => 'vacancy-item-wrapper',
            'columns_number'        => absint($grid_columns_number),
            'excerpt_length'        => $excerpt_length,
            'show_pagination'       => $pagination
        );
        $query_options      = array_merge($query_options, [
            'posts_per_page'        => ( !empty($grid_posts_per_page) ? $grid_posts_per_page : -1 ),
            'paged'                 => $paged
        ]);

        $query = new \WP_Query($query_options);
        $ajax_data = wp_json_encode($query_options);
        $widget_data = wp_json_encode($widget_options);

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="<?php echo esc_attr($widget_class); ?>"<?php echo esc_html($widget_attr); ?>>

            <div class="archive-listing" data-ajax='<?php echo esc_attr($ajax_data); ?>' data-widget='<?php echo esc_attr($widget_data); ?>'>
                <div class="<?php echo esc_attr($wrapper_class); ?>"<?php echo esc_html($wrapper_attr); ?>>
                    <?php
                        while( $query->have_posts() ){
                            $query->the_post();
                            get_template_part('content', 'neuros_vacancy', $widget_options);
                        };
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

        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}