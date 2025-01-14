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
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Neuros_Audio_Listing_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_audio_listing';
    }

    public function get_title() {
        return esc_html__('Audio Listing', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-posts-ticker';
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
                'label' => esc_html__('Audio Listing', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'view_type',
            [
                'label'     => esc_html__('View Type', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'inline',
                'options'   => [
                    'inline'    => esc_html__('Inline', 'neuros_plugin'),
                    'columns'   => esc_html__('Columns', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'columns_number',
            [
                'label'     => esc_html__('Columns Number', 'neuros_plugin'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 4,
                'min'       => 1,
                'max'       => 6,
                'condition' => [
                    'view_type'  => 'columns'
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'audio',
            [
                'label'     => esc_html__('Audio', 'neuros_plugin'),
                'type'      => Controls_Manager::MEDIA,
                'media_types' => [ 'audio' ]
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'     => esc_html__('Image', 'neuros_plugin'),
                'type'      => Controls_Manager::MEDIA
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

        $this->add_control(
            'audio_items',
            [
                'label'         => esc_html__('Items', 'neuros_plugin'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{item_title}}}',
                'prevent_empty' => false,
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'hide_icon',
            [
                'label'         => esc_html__('Hide Audio Icon', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'on',
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'title_position',
            [
                'label' => esc_html__( 'Title Position', 'neuros_plugin' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'right',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'neuros_plugin' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'neuros_plugin' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors_dictionary' => [
                    'left'  => is_rtl() ? 'flex-direction: row;' : 'flex-direction: row-reverse;',
                    'right' => is_rtl() ? 'flex-direction: row-reverse;' : 'flex-direction: row;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .audio-item' => '{{VALUE}}'
                ],
                'toggle' => false,
                'prefix_class' => 'title-position-'
            ]
        );

        $this->add_control(
            'vert_alignment',
            [
                'label' => esc_html__( 'Vertical Alignment', 'neuros_plugin' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => '',
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'neuros_plugin' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__( 'Middle', 'neuros_plugin' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'neuros_plugin' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'vertical-align-',
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
                        'max'       => 100
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 20
                ],
                'selectors' => [
                    '{{WRAPPER}} .neuros-audio-listing' => 'margin: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .audio-item-wrapper' => 'padding: calc({{SIZE}}{{UNIT}}/2);'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_vert_spacing',
            [
                'label'     => esc_html__('Vertical Space between items', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .neuros-audio-listing' => 'margin-top: calc(-{{SIZE}}{{UNIT}}/2); margin-bottom: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .audio-item-wrapper' => 'padding-top: calc({{SIZE}}{{UNIT}}/2); padding-bottom: calc({{SIZE}}{{UNIT}}/2);'
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
                    '{{WRAPPER}} .audio-item-wrapper .audio-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .audio-item'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'slider_item_settings_tabs' );

            $this->start_controls_tab( 'slider_item_normal',
                [
                    'label' => esc_html__( 'Normal', 'neuros_plugin' ),
                ]
            );

                $this->add_control(
                    'item_color',
                    [
                        'label'     => esc_html__('Item Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .audio-item' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'      => 'item_border',
                        'label'     => esc_html__( 'Item Border', 'neuros_plugin' ),
                        'selector'  => '{{WRAPPER}} .audio-item'
                    ]
                );

                $this->add_control(
                    'item_bg_color',
                    [
                        'label'     => esc_html__('Item Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .audio-item' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'item_box_shadow',
                        'label'     => esc_html__( 'Box Shadow', 'plugin-domain' ),
                        'selector'  => '{{WRAPPER}} .audio-item',
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab( 'slider_item_hover',
                [
                    'label' => esc_html__( 'Hover', 'neuros_plugin' ),
                ]
            );
                $this->add_control(
                    'item_color_hover',
                    [
                        'label'     => esc_html__('Item Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .audio-item:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .audio-item.active' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name'      => 'item_border_hover',
                        'label'     => esc_html__( 'Item Border', 'neuros_plugin' ),
                        'selector'  => '{{WRAPPER}} .audio-item:hover, {{WRAPPER}} .audio-item.active'
                    ]
                );

                $this->add_control(
                    'item_bg_color_hover',
                    [
                        'label'     => esc_html__('Item Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .audio-item:hover' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .audio-item.active' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'item_box_shadow_hover',
                        'label'     => esc_html__( 'Box Shadow', 'plugin-domain' ),
                        'selector'  => '{{WRAPPER}} .audio-item:hover, {{WRAPPER}} .audio-item.active',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // --------------------------------------------- //
        // ---------- Image and Icon Settings ---------- //
        // --------------------------------------------- //
        $this->start_controls_section(
            'image_settings_section',
            [
                'label'     => esc_html__('Image and Icon Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Size', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .audio-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'     => esc_html__('Space After Icon', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 16
                ],
                'selectors' => [
                    '{{WRAPPER}} .audio-item .audio-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .audio-item .audio-icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: auto;'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_spacing',
            [
                'label'     => esc_html__('Image Spacing', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 16
                ],
                'selectors' => [
                    '{{WRAPPER}}.title-position-left .audio-item img' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.title-position-right .audio-item img' => 'margin-right: {{SIZE}}{{UNIT}};'
                ]
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
                    '{{WRAPPER}} .audio-item img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'neuros_plugin' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .audio-item img'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Title Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'title_settings_section',
            [
                'label'     => esc_html__('Title Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'item_title_typography',
                'label'     => esc_html__('Title Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .audio-item-wrapper .audio-item-title'
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings           = $this->get_settings();

        $view_type          = $settings['view_type'];
        $columns_number     = $settings['columns_number'];
        $audio_items        = $settings['audio_items'];
        $hide_icon          = $settings['hide_icon'];

        $wrapper_class      = 'neuros-audio-listing' . ( !empty($view_type) ? ' view-' . $view_type : ' view-inline' );
        $wrapper_class      .= ( !empty($columns_number) && $view_type === 'columns' ? ' columns-' . (int)$columns_number : '' );

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="<?php echo esc_attr($wrapper_class); ?>">
            <?php
                foreach ($audio_items as $item) {
                    $audio_url = $item['audio']['url'];
                    if ( empty($audio_url) ) {
                        continue;
                    }
                    echo '<div class="audio-item-wrapper">';
                        echo '<div class="audio-item">';
                            echo wp_get_attachment_image( $item['image']['id'], 'thumbnail' );
                            echo '<div class="audio-wrapper">';
                                echo '<audio src="' . esc_attr($audio_url) . '"></audio>';
                                if ( $hide_icon !== 'on' ) {
                                    echo '<span class="audio-icon">';
                                        echo '<i aria-hidden="true" class="fontello icon-volume-muted"></i>';
                                    echo '</span>';
                                }
                                if ( !empty($item['item_title']) ) {
                                    echo '<span class="audio-item-title">' . esc_html($item['item_title']) . '</span>';
                                }
                            echo '</div>';                            
                        echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>
        <?php
    }
}