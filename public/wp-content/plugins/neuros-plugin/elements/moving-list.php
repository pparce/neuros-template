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

class Neuros_Moving_List_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_moving_list';
    }

    public function get_title() {
        return esc_html__('Moving List', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['neuros_widgets'];
    }

    public function get_script_depends() {
        return ['gsap', 'elementor_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Moving List', 'neuros_plugin')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label'         => esc_html__( 'Title', 'neuros_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '',
                'placeholder'   => esc_html__( 'Enter Title', 'neuros_plugin' ),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'         => esc_html__('Link', 'neuros_plugin'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'           => '',
                    'is_external'   => 'true',
                ],
                'placeholder'   => esc_html__( 'http://your-link.com', 'neuros_plugin' )
            ]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__( 'Item Background', 'neuros_plugin' )
                    ]                    
                ],
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.moving-item .moving-item-inner'
            ]
        );

        $repeater->start_controls_tabs(
            'item_title_color_tabs'
        );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $repeater->start_controls_tab(
                'item_tab_color_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $repeater->add_control(
                    'item_title_color',
                    [
                        'label'     => esc_html__('Title Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .moving-list {{CURRENT_ITEM}} .moving-item-title' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $repeater->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $repeater->start_controls_tab(
                'item_tab_color_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $repeater->add_control(
                    'item_title_color_hover',
                    [
                        'label'     => esc_html__('Title Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .moving-list {{CURRENT_ITEM}} a:hover .moving-item-title' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $repeater->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__( 'Item Height', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 1000
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .moving-item-inner' => 'padding-bottom: {{SIZE}}{{UNIT}};'                
                ]
            ]
        );

        $this->add_control(
            'moving_list',
            [
                'label'         => esc_html__('Moving List Items', 'neuros_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{title}}}',
                'prevent_empty' => true,
                'separator'     => 'before'
            ]
        );

        $this->end_controls_section();

        // ----------------------------------------- //
        // ---------- Moving List Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Moving List Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'items_spacing',
            [
                'label' => esc_html__( 'Items Spacing', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 20
                ],
                'selectors' => [
                    '{{WRAPPER}} .moving-list' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .moving-list .moving-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2);'
                ]
            ]
        );

        $this->add_responsive_control(
            'items_width',
            [
                'label' => esc_html__( 'Items Width', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 1000
                    ],
                    'em'        => [
                        'min'       => 0,
                        'max'       => 40
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .moving-list .moving-item' => 'width: {{SIZE}}{{UNIT}};'                
                ]
            ]
        );

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__( 'Items Height', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 1000
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .moving-list .moving-item-inner' => 'padding-bottom: {{SIZE}}{{UNIT}};'                
                ]
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label'         => esc_html__('Items Border Radius', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .moving-list .moving-item .moving-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'overflow',
            [
                'label' => esc_html__( 'Items Overflow', 'neuros_plugin' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'Default', 'neuros_plugin' ),
                    'hidden' => esc_html__( 'Hidden', 'neuros_plugin' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .neuros-moving-list-widget' => 'overflow: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Typography Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_typography_settings',
            [
                'label' => esc_html__('Typography Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .moving-list .moving-item .moving-item-title'
            ]
        );        

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Color Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_color_settings',
            [
                'label' => esc_html__('Color Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'items_bg',
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__( 'Items Background', 'neuros_plugin' )
                    ]                    
                ],
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .moving-item .moving-item-inner'
            ]
        );

        $this->start_controls_tabs(
            'title_color_tabs'
        );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_color_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'title_color',
                    [
                        'label'     => esc_html__('Title Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .moving-item .moving-item-title' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_color_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'title_color_hover',
                    [
                        'label'     => esc_html__('Title Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .moving-item a:hover .moving-item-title' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();
        
        $moving_list            = $settings['moving_list'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="neuros-moving-list-widget">
            <div class="moving-list">
                <?php
                    if ( !empty($moving_list) ) {
                        foreach ($moving_list as $item) { ?>
                        <div class="moving-item elementor-repeater-item-<?php esc_attr_e($item['_id'])?>">
                            <div class="moving-item-inner">
                                <?php
                                    if( !empty($item['link']['url']) ) {
                                        echo '<a href="' . esc_url($item['link']['url']) . '"' . ( $item['link']['is_external'] == true ? ' target="_blank"' : '') . ( $item['link']['nofollow'] == 'on' ? ' rel="nofollow"' : '') . ' class="moving-item-link">';
                                    }
                                        if( !empty($item['title']) ) {
                                            echo '<span class="moving-item-title">' . esc_html($item['title']) . '</span>';
                                        }
                                    if( !empty($item['link']['url']) ) {
                                        echo '</a>';
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                        }
                    }
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}