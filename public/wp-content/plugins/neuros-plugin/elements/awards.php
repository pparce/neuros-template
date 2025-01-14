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

class Neuros_Awards_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_awards';
    }

    public function get_title() {
        return esc_html__('Awards', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-font';
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
                'label' => esc_html__('Awards', 'neuros_plugin')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'year',
            [
                'label'         => esc_html__( 'Year', 'neuros_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => '',
                'placeholder'   => esc_html__( 'Enter Year', 'neuros_plugin' ),
            ]
        );

        $repeater->add_control(
            'subtitle',
            [
                'label'         => esc_html__( 'Subtitle', 'neuros_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => '',
                'placeholder'   => esc_html__( 'Enter Subtitle', 'neuros_plugin' ),
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'         => esc_html__( 'Title', 'neuros_plugin' ),
                'type'          => Controls_Manager::WYSIWYG,
                'label_block'   => true,
                'default'       => '',
                'placeholder'   => esc_html__( 'Enter Title', 'neuros_plugin' ),
            ]
        );

        $repeater->add_control(
            'title_link',
            [
                'label'         => esc_html__('Title Link', 'neuros_plugin'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'           => '',
                    'is_external'   => 'true',
                ],
                'placeholder'   => esc_html__( 'http://your-link.com', 'neuros_plugin' )
            ]
        );

        $this->add_control(
            'awards_list',
            [
                'label'         => esc_html__('Awards List', 'neuros_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'prevent_empty' => false,
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'     => esc_html__('Title HTML Tag', 'neuros_plugin'),
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
                'default'   => 'h4'
            ]
        );

        $this->end_controls_section();

        // ----------------------------------------- //
        // ---------- Awards Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Awards Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'         => esc_html__('Award Padding', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .awards-list .award-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label'     => esc_html__('Award Border Width', 'neuros_plugin'),
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
                    '{{WRAPPER}} .awards-list .award-item:before' =>
                        'border-bottom-width: {{SIZE}}{{UNIT}};',
                ]
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
                'name'      => 'year_typography',
                'label'     => esc_html__('Year Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .award-year'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'subtitle_typography',
                'label'     => esc_html__('Subtitle Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .award-subtitle'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .award-title'
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

        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__('Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awards-list .award-item:before' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'year_color',
            [
                'label'     => esc_html__('Year Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .award-year' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'     => esc_html__('Subtitle Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .award-subtitle' => 'color: {{VALUE}};'
                ]
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
                            '{{WRAPPER}} .award-title, {{WRAPPER}} .award-title a' => 'color: {{VALUE}};'
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
                        'label'     => esc_html__('Title Hover Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .award-title a:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings               = $this->get_settings();
        
        $awards_list            = $settings['awards_list'];
        $title_tag              = $settings['title_tag'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="neuros-awards-widget">
            <div class="awards-list">
                <?php

                if ( !empty($awards_list) ) {
                    foreach ($awards_list as $award) { ?>
                    <div class="award-item">
                        <div class="award-year-column">
                            <?php
                                if( !empty($award['year']) ) {
                                    echo '<span class="award-year">' . esc_html($award['year']) . '</span>';
                                }
                            ?>
                        </div>
                        <div class="award-subtitle-column">
                            <?php
                                if( !empty($award['subtitle']) ) {
                                    echo '<span class="award-subtitle">' . esc_html($award['subtitle']) . '</span>';
                                }
                            ?>
                        </div>
                        <div class="award-title-column">
                            <?php
                                if( !empty($award['title']) ) {
                                    echo '<' . esc_html($title_tag) . ' class="award-title">';
                                        if( !empty($award['title_link']['url']) ) {
                                            echo '<a href="' . esc_url($award['title_link']['url']) . '"' . ( $award['title_link']['is_external'] == true ? ' target="_blank"' : '') . ( $award['title_link']['nofollow'] == 'on' ? ' rel="nofollow"' : '') . '>';
                                        }
                                            echo wp_kses($award['title'], array(
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

                                        if( !empty($award['title_link']['url']) ) {
                                            echo '</a>';
                                        }
                                    echo '</' . esc_html($title_tag) . '>';
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