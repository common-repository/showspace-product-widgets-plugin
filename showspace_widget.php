<?php

# Register widget
add_action('widgets_init', create_function('', 'register_widget("showspace_widget");'));

if (!class_exists('ShowSpace_Widget')) {
  class ShowSpace_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
      parent::__construct(
        'showspace_widget',
        'ShowSpace Product Widget',
        array('description' => __('Add a ShowSpace product widget to your sidebar', 'text_domain'))
      );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
      extract($args);
      $widget_identifier = apply_filters('widget_identifier', $instance['widget_identifier']);

      echo $before_widget;
      if (empty($widget_identifier)) {
  ?>
        <!--
          Error displaying ShowSpace widget '<?php echo $widget_identifier ?>':
          Widget identifier missing.
        -->
  <?php
      } else {
        echo load_showspace_widget_tag_content($widget_identifier);
      }
      echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
      $instance = $old_instance;
      $instance['widget_identifier'] = trim($new_instance['widget_identifier']);

      return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
      if ($instance) {
        $widget_identifier = esc_attr($instance['widget_identifier']);
      } else {
        $widget_identifier = '';
      }
  ?>
      <p>
        <label for="<?php echo $this->get_field_id('widget_identifier') ?>">
          <?php _e('Widget Identifier:') ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id('widget_identifier') ?>" name="<?php echo $this->get_field_name('widget_identifier') ?>" type="text" value="<?php echo $widget_identifier ?>">
      </p>
  <?php
    }
  }
}

?>
