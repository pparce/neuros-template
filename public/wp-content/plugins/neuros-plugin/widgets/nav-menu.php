<?php
/*
 * Created by Artureanec
*/

if ( !class_exists('Neuros_Nav_Menu_Widget') ) {
    class Neuros_Nav_Menu_Widget extends WP_Widget {
        public function __construct() {
            parent::__construct(
                'Neuros_Nav_Menu_Widget',
                'Navigation Menu (Neuros Theme)',
                array(
                    'description' => esc_html__('Navigation Menu Widget by Neuros Theme', 'neuros_plugin')
                )
            );
        }

        public function widget($args, $instance) {
            $nav_menu = !empty($instance['nav_menu']) ? wp_get_nav_menu_object($instance['nav_menu']) : false;
            if (!$nav_menu) {
                return;
            }
            $default_title = esc_html__('Menu', 'neuros_plugin');
            $title = !empty($instance['title']) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            $columns = !empty($instance['columns']) ? $instance['columns'] : '';

            $additional_class = !empty($columns) ? ' columns-' . esc_attr($columns) : '';

            echo $args['before_widget'];

            if ($title) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            $format = current_theme_supports('html5', 'navigation-widgets') ? 'html5' : 'xhtml';
            $format = apply_filters('navigation_widgets_format', $format);

            if ('html5' === $format) {
                $title = trim(strip_tags($title));
                $aria_label = $title ? $title : $default_title;
                $nav_menu_args = array(
                    'fallback_cb'           => '',
                    'menu'                  => $nav_menu,
                    'container'             => 'nav',
                    'container_aria_label'  => $aria_label,
                    'items_wrap'            => '<ul id="%1$s" class="%2$s' . esc_attr($additional_class) . '">%3$s</ul>'
                );
            } else {
                $nav_menu_args = array(
                    'fallback_cb'   => '',
                    'menu'          => $nav_menu,
                    'items_wrap'    => '<ul id="%1$s" class="%2$s' . esc_attr($additional_class) . '">%3$s</ul>'
                );
            }

            wp_nav_menu(apply_filters('widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance));

            echo $args['after_widget'];
        }

        public function update($new_instance, $old_instance) {
            $instance = array();
            if (!empty($new_instance['title'])) {
                $instance['title'] = sanitize_text_field($new_instance['title']);
            }
            if (!empty($new_instance['nav_menu'])) {
                $instance['nav_menu'] = (int)$new_instance['nav_menu'];
            }
            if (!empty($new_instance['columns'])) {
                $instance['columns'] = (int)$new_instance['columns'];
            }
            return $instance;
        }

        public function form($instance) {
            global $wp_customize;
            $title = isset($instance['title']) ? $instance['title'] : '';
            $nav_menu = isset($instance['nav_menu']) ? $instance['nav_menu'] : '';
            $columns = isset($instance['columns']) ? $instance['columns'] : '';
            $menus = wp_get_nav_menus();

            $empty_menus_style = '';
            $not_empty_menus_style = '';
            if (empty($menus)) {
                $empty_menus_style = ' style="display:none" ';
            } else {
                $not_empty_menus_style = ' style="display:none" ';
            }

            $nav_menu_style = '';
            if (!$nav_menu) {
                $nav_menu_style = 'display: none;';
            }
            ?>
            <div class="widget-content">
                <div class="neuros_widget">
                    <p class="nav-menu-widget-no-menus-message" <?php echo $not_empty_menus_style; ?>>
                        <?php
                        if ($wp_customize instanceof WP_Customize_Manager) {
                            $url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
                        } else {
                            $url = admin_url('nav-menus.php');
                        }
                        printf(wp_kses_post(__('No menus have been created yet. <a href="%s">Create some</a>.', 'neuros_plugin')), esc_attr($url));
                        ?>
                    </p>
                    <div class="nav-menu-widget-form-controls" <?php echo $empty_menus_style; ?>>
                        <p>
                            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'neuros_plugin'); ?></label>
                            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                                   name="<?php echo $this->get_field_name('title'); ?>"
                                   value="<?php echo esc_attr($title); ?>"/>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:', 'neuros_plugin'); ?></label>
                            <select id="<?php echo $this->get_field_id('nav_menu'); ?>"
                                    name="<?php echo $this->get_field_name('nav_menu'); ?>">
                                <option value="0"><?php _e('&mdash; Select &mdash;', 'neuros_plugin'); ?></option>
                                <?php foreach ($menus as $menu) : ?>
                                    <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($nav_menu, $menu->term_id); ?>>
                                        <?php echo esc_html($menu->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of columns:', 'neuros_plugin'); ?></label>
                            <select id="<?php echo $this->get_field_id('columns'); ?>"
                                    name="<?php echo $this->get_field_name('columns'); ?>">
                                <option value="1" <?php selected($columns, 1); ?>><?php _e('One', 'neuros_plugin'); ?></option>
                                <option value="2" <?php selected($columns, 2); ?>><?php _e('Two', 'neuros_plugin'); ?></option>
                                <option value="3" <?php selected($columns, 3); ?>><?php _e('Three', 'neuros_plugin'); ?></option>
                            </select>
                        </p>
                        <?php if ($wp_customize instanceof WP_Customize_Manager) : ?>
                            <p class="edit-selected-nav-menu" style="<?php echo $nav_menu_style; ?>">
                                <button type="button" class="button"><?php _e('Edit Menu', 'neuros_plugin'); ?></button>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
