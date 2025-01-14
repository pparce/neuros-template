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

class Neuros_Button_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_button';
    }

    public function get_title() {
        return esc_html__('Button', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return ['neuros_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Button', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label'     => esc_html__('Button Type', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    ''      => esc_html__('Default', 'neuros_plugin'),
                    'simple'  => esc_html__('Simple', 'neuros_plugin'),
                    'alt'  => esc_html__('Alternative', 'neuros_plugin'),
                ],
                'prefix_class' => 'neuros-button-type-'
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'     => esc_html__('Button Text', 'neuros_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('Button', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'         => esc_html__('Button Link', 'neuros_plugin'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'           => '',
                    'is_external'   => 'true',
                ],
                'placeholder'   => esc_html__( 'http://your-link.com', 'neuros_plugin' )
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label'     => esc_html__('Button Alignment', 'neuros_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title'     => esc_html__('Left', 'neuros_plugin'),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title'     => esc_html__('Center', 'neuros_plugin'),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'right'     => [
                        'title'     => esc_html__('Right', 'neuros_plugin'),
                        'icon'      => 'eicon-text-align-right',
                    ]
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .button-widget' => 'text-align: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'add_decoration',
            [
                'label'         => esc_html__('Add Decoration', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'on',
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'button_position',
            [
                'label'             => esc_html__( 'Button Position', 'neuros_plugin' ),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
                        'title'             => esc_html__( 'Left', 'neuros_plugin' ),
                        'icon'              => 'eicon-h-align-left',
                    ],
                    'top'               => [
                        'title'             => esc_html__( 'Top', 'neuros_plugin' ),
                        'icon'              => 'eicon-v-align-top',
                    ],
                    'right'             => [
                        'title'             => esc_html__( 'Right', 'neuros_plugin' ),
                        'icon'              => 'eicon-h-align-right',
                    ],
                    'bottom'               => [
                        'title'             => esc_html__( 'Bottom', 'neuros_plugin' ),
                        'icon'              => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class'      => 'decoration-position-',
                'toggle'            => false,
                'default'           => 'bottom',
                'condition' => [
                    'add_decoration' => 'on'
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
            'border_width',
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
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'neuros_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .neuros-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        'selector' => '{{WRAPPER}} .neuros-button:after, {{WRAPPER}}.neuros-button-type-alt .neuros-button',
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
                            '{{WRAPPER}} .neuros-button' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}}.decoration-position-bottom .neuros-button-decoration:before, {{WRAPPER}}.decoration-position-bottom .neuros-button-decoration:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};',
                            '{{WRAPPER}}.decoration-position-top .neuros-button-decoration:before, {{WRAPPER}}.decoration-position-top .neuros-button-decoration:after' => 'box-shadow: 0 -20px 0 0 {{VALUE}};',
                            '{{WRAPPER}}.decoration-position-left .neuros-button-decoration:before, {{WRAPPER}}.decoration-position-left .neuros-button-decoration:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};',
                            '{{WRAPPER}}.decoration-position-right .neuros-button-decoration:before, {{WRAPPER}}.decoration-position-right .neuros-button-decoration:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};'
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
                            '{{WRAPPER}} .neuros-button:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}}[class*=decoration-position] .neuros-button-decoration:hover .neuros-button' => 'color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .neuros-button:hover:after, {{WRAPPER}}.neuros-button-type-alt .neuros-button:hover',
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
                            '{{WRAPPER}} .neuros-button:hover' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}}[class*=decoration-position] .neuros-button-decoration:hover .neuros-button' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}}.decoration-position-bottom .neuros-button-decoration:hover:before, {{WRAPPER}}.decoration-position-bottom .neuros-button-decoration:hover:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};',
                            '{{WRAPPER}}.decoration-position-top .neuros-button-decoration:hover:before, {{WRAPPER}}.decoration-position-top .neuros-button-decoration:hover:after' => 'box-shadow: 0 -20px 0 0 {{VALUE}};',
                            '{{WRAPPER}}.decoration-position-left .neuros-button-decoration:hover:before, {{WRAPPER}}.decoration-position-left .neuros-button-decoration:hover:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};',
                            '{{WRAPPER}}.decoration-position-right .neuros-button-decoration:hover:before, {{WRAPPER}}.decoration-position-right .neuros-button-decoration:hover:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};'
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
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
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
                    '{{WRAPPER}}:not(.neuros-button-type-simple) .neuros-button:hover' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_position',
            [
                'label' => esc_html__( 'Icon Position', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .neuros-button span[class^="icon"].left' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .neuros-button span[class^="icon"].right' => 'right: {{SIZE}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .neuros-button span[class^="icon"].left' => 'right: {{SIZE}}{{UNIT}}; left: initial;',
                    'body.rtl {{WRAPPER}} .neuros-button span[class^="icon"].right' => 'left: {{SIZE}}{{UNIT}}; right: initial;',                    
                ],
                'condition' => [
                    'button_type!' => 'simple'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings       = $this->get_settings();

        $button_type    = $settings['button_type'];
        $button_text    = $settings['button_text'];
        $button_link    = $settings['button_link'];

        $add_decoration = $settings['add_decoration'];

        if ($button_link['url'] !== '') {
            $button_url = $button_link['url'];
        } else {
            $button_url = '#';
        }

        $this->add_link_attributes( 'link', $button_link );

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="button-widget">
            <div class="button-container">
                <?php
                    if ($add_decoration == 'on') {
                        echo '<span class="neuros-button-decoration">';
                    }
                ?>
                <a class="neuros-button" href="<?php echo esc_url($button_url); ?>" <?php $this->print_render_attribute_string('link'); ?>><?php echo esc_html($button_text); ?>
                        <span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>                    
                    <span class="button-inner"></span>
                </a>
                <?php
                    if ($add_decoration == 'on') {
                        echo '</span>';
                    }
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
