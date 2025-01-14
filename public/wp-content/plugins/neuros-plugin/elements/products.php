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

class Neuros_Products_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_products';
    }

    public function get_title() {
        return esc_html__('Products', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function is_reload_preview_required() {
        return true;
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
            'section_display_product',
            [
                'label' => esc_html__('Display Product', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'products_type',
            [
                'label'   => esc_html__('Products Type', 'neuros_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'all',
                'options' => [
                    'all'           => esc_html__('All', 'neuros_plugin'),
                    'on_sale'       => esc_html__('On sale products', 'neuros_plugin'),
                    'best_selling'  => esc_html__('The best selling products', 'neuros_plugin'),
                    'top_rated'     => esc_html__('Top-rated products', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'         => esc_html__('Limit', 'neuros_plugin'),
                'description'   => esc_html__('The number of products to display', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => -1,
                'max'           => 50,
                'default'       => 4
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'         => esc_html__('Columns', 'neuros_plugin'),
                'description'   => esc_html__('The number of columns to display.', 'neuros_plugin'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 1,
                'max'           => 6,
                'default'       => 4
            ]
        );

        $this->add_control(
            'paginate',
            [
                'label'         => esc_html__('Show Pagination', 'neuros_plugin'),
                'description'   => esc_html__('Toggles pagination on. Use in conjunction with "limit"', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'no',
                'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                'label_on'      => esc_html__('Show', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Orderby', 'neuros_plugin'),
                'type'    => Controls_Manager::SELECT,
                'description' => esc_html__('Sorts the products displayed by the entered option.', 'neuros_plugin'),
                'default' => 'date',
                'options' => [
                    'date'        => esc_html__('Date', 'neuros_plugin'),
                    'id'          => esc_html__('ID', 'neuros_plugin'),
                    'menu_order'  => esc_html__('Menu order', 'neuros_plugin'),
                    'popularity'  => esc_html__('Popularity', 'neuros_plugin'),
                    'rand'        => esc_html__('Random', 'neuros_plugin'),
                    'rating'      => esc_html__('Rating', 'neuros_plugin'),
                    'title'       => esc_html__('Title', 'neuros_plugin')
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'neuros_plugin'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC'        => esc_html__('ASC', 'neuros_plugin'),
                    'DESC'       => esc_html__('DESC', 'neuros_plugin')
                ]
            ]
        );

        $cat_args = array(
            'orderby'    => 'name',
            'order'      => 'asc',
            'hide_empty' => false,
        );
        $product_categories = get_terms( 'product_cat', $cat_args );
        $category_arr = [];
        if( !empty($product_categories) ){
            foreach ($product_categories as $key => $category) {
                $category_arr[$category->slug] = $category->name;
            }
        }
        $this->add_control(
            'category',
            [
                'label'         => esc_html__('Categories', 'neuros_plugin'),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'description'   => esc_html__('List of categories.', 'neuros_plugin'),
                'options'       => $category_arr
            ]
        );

        $this->add_control(
            'skus',
            [
                'label'         => esc_html__('SKUs', 'neuros_plugin'),
                'label_block'   => true,
                'description'   => esc_html__('Comma-separated list of product SKUs.', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'placeholder'   => esc_html__( 'Enter SKU list', 'neuros_plugin' )
            ]
        );

        $this->add_control(
            'tag',
            [
                'label'         => esc_html__('Tags', 'neuros_plugin'),
                'label_block'   => true,
                'description'   => esc_html__('Comma-separated list of tag slugs.', 'neuros_plugin'),
                'type'          => Controls_Manager::TEXTAREA,
                'placeholder'   => esc_html__( 'Enter tags list', 'neuros_plugin' )
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Item Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_item_settings',
            [
                'label' => esc_html__('Product Item Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label'     => esc_html__('Item Background Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'alpha'    => false,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .product-buttons' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .product-buttons-wrapper:before,
                     {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .product-buttons-wrapper:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'item_bd_color',
            [
                'label'     => esc_html__('Item Border Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper:before' => 'border-color: {{VALUE}};'
                ]
            ]
        );

        $this->start_controls_tabs('item_settings_tabs');

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_item_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'product_shadow',
                        'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper'
                    ]
                );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_item_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name'      => 'product_shadow_hover',
                        'label'     => esc_html__('Item Shadow', 'neuros_plugin'),
                        'selector'  => '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper:hover'
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();



        // -------------------------------------- //
        // ---------- Content Settings ---------- //
        // -------------------------------------- //
        $this->start_controls_section(
            'section_content_settings',
            [
                'label' => esc_html__('Product Content Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => esc_html__('Title Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .woocommerce-loop-product-title, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper h3'
            ]
        );

        $this->start_controls_tabs('title_settings_tabs' );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $this->start_controls_tab(
                'tab_title_normal',
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
                        '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .woocommerce-loop-product-title, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper h3, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .woocommerce-loop-product-title a, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper h3 a' => 'color: {{VALUE}};'
                    ],
                    'separator' => 'after'
                ]
            );

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_title_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

            $this->add_control(
                'title_hover',
                [
                    'label'     => esc_html__('Title Hover', 'neuros_plugin'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .woocommerce-loop-product-title a:hover, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper h3 a:hover' => 'color: {{VALUE}};'
                    ],
                    'separator' => 'after'
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => esc_html__('Price Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .price',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'current_price_color',
            [
                'label'     => esc_html__('Current Price Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .price, {{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .price del' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'sale_price_color',
            [
                'label'     => esc_html__('New Price Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .price ins' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'old_price_color',
            [
                'label'     => esc_html__('Old Price Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__wrapper .content-woocommerce-wrapper .price del' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'rating_default_color',
            [
                'label'     => esc_html__('Rating Inactive Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .star-rating:before' => 'color: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'rating_active_color',
            [
                'label'     => esc_html__('Rating Active Color', 'neuros_plugin'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .star-rating span' => 'color: {{VALUE}};'
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
                'label' => esc_html__('Product Button Settings', 'neuros_plugin'),
                'tab'   => Controls_Manager::TAB_STYLE
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
                        'label'     => esc_html__('Button Text Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .woocommerce-loop-product__wrapper .product-buttons-wrapper a.button, 
                             {{WRAPPER}} .woocommerce-loop-product__wrapper .product-buttons-wrapper a.added_to_cart:hover' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg_color',
                    [
                        'label'     => esc_html__('Button Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .woocommerce-loop-product__wrapper .product-buttons-wrapper a.button, 
                             {{WRAPPER}} .woocommerce-loop-product__wrapper .product-buttons-wrapper a.added_to_cart:hover' => 'background-color: {{VALUE}};'
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
                    'button_hover_color',
                    [
                        'label'     => esc_html__('Button Text Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .woocommerce-loop-product__wrapper .product-buttons-wrapper a.button:hover, 
                             {{WRAPPER}} .woocommerce-loop-product__wrapper .product-buttons-wrapper a.added_to_cart' => 'color: {{VALUE}};'
                        ]
                    ]
                );

                $this->add_control(
                    'button_bg_hover_color',
                    [
                        'label'     => esc_html__('Button Background Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .woocommerce-loop-product__wrapper .product-buttons-wrapper a.button:hover, 
                             {{WRAPPER}} .woocommerce-loop-product__wrapper .product-buttons-wrapper a.added_to_cart' => 'background-color: {{VALUE}};'
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
                    'paginate'   => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'pagination_typography',
                'label'     => esc_html__('Pagination Typography', 'neuros_plugin'),
                'selector'  => '{{WRAPPER}} .woocommerce-pagination .page-numbers, {{WRAPPER}} .woocommerce-pagination .post-page-numbers'
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
                'prefix_class' => 'listing-pagination-background-style-',
            ]
        );

        $this->start_controls_tabs('pagination_tags_tabs', [ 
            'condition' => [
                'paginate' => 'yes'
            ]
        ]);
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
                            '{{WRAPPER}} .woocommerce-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .woocommerce-pagination .post-page-numbers:not(.current):not(:hover)' => 'color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'pagination_border_color',
                    [
                        'label'     => esc_html__('Pagination Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .woocommerce-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .woocommerce-pagination .post-page-numbers:not(.current):not(:hover)' => 'border-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .woocommerce-pagination .page-numbers:not(.current):not(:hover):after, {{WRAPPER}} .woocommerce-pagination .post-page-numbers:not(.current):not(:hover):after',
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
                            '{{WRAPPER}} .woocommerce-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .woocommerce-pagination .post-page-numbers:not(.current):not(:hover)' => 'background-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .woocommerce-pagination .page-numbers .button-inner:before, {{WRAPPER}} .woocommerce-pagination .post-page-numbers .button-inner:before',
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
                        'selector'  => '{{WRAPPER}} .woocommerce-pagination .page-numbers:not(.current):not(:hover), {{WRAPPER}} .woocommerce-pagination .post-page-numbers:not(.current):not(:hover)'
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
                            '{{WRAPPER}} .woocommerce-pagination .page-numbers.current, {{WRAPPER}} .woocommerce-pagination .post-page-numbers.current, {{WRAPPER}} .woocommerce-pagination .page-numbers:hover, {{WRAPPER}} .woocommerce-pagination .post-page-numbers:hover' => 'color: {{VALUE}};'
                        ],
                    ]
                );

                $this->add_control(
                    'pagination_border_color_active',
                    [
                        'label'     => esc_html__('Pagination Border Color', 'neuros_plugin'),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .woocommerce-pagination .page-numbers.current, {{WRAPPER}} .woocommerce-pagination .post-page-numbers.current, {{WRAPPER}} .woocommerce-pagination .page-numbers:hover, {{WRAPPER}} .woocommerce-pagination .post-page-numbers:hover' => 'border-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .woocommerce-pagination .page-numbers.current:after, {{WRAPPER}} .woocommerce-pagination .page-numbers:hover:after, {{WRAPPER}} .woocommerce-pagination .post-page-numbers.current:after, {{WRAPPER}} .woocommerce-pagination .post-page-numbers:hover:after',
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
                            '{{WRAPPER}} .woocommerce-pagination .page-numbers.current, {{WRAPPER}} .woocommerce-pagination .post-page-numbers.current, {{WRAPPER}} .woocommerce-pagination .page-numbers:hover, {{WRAPPER}} .woocommerce-pagination .post-page-numbers:hover' => 'background-color: {{VALUE}};'
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
                        'selector' => '{{WRAPPER}} .woocommerce-pagination .page-numbers .button-inner:after, {{WRAPPER}} .woocommerce-pagination .post-page-numbers .button-inner:after',
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
                        'selector'  => '{{WRAPPER}} .woocommerce-pagination .page-numbers.current, {{WRAPPER}} .woocommerce-pagination .post-page-numbers.current, {{WRAPPER}} .woocommerce-pagination .page-numbers:hover, {{WRAPPER}} .woocommerce-pagination .post-page-numbers:hover'
                    ]
                );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings       = $this->get_settings();

        $products_type = $settings['products_type'];

        $limit      = $settings['limit'];
        $columns    = $settings['columns'];
        $paginate   = $settings['paginate'] == 'yes' ? true : false;
        $orderby    = $settings['orderby'];
        $order      = $settings['order'];
        $category   = (!empty($settings['category']) ? implode(',', $settings['category']) : '');
        $skus       = $settings['skus'];
        $tag        = $settings['tag'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>
        <div class="woocommerce">
            <?php
                $atts = array(
                    'limit'          => $limit,
                    'columns'        => $columns,
                    'orderby'        => $orderby,
                    'order'          => $order,
                    'skus'           => $skus,
                    'category'       => $category,
                    'tag'            => $tag,
                    'visibility'     => 'visible',
                    'class'          => 'neuros_shop_loop',
                    'page'           => 1,
                    'paginate'       => $paginate,
                    'no_found_rows'  => false === $paginate
                );

                $type = 'products';
                if ( $products_type == 'on_sale' ) {
                    $atts['on_sale'] = 'true';
                    $type = 'sale_products';
                } elseif ( $products_type == 'best_selling' ) {
                    $atts['best_selling'] = 'true';
                    $type = 'best_selling_products';
                } elseif ( $products_type == 'top_rated' ) {
                    $atts['top_rated'] = 'true';
                    $type = 'top_rated_products';
                }

                if ( $paginate == false ) {
                    do_action( 'woocommerce_before_shop_loop' );
                }

                $shortcode = new \WC_Shortcode_Products( $atts, $type );
                echo $shortcode->get_content();

                if ( $paginate == false ) {
                    do_action( 'woocommerce_after_shop_loop' );
                }
            ?>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}
