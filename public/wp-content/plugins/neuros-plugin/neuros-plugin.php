<?php
/*
Plugin Name: Neuros Plugin
Plugin URI: https://demo.artureanec.com/
Description: Register Custom Widgets and Custom Post Types for Neuross Theme.
Version: 2.1
Author: Artureanec
Author URI: https://demo.artureanec.com/
Text Domain: neuros_plugin
*/

// --- Register Custom Widgets --- //
if (!function_exists('neuros_widgets_load')) {
    function neuros_widgets_load() {
        require_once(__DIR__ . "/widgets/nav-menu.php");
        require_once(__DIR__ . "/widgets/special-text.php");
    }
}
add_action('plugins_loaded', 'neuros_widgets_load');

if (!function_exists('neuros_add_custom_widget')) {
    function neuros_add_custom_widget($name) {
        register_widget($name);
    }
}

// --- Add Mime Types --- //
function neuros_upload_mimes( $mimes = array() ) {
    // allow SVG file upload
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}
add_filter( 'upload_mimes', 'neuros_upload_mimes', 99 );

// --- Register Custom Post Types --- //
add_action('init', 'neuros_register_custom_post_types');
if (!function_exists('neuros_register_custom_post_types')) {
    function neuros_register_custom_post_types() {
        # Projects
        register_taxonomy(
            'neuros_project_category',
            array('neuros_project'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Project Categories', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Project Category', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Category', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Project Categories', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Category', 'neuros_plugin'),
                    'parent_item'       => esc_html__('Parent Category', 'neuros_plugin'),
                    'parent_item_colon' => esc_html__('Parent Category:', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Category', 'neuros_plugin'),
                    'update_item'       => esc_html__('Update Category', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('Add New Category', 'neuros_plugin'),
                    'new_item_name'     => esc_html__('New Project Category', 'neuros_plugin'),
                    'menu_name'         => esc_html__('Project Categories', 'neuros_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false
            )
        );
        register_post_type(
            'neuros_project',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Projects', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Project', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Project', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Projects', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Project', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Project', 'neuros_plugin'),
                    'add_new'           => esc_html__('Add New Project', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('New Project', 'neuros_plugin'),
                    'archives'          => esc_html__('Projects', 'neuros_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'projects',
                    'with_front'        => false
                ),
                'hierarchical'      => true,
                'menu_position'     => 5,
                'menu_icon'         => 'dashicons-laptop',
                'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
                'taxonomies'        => array( 'neuros_project_category' ),
                'has_archive'       => true
            )
        );

        # Team
        register_taxonomy(
            'neuros_team_department',
            array('neuros_team_member'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Departments', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Department', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Departments', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Departments', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Department', 'neuros_plugin'),
                    'parent_item'       => esc_html__('Parent Department', 'neuros_plugin'),
                    'parent_item_colon' => esc_html__('Parent Department:', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Department', 'neuros_plugin'),
                    'update_item'       => esc_html__('Update Department', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('Add New Department', 'neuros_plugin'),
                    'new_item_name'     => esc_html__('New Department Name', 'neuros_plugin'),
                    'menu_name'         => esc_html__('Departments', 'neuros_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false
            )
        );
        register_post_type('neuros_team_member',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Team Members', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Team Member', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Team Member', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Team Members', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Team Member', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Team Member', 'neuros_plugin'),
                    'add_new'           => esc_html__('Add New Member', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('New Team Member', 'neuros_plugin'),
                    'archives'          => esc_html__('Team', 'neuros_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'team',
                    'with_front'        => false
                ),
                'hierarchical'      => false,
                'menu_position'     => 6,
                'menu_icon'         => 'dashicons-groups',
                'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
                'taxonomies'        => array( 'neuros_team_department' ),
                'has_archive'       => true
            )
        );

        # Careers
        register_taxonomy(
            'neuros_careers_department',
            array('neuros_vacancy'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Departments', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Department', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Departments', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Departments', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Department', 'neuros_plugin'),
                    'parent_item'       => esc_html__('Parent Department', 'neuros_plugin'),
                    'parent_item_colon' => esc_html__('Parent Department:', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Department', 'neuros_plugin'),
                    'update_item'       => esc_html__('Update Department', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('Add New Department', 'neuros_plugin'),
                    'new_item_name'     => esc_html__('New Department Name', 'neuros_plugin'),
                    'menu_name'         => esc_html__('Departments', 'neuros_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false
            )
        );
        register_post_type('neuros_vacancy',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Careers', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Career', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Career', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Careers', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Career', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Career', 'neuros_plugin'),
                    'add_new'           => esc_html__('Add New Career', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('New Career', 'neuros_plugin'),
                    'archives'          => esc_html__('Careers', 'neuros_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'careers',
                    'with_front'        => false
                ),
                'hierarchical'      => false,
                'menu_position'     => 7,
                'menu_icon'         => 'dashicons-megaphone',
                'supports'          => array( 'title', 'editor', 'author', 'excerpt' ),
                'taxonomies'        => array( 'neuros_careers_department' ),
                'has_archive'       => true
            )
        );

        # Services
        register_taxonomy(
            'neuros_services_category',
            array('neuros_service'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Service Categories', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Service Category', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Category', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Categories', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Category', 'neuros_plugin'),
                    'parent_item'       => esc_html__('Parent Category', 'neuros_plugin'),
                    'parent_item_colon' => esc_html__('Parent Category:', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Category', 'neuros_plugin'),
                    'update_item'       => esc_html__('Update Category', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('Add New Category', 'neuros_plugin'),
                    'new_item_name'     => esc_html__('New Category Name', 'neuros_plugin'),
                    'menu_name'         => esc_html__('Categories', 'neuros_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false
            )
        );
        register_taxonomy(
            'neuros_services_tag',
            array('neuros_service'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Service Tags', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Service Tag', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Tag', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Tags', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Tag', 'neuros_plugin'),
                    'parent_item'       => esc_html__('Parent Tag', 'neuros_plugin'),
                    'parent_item_colon' => esc_html__('Parent Tag:', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Tag', 'neuros_plugin'),
                    'update_item'       => esc_html__('Update Tag', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('Add New Tag', 'neuros_plugin'),
                    'new_item_name'     => esc_html__('New Tag Name', 'neuros_plugin'),
                    'menu_name'         => esc_html__('Tags', 'neuros_plugin'),
                ),
                'hierarchical'      => false,
                'show_admin_column' => false,
                'show_in_rest'      => true
            )
        );
        register_post_type('neuros_service',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Services', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Service', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Service', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Services', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Service', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Service', 'neuros_plugin'),
                    'add_new'           => esc_html__('Add New Service', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('New Service', 'neuros_plugin'),
                    'archives'          => esc_html__('Services', 'neuros_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'services',
                    'with_front'        => false
                ),
                'hierarchical'      => false,
                'menu_position'     => 8,
                'menu_icon'         => 'dashicons-admin-generic',
                'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                'taxonomies'        => array( 'neuros_services_category' ),
                'has_archive'       => true
            )
        );

        # Case Studies
        register_taxonomy(
            'neuros_case_study_category',
            array('neuros_case_study'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Case Study Categories', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Case Study Category', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Category', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Categories', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Category', 'neuros_plugin'),
                    'parent_item'       => esc_html__('Parent Category', 'neuros_plugin'),
                    'parent_item_colon' => esc_html__('Parent Category:', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Category', 'neuros_plugin'),
                    'update_item'       => esc_html__('Update Category', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('Add New Category', 'neuros_plugin'),
                    'new_item_name'     => esc_html__('New Category Name', 'neuros_plugin'),
                    'menu_name'         => esc_html__('Categories', 'neuros_plugin'),
                ),
                'hierarchical'      => true,
                'show_admin_column' => false,
                'show_in_rest'      => true
            )
        );
        register_taxonomy(
            'neuros_case_study_tag',
            array('neuros_case_study'),
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Case Study Tags', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Case Study Tag', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Tag', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Tags', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Tag', 'neuros_plugin'),
                    'parent_item'       => esc_html__('Parent Tag', 'neuros_plugin'),
                    'parent_item_colon' => esc_html__('Parent Tag:', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Tag', 'neuros_plugin'),
                    'update_item'       => esc_html__('Update Tag', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('Add New Tag', 'neuros_plugin'),
                    'new_item_name'     => esc_html__('New Tag Name', 'neuros_plugin'),
                    'menu_name'         => esc_html__('Tags', 'neuros_plugin'),
                ),
                'hierarchical'      => false,
                'show_admin_column' => false,
                'show_in_rest'      => true
            )
        );
        register_post_type('neuros_case_study',
            array(
                'label'             => null,
                'labels'            => array(
                    'name'              => esc_html__('Case Studies', 'neuros_plugin'),
                    'singular_name'     => esc_html__('Case Study', 'neuros_plugin'),
                    'search_items'      => esc_html__('Search Case Studies', 'neuros_plugin'),
                    'all_items'         => esc_html__('All Case Studies', 'neuros_plugin'),
                    'view_item'         => esc_html__('View Case Study', 'neuros_plugin'),
                    'edit_item'         => esc_html__('Edit Case Study', 'neuros_plugin'),
                    'add_new'           => esc_html__('Add New Case Study', 'neuros_plugin'),
                    'add_new_item'      => esc_html__('New Case Study', 'neuros_plugin'),
                    'archives'          => esc_html__('Case Studies', 'neuros_plugin')
                ),
                'public'            => true,
                'rewrite'           => array(
                    'slug'              => 'case-studies',
                    'with_front'        => false
                ),
                'hierarchical'      => false,
                'menu_position'     => 9,
                'menu_icon'         => 'dashicons-open-folder',
                'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
                'taxonomies'        => array( 'neuros_case_study_category' ),
                'has_archive'       => true,
                'show_in_rest'      => true
            )
        );
    }
}

// Init Custom Widgets for Elementor
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

final class Neuros_Custom_Widgets {
    const  VERSION = '1.0.0';
    const  MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const  MINIMUM_PHP_VERSION = '5.4';
    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init() {

    	load_plugin_textdomain('neuros_plugin', false, plugin_basename(dirname(__FILE__)) . '/languages');

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'neuros_admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'neuros_admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'neuros_admin_notice_minimum_php_version']);
            return;
        }

        // Add Custom Icons Group
        if ( !function_exists('neuros_add_custom_icons_group_to_elementor') ) {
            function neuros_add_custom_icons_group_to_elementor($additional_tabs) {
                $custom_groups = [
                    'theme_icons'   => [
                        'name'          => 'theme_icons',
                        'label'         => esc_html__( 'Theme Icons', 'neuros_plugin' ),
                        'labelIcon'     => 'eicon-theme-style',
                        'native'        => false,
                        'url'           => get_template_directory_uri() . '/css/fontello.css',
                        'enqueue'       => [
                            get_template_directory_uri() . '/css/fontello-enqueue.css'
                        ],
                        'prefix'        => 'icon-',
                        'displayPrefix' => 'fontello',
                        'ver'           => '1.0.0',
                        'fetchJson'     => get_template_directory_uri() . '/js/fontello.js',
                    ]
                ];
                $additional_tabs = array_merge($additional_tabs, $custom_groups);
                return $additional_tabs;
            }
        }
        add_filter( 'elementor/icons_manager/additional_tabs', 'neuros_add_custom_icons_group_to_elementor' );

        // Add Custom Fonts Group
        if ( !function_exists('neuros_add_custom_fonts_group_to_elementor') ) {
            function neuros_add_custom_fonts_group_to_elementor($font_groups) {
                $additional_groups = array(
                    'theme_fonts'     => esc_html__( 'Theme Fonts', 'neuros_plugin' )
                );
                $font_groups = array_merge($font_groups, $additional_groups);
                return $font_groups;
            }
        }
        add_filter( 'elementor/fonts/groups', 'neuros_add_custom_fonts_group_to_elementor' );

        // Add Custom Fonts
        if ( !function_exists('neuros_add_custom_fonts_to_elementor') ) {
            function neuros_add_custom_fonts_to_elementor($fonts) {
                $additional_fonts = array(
                    'Manrope Alt'        => 'theme_fonts'
                );
                $fonts = array_merge($fonts, $additional_fonts);
                return $fonts;
            }
        }
        add_filter( 'elementor/fonts/additional_fonts', 'neuros_add_custom_fonts_to_elementor' );

        // Add Hover Animations
        if ( !function_exists('neuros_add_hover_animations_to_elementor') ) {
            function neuros_add_hover_animations_to_elementor($animations) {
                $additional_animations = array('slide-horizontal' => __('Slide Horizontal', 'neuros_plugin'));
                $animations = array_merge($animations, $additional_animations);
                return $animations;
            }
        }
        add_filter( 'elementor/controls/hover_animations/additional_animations', 'neuros_add_hover_animations_to_elementor' );        

        // Include Additional Files
        add_action('elementor/init', [$this, 'neuros_include_additional_files']);

        // Add new Elementor Categories
        add_action('elementor/init', [$this, 'neuros_add_elementor_category']);

        // Register Widget Scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'neuros_register_widget_scripts']);

        add_action('wp_enqueue_scripts', function () {
            wp_localize_script('ajax_query_products', 'neuros_ajaxurl',
                array(
                    'url' => admin_url('admin-ajax.php')
                )
            );
        });

        // Register New Widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'neuros_widgets_register']);

        // Register Editor Styles
        add_action('elementor/editor/before_enqueue_scripts', function () {
            wp_register_style('neuros_elementor_admin', plugins_url('neuros-plugin/css/neuros-plugin-admin.css'));
            wp_enqueue_style('neuros_elementor_admin');            
        });
    }

    public function neuros_admin_notice_missing_main_plugin() {
        $message = sprintf(
        /* translators: 1: Restbeef Core 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'neuros_plugin'),
            '<strong>' . esc_html__('Restbeef Core', 'neuros_plugin') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'neuros_plugin') . '</strong>'
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function neuros_admin_notice_minimum_elementor_version() {
        $message = sprintf(
        /* translators: 1: Restbeef Core 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'neuros_plugin'),
            '<strong>' . esc_html__('Restbeef Core', 'neuros_plugin') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'neuros_plugin') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function neuros_admin_notice_minimum_php_version() {
        $message = sprintf(
        /* translators: 1: Press Elements 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'neuros_plugin'),
            '<strong>' . esc_html__('Press Elements', 'neuros_plugin') . '</strong>',
            '<strong>' . esc_html__('PHP', 'neuros_plugin') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function neuros_include_additional_files() {}

    public function neuros_add_elementor_category() {
        $categories = [];
        $categories['neuros_widgets'] = [
            'title' => esc_html__('Neuros Widgets', 'neuros_plugin'),
            'icon'  => 'eicon-plug'
        ];
        $old_categories = \Elementor\Plugin::$instance->elements_manager->get_categories();
        $categories     = array_merge($categories, $old_categories);

        $set_categories = function ( $categories ) {
            $this->categories = $categories;
        };
        $set_categories->call( \Elementor\Plugin::$instance->elements_manager, $categories );
    }

    public function neuros_register_widget_scripts() {
        // Lib
        wp_register_script('fancybox', plugins_url('neuros-plugin/js/lib/jquery.fancybox.min.js'), array('jquery'));
        wp_register_script('slick-slider', plugins_url('neuros-plugin/js/lib/slick.min.js'), array('jquery'));
        wp_register_script('isotope', plugins_url('neuros-plugin/js/lib/isotope.pkgd.min.js'), array('jquery'));
        wp_register_script('plugin', plugins_url('neuros-plugin/js/lib/jquery.plugin.js'), array('jquery'));
        
        wp_register_script('flowmap-effect', plugins_url('neuros-plugin/js/flowmap-effect.min.js'), array(), false, true );
        wp_register_script('aat', plugins_url('neuros-plugin/js/lib/aat.min.js'), array(), false, true );
        wp_register_script('scroll-trigger', plugins_url('neuros-plugin/js/lib/ScrollTrigger.min.js'), array(), false, true );
        wp_register_script('gsap', plugins_url('neuros-plugin/js/lib/gsap.min.js'), array('scroll-trigger'), false, true );

        // Scripts
        wp_register_script('neuros_elementor_editor', plugins_url('neuros-plugin/js/elementor-scripts.js'), array('jquery'));
        wp_enqueue_script('neuros_elementor_editor');
        wp_register_script('elementor_widgets', plugins_url('neuros-plugin/js/elementor-widgets.js'), array('jquery', 'owl-carousel', 'isotope', 'neuros-theme'));
    }

    public function neuros_widgets_register() {

        // --- Include Widget Files --- //
        require_once __DIR__ . '/elements/audio-listing.php';
        require_once __DIR__ . '/elements/awards.php';
        require_once __DIR__ . '/elements/blog.php';
        require_once __DIR__ . '/elements/button.php';
        require_once __DIR__ . '/elements/case-study-listing.php';
        require_once __DIR__ . '/elements/content-slider.php';
        require_once __DIR__ . '/elements/custom-menu.php';
        require_once __DIR__ . '/elements/gallery.php';
        require_once __DIR__ . '/elements/heading.php';
        require_once __DIR__ . '/elements/icon-box.php';
        require_once __DIR__ . '/elements/image-carousel.php';
        require_once __DIR__ . '/elements/price-item.php';     
        require_once __DIR__ . '/elements/moving-list.php';
        require_once __DIR__ . '/elements/projects-listing.php';
        require_once __DIR__ . '/elements/special-text.php';
        require_once __DIR__ . '/elements/services-listing.php';
        require_once __DIR__ . '/elements/step-carousel.php';
        require_once __DIR__ . '/elements/tabs.php';
        require_once __DIR__ . '/elements/team-members.php';
        require_once __DIR__ . '/elements/testimonial-carousel.php';
        require_once __DIR__ . '/elements/vacancies-listing.php';
        require_once __DIR__ . '/elements/video-button.php';        

        // --- Register Widgets --- //
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Audio_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Awards_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Blog_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Button_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Case_Study_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Vacancies_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Content_Slider_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Custom_Menu_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Gallery_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Heading_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Icon_Box_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Image_Carousel_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Moving_List_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Price_Item_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Projects_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Services_Listing_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Special_Text_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Step_Carousel_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Tabs_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Team_Members_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Testimonial_Carousel_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Video_Button_Widget());

        if (class_exists('WooCommerce')) {
            require_once __DIR__ . '/elements/products.php';
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Products_Widget());
        }

        if ( function_exists( 'wpforms' ) ) {
            require_once __DIR__ . '/elements/wpforms.php';
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Wpforms_Widget());
        }

        if ( function_exists( 'mc4wp' ) ) {
            require_once __DIR__ . '/elements/mailchimp.php';
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Neuros\Widgets\Neuros_Mailchimp_Widget());
        }
    }
}

Neuros_Custom_Widgets::instance();

if ( did_action( 'elementor/loaded' ) ) {

    add_action('elementor/element/after_section_start', function ($element, $section_id, $args) {
        if ('accordion' === $element->get_name() && 'section_title' === $section_id) {
            $element->add_control(
                'accordion_style',
                [
                    'label' => esc_html__( 'Accordion Style', 'neuros_plugin' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        '' => esc_html__( 'Default', 'neuros_plugin' ),
                        'counter' => esc_html__( 'Counter', 'neuros_plugin' ),
                    ],
                    'prefix_class' => 'elementor-accordion-style-'
                ]
            );
        }
        if ('icon' === $element->get_name() && 'section_style_icon' === $section_id) {            
            $element->add_responsive_control(
                'icon_align',
                [
                    'label' => esc_html__( 'Alignment', 'neuros_plugin' ),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'neuros_plugin' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'neuros_plugin' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'neuros_plugin' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'selectors' => [
                        '{{WRAPPER}}.neuros-icon-decoration-on .elementor-widget-container' => 'text-align: {{VALUE}};',
                        '{{WRAPPER}}:not(.neuros-icon-decoration-on) .elementor-icon-wrapper' => 'text-align: {{VALUE}};',
                    ],
                    'prefix_class' => 'neuros-icon-alignment%s-'
                ]
            );
            $element->add_control(
                'icon_inner_bg_color',
                [
                    'label' => esc_html__( 'Icon Wrapper Background Color', 'neuros_plugin' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',                    
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-inner' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}}.neuros-icon-decoration-on .elementor-icon-wrapper:before,
                        {{WRAPPER}}.neuros-icon-decoration-on .elementor-icon-wrapper:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};'
                    ],
                    'condition' => [
                        'add_decoration' => 'on',
                    ],
                ]
            );
        } 
    }, 10, 3);
    
    add_action('elementor/element/before_section_end', function ($element, $section_id, $args) {
        if ('section' === $element->get_name() && 'section_background' === $section_id) {
            $element->add_control(
                'background_clip',
                [
                    'label'         => esc_html__( 'Background Clip', 'neuros_plugin' ),
                    'type'          => \Elementor\Controls_Manager::SELECT,
                    'options'       => [
                        ''              => esc_html__( 'Default', 'neuros_plugin' ),
                        'border-box'    => 'Border Box',
                        'padding-box'   => 'Padding Box',
                        'content-box'   => 'Content Box',
                        'text'          => 'Text',
                        'inherit'       => 'Inherit',
                        'initial'       => 'Initial',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}}' => 'background-clip: {{VALUE}}',
                    ],
                ]
            );
            $element->add_control(
                'use_parallax',
                [
                    'label'         => esc_html__( 'Parallax Effect', 'plugin-domain' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'neuros_plugin' ),
                    'label_off'     => esc_html__( 'Off', 'neuros_plugin' ),
                    'return_value'  => 'yes',
                    'default'       => 'no'
                ]
            );
            $element->add_control(
                'add_flowmap_animation',
                [
                    'label'         => esc_html__( 'Add Flowmap Animation', 'plugin-domain' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'neuros_plugin' ),
                    'label_off'     => esc_html__( 'Off', 'neuros_plugin' ),
                    'return_value'  => 'on',
                    'default'       => ''
                ]
            );
            $element->add_control(
	            'flowmap_image',
	            [
	                'label'     => esc_html__('Flowmap Image', 'neuros_plugin'),
	                'type'      => \Elementor\Controls_Manager::MEDIA,
	                'condition' => [
	                	'add_flowmap_animation' => 'on'
	                ]
	            ]
	        );
	        $element->add_group_control(
                \Elementor\Group_Control_Css_Filter::get_type(),
                [
                    'name'          => 'flowmap_css_filters',
                    'selector'      => '{{WRAPPER}} .flowmap-deformation-wrapper',
                    'condition' => [
	                	'add_flowmap_animation' => 'on'
	                ]
                ]
            );
        }

        if ('section' === $element->get_name() && 'section_layout' === $section_id) {
            $element->add_control(
                'section_container_padding',
                [
                    'label'         => esc_html__( 'Remove Container Padding', 'neuros_plugin' ),
                    'description'    => esc_html__('Container paddings are added to no gap stretched section`s container'),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'neuros_plugin' ),
                    'label_off'     => esc_html__( 'Off', 'neuros_plugin' ),
                    'return_value'  => 'container-padding-remove',
                    'default'       => '',
                    'prefix_class'  => 'elementor-section-',
                    'hide_in_inner' => true,
                    'condition'     => [
                        'stretch_section' => 'section-stretched',
                        'gap!'       => 'no'
                    ] 
                ]
            );

            $element->add_control(
                'section_inner_container_padding',
                [
                    'label'         => esc_html__( 'Remove Container Padding', 'neuros_plugin' ),
                    'description'    => esc_html__('Container paddings are added to inner section container in stretched parent section with no gap'),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'neuros_plugin' ),
                    'label_off'     => esc_html__( 'Off', 'neuros_plugin' ),
                    'return_value'  => 'container-padding-remove',
                    'default'       => '',
                    'prefix_class'  => 'elementor-section-',
                    'hide_in_top' => true,
                    'condition'     => [
                        'gap!'       => 'no'
                    ] 
                ]
            );

            $element->add_control(
                'section_inner_fit_height',
                [
                    'label'         => esc_html__( 'Fit Column Height', 'neuros_plugin' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'neuros_plugin' ),
                    'label_off'     => esc_html__( 'Off', 'neuros_plugin' ),
                    'return_value'  => 'fit-height',
                    'default'       => '',
                    'prefix_class'  => 'elementor-section-',
                    'hide_in_top' => true,
                ]
            );

            $element->add_control(
                'section_inner_scroll_animation',
                [
                    'label'         => esc_html__( 'Add Scroll Animation', 'neuros_plugin' ),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'On', 'neuros_plugin' ),
                    'label_off'     => esc_html__( 'Off', 'neuros_plugin' ),
                    'return_value'  => 'on',
                    'default'       => '',
                    'prefix_class'  => 'elementor-section-scroll-animation-',
                    'hide_in_top' => true,
                ]
            );
        }
        if ('text-editor' === $element->get_name() && 'section_style' === $section_id) {
            $element->add_control(
                'blockquote_icon_color',
                [
                    'label'     => esc_html__( 'Blockquote Icon Color', 'elementor' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} blockquote:before' => 'color: {{VALUE}};',
                    ],
                ]
            );
        }

        if ('icon' === $element->get_name() && 'section_icon' === $section_id) {            
            $element->add_control(
                'add_decoration',
                [
                    'label'         => esc_html__('Add Decoration', 'neuros_plugin'),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'default'       => '',
                    'return_value'  => 'on',
                    'label_off'     => esc_html__('No', 'neuros_plugin'),
                    'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                    'separator'     => 'before',
                    'prefix_class'  => 'neuros-icon-decoration-'
                ]
            );
        }

        if ('icon' === $element->get_name() && 'section_style_icon' === $section_id) {
            $element->remove_responsive_control('align');
            $element->add_responsive_control(
                'icon_inner_padding',
                [
                    'label'         => esc_html__('Icon Wrapper Padding', 'neuros_plugin'),
                    'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .elementor-icon-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                    'condition' => [
                        'add_decoration' => 'on'
                    ]
                ]
            );

            $element->add_responsive_control(
                'border_radius_inner',
                [
                    'label' => esc_html__( 'Icon Wrapper Border Radius', 'neuros_plugin' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'add_decoration' => 'on'
                    ]
                ]
            );
        }

        if ( 'image' === $element->get_name() && 'section_image' === $section_id ) {
            $element->add_control(
                'show_hover_text',
                [
                    'label'         => esc_html__('Show hover text', 'neuros_plugin'),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_off'     => esc_html__('Hide', 'neuros_plugin'),
                    'label_on'      => esc_html__('Show', 'neuros_plugin'),
                    'default'       => 'no',
                    'return_value'  => 'yes'
                ]
            );
            $element->add_control(
                'subtitle',
                [
                    'label'         => esc_html__('Subtitle', 'neuros_plugin'),
                    'type'          => \Elementor\Controls_Manager::TEXT,
                    'default'       => '',
                    'condition'     => [
                        'show_hover_text'   => 'yes'
                    ]
                ]
            );
            $element->add_control(
                'title',
                [
                    'label'         => esc_html__('Title', 'neuros_plugin'),
                    'type'          => \Elementor\Controls_Manager::TEXT,
                    'default'       => '',
                    'condition'     => [
                        'show_hover_text'   => 'yes'
                    ]
                ]
            );
            $element->add_control(
                'hover_text_color',
                [
                    'label'     => esc_html__( 'Hover Text Color', 'neuros_plugin' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hovered-text-title, {{WRAPPER}} .hovered-text-subtitle' => 'color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'show_hover_text'   => 'yes'
                    ]
                ]
            );
            $element->add_control(
                'hover_text_bg_color',
                [
                    'label'     => esc_html__( 'Hover Text Background Color', 'neuros_plugin' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .hovered-text-title, {{WRAPPER}} .hovered-text-subtitle' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .hovered-text-subtitle-wrapper:after' => 'box-shadow: 0 20px 0 0 {{VALUE}};'
                    ],
                    'condition'     => [
                        'show_hover_text'   => 'yes'
                    ]
                ]
            );
            $element->add_control(
                'add_scroll_animation',
                [
                    'label'         => esc_html__('Add Scroll Animation', 'neuros_plugin'),
                    'type'          => \Elementor\Controls_Manager::SWITCHER,
                    'label_off'     => esc_html__('No', 'neuros_plugin'),
                    'label_on'      => esc_html__('Yes', 'neuros_plugin'),
                    'default'       => '',
                    'return_value'  => 'on',
                    'prefix_class'  => 'elementor-image-scroll-animation-'
                ]
            );
        }

        if ('image-box' === $element->get_name() && 'section_style_box' === $section_id) {
            $element->add_responsive_control(
                'image_box_padding',
                [
                    'label'         => esc_html__('Image Padding', 'neuros_plugin'),
                    'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .elementor-image-box-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );

            $element->add_responsive_control(
                'image_box_bd_radius',
                [
                    'label' => esc_html__( 'Image Box Border Radius', 'neuros_plugin' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-box-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ]
                ]
            );

            $element->add_control(
                'image_box_bg_color',
                [
                    'label'     => esc_html__( 'Image Background Color', 'neuros_plugin' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-box-img' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
        }

        if ('image-box' === $element->get_name() && 'section_style_content' === $section_id) {
            $element->add_responsive_control(
                'content_border_width',
                [
                    'label'     => esc_html__('Border Width', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-content' => 'border-bottom-width: {{SIZE}}{{UNIT}}; border-bottom-style: solid;',
                    ]
                ]
            );

            $element->add_control(
                'content_border_color',
                [
                    'label'     => esc_html__('Border Color', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-content' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_responsive_control(
                'content_border_spacing',
                [
                    'label'     => esc_html__('Border Spacing', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'range'     => [
                        'px'        => [
                            'min'       => 0,
                            'max'       => 100
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-content' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                    ]
                ]
            );            
        }

        if ('counter' === $element->get_name() && 'section_counter_style' === $section_id) {
        	$element->add_responsive_control(
				'horizontal_title_gap',
				[
					'label' => esc_html__( 'Title Gap', 'neuros_plugin' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem', 'custom' ],
					'selectors' => [
						'{{WRAPPER}} .elementor-counter' => 'gap: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'title!' => '',
						'title_position' => [ 'start', 'end' ],
					],
				]
			);
            $element->add_control(
                'counter_filter_blur',
                [
                    'label' => esc_html__( 'Counter Backdrop Blur Filter, px', 'neuros_plugin' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 25,
                            'step' => 0.1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-widget-container' => 'backdrop-filter: blur( {{SIZE}}px ); -webkit-backdrop-filter: blur( {{SIZE}}px );',
                    ],
                ]            
            );
        }

        if ('counter' === $element->get_name() && 'section_number' === $section_id) {    		
            $element->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'pagination_border_color_gradient',
                    'fields_options' => [
                        'background' => [
                            'label' => esc_html__( 'Text Stroke Gradient', 'neuros_plugin' )
                        ]                    
                    ],
                    'types' => [ 'gradient' ],
                    'selector' => '{{WRAPPER}} .elementor-counter-number-wrapper',
                ]
            );

            $element->add_responsive_control(
                'number_padding',
                [
                    'label'         => esc_html__('Number Padding', 'neuros_plugin'),
                    'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%', 'custom'],
                    'selectors'     => [
                        '{{WRAPPER}} .elementor-counter-number-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );
        }

        if ( 'video' === $element->get_name() && 'section_image_overlay' === $section_id ) {
            $element->add_control(
                'show_color_overlay',
                [
                    'label'                 => esc_html__( 'Color Overlay', 'neuros_plugin' ),
                    'type'                  => \Elementor\Controls_Manager::SWITCHER,
                    'label_off'             => esc_html__( 'Hide', 'neuros_plugin' ),
                    'label_on'              => esc_html__( 'Show', 'neuros_plugin' ),
                    'frontend_available'    => true,
                    'condition'             => [
                        'show_image_overlay'    => 'yes'
                    ],
                    'separator'             => 'before'
                ]
            );

            $element->start_controls_tabs(
                'tabs_background_overlay',
                [
                    'condition' => [
                        'show_image_overlay'    => 'yes',
                        'show_color_overlay'    => 'yes'
                    ],
                ]
            );

                $element->start_controls_tab(
                    'tab_background_overlay_normal',
                    [
                        'label' => esc_html__( 'Normal', 'neuros_plugin' ),
                    ]
                );

                    $element->add_group_control(
                        \Elementor\Group_Control_Background::get_type(),
                        [
                            'name'      => 'background_overlay',
                            'selector'  => '{{WRAPPER}} .elementor-custom-embed-image-overlay:before',
                        ]
                    );

                    $element->add_control(
                        'background_overlay_opacity',
                        [
                            'label'     => esc_html__( 'Opacity', 'neuros_plugin' ),
                            'type'      => \Elementor\Controls_Manager::SLIDER,
                            'default'   => [
                                'size'      => .5,
                            ],
                            'range'     => [
                                'px'        => [
                                    'max'       => 1,
                                    'step'      => 0.01,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .elementor-custom-embed-image-overlay:before' => 'opacity: {{SIZE}};',
                            ],
                            'condition' => [
                                'background_overlay_background' => [ 'classic', 'gradient' ],
                            ],
                        ]
                    );

                    $element->add_group_control(
                        \Elementor\Group_Control_Css_Filter::get_type(),
                        [
                            'name'          => 'bg_css_filters',
                            'selector'      => '{{WRAPPER}} .elementor-custom-embed-image-overlay:before',
                            'conditions'    => [
                                'relation'      => 'or',
                                'terms'         => [
                                    [
                                        'name'      => 'background_overlay_image[url]',
                                        'operator'  => '!==',
                                        'value'     => '',
                                    ],
                                    [
                                        'name'      => 'background_overlay_color',
                                        'operator'  => '!==',
                                        'value'     => '',
                                    ],
                                ],
                            ],
                        ]
                    );

                    $element->add_control(
                        'overlay_blend_mode',
                        [
                            'label'         => esc_html__( 'Blend Mode', 'neuros_plugin' ),
                            'type'          => \Elementor\Controls_Manager::SELECT,
                            'options'       => [
                                ''              => esc_html__( 'Normal', 'neuros_plugin' ),
                                'multiply'      => 'Multiply',
                                'screen'        => 'Screen',
                                'overlay'       => 'Overlay',
                                'darken'        => 'Darken',
                                'lighten'       => 'Lighten',
                                'color-dodge'   => 'Color Dodge',
                                'saturation'    => 'Saturation',
                                'color'         => 'Color',
                                'luminosity'    => 'Luminosity',
                            ],
                            'selectors'     => [
                                '{{WRAPPER}} .elementor-custom-embed-image-overlay:before' => 'mix-blend-mode: {{VALUE}}',
                            ],
                            'conditions'    => [
                                'relation'      => 'or',
                                'terms'         => [
                                    [
                                        'name'      => 'background_overlay_image[url]',
                                        'operator'  => '!==',
                                        'value'     => '',
                                    ],
                                    [
                                        'name'      => 'background_overlay_color',
                                        'operator'  => '!==',
                                        'value'     => '',
                                    ],
                                ],
                            ],
                        ]
                    );

                $element->end_controls_tab();

                $element->start_controls_tab(
                    'tab_background_overlay_hover',
                    [
                        'label' => esc_html__( 'Hover', 'neuros_plugin' ),
                    ]
                );

                    $element->add_group_control(
                        \Elementor\Group_Control_Background::get_type(),
                        [
                            'name'      => 'background_overlay_hover',
                            'selector'  => '{{WRAPPER}}:hover .elementor-custom-embed-image-overlay:before',
                        ]
                    );

                    $element->add_control(
                        'background_overlay_hover_opacity',
                        [
                            'label'     => esc_html__( 'Opacity', 'neuros_plugin' ),
                            'type'      => \Elementor\Controls_Manager::SLIDER,
                            'default'   => [
                                'size'      => .5,
                            ],
                            'range'     => [
                                'px'        => [
                                    'max'       => 1,
                                    'step'      => 0.01,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}}:hover .elementor-custom-image-color-overlay:before' => 'opacity: {{SIZE}};',
                            ],
                            'condition' => [
                                'background_overlay_hover_background' => [ 'classic', 'gradient' ],
                            ],
                        ]
                    );

                    $element->add_group_control(
                        \Elementor\Group_Control_Css_Filter::get_type(),
                        [
                            'name'      => 'bg_css_filters_hover',
                            'selector'  => '{{WRAPPER}}:hover .elementor-custom-embed-image-overlay:before',
                        ]
                    );

                    $element->add_control(
                        'background_overlay_hover_transition',
                        [
                            'label'         => esc_html__( 'Transition Duration', 'neuros_plugin' ),
                            'type'          => \Elementor\Controls_Manager::SLIDER,
                            'default'       => [
                                'size'  => 0.3,
                            ],
                            'range'         => [
                                'px'    => [
                                    'max'       => 3,
                                    'step'      => 0.1,
                                ],
                            ],
                            'render_type'   => 'ui',
                            'separator'     => 'before',
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }
        if ( 'video' === $element->get_name() && 'section_video_style' === $section_id ) {
            $element->add_responsive_control(
                'video_width',
                [
                    'label'         => esc_html__('Video Max Width', 'neuros_plugin'),
                    'type'          => \Elementor\Controls_Manager::SLIDER,
                    'size_units'    => [ 'px', '%' ],
                    'range'         => [
                        'px'            => [
                            'min'           => 100,
                            'max'           => 1170,
                        ],
                        '%'             => [
                            'min'           => 1,
                            'max'           => 100,
                        ]
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .elementor-widget-container' => 'max-width: {{SIZE}}{{UNIT}};'
                    ]
                ]
            );

            $element->add_responsive_control(
                'video_alignment',
                [
                    'label'     => esc_html__('Video Position', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::CHOOSE,
                    'options'   => [
                        'left'      => [
                            'title'     => esc_html__('Left', 'neuros_plugin'),
                            'icon'      => 'eicon-text-align-left',
                        ],
                        'center'      => [
                            'title'     => esc_html__('Center', 'neuros_plugin'),
                            'icon'      => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title'     => esc_html__('Right', 'neuros_plugin'),
                            'icon'      => 'eicon-text-align-right',
                        ]
                    ],
                    'default'   => 'left',
                    'selectors_dictionary' => [
                        'left' => 'margin-right: auto; margin-left: 0;',
                        'center' => 'margin-right: auto; margin-left: auto;',
                        'right' => 'margin-left: auto; margin-right: 0;',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-widget-container' => '{{VALUE}}',
                    ],
                ]
            );
        }

        if ('image-carousel' === $element->get_name() && 'section_style_navigation' === $section_id) {

            $element->remove_control('arrows_size');
            $element->remove_control('arrows_color');
            $element->remove_control('heading_style_dots');
            $element->remove_control('dots_position');
            $element->remove_control('dots_size');
            $element->remove_control('dots_color');

            $element->start_controls_tabs(
                'slider_nav_settings_tabs',
                [
                    'condition' => [
                        'navigation' => [ 'arrows', 'both' ],
                    ]
                ]
            );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $element->start_controls_tab(
                'tab_arrows_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

            $element->add_control(
                'nav_color',
                [
                    'label'     => esc_html__('Slider Arrows Color', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button i' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'nav_bd',
                [
                    'label'     => esc_html__('Slider Arrows Border', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button i' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'nav_bg',
                [
                    'label'     => esc_html__('Slider Arrows Background', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button i' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'nav_box_shadow',
                    'label'     => esc_html__( 'Box Shadow', 'neuros_plugin' ),
                    'selector'  => '{{WRAPPER}} .swiper-container .elementor-swiper-button i',
                ]
            );

            $element->end_controls_tab();

            // ----------------------- //
            // ------ Hover Tab ------ //
            // ----------------------- //
            $element->start_controls_tab(
                'tab_arrows_hover',
                [
                    'label' => esc_html__('Hover', 'neuros_plugin')
                ]
            );

            $element->add_control(
                'nav_hover',
                [
                    'label'     => esc_html__('Slider Arrows Color', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button:hover i' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'nav_bd_hover',
                [
                    'label'     => esc_html__('Slider Arrows Border', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button:hover i' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'nav_bg_hover',
                [
                    'label'     => esc_html__('Slider Arrows Background', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-container .elementor-swiper-button:hover i' => 'background-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'nav_box_shadow_hover',
                    'label'     => esc_html__( 'Box Shadow', 'neuros_plugin' ),
                    'selector'  => '{{WRAPPER}} .swiper-container .elementor-swiper-button:hover i',
                ]
            );

            $element->end_controls_tab();

            $element->end_controls_tabs();


            $element->add_control(
                'heading_style_dots',
                [
                    'label'     => esc_html__( 'Dots', 'elementor' ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'navigation' => [ 'dots', 'both' ],
                    ],
                ]
            );


            $element->start_controls_tabs(
                'slider_dot_settings_tabs',
                [
                    'condition' => [
                        'navigation' => [ 'dots', 'both' ],
                    ]
                ]
            );

            // ------------------------ //
            // ------ Normal Tab ------ //
            // ------------------------ //
            $element->start_controls_tab(
                'pagination_normal',
                [
                    'label' => esc_html__('Normal', 'neuros_plugin')
                ]
            );

            $element->add_control(
                'dot_color',
                [
                    'label'     => esc_html__('Pagination Dot Color', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet:after' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'dot_border',
                [
                    'label'     => esc_html__('Pagination Dot Border', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->end_controls_tab();

            // ------------------------ //
            // ------ Active Tab ------ //
            // ------------------------ //
            $element->start_controls_tab(
                'pagination_active',
                [
                    'label' => esc_html__('Active', 'neuros_plugin')
                ]
            );

            $element->add_control(
                'dot_active',
                [
                    'label'     => esc_html__('Pagination Active Dot Color', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active:after' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->add_control(
                'dot_border_active',
                [
                    'label'     => esc_html__('Pagination Active Dot Border', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-color: {{VALUE}};'
                    ]
                ]
            );

            $element->end_controls_tab();

            $element->end_controls_tabs();
        }

        if ('image-carousel' === $element->get_name() && 'section_style_image' === $section_id) {
            $element->remove_control('image_spacing');
            $element->remove_control('image_spacing_custom');
            $element->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'image_shadow',
                    'selector'  => '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .swiper-slide-image',
                ]
            );

            $element->add_control(
                'image_spacing',
                [
                    'label'     => esc_html__( 'Spacing', 'neuros_plugin' ),
                    'type'      => \Elementor\Controls_Manager::SELECT,
                    'options'   => [
                        ''          => esc_html__( 'Default', 'neuros_plugin' ),
                        'custom'    => esc_html__( 'Custom', 'neuros_plugin' ),
                    ],
                    'default'   => '',
                    'condition' => [
                        'slides_to_show!' => '1',
                    ],
                ]
            );
            $element->add_control(
                'image_spacing_custom',
                [
                    'label'                 => esc_html__( 'Image Spacing', 'neuros_plugin' ),
                    'type'                  => \Elementor\Controls_Manager::SLIDER,
                    'range'                 => [
                        'px'                    => [
                            'max'                   => 100,
                        ],
                    ],
                    'default'               => [
                        'size'                  => 20,
                    ],
                    'show_label'            => false,
                    'condition'             => [
                        'image_spacing'         => 'custom',
                        'slides_to_show!'       => '1',
                    ],
                    'frontend_available'    => true,
                    'render_type'           => 'none',
                    'separator'             => 'after',
                    'selectors'             => [
                        '{{WRAPPER}} .elementor-image-carousel-wrapper' => 'margin: -{{SIZE}}px; padding: {{SIZE}}px !important;'
                    ],
                ]
            );

            $element->add_control(
                'icon_color',
                [
                    'label'     => esc_html__('Icon Color', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-slide a:after' => 'color: {{VALUE}};'
                    ],
                    'separator' => 'before',
                    'condition' => [
                        'link_to'   => ['file', 'custom']
                    ]
                ]
            );

            $element->add_control(
                'icon_bg_color',
                [
                    'label'     => esc_html__('Icon Background Color', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-slide a:after' => 'background-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'link_to'   => ['file', 'custom']
                    ]
                ]
            );

            $element->add_control(
                'overlay_color',
                [
                    'label'     => esc_html__('Image Overlay Color', 'neuros_plugin'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .swiper-slide a:before' => 'background-color: {{VALUE}};'
                    ],
                    'condition' => [
                        'link_to'       => ['file', 'custom'],
                        'view_style'    => 'style_2'
                    ]
                ]
            );


            $element->start_controls_tabs('frame_settings_tabs');

                // ------------------------ //
                // ------ Normal Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'frame_normal',
                    [
                        'label'     => esc_html__('Normal', 'neuros_plugin'),
                        'condition' => [
                            'link_to'    => ['file', 'custom'],
                            'view_style' => 'style_2'
                        ]
                    ]
                );

                    $element->add_control(
                        'frame_color',
                        [
                            'label'     => esc_html__('Frame Color', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .swiper-slide a:before' => 'border-color: {{VALUE}};'
                            ],
                            'condition' => [
                                'link_to'    => ['file', 'custom'],
                                'view_style' => 'style_2'
                            ]
                        ]
                    );

                $element->end_controls_tab();

                // ------------------------ //
                // ------ Active Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'frame_hover',
                    [
                        'label'     => esc_html__('Hover', 'neuros_plugin'),
                        'condition' => [
                            'link_to'    => ['file', 'custom'],
                            'view_style' => 'style_2'
                        ]
                    ]
                );

                    $element->add_control(
                        'frame_color_hover',
                        [
                            'label'     => esc_html__('Frame Color on Hover', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .swiper-slide a:hover:before' => 'border-color: {{VALUE}};'
                            ],
                            'condition' => [
                                'link_to'    => ['file', 'custom'],
                                'view_style' => 'style_2'
                            ]
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }        

        if ('accordion' === $element->get_name() && 'section_title_style' === $section_id) {
            $element->add_responsive_control(
                'space_between',
                [
                    'label'     => esc_html__( 'Space Between', 'neuros_plugin' ),
                    'type'      => \Elementor\Controls_Manager::SLIDER,
                    'range'     => [
                        'px'        => [
                            'min'       => 0,
                            'max'       => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-accordion-item:not(:last-of-type)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );
            $element->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'box_shadow',
                    'selector'  => '{{WRAPPER}} .elementor-accordion-item',
                ]
            );
        }

        if ('accordion' === $element->get_name() && 'section_toggle_style_title' === $section_id) {
            $element->remove_control('title_background');
            $element->remove_control('title_color');
            $element->remove_control('tab_active_color');

            $element->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'counter_typography',
                    'label' => esc_html__( 'Counter Typography', 'neuros_plugin' ),
                    'selector' => '{{WRAPPER}} .elementor-accordion .elementor-accordion-title:before',
                    'condition' => [
                        'accordion_style' => 'counter'
                    ]
                ]
            );

            $element->add_responsive_control(
                'counter_title_padding',
                [
                    'label' => esc_html__( 'Counter Title Padding', 'neuros_plugin' ),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-accordion .elementor-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'accordion_style' => 'counter'
                    ]
                ]
            );

            $element->start_controls_tabs('title_colors_tabs');

                // ------------------------ //
                // ------ Normal Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'title_colors_normal',
                    [
                        'label' => esc_html__('Normal', 'neuros_plugin')
                    ]
                );

                    $element->add_control(
                        'title_color',
                        [
                            'label'     => esc_html__('Title Color', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title:not(.elementor-active) .elementor-accordion-title' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'title_bg_color',
                        [
                            'label'     => esc_html__('Title Background Color', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title:not(.elementor-active)' => 'background-color: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

                // ------------------------ //
                // ------ Active Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'title_colors_active',
                    [
                        'label' => esc_html__('Active', 'neuros_plugin')
                    ]
                );

                    $element->add_control(
                        'active_title_color',
                        [
                            'label'     => esc_html__('Title Color', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title.elementor-active .elementor-accordion-title' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'active_title_bg_color',
                        [
                            'label'     => esc_html__('Title Background Color', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }

        if ('toggle' === $element->get_name() && 'section_toggle_style_title' === $section_id) {
            $element->remove_control('title_background');
            $element->remove_control('title_color');
            $element->remove_control('tab_active_color');

            $element->start_controls_tabs('title_colors_tabs');

                // ------------------------ //
                // ------ Normal Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'title_colors_normal',
                    [
                        'label' => esc_html__('Normal', 'neuros_plugin')
                    ]
                );

                    $element->add_control(
                        'title_color',
                        [
                            'label'     => esc_html__('Title Color', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title:not(.elementor-active) .elementor-toggle-title' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'title_bg_color',
                        [
                            'label'     => esc_html__('Title Background Color', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title:not(.elementor-active)' => 'background-color: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

                // ------------------------ //
                // ------ Active Tab ------ //
                // ------------------------ //
                $element->start_controls_tab(
                    'title_colors_active',
                    [
                        'label' => esc_html__('Active', 'neuros_plugin')
                    ]
                );

                    $element->add_control(
                        'active_title_color',
                        [
                            'label'     => esc_html__('Title Color', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title.elementor-active .elementor-toggle-title' => 'color: {{VALUE}};'
                            ]
                        ]
                    );

                    $element->add_control(
                        'active_title_bg_color',
                        [
                            'label'     => esc_html__('Title Background Color', 'neuros_plugin'),
                            'type'      => \Elementor\Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}};'
                            ]
                        ]
                    );

                $element->end_controls_tab();

            $element->end_controls_tabs();
        }

    }, 10, 3);

    add_action('elementor/frontend/section/before_render', function( \Elementor\Element_Base $element ) {
        $settings = $element->get_settings();
        if ( $settings['use_parallax'] == 'yes' ) {
            $element->add_render_attribute('_wrapper', [
                'data-parallax'    => 'scroll'
            ] );
        }
        if ( $settings['add_flowmap_animation'] == 'on' && !empty($settings['flowmap_image']['url']) ) {
        	wp_enqueue_script('flowmap-effect');
            $metadata = wp_get_attachment_metadata($settings['flowmap_image']['id']);
            $element->add_render_attribute('_wrapper', [
            	'data-flowmap'        => 'on',
            	'data-flowmap-url'    => esc_url($settings['flowmap_image']['url']),
                'data-flowmap-width'  => esc_attr($metadata['width']),
                'data-flowmap-height' => esc_attr($metadata['height'])
            ] );
        }
        if ( $settings['section_inner_scroll_animation'] == 'on' ) {
            wp_enqueue_script('aat');
        }
    } );

    add_filter('elementor/widget/render_content', function( $content, $widget ) {
        if ( 'image' === $widget->get_name() ) {
            wp_enqueue_script('elementor_widgets');
            $settings = $widget->get_settings();
            $out = '';
            if ( $settings['show_hover_text'] == 'yes' ) {
                $out .= '<div class="hovered-text">';
                    $out .= '<div class="hovered-text-card">';
                        $out .= !empty($settings['subtitle']) ? '<div class="hovered-text-subtitle-wrapper"><div class="hovered-text-subtitle">' . esc_html($settings['subtitle']) . '</div></div>' : '';
                        $out .= !empty($settings['title']) ? '<div class="hovered-text-title">' . esc_html($settings['title']) . '</div>' : '';
                    $out .= '</div>';
                $out .= '</div>';
            }
            if ( $settings['add_scroll_animation'] == 'on' ) {
                wp_enqueue_script('aat');
                wp_enqueue_script('elementor_widgets');                
            }
            $content .= wp_kses_post($out);
        }
        return $content;
    }, 10, 2);
}