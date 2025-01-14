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
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Neuros_Tabs_Widget extends Widget_Base {

    public function get_name() {
        return 'neuros_tabs';
    }

    public function get_title() {
        return esc_html__('Tabs', 'neuros_plugin');
    }

    public function get_icon() {
        return 'eicon-tabs';
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
                'label' => esc_html__('Tabs', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'tabs_direction',
            [
                'label'         => esc_html__('Tabs Direction', 'neuros_plugin'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'horizontal',
                'options'       => [
                    'horizontal' => esc_html__('Horizontal', 'neuros_plugin'),
                    'vertical'   => esc_html__('Vertical', 'neuros_plugin')
                ],
                'prefix_class'  => 'tabs-direction-'
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Tab Title', 'neuros_plugin'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Tab', 'neuros_plugin')
            ]
        );

        $repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'neuros_plugin' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
            'description',
            [
                'label' => esc_html__('Tab Description', 'neuros_plugin'),
                'type' => Controls_Manager::WYSIWYG,
            ]
        );

		$repeater->add_responsive_control(
            'item_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .neuros_tab_icon' => 'font-size: {{SIZE}}{{UNIT}};',                   
                ],
            ]
        );

        $repeater->add_responsive_control(
            'item_icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'neuros_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .neuros_tab_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$repeater->add_control(
            'element_id',
            [
                'label' => esc_html__('Element ID', 'neuros_plugin'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter Element ID without #', 'neuros_plugin')
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Tabs', 'neuros_plugin'),
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{title}}}',
                'prevent_empty' => false
            ]
        );

        $this->add_responsive_control(
            'tabs_align',
            [
                'label' => esc_html__('Tabs Alignment', 'neuros_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'neuros_plugin'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'neuros_plugin'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'neuros_plugin'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.tabs-direction-horizontal .neuros_tabs_titles_container' => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}}.tabs-direction-vertical .neuros_tabs_titles_container' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ----------------------------------- //
        // ---------- Tabs Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_controls_settings',
            [
                'label' => esc_html__('Tab Title Settings', 'neuros_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'tabs_spacing',
            [
                'label' => esc_html__( 'Space Between Tabs', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}}.tabs-direction-horizontal .neuros_tabs_titles_container .neuros_tab_title_item' => 'padding-right: calc({{SIZE}}{{UNIT}}/2); padding-left: calc({{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}}.tabs-direction-horizontal .neuros_tabs_titles_container' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}}.tabs-direction-vertical .neuros_tabs_titles_container .neuros_tab_title_item' => 'padding-top: calc({{SIZE}}{{UNIT}}/2); padding-bottom: calc({{SIZE}}{{UNIT}}/2);',
                    '{{WRAPPER}}.tabs-direction-vertical .neuros_tabs_titles_container' => 'margin-top: calc(-{{SIZE}}{{UNIT}}/2); margin-bottom: calc(-{{SIZE}}{{UNIT}}/2);'
                ],
            ]
        );

        $this->add_responsive_control(
            'text_h_align',
            [
                'label' => esc_html__('Tab Title Horizontal Alignment', 'neuros_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'neuros_plugin'),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'neuros_plugin'),
                        'icon' => 'eicon-align-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'neuros_plugin'),
                        'icon' => 'eicon-align-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'neuros_plugin'),
                        'icon' => 'eicon-justify-space-between-h',
                    ]
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .neuros_tab_title_item a' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_v_align',
            [
                'label' => esc_html__('Tab Title Vertical Alignment', 'neuros_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'neuros_plugin'),
                        'icon' => 'eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'neuros_plugin'),
                        'icon' => 'eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'neuros_plugin'),
                        'icon' => 'eicon-align-end-v',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .neuros_tab_title_item a' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => esc_html__('Tab Title Text Alignment', 'neuros_plugin'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'neuros_plugin'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'neuros_plugin'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'neuros_plugin'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .neuros_tab_title_item a' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_padding',
            [
                'label'         => esc_html__('Tabs Padding', 'neuros_plugin'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .neuros_tab_title_item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'tabs_width',
            [
                'label' => esc_html__( 'Tabs Width', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item' => 'width: {{SIZE}}{{UNIT}};',                   
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_border',
                'label' => esc_html__( 'Tabs Border', 'elementory' ),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .neuros_tab_title_item a',
            ]
        );

        $this->add_responsive_control(
            'tabs_radius',
            [
                'label' => esc_html__('Tabs Radius', 'neuros_plugin'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .neuros_tab_title_item a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'controls_typography',
                'label' => esc_html__('Tab Title Typography', 'neuros_plugin'),
                'selector' => '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item a'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Tab Description Typography', 'neuros_plugin'),
                'selector' => '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item .neuros_tab_description'
            ]
        );

        $this->add_control(
            'add_overlay',
            [
                'label'         => esc_html__('Add Title Overlay', 'neuros_plugin'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'on',
                'return_value'  => 'on',
                'label_off'     => esc_html__('No', 'neuros_plugin'),
                'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                'prefix_class'  => 'tabs-overlay-'
            ]
        );

        $this->add_control(
            'controls_overlay_color',
            [
                'label' => esc_html__('Tab Title Overlay Color', 'neuros_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item a:before' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                	'add_overlay' => 'on'
                ]
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
                'controls_color',
                [
                    'label' => esc_html__('Tab Title Color', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item:not(.active) a:not(:hover)' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'controls_bg',
                [
                    'label' => esc_html__('Tab Title Background', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item:not(.active) a:not(:hover)' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'controls_bd',
                [
                    'label' => esc_html__('Tab Title Border Color', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item:not(.active) a:not(:hover)' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'description_color',
                [
                    'label' => esc_html__('Tab Description Color', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item:not(.active) a:not(:hover) .neuros_tab_description' => 'color: {{VALUE}};'
                    ]
                ]
            );    

            $this->end_controls_tab();

            // ----------------------- //
            // ------ Active Tab ------ //
            // ----------------------- //
            $this->start_controls_tab(
                'tab_control_active',
                [
                    'label' => esc_html__('Active', 'neuros_plugin')
                ]
            );

            $this->add_control(
                'controls_color_active',
                [
                    'label' => esc_html__('Active Tab Title Color', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a, {{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'controls_bg_active',
                [
                    'label' => esc_html__('Active Tab Title Background', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a, {{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'controls_bd_active',
                [
                    'label' => esc_html__('Active Tab Title Border Color', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a, {{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a:hover' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'description_color_active',
                [
                    'label' => esc_html__('Active Tab Description Color', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a .neuros_tab_description, {{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a:hover .neuros_tab_description' => 'color: {{VALUE}};'
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
                'controls_color_hover',
                [
                    'label' => esc_html__('Tab Title on Hover', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'controls_bg_hover',
                [
                    'label' => esc_html__('Tab Title Background on Hover', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item a:hover' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'controls_bd_hover',
                [
                    'label' => esc_html__('Tab Title Border Color on Hover', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item a:hover' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'description_color_hover',
                [
                    'label' => esc_html__('Tab Description on Hover', 'neuros_plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item a:hover .neuros_tab_description' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        

        // ----------------------------------- //
        // ---------- Icon Settings ---------- //
        // ----------------------------------- //
        $this->start_controls_section(
            'section_content_icon_settings',
            [
                'label' => esc_html__('Icon Settings', 'neuros_plugin'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'neuros_plugin' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .neuros_tab_icon' => 'font-size: {{SIZE}}{{UNIT}};',                   
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__( 'Icon Spacing', 'neuros_plugin' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .neuros_tab_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'neuros_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_icon' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Hover Color', 'neuros_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item a:hover .neuros_tab_icon' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'icon_color_active',
            [
                'label' => esc_html__('Icon Active Color', 'neuros_plugin'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a .neuros_tab_icon, {{WRAPPER}} .neuros_tabs_titles_container .neuros_tab_title_item.active a:hover .neuros_tab_icon' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $tabs = $settings['tabs'];

        // ------------------------------------ //
        // ---------- Widget Content ---------- //
        // ------------------------------------ //
        ?>

        <div class="neuros_tabs_widget">
            <div class="neuros_tabs_titles_container">
                <?php
                foreach ($tabs as $tab) {
                    ?>
                    <div class="neuros_tab_title_item elementor-repeater-item-<?php echo esc_attr($tab['_id'])?>" data-id="<?php echo esc_attr($tab['element_id']); ?>">
                        <a href="<?php echo esc_js('javascript:void(0)'); ?>">
                        	<span class="neuros_tab_icon"><?php Icons_Manager::render_icon( $tab['icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                        	<?php
                        		if( !empty($tab['description']) || !empty($tab['title']) ) {
                        			echo '<span class="neuros_tab_content">';
                        				if( !empty($tab['title']) ) {
                        					echo '<span class="neuros_tab_title">' . wp_kses_post($tab['title']) . '</span>';
                        				}
                        				if( !empty($tab['description']) ) {
                        					echo '<span class="neuros_tab_description">' . wp_kses_post($tab['description']) . '</span>';
                        				}
                        			echo '</span>';
                        		}
                        	?>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}

    public function render_plain_content() {}
}