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

class Neuros_Icon_Box_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_icon_box';
    }

    public function get_title() {
        return esc_html__('Icon Box', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-icon-box';
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
                'label' => esc_html__('Icon Box', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'icon_type',
            [
                'label'     => esc_html__('Type of Icon', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'default',
                'options'   => [
                    'default'   => esc_html__('Default Icon', 'neuros_plugin'),
                    'svg'       => esc_html__('SVG Icon', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'default_icon',
            [
                'label'                     => esc_html__('Icon', 'neuros_plugin'),
                'type'                      => Controls_Manager::ICONS,
                'label_block'               => false,
                'default'                   => [
                    'value'     => 'fas fa-star',
                    'library'   => 'fa-solid'
                ],
                'skin'                      => 'inline',
                'exclude_inline_options'    => ['svg'],
                'condition'                 => [
                    'icon_type' => 'default'
                ]
            ]
        );

        $this->add_control(
            'svg_icon',
            [
                'label'         => esc_html__('SVG Icon', 'neuros_plugin'),
                'description'   => esc_html__('Enter svg code', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => '',
                'condition'     => [
                    'icon_type'     => 'svg'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_position',
            [
                'label'             => esc_html__( 'Icon Position', 'neuros_plugin' ),
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
                'prefix_class'      => 'icon-position%s-',
                'toggle'            => true,
                'default'           => 'top'
            ]
        );

        $this->add_responsive_control(
            'icon_vertical_position',
            [
                'label'             => esc_html__('Icon Vertical Alignment', 'neuros_plugin'),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'top'               => [
                        'title'             => esc_html__( 'Top', 'neuros_plugin' ),
                        'icon'              => 'eicon-v-align-top',
                    ],
                    'middle'            => [
                        'title'             => esc_html__( 'Middle', 'neuros_plugin' ),
                        'icon'              => 'eicon-v-align-middle',
                    ],
                    'bottom'            => [
                        'title'             => esc_html__( 'Bottom', 'neuros_plugin' ),
                        'icon'              => 'eicon-v-align-bottom',
                    ]
                ],
                'prefix_class'      => 'v-alignment%s-',
                'toggle'            => true,
                'default'           => 'top',
                'condition'         => [
                    'icon_position'   => ['left', 'right']
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_box_align',
            [
                'label'             => esc_html__('Icon Box Alignment', 'neuros_plugin'),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'left'              => [
                        'title'             => esc_html__('Left', 'neuros_plugin'),
                        'icon'              => 'eicon-text-align-left',
                    ],
                    'center'            => [
                        'title'             => esc_html__('Center', 'neuros_plugin'),
                        'icon'              => 'eicon-text-align-center',
                    ],
                    'right'             => [
                        'title'             => esc_html__('Right', 'neuros_plugin'),
                        'icon'              => 'eicon-text-align-right',
                    ],
                    'space-between'     => [
                        'title'             => esc_html__('Space Between', 'neuros_plugin'),
                        'icon'              => 'eicon-justify-space-between-h',
                    ],
                ],
                'prefix_class'      => 'alignment%s-',
                'toggle'            => true,
                'default'           => 'center'
            ]
        );

        $this->add_control(
            'background_type',
            [
                'label'     => esc_html__('Type of Background', 'neuros_plugin'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => [
                    'none'              => esc_html__('None', 'neuros_plugin'),
                    'svg'               => esc_html__('SVG', 'neuros_plugin'),
                    'image'             => esc_html__('Image', 'neuros_plugin'),
                    'color'             => esc_html__('Color', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'svg_background',
            [
                'label'         => esc_html__('SVG Background', 'neuros_plugin'),
                'description'   => esc_html__('Enter svg code', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => '',
                'condition'     => [
                    'background_type' => 'svg'
                ]
            ]
        );

        $this->start_controls_tabs('background_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'background_normal',
                [
                    'label'     => esc_html__('Normal', 'neuros_plugin'),
                    'condition' => [
                        'background_type' => 'image'
                    ]
                ]
            );

                $this->add_control(
                    'bg_image',
                    [
                        'label'     => esc_html__('Choose Background Image', 'neuros_plugin'),
                        'type'      => Controls_Manager::MEDIA,
                        'default'   => [],
                        'condition' => [
                            'background_type' => 'image'
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'background_hover',
                [
                    'label'     => esc_html__('Hover', 'neuros_plugin'),
                    'condition' => [
                        'background_type' => 'image'
                    ]
                ]
            );

                $this->add_control(
                    'bg_image_hover',
                    [
                        'label'     => esc_html__('Choose Background Image', 'neuros_plugin'),
                        'type'      => Controls_Manager::MEDIA,
                        'default'   => [],
                        'condition' => [
                            'background_type' => 'image'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'title',
            [
                'label'         => esc_html__('Icon Box Title', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => esc_html__('Title', 'neuros_plugin'),
                'placeholder'   => esc_html__('Enter Icon Box Title', 'neuros_plugin'),
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'info',
            [
                'label' => esc_html__('Icon Box Information', 'neuros_plugin'),
                'type' => Controls_Manager::WYSIWYG,
                'rows' => '10',
                'default' => '',
                'placeholder' => esc_html__('Enter Your Custom Information', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'add_link',
            [
                'label'         => esc_html__('Add Link', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'link',
            [
                'label'         => esc_html__('Image Box Link', 'neuros_plugin'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'           => '',
                    'is_external'   => 'true',
                ],
                'placeholder'   => esc_html__( 'http://your-link.com', 'neuros_plugin' ),
                'condition' => [
                    'add_link' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'link_padding',
            [
                'label'         => esc_html__('Link Padding', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors'     => [
                    '{{WRAPPER}} .icon-box-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'add_link' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Icon Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'icon_settings',
            [
                'label' => esc_html__('Icon Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'icon_container_size',
            [
                'label'     => esc_html__('Icon Container Size', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 10,
                        'max'       => 280
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-container' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_background_size',
            [
                'label'     => esc_html__('Icon Background Size', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 10,
                        'max'       => 280
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-container .background' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'background_type' => 'svg'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => esc_html__('Icon Size', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 5,
                        'max'       => 280
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-container i' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'icon_type' => 'default'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_svg_size',
            [
                'label'     => esc_html__('Icon Size', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 5,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-container .icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'icon_type' => 'svg'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'icon_shadow',
                'label'     => esc_html__('Icon Shadow', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .icon-container'
            ]
        );


        $this->start_controls_tabs('icon_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'icon_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'icon_color',
                    [
                        'label'     => esc_html__('Icon Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .icon-container i' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'default'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_svg_color',
                    [
                        'label'     => esc_html__('Icon Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .icon-container .icon svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'svg'
                        ]
                    ]
                );

                $this->add_control(
                    'background_svg_color',
                    [
                        'label'     => esc_html__('Background SVG Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .icon-container .background svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'svg',
                        ]
                    ]
                );

                $this->add_control(
                    'background_color',
                    [
                        'label'     => esc_html__('Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .icon-container' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'color',
                        ]
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'icon_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'icon_color_hover',
                    [
                        'label'     => esc_html__('Icon Color on Hover', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .icon-container i' => 'color: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'default'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_svg_color_hover',
                    [
                        'label'     => esc_html__('Icon Color on Hover', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .icon-container .icon svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'icon_type' => 'svg'
                        ]
                    ]
                );

                $this->add_control(
                    'background_svg_color_hover',
                    [
                        'label'     => esc_html__('Background SVG on Hover', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .icon-container .background svg' => 'fill: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'svg'
                        ]
                    ]
                );

                $this->add_control(
                    'background_color_hover',
                    [
                        'label'     => esc_html__('Background Color on Hover', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:hover .icon-container' => 'background-color: {{VALUE}};'
                        ],
                        'condition' => [
                            'background_type' => 'color'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'         => esc_html__('Icon Margins', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .icon-box-item .icon-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_radius',
            [
                'label'         => esc_html__('Icon Border Radius', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .icon-box-item .icon-container.background-type-color' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'     => [
                    'background_type' => 'color'
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Title Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'title_settings',
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
                'selector'  => '{{WRAPPER}} .icon-box-title'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .icon-box-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Title Color on Hover', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .icon-box-item-link:hover .icon-box-title' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'add_link' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();


        // ---------------------------------------- //
        // ---------- Info Text Settings ---------- //
        // ---------------------------------------- //
        $this->start_controls_section(
            'text_settings',
            [
                'label' => esc_html__('Information Text Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'info_color',
            [
                'label'     => esc_html__('Information Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .icon-box-info' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'info_typography',
                'label'     => esc_html__('Information Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .icon-box-info, {{WRAPPER}} .icon-box-info p'
            ]
        );

        $this->add_responsive_control(
            'info_margin',
            [
                'label'     => esc_html__('Space Between Title and Text', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 200
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-box-info' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings        = $this->get_settings();

        $icon_type       = $settings['icon_type'];
        $default_icon    = $settings['default_icon'];
        $svg_icon        = $settings['svg_icon'];

        $background_type = $settings['background_type'];

        if ( $background_type == 'svg' ) {
            $svg_background = $settings['svg_background'];
        }
        if ( $background_type == 'image' ) {
            $bg_image = !empty($settings['bg_image']['url']) ? $settings['bg_image'] : array();
        }

        $title              = $settings['title'];
        $info               = $settings['info'];
        $add_link           = $settings['add_link'];
        $link               = $settings['link'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="neuros-icon-box-widget">
            <?php
                $is_link = ($add_link == 'yes' && !empty($link) && $link['url'] !== '');
                if($is_link) {
                    $this->add_link_attributes( 'link', $link );
                    echo '<a class="icon-box-item-link" href="' . esc_url($link['url']) . '"';
                        $this->print_render_attribute_string('link');
                    echo '>';
                }
            ?>
            <div class="icon-box-item">

                <div class="icon-container<?php echo ( !empty($background_type) ? ' background-type-' . esc_attr($background_type) : '' ); ?>">
                    <?php
                    if ($icon_type == 'default') {
                        echo '<i class="' . esc_attr($default_icon['value']) . '"></i>';
                    }
                    if ($icon_type == 'svg') {
                        echo '<span class="icon">' . neuros_output_code($svg_icon) . '</span>';
                    }

                    if ($background_type == 'image') {
                        if (!empty($bg_image['url'])) {
                            echo '<img class="icon-container-bg-image" src="' . esc_url($bg_image['url']) . '" alt="' . esc_html__('Background Image', 'neuros_plugin') . '" />';
                        }
                    }
                    if ($background_type == 'svg' && !empty($svg_background)) {
                        echo '<span class="background">' . neuros_output_code($svg_background) . '</span>';
                    }
                    ?>
                </div>

                <div class="content-container">
                    <?php
                        if ($title !== '') {
                            echo '<h5 class="icon-box-title">';
                                echo '<span class="neuros-heading-content">' . neuros_output_code($title) . '</span>';
                            echo '</h5>';
                        }
                    ?>


                    <?php
                        if ($info !== '') {
                            echo '<div class="icon-box-info">';
                                echo neuros_output_code($info);
                            echo '</div>';
                        }
                    ?>

                </div>
            </div>
            <?php 
                if($is_link) {                   
                    echo '</a>';
                }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}