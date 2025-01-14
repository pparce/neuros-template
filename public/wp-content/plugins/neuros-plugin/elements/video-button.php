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
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Neuros_Video_Button_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_video_button';
    }

    public function get_title() {
        return esc_html__('Video Button', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-play';
    }

    public function get_categories() {
        return ['neuros_widgets'];
    }

    public function get_script_depends() {
        return ['elementor_widgets'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Video', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'video_type',
            [
                'label'     => esc_html__( 'Source', 'neuros_plugin' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'youtube',
                'options'   => [
                    'youtube'       => esc_html__( 'YouTube', 'neuros_plugin' ),
                    'vimeo'         => esc_html__( 'Vimeo', 'neuros_plugin' ),
                    'dailymotion'   => esc_html__( 'Dailymotion', 'neuros_plugin' ),
                    'hosted'        => esc_html__( 'Self Hosted', 'neuros_plugin' )
                ],
                'frontend_available' => true
            ]
        );

        $this->add_control(
            'youtube_url',
            [
                'label'         => esc_html__( 'Link', 'neuros_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'placeholder'   => esc_html__( 'Enter your URL', 'neuros_plugin' ) . ' (YouTube)',
                'default'       => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                'label_block'   => true,
                'condition'     => [
                    'video_type'    => 'youtube'
                ],
                'frontend_available' => true
            ]
        );

        $this->add_control(
            'vimeo_url',
            [
                'label'         => esc_html__( 'Link', 'neuros_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ],
                ],
                'placeholder'   => esc_html__( 'Enter your URL', 'neuros_plugin' ) . ' (Vimeo)',
                'default'       => 'https://vimeo.com/235215203',
                'label_block'   => true,
                'condition'     => [
                    'video_type'    => 'vimeo'
                ]
            ]
        );

        $this->add_control(
            'dailymotion_url',
            [
                'label'         => esc_html__( 'Link', 'neuros_plugin' ),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ],
                ],
                'placeholder'   => esc_html__( 'Enter your URL', 'neuros_plugin' ) . ' (Dailymotion)',
                'default'       => 'https://www.dailymotion.com/video/x6tqhqb',
                'label_block'   => true,
                'condition'     => [
                    'video_type'    => 'dailymotion'
                ]
            ]
        );

        $this->add_control(
            'insert_url',
            [
                'label'     => esc_html__( 'External URL', 'neuros_plugin' ),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'video_type'    => 'hosted'
                ]
            ]
        );

        $this->add_control(
            'hosted_url',
            [
                'label'         => esc_html__( 'Choose File', 'neuros_plugin' ),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::MEDIA_CATEGORY
                    ],
                ],
                'media_type'    => 'video',
                'condition'     => [
                    'video_type'    => 'hosted',
                    'insert_url'    => ''
                ]
            ]
        );

        $this->add_control(
            'external_url',
            [
                'label'         => esc_html__( 'URL', 'neuros_plugin' ),
                'type'          => Controls_Manager::URL,
                'autocomplete'  => false,
                'options'       => false,
                'label_block'   => true,
                'show_label'    => false,
                'dynamic'       => [
                    'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
                'media_type'    => 'video',
                'placeholder'   => esc_html__( 'Enter your URL', 'neuros_plugin' ),
                'condition'     => [
                    'video_type'    => 'hosted',
                    'insert_url'    => 'yes'
                ],
            ]
        );

        $this->add_control(
            'controls',
            [
                'label' => esc_html__( 'Player Controls', 'neuros_plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Hide', 'neuros_plugin' ),
                'label_on' => esc_html__( 'Show', 'neuros_plugin' ),
                'default' => 'yes',
                'condition' => [
                    'video_type!' => 'vimeo',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Play Button Text', 'neuros_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter Play Button Text', 'neuros_plugin'),
                'default' => esc_html__('Play video', 'neuros_plugin'),
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
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .neuros_video_button_container' => 'text-align: {{VALUE}};',
                ],
                'prefix_class' => 'neuros-video-button-alignment%s-'
            ]
        );

        $this->add_control(
            'hide_icon',
            [
                'label'     => esc_html__( 'Hide Icon', 'neuros_plugin' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'       => '',
                'return_value'  => 'yes',
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
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
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'separator'     => 'before',
                'prefix_class'  => 'neuros-video-button-decoration-'
            ]
        );

        $this->end_controls_section();

        // ------------------------------------ //
        // ---------- Video Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Video Button Settings', 'neuros_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control(
            'button_padding',
            [
                'label'         => esc_html__('Button Padding', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .neuros_video_button_widget .elementor-custom-embed-play' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_button_size',
            [
                'label' => esc_html__('Trigger Button Size', 'neuros_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 250,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .neuros_video_button_widget .icon-play-wrapper' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'neuros_plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .neuros_video_button_widget .eicon-play' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_radius',
            [
                'label'         => esc_html__('Border Radius', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .elementor-custom-embed-play' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Button Text Typography', 'neuros_plugin'),
                'selector' => '{{WRAPPER}} .neuros_button_text'
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_bg_image',
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__( 'Button Background Image', 'neuros_plugin' )
                    ]                    
                ],
                'exclude' => ['color'],
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} .elementor-custom-embed-play',
                'condition' => [
                    'hide_icon!' => 'on'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_text_margin',
            [
                'label'         => esc_html__('Button Text Margin', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .neuros_button_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
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
                    'icon_color',
                    [
                        'label' => esc_html__('Icon Color', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros_video_button_widget .eicon-play' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_border_color',
                    [
                        'label' => esc_html__('Icon Border Color', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros_video_button_widget .icon-play-wrapper:before' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_bg_color',
                    [
                        'label' => esc_html__('Icon Background Color', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros_video_button_widget .icon-play-wrapper' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_text_color',
                    [
                        'label' => esc_html__('Button Text Color', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros_button_text' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg_color',
                    [   
                        'label' => esc_html__('Button Background Color', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elementor-custom-embed-play' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}}.neuros-video-button-decoration-on .elementor-custom-embed-image-overlay:before, {{WRAPPER}}.neuros-video-button-decoration-on .elementor-custom-embed-image-overlay:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};'
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow',
                        'selector' => '{{WRAPPER}} .elementor-custom-embed-play',
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
                    'icon_hover',
                    [
                        'label' => esc_html__('Icon Hover', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elementor-custom-embed-play:hover .eicon-play' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_border_hover',
                    [
                        'label' => esc_html__('Icon Border Hover Color', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros_video_button_widget .elementor-custom-embed-play:hover .icon-play-wrapper:before' => 'border-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'icon_bg_hover',
                    [
                        'label' => esc_html__('Icon Background Hover Color', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .neuros_video_button_widget .elementor-custom-embed-play:hover .icon-play-wrapper' => 'background-color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_text_hover',
                    [
                        'label' => esc_html__('Button Text Hover', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elementor-custom-embed-play:hover .neuros_button_text' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg_hover',
                    [   
                        'label' => esc_html__('Button Background Hover Color', 'neuros_plugin'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}}:not(.neuros-video-button-decoration-on) .elementor-custom-embed-play:hover' => 'background-color: {{VALUE}};',
                        ]
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'button_box_shadow_hover',
                        'selector' => '{{WRAPPER}} .elementor-custom-embed-play:hover',
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
                    '{{WRAPPER}} .elementor-custom-embed-play' => '{{VALUE}}',
                    '{{WRAPPER}} .elementor-custom-embed-play:hover' => '{{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $youtube_url = $settings['youtube_url'];
        $vimeo_url = $settings['vimeo_url'];
        $dailymotion_url = $settings['dailymotion_url'];
        $video_type = $settings['video_type'];
        $insert_url = $settings['insert_url'];        
        $hosted_url = $settings['hosted_url'];
        $external_url = $settings['external_url'];
        $button_text = $settings['button_text'];
        $hide_icon = $settings['hide_icon'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="neuros_video_button_container">
            <div class="neuros_video_button_widget">
                <?php 
                    if( ( $video_type == 'youtube' && !empty($youtube_url) ) ||
                        ( $video_type == 'vimeo' && !empty($vimeo_url) ) ||
                        ( $video_type == 'dailymotion' && !empty($dailymotion_url) ) ||
                        ( $video_type == 'hosted' && (
                                !empty($insert_url) ||
                                !empty($hosted_url) ||
                                !empty($external_url)
                            ) ) 
                    ) {
                        $video_url = $settings[ $settings['video_type'] . '_url' ];

                        if ( 'hosted' === $settings['video_type'] ) {
                            $video_url = $this->get_hosted_video_url();
                        } else {
                            $embed_params = $this->get_embed_params();
                            $embed_options = $this->get_embed_options();
                        }
                        
                        $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-wrapper' );

                        $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-open-lightbox' );
                        ?>
                        <div <?php $this->print_render_attribute_string( 'video-wrapper' ); ?>>
                            <?php
                                if ( 'hosted' === $settings['video_type'] ) {
                                    $lightbox_url = $video_url;
                                } else {
                                    $lightbox_url = \Elementor\Embed::get_embed_url( $video_url, $embed_params, $embed_options );
                                }

                                $lightbox_options = [
                                    'type'          => 'video',
                                    'videoType'     => $settings['video_type'],
                                    'url'           => $lightbox_url,
                                    'modalOptions'  => [
                                        'id'                        => 'elementor-lightbox-' . $this->get_id(),
                                        'videoAspectRatio'          => '169'
                                    ],
                                ];
                                if('hosted' === $video_type) {
                                    $lightbox_options['videoParams'] = $this->get_hosted_params();
                                }

                                $this->add_render_attribute( 'image-overlay', 'class', 'elementor-custom-embed-image-overlay' );

                                $this->add_render_attribute( 'image-overlay', [
                                    'data-elementor-open-lightbox'  => 'yes',
                                    'data-elementor-lightbox'       => wp_json_encode( $lightbox_options ),
                                ] );

                                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                                    $this->add_render_attribute( 'image-overlay', [
                                        'class' => 'elementor-clickable',
                                    ] );
                                }
                            ?>
                            <div <?php $this->print_render_attribute_string( 'image-overlay' ); ?>>
                                <div class="elementor-custom-embed-play" role="button">
                                    <?php
                                        if( $hide_icon !== 'yes' ) { ?>
                                            <div class="icon-play-wrapper">
                                                <i class="eicon-play" aria-hidden="true"></i>
                                            </div>
                                        <?php }
                                    ?>                                    
                                    <?php
                                        if ($button_text !== '') {
                                            ?>
                                            <span class="neuros_button_text"><?php echo esc_html($button_text); ?></span>
                                            <?php
                                        }                                        
                                    ?>
                                    <span class="elementor-screen-only"><?php echo ($button_text !== '' ? esc_html($button_text) : esc_html__('Watch video', 'neuros_plugin')); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php }
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function get_embed_params() {
        $settings = $this->get_settings_for_display();      
        $params = [];
        $params_dictionary = [];
        if ( 'youtube' === $settings['video_type'] ) {
            $params_dictionary = [];
            $params['wmode'] = 'opaque';
        } elseif ( 'vimeo' === $settings['video_type'] ) {
            $params_dictionary = [
                'mute'              => 'muted',
                'vimeo_title'       => 'title',
                'vimeo_portrait'    => 'portrait',
                'vimeo_byline'      => 'byline'
            ];
            $params['color'] = str_replace( '#', '', $settings['color'] );
            $params['autopause'] = '0';
        } elseif ( 'dailymotion' === $settings['video_type'] ) {
            $params_dictionary = [
                'showinfo'  => 'ui-start-screen-info',
                'logo'      => 'ui-logo',
            ];
            $params['ui-highlight'] = str_replace( '#', '', $settings['color'] );
            $params['endscreen-enable'] = '0';
        }
        foreach ( $params_dictionary as $key => $param_name ) {
            $setting_name = $param_name;
            if ( is_string( $key ) ) {
                $setting_name = $key;
            }
            $setting_value = $settings[ $setting_name ] ? '1' : '0';
            $params[ $param_name ] = $setting_value;
        }

        return $params;
    }

    private function get_hosted_video_url() {
        $settings = $this->get_settings_for_display();

        if ( ! empty( $settings['insert_url'] ) ) {
            $video_url = $settings['external_url']['url'];
        } else {
            $video_url = $settings['hosted_url']['url'];
        }
        if ( empty( $video_url ) ) {
            return '';
        }
        return $video_url;
    }    

    private function get_embed_options() {
        $settings = $this->get_settings_for_display();
        $embed_options = [];
        if ( 'youtube' === $settings['video_type'] ) {
            $embed_options['privacy'] = 'no';
        }
        return $embed_options;
    }

    private function get_hosted_params() {
        $settings = $this->get_settings_for_display();

        $video_params = ['autoplay' => true, 'loop' => false];

        if($settings['controls']) {
            $video_params['controls'] = true;
        }

        return $video_params;
    }
}
