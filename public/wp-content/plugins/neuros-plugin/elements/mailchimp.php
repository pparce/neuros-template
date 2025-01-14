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
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Neuros_Mailchimp_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_mailchimp';
    }

    public function get_title() {
        return esc_html__('MailChimp', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-mailchimp';
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_script_depends() {
        return ['elementor_widgets'];
    }

    public function get_categories() {
        return ['neuros_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_display_form',
            [
                'label' => esc_html__('Display Form', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'neuros_plugin'),
                'type' => Controls_Manager::TEXT,
                'default' => ''
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Title Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'title_settings_section',
            [
                'label'     => esc_html__('Title Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'title!'  => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .mailchimp-widget-heading'
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('HTML Tag', 'neuros_plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html__( 'H1', 'neuros_plugin' ),
                    'h2' => esc_html__( 'H2', 'neuros_plugin' ),
                    'h3' => esc_html__( 'H3', 'neuros_plugin' ),
                    'h4' => esc_html__( 'H4', 'neuros_plugin' ),
                    'h5' => esc_html__( 'H5', 'neuros_plugin' ),
                    'h6' => esc_html__( 'H6', 'neuros_plugin' ),
                    'div' => esc_html__( 'div', 'neuros_plugin' ),
                    'span' => esc_html__( 'span', 'neuros_plugin' ),
                    'p' => esc_html__( 'p', 'neuros_plugin' )
                ],
                'default' => 'h5'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mailchimp-widget-heading, {{WRAPPER}}' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Field Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'fields_settings_section',
            [
                'label'     => esc_html__('Fields Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        // Field
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'field_typography',
                'label'     => esc_html__('Field Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"], 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select, 
                    {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea'
            ]
        );

        $this->start_controls_tabs('fields_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_fields_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'field_color',
                    [
                        'label'     => esc_html__('Field Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_border_color',
                    [
                        'label'     => esc_html__('Field Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields .form-field' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields .select-wrap:after' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_background_color',
                    [
                        'label'     => esc_html__('Field Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="radio"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="checkbox"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"], 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_placeholder_color',
                    [
                        'label'     => esc_html__('Field Placeholder Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields .input-floating-wrap .floating-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input:-moz-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields .wpforms-form input::-moz-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input:-ms-input-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea::-webkit-input-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:-moz-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea::-moz-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:-ms-input-placeholder' => 'color: {{VALUE}};',
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_fields_active',
                [
                    'label' => esc_html__('Active', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'field_color_focus',
                    [
                        'label'     => esc_html__('Field Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:focus' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_border_focus',
                    [
                        'label'     => esc_html__('Field Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields .form-field:focus-within' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_background_focus',
                    [
                        'label'     => esc_html__('Field Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="date"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="datetime-local"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="email"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="month"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="number"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="password"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="search"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="tel"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="text"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="time"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="url"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="week"]:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields select:focus, 
                            {{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:focus' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'field_placeholder_color_focus',
                    [
                        'label'     => esc_html__('Field Placeholder Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields .input-floating-wrap input:focus ~ .floating-placeholder,
                             {{WRAPPER}} .mc4wp-form .mc4wp-form-fields .input-floating-wrap input:not(:placeholder-shown) ~ .floating-placeholder,
                             {{WRAPPER}} .mc4wp-form .mc4wp-form-fields .input-floating-wrap textarea:focus ~ .floating-placeholder,
                             {{WRAPPER}} .mc4wp-form .mc4wp-form-fields .input-floating-wrap textarea:not(:placeholder-shown) ~ .floating-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input:focus::-webkit-input-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input:focus:-moz-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields .wpforms-form input:focus::-moz-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input:focus:-ms-input-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:focus::-webkit-input-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:focus:-moz-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:focus::-moz-placeholder' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields textarea:focus:-ms-input-placeholder' => 'color: {{VALUE}};',
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();        

        $this->add_control(
            'dark_color',
            [
                'label'     => esc_html__('Field Dark Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"], 
                     {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="radio"],
                     {{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="checkbox"]' => 'background-color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label'     => esc_html__('Field Accent Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="radio"]:checked:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="checkbox"]:checked:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-webkit-slider-thumb' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-moz-range-thumb' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-ms-thumb' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]:focus::-ms-thumb' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'thumb_color',
            [
                'label'     => esc_html__('Range Thumb Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-webkit-slider-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-moz-range-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]::-ms-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields input[type="range"]:focus::-ms-thumb' => 'background-color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        // Label
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'label_typography',
                'label'     => esc_html__('Label Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields label'
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => esc_html__('Label Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields label' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'button_settings_section',
            [
                'label'     => esc_html__('Button Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Button Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button'
            ]
        );

        $this->add_control(
            'button_border_style',
            [
                'label' => esc_html__( 'Button Border Style', 'neuros_plugin' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'gradient' => esc_html__( 'Gradient', 'neuros_plugin' ),
                    'solid' => esc_html__( 'Solid', 'neuros_plugin' ),
                ],
                'prefix_class' => 'mailchimp-button-border-style-',
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
                'prefix_class' => 'mailchimp-button-bakground-style-',
            ]
        );

        $this->start_controls_tabs('button_colors_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_button_normal',
                [
                    'label'     => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'button_text_color',
                    [
                        'label'     => esc_html__('Button Text Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_border_color',
                    [
                        'label'     => esc_html__('Button Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button' => 'border-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button:after',
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
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button' => 'background-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button .button-inner:before',
                        'condition' => [
                            'button_background_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'button_shadow',
                        'label'     => esc_html__('Button Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button'
                    ]
                );

            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_button_active',
                [
                    'label'     => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'button_text_color_hover',
                    [
                        'label'     => esc_html__('Button Text Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_border_color_hover',
                    [
                        'label'     => esc_html__('Button Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button:hover' => 'border-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button:hover:after',
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
                            '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button:hover' => 'background-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button .button-inner:after',
                        'condition' => [
                            'button_background_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'button_shadow_hover',
                        'label'     => esc_html__('Button Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} .mc4wp-form .mc4wp-form-fields button:hover'
                    ]
                );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings();
        $title              = $settings['title'];
        $title_tag          = $settings['title_tag'];
        $shortcode_attr     = '';

        $form_id = (int) get_option( 'mc4wp_default_form_id', 0 );

        if (!empty($form_id)) {
            $shortcode_attr .= ' id="' . esc_attr($form_id) . '"';
        }

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="neuros-mailchimp-widget">
            <?php
                if ( !empty($title) ) {
                    echo '<' . esc_html($title_tag) . ' class="mailchimp-widget-heading neuros-heading"><span class="neuros-heading-content">' . esc_html($title) . '</span></' . esc_html
                        ($title_tag) . '>';
                }
                if ( !empty($form_id) ) {
                    $shortcode = '[mc4wp_form' . $shortcode_attr . ']';
                    echo do_shortcode($shortcode);
                }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
