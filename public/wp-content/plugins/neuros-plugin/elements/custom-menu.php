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

class Neuros_Custom_Menu_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_custom_menu';
    }

    public function get_title() {
        return esc_html__('Custom Menu', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-nav-menu';
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
                'label' => esc_html__('Custom Menu', 'neuros_plugin')
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label'         => esc_html__('Navigation Label', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__('Enter Label Text', 'neuros_plugin')
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'         => esc_html__( 'Link', 'neuros_plugin' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_url( 'https://your-link.com' ),
                'default'       => [
                    'url'           => ''
                ]
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
            'items',
            [
                'label'         => esc_html__('Menu Items', 'neuros_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'default'       => [],
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{title}}}',
                'prevent_empty' => false
            ]
        );

        $this->add_responsive_control(
            'menu_align',
            [
                'label'     => esc_html__('Alignment', 'neuros_plugin'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'          => [
                        'title'         => esc_html__('Left', 'neuros_plugin'),
                        'icon'          => 'eicon-text-align-left',
                    ],
                    'center'        => [
                        'title'         => esc_html__('Center', 'neuros_plugin'),
                        'icon'          => 'eicon-text-align-center',
                    ],
                    'right'         => [
                        'title'         => esc_html__('Right', 'neuros_plugin'),
                        'icon'          => 'eicon-text-align-right',
                    ]
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}}'   => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Items Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_items_settings',
            [
                'label' => esc_html__('Menu Items Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'items_typography',
                'label'     => esc_html__('Labels Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} ul li a'
            ]
        );

        $this->start_controls_tabs('controls_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_control_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'labels_color',
                    [
                        'label'     => esc_html__('Labels Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} ul li a:not(:hover)' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_control_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'labels_color_hover',
                    [
                        'label' => esc_html__('Labels Color', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} ul li a:hover, {{WRAPPER}} ul li.active a' => 'color: {{VALUE}};',
                            '{{WRAPPER}} ul li.active a:before'                     => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'items_margin',
            [
                'label'         => esc_html__('Items Margin', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ul '   => 'margin: 0 -{{RIGHT}}{{UNIT}} 0 -{{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings   = $this->get_settings();
        $items      = $settings['items'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <ul class="ul">
            <?php
                foreach ($items as $item) {
                    echo '<li' . ($item['is_active'] == 'yes' ? ' class="active"' : '') . '>';
                        echo '<a href="' . esc_url($item['link']['url']) . '"' . (($item['link']['is_external'] == true) ? ' target="_blank"' : '') . (($item['link']['nofollow'] == 'on') ?
                        ' rel="nofollow"' : '') . '>';
                            echo esc_html($item['title']);
                        echo '</a>';
                    echo '</li>';
                }
            ?>
        </ul>

        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}