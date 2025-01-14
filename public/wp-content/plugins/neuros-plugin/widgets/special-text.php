<?php
/*
 * Created by Artureanec
*/

if ( !class_exists('Neuros_Special_Text_Widget') ) {
    class Neuros_Special_Text_Widget extends WP_Widget {
        public function __construct() {
            parent::__construct(
                'Neuros_Special_Text_Widget',
                'Special Text (Neuros Theme)',
                array(
                    'description' => esc_html__('Special Text Widget by Neuros Theme', 'neuros_plugin')
                )
            );
        }

        public function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['text'] = wp_kses_post($new_instance['text']);
            return $instance;
        }

        public function widget($args, $instance) {

            echo $args['before_widget'];

            if ($instance['text'] !== '') {
                echo '
                    <div class="neuros-special-text-widget-text">
                        <p>
                            ' . wp_kses_post($instance['text']) . '
                        </p>
                    </div>
                ';
            }

            echo $args['after_widget'];
        }        

        public function form($instance) {
            $default_values = array(
                'text'      => '',
            );

            $instance = wp_parse_args((array)$instance, $default_values);
            ?>
                <div class="neuros_widget">
                    <p>
                        <label for="<?php echo esc_attr($this->get_field_id('text')); ?>">
                            <?php esc_html_e('Text', 'neuros_plugin'); ?>:
                        </label>
                        <textarea class="widefat"
                                  id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                                  name="<?php echo esc_attr($this->get_field_name('text')); ?>"
                        ><?php echo wp_kses_post($instance['text']); ?></textarea>
                    </p>
                </div>
            <?php
        }
    }
}
