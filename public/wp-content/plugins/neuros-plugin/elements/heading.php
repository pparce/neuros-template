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

class Neuros_Heading_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_heading';
    }

    public function get_title() {
        return esc_html__('Heading', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-heading';
    }

    public function get_categories() {
        return ['neuros_widgets'];
    }
    
    public function get_script_depends() {
        return ['elementor_widgets'];
    }
    
    public function is_reload_preview_required() {
        return true;
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'         => esc_html__('Heading', 'neuros_plugin'),
                'type'          => Controls_Manager::WYSIWYG,
                'rows'          => '10',
                'default'       => esc_html__( 'This is heading element', 'neuros_plugin' ),
                'placeholder'   => esc_html__( 'Enter Your Heading', 'neuros_plugin' )
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
                'default'       => esc_html__( 'Subheading', 'neuros_plugin' ),
                'placeholder'   => esc_html__( 'Enter Your Subheading', 'neuros_plugin'),
                'label_block'   => true,
                'condition'     => [
                    'add_subtitle'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'remove_subtitle_decoration',
            [
                'label'         => esc_html__('Remove Subheading Decoration', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'off',
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'prefix_class' => 'neuros-heading-subheading-decoration-',
                'condition'     => [
                    'add_subtitle'  => 'yes',
                    'subtitle!'      => ''
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

        $this->add_responsive_control(
            'title_align',
            [
                'label'     => esc_html__('Alignment', 'neuros_plugin'),
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
                    '{{WRAPPER}} .neuros-heading' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section();

        // -------------------------------------- //
        // ---------- Heading Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_heading_settings',
            [
                'label' => esc_html__('Heading Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'subheading_spacing',
            [
                'label'     => esc_html__('Space After Subheading', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],                
                'selectors' => [
                    '{{WRAPPER}} .neuros-subheading:not(:last-child)' =>
                        'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'add_subtitle' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Heading Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .neuros-heading'
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

        $this->add_control(
            'add_gradient_color',
            [
                'label'         => esc_html__('Add Gradient Color', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin')
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'accent_bg_color',
                'label'     => esc_html__( 'Text Gradient Color', 'neuros_plugin' ),
                'fields_options' => [
                    'background' => [
                        'label'     => esc_html__( 'Text Gradient Color', 'neuros_plugin' ),
                    ]
                ],
                'types'     => [ 'gradient' ],
                'selector'  => '{{WRAPPER}} .neuros-heading .neuros-heading-content del',
                'condition' => [
                    'add_gradient_color' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'gradient_style',
            [
                'label'     => esc_html__('Gradient Block Style', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    ''             => esc_html__('Default', 'neuros_plugin'),
                    'inline'       => esc_html__('Inline', 'neuros_plugin'),
                    'inline-block' => esc_html__('Inline Block', 'neuros_plugin'),
                    'block'        => esc_html__('Block', 'neuros_plugin'),
                ],
                'selectors' => [
                	'{{WRAPPER}} .neuros-heading-content.has_gradient_color_text del' => 'display: {{VALUE}};'
                ],
                'condition' => [
                    'add_gradient_color' => 'yes'
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

        $this->add_control(
            'heading_filter_blur',
            [
                'label' => esc_html__( 'Heading Backdrop Blur Filter, px', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 25,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'backdrop-filter: blur( {{SIZE}}px ); -webkit-backdrop-filter: blur( {{SIZE}}px );',
                ],
            ]            
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings           = $this->get_settings_for_display();
        $title_tag          = $settings['title_tag'];
        $heading            = $settings['heading'];
        $add_subtitle       = $settings['add_subtitle'];
        $subtitle           = $settings['subtitle'];
        $add_gradient_color = $settings['add_gradient_color'];


        $content_class = '';
        if ( $add_gradient_color === 'yes' ) {
        	$content_class .= ' has_gradient_color_text';
        }


        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        if ( !empty($heading) ) {
            echo '<div class="neuros-heading-widget">';
                echo '<' . esc_html($title_tag) . ' class="neuros-heading">';
                    if ( $add_subtitle == 'yes' && !empty($subtitle) ) {
                        echo '<span class="neuros-subheading">' . esc_html($subtitle) . '</span>';
                    }
                    echo '<span class="neuros-heading-content' . esc_attr($content_class) . '">';
                        echo wp_kses($heading, array(
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
                                'title'     => true,
                                'style'     => true
                            ),
                            'em'        => array(),
                            'strong'    => array(),
                            'del'       => array()
                        ));
                    echo '</span>';
                echo '</' . esc_html($title_tag) . '>';
            echo '</div>';
        }
    }

    protected function content_template() {}

    public function render_plain_content() {}
}