<?php

# Add admin menu
add_action('admin_init', 'register_showspace_admin_settings');
function register_showspace_admin_settings() {
  register_setting(
    'showspace_options',
    'showspace_options',
    'showspace_options_validate'
  );

  add_settings_section(
    'showspace_settings_section',
    '',
    'showspace_settings_section',
    'showspace'
  );

  add_settings_field(
    'showspace_api_key_field',
    'API Key',
    'showspace_api_key_field',
    'showspace',
    'showspace_settings_section'
  );

  add_settings_field(
    'showspace_terms_accepted_field',
    'Terms & Conditions',
    'showspace_terms_accepted_field',
    'showspace',
    'showspace_settings_section'
  );
}

function showspace_options_validate($options) {
  $options['showspace_api_key'] = trim($options['showspace_api_key']);

  return $options;
}

function showspace_settings_section() {}

function showspace_api_key_field() {
?>
  <input id="showspace_api_key" name="showspace_options[showspace_api_key]" size="40" type="text" value="<?php echo showspace_api_key() ?>">
<?php
}

function showspace_terms_accepted_field() {
  global $showspace_web_url;
?>
  <label for="showspace_terms_accepted">
    <input id="showspace_terms_accepted" name="showspace_options[showspace_terms_accepted]" type="checkbox" value="1"<?php if (showspace_terms_accepted()) echo ' checked="checked"' ?>>
    I agree to the
    <a href="<?php echo $showspace_web_url ?>/terms" target="_blank">ShowSpace terms & conditions</a>.
  </label>
<?php
}

add_action('admin_menu', 'add_showspace_admin_menu');
function add_showspace_admin_menu() {
  $page = add_options_page(
    'ShowSpace Options',
    'ShowSpace',
    'manage_options',
    'showspace-settings',
    'showspace_admin_menu_content'
  );

  # Load stylesheet only on ShowSpace settings page
  add_action("admin_print_styles-$page", 'enqueue_showspace_admin_styles');
}

function enqueue_showspace_admin_styles() {
  wp_enqueue_style('showspace_admin_styles', plugins_url('showspace_admin.css', __FILE__));
}

function showspace_admin_menu_content() {
  global $showspace_web_url, $showspace_admin_url;

  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  }

  include('showspace_admin_menu_content.php');
}

?>
