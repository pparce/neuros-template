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

class Neuros_Wpforms_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_wpforms';
    }

    public function get_title() {
        return esc_html__('WPForms', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
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

        $forms = wpforms()->form->get();
        $form_list_default = [
            'default' => esc_html__('Select your form', 'neuros_plugin')
        ];
        $form_list = [];
        if ( !empty( $forms ) ) {
            foreach ($forms as $key => $form) {
                $form_list[$form->post_title] = $form->post_title;
            }
            $form_list = array_merge($form_list_default, $form_list);
        } else {
            $form_list['default'] = esc_html__('No forms', 'neuros_plugin');
        }
        $this->add_control(
            'form',
            [
                'label'   => esc_html__('Form', 'neuros_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => $form_list
            ]
        );

        $this->add_control(
            'add_name',
            [
                'label' => esc_html__('Display form name', 'neuros_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('No', 'neuros_plugin'),
                'label_on' => esc_html__('Yes', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'add_description',
            [
                'label' => esc_html__('Display form description', 'neuros_plugin'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_off' => esc_html__('No', 'neuros_plugin'),
                'label_on' => esc_html__('Yes', 'neuros_plugin')
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label'     => esc_html__('Text Alignment', 'neuros_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
                'options'   => [
                    'left'      => [
                        'title'     => esc_html__( 'Left', 'neuros_plugin' ),
                        'icon'      => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title'     => esc_html__( 'Center', 'neuros_plugin' ),
                        'icon'      => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title'     => esc_html__( 'Right', 'neuros_plugin' ),
                        'icon'      => 'eicon-text-align-right'
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}'   => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'submit_spacing',
            [
                'label' => esc_html__( 'Space Before Submit Button', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}}' => '--wpforms-button-size-margin-top: {{SIZE}}{{UNIT}};',              
                ],
            ]
        );

        $this->add_responsive_control(
            'textfield_height',
            [
                'label' => esc_html__( 'Text Field Height', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="range"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select' => 'height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'field_padding',
            [
                'label' => esc_html__( 'Field Padding', 'neuros_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="range"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                'selector'  => '{{WRAPPER}} .wpforms-widget-heading'
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
                'default' => 'h4'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-widget-heading' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------- //
        // ---------- Content Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'content_settings_section',
            [
                'label'         => esc_html__('Form Header Settings', 'neuros_plugin'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'conditions'    => [
                    'relation'  => 'or',
                    'terms'     => [
                        [
                            'name'      => 'add_name',
                            'operator'  => '==',
                            'value'     => 'yes'
                        ],
                        [
                            'name'      => 'add_description',
                            'operator'  => '==',
                            'value'     => 'yes'
                        ],
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'form_name_typography',
                'label'     => esc_html__('Form Name Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .wpforms-head-container .wpforms-title',
                'condition' => [
                    'add_name'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'form_name_color',
            [
                'label'     => esc_html__('Form Name Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-head-container .wpforms-title' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'add_name'  => 'yes'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'form_description_typography',
                'label'     => esc_html__('Form Description Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .wpforms-head-container .wpforms-description',
                'condition' => [
                    'add_description'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'form_description_color',
            [
                'label'     => esc_html__('Form Description Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-head-container .wpforms-description' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'add_description'  => 'yes'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------- //
        // ---------- Fields Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'fields_settings_section',
            [
                'label'     => esc_html__('Fields Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        // Field
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'field_typography',
                'label'     => esc_html__('Field Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-label-inline, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="range"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'placeholder_typography',
                'label'     => esc_html__('Floating Placeholder Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .input-floating-wrap .floating-placeholder'
            ]
        );

        $this->add_control(
            'field_color',
            [
                'label'     => esc_html__('Field Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-label-inline, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'field_placeholder_color',
            [
                'label'     => esc_html__('Field Placeholder Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .input-floating-wrap .floating-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input:-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input:-ms-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea:-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea:-ms-input-placeholder' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'field_placeholder_color_active',
            [
                'label'     => esc_html__('Field Focus Placeholder Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .input-floating-wrap input:focus ~ .floating-placeholder,
                     {{WRAPPER}} .input-floating-wrap input:not(:placeholder-shown) ~ .floating-placeholder,
                     {{WRAPPER}} .input-floating-wrap textarea:focus ~ .floating-placeholder,
                     {{WRAPPER}} .input-floating-wrap textarea:not(:placeholder-shown) ~ .floating-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input:focus::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input:focus:-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input:focus::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input:focus:-ms-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea:focus::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea:focus:-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea:focus::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea:focus:-ms-input-placeholder' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'field_border_color',
            [
                'label'     => esc_html__('Field Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="radio"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="checkbox"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .select-wrap:after' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'field_border_color_active',
            [
                'label'     => esc_html__('Field Focus Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="radio"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="checkbox"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"]:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select:focus, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select-wrap:focus-within, 
                    {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea:focus' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .select-wrap:after' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'field_background_color',
            [
                'label'     => esc_html__('Field Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="radio"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="checkbox"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="date"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="datetime-local"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="email"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="month"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="number"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="password"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="search"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="tel"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="text"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="time"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="url"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="week"], 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form select, 
                {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form textarea' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'dark_color',
            [
                'label'     => esc_html__('Field Dark Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"],
                     {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="radio"],
                     {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="checkbox"]' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label'     => esc_html__('Field Accent Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="radio"]:checked:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="checkbox"]:checked:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-webkit-slider-thumb' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-moz-range-thumb' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-ms-thumb' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]:focus::-ms-thumb' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'thumb_color',
            [
                'label'     => esc_html__('Range Thumb Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-webkit-slider-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-moz-range-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]::-ms-thumb' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-field-number-slider input[type="range"]:focus::-ms-thumb' => 'background-color: {{VALUE}};'
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
                'selector'  => '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-label'
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => esc_html__('Label Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-label' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'required_color',
            [
                'label'     => esc_html__('Required Field Sign Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-label .wpforms-required-label' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        // Description
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'label'     => esc_html__('Field Description Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-number-slider-hint, {{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-description'
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__('Field Description Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-number-slider-hint, {{WRAPPER}} div.wpforms-container-full .wpforms-form .wpforms-field-description' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
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
                'selector'  => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"], {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"], {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button'
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
                'prefix_class' => 'wpforms-button-border-style-',
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
                'prefix_class' => 'wpforms-button-bakground-style-',
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
                            '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"], 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"], 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_border_color',
                    [
                        'label'     => esc_html__('Button Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"], 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"], 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button' => 'border-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"]:after, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button:after',
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
                            '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"],
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"], 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button' => 'background-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"],
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"] .button-inner:before, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button .button-inner:before',
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
                        'selector'  => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"],
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"], 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button'
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
                            '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"]:hover, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"]:hover, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_border_color_hover',
                    [
                        'label'     => esc_html__('Button Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"]:hover, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"]:hover, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button:hover' => 'border-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"]:hover:after, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button:hover:after',
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
                            '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"]:hover,
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"]:hover, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button:hover' => '--wpforms-button-background-color-alt: {{VALUE}}; background-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"]:hover,
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"] .button-inner:after, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button .button-inner:after',
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
                        'selector'  => '{{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form input[type="submit"]:hover,
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form button[type="submit"]:hover, 
                            {{WRAPPER}} div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-page-button:hover'
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
        $add_name           = $settings['add_name'];
        $add_description    = $settings['add_description'];
        $shortcode_attr     = '';

        $form_id            = '';
        $form_name          = $settings['form'];

        $forms = wpforms()->form->get();
        if ( !empty( $forms ) ) {
            foreach ($forms as $key => $form) {
                if ($form->post_title == $form_name) {
                    $form_id = $form->ID;
                }
            }

            if (!empty($form_id)) {
                $shortcode_attr .= ' id="' . esc_attr($form_id) . '"';
            }
            if ($add_name == 'yes') {
                $shortcode_attr .= ' title="true"';
            }
            if ($add_description == 'yes') {
                $shortcode_attr .= ' description="true"';
            }
        }

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="neuros-wpforms-widget">
            <?php
                if ( !empty($title) ) {
                    echo '<' . esc_html($title_tag) . ' class="wpforms-widget-heading neuros-heading"><span class="neuros-heading-content">' . esc_html($title) . '</span></' . esc_html($title_tag) . '>';
                }
                if ( !empty($form_id) ) {
                    $shortcode = '[wpforms' . $shortcode_attr . ']';
                    echo do_shortcode($shortcode);
                }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
