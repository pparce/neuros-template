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

class Neuros_Price_Item_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_price_item';
    }

    public function get_title() {
        return esc_html__('Price Item', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-price-table';
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
                'label' => esc_html__('Price Item', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'block_type',
            [
                'label'     => esc_html__('Price Item Type', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'standard',
                'options'   => [
                    'standard'  => esc_html__('Standard', 'neuros_plugin'),
                    'wide'      => esc_html__('Wide', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'block_style',
            [
                'label'     => esc_html__('Price Item Style', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    ''      => esc_html__('Default', 'neuros_plugin'),
                    'alt'   => esc_html__('Alternative', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'active_block_status',
            [
                'label'         => esc_html__('Highlight this block?', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'return_value'  => 'yes',
                'default'       => 'no'
            ]
        );

        $this->add_control(
            'title',
            [
                'label'     => esc_html__('Title', 'neuros_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => ''
            ]
        );

        $this->add_control(
            'item_label',
            [
                'label'     => esc_html__('Label', 'neuros_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => ''
            ]
        );        

        $this->add_control(
            'description',
            [
                'label'         => esc_html__('Short Description', 'neuros_plugin'),
                'description'   => esc_html__('Enter description', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => ''
            ]
        );

        $this->add_control(
            'image',
            [
                'label'     => esc_html__('Image', 'neuros_plugin'),
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'block_type' => 'standard'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'default'   => 'full',
                'condition' => [
                    'block_type' => 'standard'
                ]
            ]
        );

        $this->add_control(
            'currency',
            [
                'label'         => esc_html__('Currency', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => '$',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'currency_position',
            [
                'label'     => esc_html__('Currency Position', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'before',
                'options'   => [
                    'before'    => esc_html__('Before Price', 'neuros_plugin'),
                    'after'     => esc_html__('After Price', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'price',
            [
                'label'     => esc_html__('Price', 'neuros_plugin'),
                'type'      => Controls_Manager::TEXT,
                'default'   => ''
            ]
        );

        $this->add_control(
            'period',
            [
                'label'         => esc_html__('Period', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__('month', 'neuros_plugin')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label'         => esc_html__( 'Text', 'neuros_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => '',
                'placeholder'   => esc_html__( 'Enter Text', 'neuros_plugin' ),
            ]
        );

        $repeater->add_control(
            'is_active',
            [
                'label'         => esc_html__('Highlight this field', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'return_value'  => 'yes',
                'default'       => 'no'
            ]
        );

        $this->add_control(
            'custom_fields',
            [
                'label'         => esc_html__('Custom Fields', 'neuros_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'prevent_empty' => true,
                'separator'     => 'before',
                'default'       => [
                    [
                        'text'      => '',
                        'is_active' => 'no'
                    ]
                ]
            ]
        );

        $this->add_control(
            'price_button_text',
            [
                'label'         => esc_html__('Button Text', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Get started', 'neuros_plugin'),
                'placeholder'   => esc_html__('Button Text', 'neuros_plugin'),
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'         => esc_html__('Button Link', 'neuros_plugin'),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_url('http://your-link.com'),
                'default'       => [
                    'url'   => '',
                ]
            ]
        );

        $this->end_controls_section();

        // ----------------------------------------- //
        // ---------- Price Item Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Price Item Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'item_color',
            [
                'label'     => esc_html__('Item Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-title,
                     {{WRAPPER}} .price-item .price-item-container,
                     {{WRAPPER}} .price-item .price-item-custom-fields,
                     {{WRAPPER}} .price-item .price-item-description' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'item_bg',
                'label'             => esc_html__( 'Background', 'neuros_plugin' ),
                'types'             => [ 'classic', 'gradient' ],
                'fields_options'    => [
                    'color' => [
                        'label'     => esc_html__('Background Color', 'neuros_plugin')
                    ]
                ],
                'selector'          => '{{WRAPPER}} .price-item'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'item_bg_add',
                'label'             => esc_html__( 'Background', 'neuros_plugin' ),
                'types'             => [ 'classic', 'gradient' ],
                'fields_options'    => [
                    'background' => [
                        'label'     => esc_html__('Additional Background', 'neuros_plugin')
                    ]
                ],
                'selector'          => '{{WRAPPER}} .price-item-image-block',
                'condition' => [
                    'block_type'  => 'standard',
                    'block_style' => 'alt'
                ]
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__( 'Border Width', 'neuros_plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-item' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .price-item .price-item-label-wrapper' => 'top: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__('Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'         => esc_html__('Border Radius', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .price-item, {{WRAPPER}} .price-item-image-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'item_shadow',
                'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .price-item',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'         => esc_html__('Item Padding', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .price-item.price-item-type-standard' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .price-item.price-item-type-wide .price-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Title Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_title_settings',
            [
                'label' => esc_html__('Title Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .price-item-title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'     => esc_html__('Space After Title', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item-title:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Label Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_label_settings',
            [
                'label' => esc_html__('Label Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'label_typography',
                'label'     => esc_html__('Label Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-item-label'
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => esc_html__('Label Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-label' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'label_bg_color',
            [
                'label'     => esc_html__('Label Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-label' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .price-item .price-item-label-wrapper:before,
                     {{WRAPPER}} .price-item .price-item-label-wrapper:after' => 'box-shadow: 0 -20px 0 0 {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'label_padding',
            [
                'label'         => esc_html__('Label Padding', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .price-item .price-item-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Image Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_image_settings',
            [
                'label'     => esc_html__('Image Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'block_type'    => 'standard'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'     => esc_html__('Space After Image', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item-image:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'block_type'    => 'standard'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------------ //
        // ---------- Price Block Settings ---------- //
        // ------------------------------------------ //
        $this->start_controls_section(
            'section_price_settings',
            [
                'label' => esc_html__('Price Block Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => esc_html__('Price Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-wrapper .price'
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__('Price Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-wrapper .price' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'currency_typography',
                'label'     => esc_html__('Currency Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-wrapper .currency'
            ]
        );

        $this->add_control(
            'currency_color',
            [
                'label'     => esc_html__('Currency Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-wrapper .currency' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'period_typography',
                'label'     => esc_html__('Period Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-item-period'
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label'     => esc_html__('Period Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-period' => 'color: {{VALUE}};'
                ],
                'separator' => 'after'
            ]
        );

        $this->add_responsive_control(
            'price_margin',
            [
                'label'     => esc_html__('Space After Price', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item-container:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_content_settings',
            [
                'label' => esc_html__('Content Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'fields_margin',
            [
                'label'     => esc_html__('Space Between Fields', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 20
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-custom-field:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'fields_typography',
                'label'     => esc_html__('Custom Fields Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-item-custom-field',
                'separator' => 'after'
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label'     => esc_html__('Space After Content', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item-custom-fields:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'block_type'    => 'standard'
                ]
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
                    'fields_color',
                    [
                        'label'     => esc_html__('Custom Fields Text Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .price-item .price-item-custom-field:not(.active)' => 'color: {{VALUE}};'
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
                    'active_fields_color',
                    [
                        'label'     => esc_html__('Custom Fields Text Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .price-item .price-item-custom-field.active' => 'color: {{VALUE}};'
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'label'     => esc_html__('Description Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .price-item .price-item-description'
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__('Description Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-item .price-item-description' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label'     => esc_html__('Space After Description', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-item-description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'block_type'    => 'standard'
                ]
            ]
        );

        $this->end_controls_section();

        // ------------------------------------- //
        // ---------- Button Settings ---------- //
        // ------------------------------------- //
        $this->start_controls_section(
            'section_button_settings',
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
                'selector'  => '{{WRAPPER}} .price-item-button-container .neuros-button'
            ]
        );

        $this->add_control(
            'button_border_width',
            [
                'label' => esc_html__( 'Border Width', 'neuros_plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-item-button-container .neuros-button' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .price-item-button-container .neuros-button' => '--button-border-width: {{SIZE}}{{UNIT}};',                    
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
                            '{{WRAPPER}} .price-item-button-container .neuros-button' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_border_color',
                    [
                        'label'     => esc_html__('Button Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .price-item-button-container .neuros-button' => 'border-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .price-item-button-container .neuros-button:after',
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
                            '{{WRAPPER}} .price-item-button-container .neuros-button' => 'background-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .price-item-button-container .neuros-button .button-inner:before',
                        'condition' => [
                            'button_background_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow',
                        'selector' => '{{WRAPPER}} .price-item-button-container .neuros-button',
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
                            '{{WRAPPER}} .price-item-button-container .neuros-button:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_border_color_hover',
                    [
                        'label'     => esc_html__('Button Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .price-item-button-container .neuros-button:hover' => 'border-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .price-item-button-container .neuros-button:hover:after',
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
                            '{{WRAPPER}} .price-item-button-container .neuros-button:hover' => 'background-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .price-item-button-container .neuros-button .button-inner:after',
                        'condition' => [
                            'button_background_style' => 'gradient'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow_hover',
                        'selector' => '{{WRAPPER}} .price-item-button-container .neuros-button',
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
                    '{{WRAPPER}} .price-item-button-container .neuros-button' => '{{VALUE}}',
                    '{{WRAPPER}} .price-item-button-container .neuros-button:hover' => '{{VALUE}}',
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
                    '{{WRAPPER}} .price-item-button-container .neuros-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'         => esc_html__('Button Padding', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .price-item-button-container .neuros-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .price-item-button-container .neuros-button:hover' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();

        $block_type             = $settings['block_type'];
        $block_style            = $settings['block_style'];
        $title                  = $settings['title'];
        $item_label             = $settings['item_label'];
        $image                  = $settings['image'];
        $active_block_status    = $settings['active_block_status'];
        $currency               = $settings['currency'];
        $currency_position      = $settings['currency_position'];
        $price                  = $settings['price'];
        $period                 = $settings['period'];
        $custom_fields          = $settings['custom_fields'];
        $description            = $settings['description'];
        $price_button_text      = $settings['price_button_text'];
        $button_link            = $settings['button_link'];
        $button_url             = $button_link['url'];

        if ( !empty($price_button_text) && empty($button_url) ) {
            $button_url         = '#';
        }
        $price_item_class = $active_block_status === 'yes' ? ' active' : '';
        $price_item_class .= ' price-item-type-' . esc_attr($block_type);
        $price_item_class .= ($block_type == 'wide' && $block_style === 'alt') ? ' price-item-style-alt' : '';

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="neuros-price-item-widget<?php echo (($block_type === 'standard' && $block_style === 'alt') ? ' neuros-price-item-style-alt' : ''); ?>">
            <div class="price-item<?php echo esc_attr($price_item_class) ?>">
                
                <?php
                    if ($item_label !== '') {
                        echo '<div class="price-item-label-wrapper">';
                            echo '<div class="price-item-label">';
                                echo esc_html($item_label);
                            echo '</div>';
                        echo '</div>';
                    }
                ?>
                <div class="price-item-inner">

                    <?php
                    if ($block_type === 'wide' && ($title !== '' || !empty($description))) {
                        echo '<div class="price-item-title-wrapper">';
                    }
                    if ($title !== '') {
                        echo '<div class="price-item-title">' . esc_html($title) . '</div>';
                    }
                    if ($block_type === 'wide' && $block_style === 'alt' && !empty($price) ) {
                        ?>
                        <div class="price-item-container price-item-currency-position-<?php echo esc_attr($currency_position); ?>">
                            <div class="price-wrapper">
                                <?php
                                if ( !empty($currency) && $currency_position == 'before' ) {
                                    echo '<span class="currency">' . esc_html($currency) . '</span>';
                                }

                                echo '<span class="price">' . esc_html($price) . '</span>';

                                if ( !empty($currency) && $currency_position == 'after' ) {
                                    echo '<span class="currency">' . esc_html($currency) . '</span>';
                                }
                                ?>
                            </div>

                            <?php
                            if ( !empty($period) ) {
                                echo '<div class="price-item-period">' . esc_html($period) . '</div>';
                            }
                            ?>
                        </div>
                        <?php
                    }

                    if ( $description !== '' ) {
                        echo '<div class="price-item-description">' . esc_html($description) . '</div>';
                    }
                    if ($block_type === 'wide' && ($title !== '' || !empty($description))) {
                        echo '</div>';
                    }

                    if ( $block_type === 'standard' && !empty($image['url']) ) {
                        echo '<div class="price-item-image">';
                            echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
                        echo '</div>';
                    }

                    if ( !empty($custom_fields) ) {
                        ?>
                        <div class="price-item-custom-fields">
                            <?php
                            foreach ($custom_fields as $field) {
                                $field_status_class = $field['is_active'] == 'yes' ? ' active' : '';
                                if ( !empty($field['text']) ) { ?>
                                    <div class="price-item-custom-field <?php echo esc_attr($field_status_class); ?>"><?php echo esc_html($field['text']); ?></div>
                                <?php }
                            }
                            ?>
                        </div>
                        <?php
                    }                    
                    if ($block_type === 'wide' && (!empty($price) || !empty($price_button_text))) {
                        echo '<div class="price-item-price-wrapper">';
                    }
                    if ($block_type == 'standard' || ($block_type === 'wide' && $block_style !== 'alt') && !empty($price) ) {
                        ?>
                        <div class="price-item-container price-item-currency-position-<?php echo esc_attr($currency_position); ?>">
                            <div class="price-wrapper">
                                <?php
                                if ( !empty($currency) && $currency_position == 'before' ) {
                                    echo '<span class="currency">' . esc_html($currency) . '</span>';
                                }

                                echo '<span class="price">' . esc_html($price) . '</span>';

                                if ( !empty($currency) && $currency_position == 'after' ) {
                                    echo '<span class="currency">' . esc_html($currency) . '</span>';
                                }
                                ?>
                            </div>

                            <?php
                            if ( !empty($period) ) {
                                echo '<div class="price-item-period">' . esc_html($period) . '</div>';
                            }
                            ?>
                        </div>
                        <?php
                    }?>

                    <?php
                        if ( !empty($price_button_text) ) { ?>
                            <div class="price-item-button-container">
                                <a class="neuros-button" href="<?php echo esc_url($button_url); ?>" <?php echo (($button_link['is_external'] == true) ? 'target="_blank"' : ''); echo (($button_link['nofollow'] == 'on') ? 'rel="nofollow"' : ''); ?>><?php echo esc_html($price_button_text); ?>
                                    <span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span><span class="button-inner">                                    
                                </a>
                            </div>
                        <?php }
                        if ($block_type === 'wide' && (!empty($price) || !empty($price_button_text))) {
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            <?php                
                if( $block_type === 'standard' && $block_style === 'alt' ) { ?>
                    <div class="price-item-image-block"></div>
                <?php }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}