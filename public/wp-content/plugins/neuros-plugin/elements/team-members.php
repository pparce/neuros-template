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

class Neuros_Team_Members_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_team_members';
    }

    public function get_title() {
        return esc_html__('Team Members', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['neuros_widgets'];
    }

    public function get_script_depends() {
        return ['elementor_widgets', 'wp-mediaelement'];
    }

    protected function register_controls() {

        // ----------------------------- //
        // ---------- Content ---------- //
        // ----------------------------- //
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Team Members', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'listing_style',
            [
                'label'         => esc_html__('Listing Ladder Style', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => '',
                'options'       => [
                    ''            => esc_html__('Off', 'neuros_plugin'),
                    'even'        => esc_html__('Even', 'neuros_plugin'),
                    'odd'         => esc_html__('Odd', 'neuros_plugin')
                ],
                'prefix_class' => 'team-members-listing-style-'
            ]
        );

        $this->add_responsive_control(
            'ladder_spacing',
            [
                'label'     => esc_html__('Space Before Items', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}.team-members-listing-style-odd .team-item-wrapper:nth-child(odd)' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.team-members-listing-style-even .team-item-wrapper:nth-child(even)' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'listing_style!' => ''
                ]
            ]
        );

        $this->add_control(
            'post_order_by',
            [
                'label'         => esc_html__('Order By', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'date',
                'options'       => [
                    'date'          => esc_html__('Post Date', 'neuros_plugin'),
                    'rand'          => esc_html__('Random', 'neuros_plugin'),
                    'ID'            => esc_html__('Post ID', 'neuros_plugin'),
                    'title'         => esc_html__('Post Title', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'post_order',
            [
                'label'         => esc_html__('Order', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'desc',
                'options'       => [
                    'desc'          => esc_html__('Descending', 'neuros_plugin'),
                    'asc'           => esc_html__('Ascending', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'filter_by',
            [
                'label'         => esc_html__('Filter by:', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'none',
                'options'       => [
                    'none'          => esc_html__('None', 'neuros_plugin'),
                    'cat'           => esc_html__('Department', 'neuros_plugin'),
                    'id'            => esc_html__('ID', 'neuros_plugin')
                ],
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'         => esc_html__('Categories', 'neuros_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of categories.', 'neuros_plugin'),
                'options'       => neuros_get_all_taxonomy_terms('neuros_team_member', 'neuros_team_department'),
                'condition'     => [
                    'filter_by'     => 'cat'
                ]
            ]
        );

        $this->add_control(
            'team_members',
            [
                'label'         => esc_html__('Choose Team Members', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => neuros_get_all_post_list('neuros_team_member'),
                'label_block'   => true,
                'multiple'      => true,
                'condition'     => [
                    'filter_by'     => 'id'
                ]
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__('Show Pagination', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin'),
                'return_value'  => 'yes',
                'default'       => 'yes',
                'separator'     => 'before'
            ]
        );

        $this->end_controls_section();


        // ----------------------------------- //
        // ---------- Grid Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_grid_settings',
            [
                'label'         => esc_html__('Grid Settings', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'grid_columns_number',
            [
                'label'         => esc_html__('Columns Number', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => 1,
                'max'           => 6
            ]
        );

        $this->add_control(
            'grid_posts_per_page',
            [
                'label'         => esc_html__('Items Per Page', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => -1
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
                'label'     => esc_html__('Horizontal Space Between Items', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 40
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-listing-wrapper .team-item-wrapper'  => 'padding-left: calc({{SIZE}}{{UNIT}}/2); padding-right: calc({{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}} .team-listing-wrapper'                     => 'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2);'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_spacing_vertical',
            [
                'label'     => esc_html__('Vertical Space Between Items', 'neuros_plugin'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'        => [
                        'min'       => 0,
                        'max'       => 100
                    ]
                ],
                'default'   => [
                    'unit'      => 'px',
                    'size'      => 30
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-listing-wrapper .team-item-wrapper'  => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .team-listing-wrapper' =>
                        'margin-bottom: -{{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label'     => esc_html__('Item Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .team-item, {{WRAPPER}} .team-item .socials-trigger-wrapper' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .team-item .socials-trigger-wrapper:before, {{WRAPPER}} .team-item .socials-trigger-wrapper:after' => 'box-shadow: 0 20px 0 0 {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'item_border_width',
            [
                'label'     => esc_html__('Item Border Width', 'neuros_plugin'),
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
                    '{{WRAPPER}} .team-item:before' => 'border-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'item_bd_color',
            [
                'label'     => esc_html__('Item Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-item:before' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'     => esc_html__('Items Border Radius', 'neuros_plugin'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-item' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();


        // ------------------------------------ //
        // ---------- Media Settings ---------- //
        // ------------------------------------ //
        $this->start_controls_section(
            'media_settings_section',
            [
                'label'     => esc_html__('Media Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'media_background_color',
            [
                'label'     => esc_html__('Image Overlay Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-item .team-item-media:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'tag_typography',
                'label'     => esc_html__('Tag Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .team-item .team-item-tag'
            ]
        );

        $this->add_control(
            'tag_color',
            [
                'label'     => esc_html__('Tag Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-item .team-item-tag' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'content_settings_section',
            [
                'label'     => esc_html__('Content Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'     => esc_html__('Content Padding', 'neuros_plugin'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-item .team-item-content' =>
                        'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'name_typography',
                'label'     => esc_html__('Name Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .team-item .post-title'
            ]
        );

        $this->start_controls_tabs('content_name_tabs');
            // ------ Normal Tab ------ //
            $this->start_controls_tab(
                'tab_content_name_normal',
                [
                    'label'     => esc_html__('Normal', 'neuros_plugin')
                ]
            );
            $this->add_control(
                'name_color_normal',
                [
                    'label'     => esc_html__('Name Color', 'neuros_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .team-item .post-title' => 'color: {{VALUE}};'
                    ]
                ]
            );
            $this->end_controls_tab();

            // ------ Hover Tab ------ //
            $this->start_controls_tab(
                'tab_content_name_hover',
                [
                    'label'     => esc_html__('Hover', 'neuros_plugin')
                ]
            );
                $this->add_control(
                    'name_color_hover',
                    [
                        'label'     => esc_html__('Name Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .team-item:hover .post-title' => 'color: {{VALUE}};'
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
                'name'      => 'position_typography',
                'label'     => esc_html__('Position Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .team-item-position'
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label'     => esc_html__('Position Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-item-position' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        // -------------------------------------- //
        // ---------- Socials Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'socials_settings_section',
            [
                'label'     => esc_html__('Social Buttons Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'socials_bg_color',
            [
                'label'     => esc_html__('Icon Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .team-item .team-item-socials .wrapper-socials, {{WRAPPER}} .team-item .socials-trigger-wrapper .socials-trigger' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->start_controls_tabs('social_icon_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'social_icon_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'socials_icon_color',
                    [
                        'label'     => esc_html__('Icon Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .team-item .socials-trigger-wrapper .socials-trigger, {{WRAPPER}} .team-item .team-item-socials .wrapper-socials a' => 'color: {{VALUE}};'
                        ]
                    ]
                );                

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'social_icon_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_control(
                    'socials_hover',
                    [
                        'label'     => esc_html__('Hovered Icon Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .team-item .team-item-socials .wrapper-socials a:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // ----------------------------------------- //
        // ---------- Pagination Settings ---------- //
        // ----------------------------------------- //
        $this->start_controls_section(
            'pagination_settings_section',
            [
                'label'     => esc_html__('Pagination Settings', 'neuros_plugin'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pagination'   => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'pagination_typography',
                'label'     => esc_html__('Pagination Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .content-pagination .page-numbers, {{WRAPPER}} .content-pagination .post-page-numbers'
            ]
        );

        $this->add_control(
            'pagination_bd_style',
            [
                'label' => esc_html__( 'Pagination Border Style', 'neuros_plugin' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'gradient',
                'options' => [
                    'gradient' => esc_html__( 'Gradient', 'neuros_plugin' ),
                    'solid' => esc_html__( 'Solid', 'neuros_plugin' ),
                ],
                'prefix_class' => 'listing-pagination-border-style-',
            ]
        );

        $this->add_control(
            'pagination_bg_style',
            [
                'label' => esc_html__( 'Pagination Background Style', 'neuros_plugin' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'gradient' => esc_html__( 'Gradient', 'neuros_plugin' ),
                    'solid' => esc_html__( 'Solid', 'neuros_plugin' ),
                ],
                'prefix_class' => 'listing-pagination-bakground-style-',
            ]
        );

        $this->start_controls_tabs('pagination_settings_tabs');
        // ------ Normal Tab ------ //
        $this->start_controls_tab(
            'tab_pagination_normal',
            [
                'label'     => esc_html__('Normal', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     => esc_html__('Pagination Text Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'pagination_border_color',
            [
                'label'     => esc_html__('Pagination Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)' => 'border-color: {{VALUE}};'
                ],
                'condition' => [
                    'pagination_bd_style' => 'solid'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pagination_border_color_gradient',
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__( 'Border Color Gradient', 'neuros_plugin' )
                    ]                    
                ],
                'types' => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover):after, {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover):after',
                'condition' => [
                    'pagination_bd_style' => 'gradient'
                ]
            ]
        );

        $this->add_control(
            'pagination_background_color',
            [
                'label'     => esc_html__('Pagination Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'pagination_bg_style' => 'solid'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pagination_bg_color_gradient',
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__( 'Background Color Gradient', 'neuros_plugin' )
                    ]                    
                ],
                'types' => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .content-pagination .page-numbers .button-inner:before, {{WRAPPER}} .content-pagination .post-page-numbers .button-inner:before',
                'condition' => [
                    'pagination_bg_style' => 'gradient'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'pagination_shadow',
                'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .content-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .content-pagination .post-page-numbers:not(.current):not(:hover)'
            ]
        );

        $this->end_controls_tab();

        // ------ Hover Tab ------ //
        $this->start_controls_tab(
            'tab_pagination_active',
            [
                'label'     => esc_html__('Active', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'pagination_color_active',
            [
                'label'     => esc_html__('Pagination Text Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'pagination_border_color_active',
            [
                'label'     => esc_html__('Pagination Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover' => 'border-color: {{VALUE}};'
                ],
                'condition' => [
                    'pagination_bd_style' => 'solid'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pagination_border_color_gradient_active',
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__( 'Border Color Gradient', 'neuros_plugin' )
                    ]                    
                ],
                'types' => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .content-pagination .page-numbers.current:after, {{WRAPPER}} .content-pagination .page-numbers:hover:after, {{WRAPPER}} .content-pagination .post-page-numbers.current:after, {{WRAPPER}} .content-pagination .post-page-numbers:hover:after',
                'condition' => [
                    'pagination_bd_style' => 'gradient'
                ]
            ]
        );

        $this->add_control(
            'pagination_background_color_active',
            [
                'label'     => esc_html__('Pagination Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'pagination_bg_style' => 'solid'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pagination_bg_color_gradient_active',
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__( 'Background Color Gradient', 'neuros_plugin' )
                    ]                    
                ],
                'types' => [ 'gradient' ],
                'selector' => '{{WRAPPER}} .content-pagination .page-numbers .button-inner:after, {{WRAPPER}} .content-pagination .post-page-numbers .button-inner:after',
                'condition' => [
                    'pagination_bg_style' => 'gradient'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'pagination_shadow_active',
                'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .content-pagination .page-numbers.current, {{WRAPPER}} .content-pagination .post-page-numbers.current, {{WRAPPER}} .content-pagination .page-numbers:hover, {{WRAPPER}} .content-pagination .post-page-numbers:hover'
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings       = $this->get_settings();

        $post_order_by          = $settings['post_order_by'];
        $post_order             = $settings['post_order'];
        $filter_by              = $settings['filter_by'];
        $categories             = $settings['categories'];
        $team_members           = $settings['team_members'];
        $pagination             = $settings['show_pagination'];
        $paged                  = isset( $_GET[esc_attr($this->get_id()) . '-paged'] ) && $pagination == 'yes' ? (int)$_GET[esc_attr($this->get_id()) . '-paged'] : 1;

        $grid_columns_number    = $settings['grid_columns_number'];
        $grid_posts_per_page    = $settings['grid_posts_per_page'];

        $widget_class           = 'neuros-team-members-widget';
        $wrapper_class          = 'archive-listing-wrapper team-listing-wrapper';

        global $wp;
        $base = home_url($wp->request);

        $query_options          = [
            'post_type'             => 'neuros_team_member',
            'ignore_sticky_posts'   => true,
            'orderby'               => sanitize_key($post_order_by),
            'order'                 => sanitize_key($post_order),
            'link_base'             => esc_url($base)
        ];

        if ( $filter_by == 'cat' ) {
            $query_options = array_merge($query_options, [
                'neuros_team_department'  => $categories
            ]);
        } elseif ( $filter_by == 'id' ) {
            $query_options = array_merge($query_options, [
                'post__in'          => $team_members
            ]);
        };

        $wrapper_class      .= ' team-grid-listing' . ( !empty($grid_columns_number) ? ' columns-' . esc_attr($grid_columns_number) : '' );
        $widget_options     = array(
            'item_class'            => 'team-item-wrapper',
            'columns_number'        => absint($grid_columns_number),
            'show_pagination'       => $pagination
        );
        $query_options      = array_merge($query_options, [
            'posts_per_page'        => ( !empty($grid_posts_per_page) ? $grid_posts_per_page : -1 ),
            'columns_number'        => $grid_columns_number,
            'paged'                 => $paged
        ]);

        $query = new \WP_Query($query_options);
        $ajax_data = wp_json_encode($query_options);
        $widget_data = wp_json_encode($widget_options);

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="<?php echo esc_attr($widget_class); ?>">

            <div class="archive-listing" data-ajax='<?php echo esc_attr($ajax_data); ?>' data-widget='<?php echo esc_attr($widget_data); ?>'>
                <div class="<?php echo esc_attr($wrapper_class); ?>">
                    <?php
                        while( $query->have_posts() ){
                            $query->the_post();
                            get_template_part('content', 'neuros_team_member', $widget_options);
                        };
                        wp_reset_postdata();
                    ?>
                </div>

                <?php
                    if ( $pagination == 'yes' && $query->max_num_pages > 1) {
                        echo '<div class="content-pagination">';
                            echo '<nav class="navigation pagination" role="navigation">';
                                echo '<h2 class="screen-reader-text">' . esc_html__('Pagination', 'neuros_plugin') . '</h2>';
                                echo '<div class="nav-links">';                        
                                    echo paginate_links( array(
                                        'format'    => '?' . esc_attr($this->get_id()) . '-paged=%#%',
                                        'current'   => max( 1, $paged ),
                                        'total'     => $query->max_num_pages,
                                        'end_size'  => 2,
                                        'before_page_number' => '<span class="button-inner"></span>',
                                        'prev_text' => esc_html__('Previous', 'neuros_plugin') . '<span class="button-inner"></span><span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>',
                                        'next_text' => esc_html__('Next', 'neuros_plugin') . '<span class="button-inner"></span><span class="icon-button-arrow left"></span><span class="icon-button-arrow right"></span>'
                                    ) );
                                echo '</div>';
                            echo '</nav>';
                        echo '</div>';
                    }
                ?>
            </div>

        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}