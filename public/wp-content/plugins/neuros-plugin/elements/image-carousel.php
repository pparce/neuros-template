<?php
/*
 * Created by Artureanec
*/

namespace Neuros\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\REPEATER;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Neuros_Image_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_image_carousel';
    }

    public function get_title() {
        return esc_html__('Image Carousel', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-carousel-loop';
    }

    public function get_categories() {
        return ['neuros_widgets'];
    }

    public function get_script_depends() {
        return ['elementor_widgets', 'wp-mediaelement'];
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
                'label' => esc_html__('Image Carousel', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'view_type',
            [
                'label'     => esc_html__('View Type', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'type-1',
                'options'   => [
                    'type-1'    => esc_html__('Type 1', 'neuros_plugin'),
                    'type-2'    => esc_html__('Type 2', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label'         => esc_html__('Title', 'neuros_plugin'),
                'type'          => Controls_Manager::WYSIWYG
            ]
        );

        $this->add_control(
            'add_subtitle',
            [
                'label'         => esc_html__('Add Subheading', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'no',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label'         => esc_html__('Subheading', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__( 'This is subheading element', 'neuros_plugin' ),
                'placeholder'   => esc_html__( 'Enter Your Subheading', 'neuros_plugin'),
                'label_block'   => true,
                'condition'     => [
                    'add_subtitle'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'     => esc_html__('HTML Tag', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'h1'        => esc_html__( 'H1', 'neuros_plugin' ),
                    'h2'        => esc_html__( 'H2', 'neuros_plugin' ),
                    'h3'        => esc_html__( 'H3', 'neuros_plugin' ),
                    'h4'        => esc_html__( 'H4', 'neuros_plugin' ),
                    'h5'        => esc_html__( 'H5', 'neuros_plugin' ),
                    'h6'        => esc_html__( 'H6', 'neuros_plugin' ),
                    'div'       => esc_html__( 'div', 'neuros_plugin' ),
                    'span'      => esc_html__( 'span', 'neuros_plugin' ),
                    'p'         => esc_html__( 'p', 'neuros_plugin' )
                ],
                'default'   => 'h2'
            ]
        );

        $this->add_control(
            'title_align',
            [
                'label'         => esc_html__('Title Alignment', 'neuros_plugin'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'           => [
                        'title'         => esc_html__('Left', 'neuros_plugin'),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'        => [
                        'title'         => esc_html__('Center', 'neuros_plugin'),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title'         => esc_html__('Right', 'neuros_plugin'),
                        'icon'          => 'eicon-text-align-right',
                    ]
                ],
                'default'       => is_rtl() ? 'right' : 'left',
                'prefix_class'  => 'title-alignment-',
                'toggle'        => false
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label'     => esc_html__('Image', 'neuros_plugin'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url'           => Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_thumbnail',
                'default'   => 'full'
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label'         => esc_html__('Title', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
                'label_block'   => true,
                'placeholder'   => esc_html__('Enter Title', 'neuros_plugin')
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label'         => esc_html__('Description', 'neuros_plugin'),
                'type'          => Controls_Manager::WYSIWYG,
                'rows'          => '10',
                'default'       => '',
                'placeholder'   => esc_html__('Enter Description', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'carousel_items',
            [
                'label'         => esc_html__('Items', 'neuros_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{name}}}',
                'prevent_empty' => false,
                'separator'     => 'before'
            ]
        );

        $this->end_controls_section();


        // ---------------------------- //
        // ---------- Slider ---------- //
        // ---------------------------- //
        $this->start_controls_section(
            'section_slider',
            [
                'label'         => esc_html__('Slider Settings', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'items',
            [
                'label'         => esc_html__('Visible Items', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => 1,
                'max'           => 6
            ]
        );

        $this->add_control(
            'dots',
            [
                'label'         => esc_html__('Show pagination dots', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'         => esc_html__('Animation Speed', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 500
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label'         => esc_html__('Infinite Loop', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__('Autoplay', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'         => esc_html__('Autoplay Speed', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 300,
                'step'          => 100,
                'condition'     => [
                    'autoplay'      => 'yes'
                ]
            ]
        );

        $this->add_control(
            'autoplay_timeout',
            [
                'label'         => esc_html__('Autoplay Timeout', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 5000,
                'step'          => 100,
                'condition'     => [
                    'autoplay'      => 'yes'
                ]
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'         => esc_html__('Pause on Hover', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'condition'     => [
                    'autoplay'      => 'yes'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Title Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'title_settings_section',
            [
                'label'     => esc_html__('Heading Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Heading Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .neuros-heading .neuros-heading-content'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Heading Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .neuros-heading .neuros-heading-content' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'subtitle_typography',
                'label'     => esc_html__('Subheading Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .neuros-subheading',
                'condition' => [
                    'add_subtitle'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'     => esc_html__('Subheading Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .neuros-subheading' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'add_subtitle'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'accent_text_color',
            [
                'label'     => esc_html__('Text Underline Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .neuros-heading .neuros-heading-content span[style *= "text-decoration: underline"]:before' => 'background-color: {{VALUE}} !important;'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'      => 'title_shadow',
                'label'     => esc_html__('Heading Text Shadow', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .neuros-heading .neuros-heading-content'
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
                    'size'      => 30
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-wrapper' => 'margin: 0 calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .slider-wrapper .slider-item' => 'padding: 0 calc({{SIZE}}{{UNIT}}/2);'
                ]
            ]
        );



        $this->add_control(
            'item_vertical_align',
            [
                'label'     => esc_html__('Vertical Alignment', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'center',
                'options'   => [
                    'flex-start'    => esc_html__('Top', 'neuros_plugin'),
                    'center'        => esc_html__('Center', 'neuros_plugin'),
                    'flex-end'      => esc_html__('Bottom', 'neuros_plugin')
                ],
                'selectors' => [
                    '{{WRAPPER}} .owl-carousel .owl-stage' => '-webkit-align-items: {{VALUE}}; -moz-align-items: {{VALUE}}; -ms-align-items: {{VALUE}}; align-items: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'item_padding',
            [
                'label'         => esc_html__( 'Item padding', 'plugin-domain' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .slider-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'         => esc_html__( 'Item Border Radius', 'neuros_plugin' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .slider-item-inner'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_align',
            [
                'label'     => esc_html__('Item Alignment', 'neuros_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'=> [
                        'title'     => esc_html__('Left', 'neuros_plugin'),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title'     => esc_html__('Center', 'neuros_plugin'),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title'     => esc_html__('Right', 'neuros_plugin'),
                        'icon'      => 'eicon-text-align-right',
                    ]
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .slider-item-inner' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->start_controls_tabs( 'slider_item_settings_tabs' );

            $this->start_controls_tab( 'slider_item_normal',
                [
                    'label' => esc_html__( 'Normal', 'neuros_plugin' ),
                ]
            );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'      => 'item_border',
                        'label'     => esc_html__( 'Item Border', 'neuros_plugin' ),
                        'selector'  => '{{WRAPPER}} .slider-item-inner'
                    ]
                );

                $this->add_control(
                    'item_bg_color',
                    [
                        'label'     => esc_html__('Item Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'item_box_shadow',
                        'label'     => esc_html__( 'Box Shadow', 'plugin-domain' ),
                        'selector'  => '{{WRAPPER}} .slider-item-inner',
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab( 'slider_item_hover',
                [
                    'label' => esc_html__( 'Hover', 'neuros_plugin' ),
                ]
            );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'      => 'item_border_hover',
                        'label'     => esc_html__( 'Item Border', 'neuros_plugin' ),
                        'selector'  => '{{WRAPPER}} .slider-item-inner:hover'
                    ]
                );

                $this->add_control(
                    'item_bg_color_hover',
                    [
                        'label'     => esc_html__('Item Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner:hover' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'item_box_shadow_hover',
                        'label'     => esc_html__( 'Box Shadow', 'plugin-domain' ),
                        'selector'  => '{{WRAPPER}} .slider-item-inner:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Image Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'image_settings_section',
            [
                'label'     => esc_html__('Image Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label'             => esc_html__( 'Width', 'neuros_plugin' ),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'unit'  => '%',
                ],
                'tablet_default'    => [
                    'unit'  => '%',
                ],
                'mobile_default'    => [
                    'unit'  => '%',
                ],
                'size_units'        => [ '%', 'px', 'vw' ],
                'range'             => [
                    '%'     => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                    'px'    => [
                        'min'   => 1,
                        'max'   => 1000,
                    ],
                    'vw'    => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label'             => esc_html__( 'Max Width', 'neuros_plugin' ),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'unit'  => '%',
                ],
                'tablet_default'    => [
                    'unit'  => '%',
                ],
                'mobile_default'    => [
                    'unit'  => '%',
                ],
                'size_units'        => [ '%', 'px', 'vw' ],
                'range'             => [
                    '%'     => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                    'px'    => [
                        'min'   => 1,
                        'max'   => 1000,
                    ],
                    'vw'    => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label'             => esc_html__( 'Height', 'neuros_plugin' ),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'unit'  => 'px',
                ],
                'tablet_default'    => [
                    'unit'  => 'px',
                ],
                'mobile_default'    => [
                    'unit'  => 'px',
                ],
                'size_units'        => [ 'px', 'vh' ],
                'range'             => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500,
                    ],
                    'vh'    => [
                        'min'   => 1,
                        'max'   => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type'  => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'image_effects' );

            $this->start_controls_tab( 'normal',
                [
                    'label' => esc_html__( 'Normal', 'neuros_plugin' ),
                ]
            );

                $this->add_control(
                    'opacity',
                    [
                        'label'     => esc_html__( 'Opacity', 'neuros_plugin' ),
                        'type'      => Controls_Manager::SLIDER,
                        'range'     => [
                            'px'        => [
                                'max'       => 1,
                                'min'       => 0.10,
                                'step'      => 0.01,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} img' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Css_Filter::get_type(),
                    [
                        'name'      => 'css_filters',
                        'selector'  => '{{WRAPPER}} img',
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab( 'hover',
                [
                    'label' => esc_html__( 'Hover', 'neuros_plugin' ),
                ]
            );

                $this->add_control(
                    'opacity_hover',
                    [
                        'label'     => esc_html__( 'Opacity', 'neuros_plugin' ),
                        'type'      => Controls_Manager::SLIDER,
                        'range'     => [
                            'px'        => [
                                'max'       => 1,
                                'min'       => 0.10,
                                'step'      => 0.01,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} img:hover' => 'opacity: {{SIZE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Css_Filter::get_type(),
                    [
                        'name'      => 'css_filters_hover',
                        'selector'  => '{{WRAPPER}} img:hover',
                    ]
                );

                $this->add_control(
                    'background_hover_transition',
                    [
                        'label'     => esc_html__( 'Transition Duration', 'neuros_plugin' ),
                        'type'      => Controls_Manager::SLIDER,
                        'range'     => [
                            'px'        => [
                                'max'       => 3,
                                'step'      => 0.1,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} img'   => 'transition-duration: {{SIZE}}s',
                        ],
                    ]
                );

                $this->add_control(
                    'hover_animation',
                    [
                        'label' => esc_html__( 'Hover Animation', 'neuros_plugin' ),
                        'type'  => Controls_Manager::HOVER_ANIMATION,
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'neuros_plugin' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} img'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'image_box_shadow',
                'exclude'   => [
                    'box_shadow_position',
                ],
                'selector'  => '{{WRAPPER}} img',
            ]
        );

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
                'name'      => 'item_title_typography',
                'label'     => esc_html__('Title Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .slider-item-inner .slider-item-title'
            ]
        );

        $this->add_responsive_control(
            'item_title_margin',
            [
                'label'     => esc_html__('Space between title and image', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => -100,
                        'max'       => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-item-inner img:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'item_description_typography',
                'label'     => esc_html__('Description Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .slider-item-inner .slider-item-description',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'item_description_margin',
            [
                'label'     => esc_html__('Space between description and image', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => -100,
                        'max'       => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-item-inner .slider-item-description:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs('content_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_content_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'item_title_color',
                    [
                        'label'     => esc_html__('Title Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner .slider-item-title' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'item_description_color',
                    [
                        'label'     => esc_html__('Description Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner .slider-item-description' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_content_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'item_title_hover',
                    [
                        'label'     => esc_html__('Title Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner:hover .slider-item-title' => 'color: {{VALUE}};'
                        ],
                        'separator' => 'after'
                    ]
                );

                $this->add_control(
                    'item_description_hover',
                    [
                        'label'     => esc_html__('Description Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .slider-item-inner:hover .slider-item-description' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // ----------------------------------------- //
        // ---------- Slider Nav Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'slider_nav_settings_section',
            [
                'label'     => esc_html__('Slider Navigation Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('slider_pagination_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'slider_dots_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'dot_color',
                    [
                        'label'     => esc_html__('Pagination Dot Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-dots .owl-dot span:after' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'dot_border',
                    [
                        'label'     => esc_html__('Pagination Dot Border', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-dots .owl-dot span' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'slider_dots_active',
                [
                    'label' => esc_html__('Active', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'dot_active',
                    [
                        'label'     => esc_html__('Pagination Active Dot Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-dots .owl-dot.active span:after' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'dot_border_active',
                    [
                        'label'     => esc_html__('Pagination Active Dot Border', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();

        $view_type              = $settings['view_type'];
        $title                  = $settings['title'];
        $title_tag              = $settings['title_tag'];
        $add_subtitle           = $settings['add_subtitle'];
        $subtitle               = $settings['subtitle'];

        $carousel_items         = $settings['carousel_items'];

        $items                  = $settings['items'];
        $dots                   = $settings['dots'];
        $speed                  = $settings['speed'];
        $infinite               = $settings['infinite'];
        $autoplay               = $settings['autoplay'];
        $autoplay_speed         = $settings['autoplay_speed'];
        $autoplay_timeout       = $settings['autoplay_timeout'];
        $pause_on_hover         = $settings['pause_on_hover'];

        $widget_class           = 'neuros-image-slider-widget';

        $widget_id              = $this->get_id();

        $dots_container_desktop = ( !empty($title) && !empty($widget_id) ? '.owl-dots-desktop.owl-dots-' . esc_attr($widget_id) : '.owl-dots-' . esc_attr($widget_id) );
        $dots_container_mobile  = ( !empty($title) && !empty($widget_id) ? '.owl-dots-mobile.owl-dots-' . esc_attr($widget_id) : $dots_container_desktop );

        $slider_options     = [
            'items'                 => !empty($items) ? (int)$items : 1,
            'nav'                   => false,
            'dots'                  => ('yes' === $dots),
            'dotsContainer'         => $dots_container_desktop,
            'dotsContainerMobile'   => $dots_container_mobile,
            'autoplayHoverPause'    => ('yes' === $pause_on_hover),
            'autoplay'              => ('yes' === $autoplay),
            'autoplaySpeed'         => absint($autoplay_speed),
            'autoplayTimeout'       => absint($autoplay_timeout),
            'loop'                  => ('yes' === $infinite),
            'speed'                 => absint($speed),
        ];
        $wrapper_attr       = ' data-slider-options=' . esc_attr(wp_json_encode($slider_options));
        $wrapper_class      = 'owl-carousel owl-theme' . ( !empty($view_type) ? ' view-' . esc_attr($view_type) : ' view-type-1' );

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="<?php echo esc_attr($widget_class); ?>">

            <?php
                if ( !empty($title) ) {
                    echo '<' . esc_html($title_tag) . ' class="neuros-heading' . ( $dots == 'yes' ? ' heading-with-pagination' : '' ) . '">';
                        echo '<span class="neuros-heading-inner">';
                            if ( $add_subtitle == 'yes' && !empty($subtitle) ) {
                                echo '<span class="neuros-subheading">' . esc_html($subtitle) . '</span>';
                            }
                            echo '<span class="neuros-heading-content">';
                                echo wp_kses($title, array(
                                    'br'        => array(),
                                    'span'      => array(
                                        'style'     => true
                                    ),
                                    'a'         => array(
                                        'href'      => true,
                                        'target'    => true
                                    ),
                                    'img'       => array(
                                        'src'       => true,
                                        'srcset'    => true,
                                        'sizes'     => true,
                                        'class'     => true,
                                        'alt'       => true,
                                        'title'     => true
                                    ),
                                    'em'        => array(),
                                    'strong'    => array(),
                                    'del'       => array()
                                ));
                            echo '</span>';
                        echo '</span>';
                        if ( $dots == 'yes' ) {
                            echo '<div class="owl-dots owl-dots-desktop' . (!empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '') . '"></div>';
                        }
                    echo '</' . esc_html($title_tag) . '>';
                }
            ?>

            <div class="slider-wrapper">
                <div class="<?php echo esc_attr($wrapper_class); ?>"<?php echo esc_html($wrapper_attr); ?>>
                    <?php
                        foreach ($carousel_items as $item) {
                            echo '<div class="slider-item">';
                                echo '<div class="slider-item-inner">';
                                    if ( !empty($item['item_title']) ) {
                                        echo '<div class="slider-item-title">' . esc_html($item['item_title']) . '</div>';
                                    }
                                    echo Group_Control_Image_Size::get_attachment_image_html( $item, 'image_thumbnail', 'image' );
                                    if ( !empty($item['item_description']) ) {
                                        echo '<div class="slider-item-description">' . wp_kses($item['item_description'], array(
                                                'br'        => array(),
                                                'span'      => array(
                                                    'style'     => true
                                                ),
                                                'a'         => array(
                                                    'href'      => true,
                                                    'target'    => true
                                                ),
                                                'img'       => array(
                                                    'src'       => true,
                                                    'srcset'    => true,
                                                    'sizes'     => true,
                                                    'class'     => true,
                                                    'alt'       => true,
                                                    'title'     => true
                                                ),
                                                'em'        => array(),
                                                'strong'    => array(),
                                                'del'       => array()
                                            )) . '</div>';
                                    }
                                echo '</div>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>

            <?php
                if ( $dots == 'yes' ) {
                    echo '<div class="owl-dots' . ( empty($title) ? '' : ' owl-dots-mobile' ) . ( !empty($widget_id) ? ' owl-dots-' . esc_attr($widget_id) : '' ) . '"></div>';
                }
            ?>

        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}

    private function get_link_url( $attachment, $instance ) {
        if ( 'none' === $instance['link_to'] ) {
            return false;
        }

        if ( 'custom' === $instance['link_to'] ) {
            if ( empty( $instance['link']['url'] ) ) {
                return false;
            }

            return $instance['link'];
        }

        return [
            'url' => wp_get_attachment_url( $attachment['id'] ),
        ];
    }

    private function get_image_caption( $attachment ) {
        $caption_type = $this->get_settings_for_display( 'caption_type' );

        if ( empty( $caption_type ) ) {
            return '';
        }

        $attachment_post = get_post( $attachment['id'] );

        if ( 'caption' === $caption_type ) {
            return $attachment_post->post_excerpt;
        }

        if ( 'title' === $caption_type ) {
            return $attachment_post->post_title;
        }

        return $attachment_post->post_content;
    }
}