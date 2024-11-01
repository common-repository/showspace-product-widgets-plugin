<?php

/*

    Plugin Name: ShowSpace Product Widgets
    Plugin URI: http://www.show-space.com/knowledge-base/basics/install-widget#wordpress
    Description: ShowSpace lets you painlessly gather products from all over the web and display them on your blog!
    Version: 2.2.2
    Author: showspace
    Author URI: http://www.show-space.com
    License:

      Copyright 2012  ShowSpace  (email: hello@show-space.com)

      This program is free software; you can redistribute it and/or modify
      it under the terms of the GNU General Public License, version 2, as
      published by the Free Software Foundation.

      This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
      GNU General Public License for more details.

      You should have received a copy of the GNU General Public License
      along with this program; if not, write to the Free Software
      Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

global $showspace_host, $showspace_web_url, $showspace_admin_url, $showspace_db_version;

$showspace_host       = 'show-space.com';
$showspace_web_url    = "http://www.$showspace_host";
$showspace_admin_url  = "http://admin.$showspace_host";
$showspace_db_version = '1.0';

require_once 'showspace_widget.php';
require_once 'showspace_admin_menu.php';

# User Agent parser
require_once 'UASparser.php';
$ua_parser = null;
$ua_info   = null;

function showspace_table_name() {
  global $wpdb;

  return $wpdb->prefix.'showspace_widgets';
}

# Create table on plugin activation
register_activation_hook(__FILE__, 'showspace_create_table');
function showspace_create_table() {
  global $wpdb, $showspace_db_version;

  if (get_option('showspace_db_version') !== $showspace_db_version) {
    $table_name = showspace_table_name();

    $sql = "
      CREATE TABLE $table_name (
        identifier   VARCHAR(255)  NOT NULL,
        updated_at   DATETIME      NOT NULL,
        rendered_at  DATETIME      NOT NULL,
        content      LONGTEXT      NOT NULL,
        PRIMARY KEY  (identifier)
      );
    ";

    require_once ABSPATH.'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    update_option('showspace_db_version', $showspace_db_version);
  }
}

# Check if the table has to be updated
add_action('plugins_loaded', 'showspace_update_table_check');
function showspace_update_table_check() {
  global $showspace_db_version;

  if (get_option('showspace_db_version') !== $showspace_db_version) {
    showspace_create_table();
  }
}

function get_widget_data_from_db($widget_identifier) {
  global $wpdb;

  $table_name = showspace_table_name();
  $sql = "SELECT * FROM $table_name WHERE identifier='$widget_identifier'";

  return $wpdb->get_row($sql);
}

function save_widget_data_to_db($identifier, $updated_at, $content) {
  global $wpdb;

  $table_name = showspace_table_name();
  $exists = $wpdb->get_var("SELECT identifier FROM $table_name WHERE identifier='$identifier' LIMIT 1;");
  $updated_at_formatted = date('Y-m-d H:i:s', strtotime($updated_at));

  if (empty($exists)) {
    $wpdb->insert(
      showspace_table_name(),
      array(
        'identifier' => $identifier,
        'updated_at' => $updated_at_formatted,
        'content'    => $content
      )
    );
  } else {
    $wpdb->update(
      showspace_table_name(),
      array(
        'updated_at' => $updated_at_formatted,
        'content'    => $content
      ),
      array(
        'identifier' => $identifier
      )
    );
  }
}

function save_rendered_at($identifier) {
  global $wpdb;

  $table_name = showspace_table_name();
  $rendered_at_formatted = date('Y-m-d H:i:s');

  $wpdb->update(
    showspace_table_name(),
    array(
      'rendered_at' => $rendered_at_formatted
    ),
    array(
      'identifier' => $identifier
    )
  );
}

# Show a message when the plugin has been activated but the API key has not been filled in.
add_action('admin_notices', 'show_api_key_missing_notice');
function show_api_key_missing_notice() {
  if (!showspace_settings_complete()) {
?>
    <div id="message" class="error">
      <p>
        Some
        <a href="<?php echo admin_url('options-general.php?page=showspace-settings') ?>">settings</a>
        are missing for the ShowSpace Product Widgets plugin to function.
      </p>
    </div>
<?php
  }
}

# Helper function to determine if all necessary settings are set
function showspace_settings_complete() {
  return showspace_api_key() != "" && showspace_terms_accepted();
}

# Helper function to get the api_key value
function showspace_api_key() {
  $options = get_option('showspace_options');
  return $options['showspace_api_key'];
}

# Helper function to get the terms_accepted value
function showspace_terms_accepted() {
  $options = get_option('showspace_options');
  return array_key_exists('showspace_terms_accepted', $options);
}

# Helper function to determine the current URL
function current_url() {
  $page_url = 'http';
  if (@$_SERVER['HTTPS'] == 'on') {
    $page_url .= 's';
  }
  $page_url .= '://'.$_SERVER['SERVER_NAME'];
  if ($_SERVER['SERVER_PORT'] != '80') {
    $page_url .= ':'.$_SERVER['SERVER_PORT'];
  }
  $page_url .= $_SERVER['REQUEST_URI'];
  return $page_url;
}

# Helper function to determine the current request user agent type
function ua_type() {
  global $ua_parser, $ua_info;

  if (is_null($ua_info)) {
    $ua_parser = new UASparser();
    $ua_parser->SetCacheDir(dirname(__FILE__).'/cache');
    $ua_info = $ua_parser->Parse();
  }

  return $ua_info['typ'];
}

# Load widgets
add_filter('the_content', 'replace_showspace_widget_tags');
function replace_showspace_widget_tags($content) {
  $regex = '
    /
      \[            # Open brackets
        \s*         # Whitespace
        ss-widget   # "ss-widget"
        \s+         # Whitespace
        id          # "id"
        \s*         # Whitespace
        =           # Equal sign
        \s*         # Whitespace
        (\S+)       # Widget identifier
        \s*         # Whitespace
      \]            # Close brackets
    /ix
  ';

  return preg_replace_callback(
    $regex,
    create_function('$matches', 'return load_showspace_widget_tag_content($matches[1]);'),
    $content
  );
}

function load_showspace_widget_tag_content($widget_identifier) {
  global $showspace_web_url;

  $output = "\n<!-- Trying to render ShowSpace widget '$widget_identifier' -->\n";

  if (!showspace_settings_complete()) {
    $output .= '<!--
      Some settings are missing for the ShowSpace Product Widgets plugin to function.
      Please check the ShowSpace settings under Settings > ShowSpace in your Wordpress admin area.
    -->';
  } else {
    $widget_data = get_widget_data_from_db($widget_identifier);

    if (empty($widget_data) || empty($widget_data->content)) {
      $request_args = null;
    } else {
      $request_args = array(
        'headers' => array(
          'If-Modified-Since' => date('r', strtotime($widget_data->updated_at))
        )
      );
    }

    $source = current_url();
    $ua_type = ua_type();
    $api_key = showspace_api_key();
    $url = "$showspace_web_url/widgets/$widget_identifier?api_key=$api_key&ua_type=$ua_type&source=$source";
    $response = wp_remote_get($url, $request_args);

    if (is_wp_error($response)) {
      $wp_error = $response->get_error_message();
      $output .= "<!-- WP Error: $wp_error -->";
    } else {
      $response_code = $response['response']['code'];
      $last_modified = isset($response['headers']['last-modified']) ? $response['headers']['last-modified'] : null;

      switch ($response_code) {
        case 200:
          # Widget modified or not cached yet, render from response
          $output .= "<!-- Server response code 200, widget rendered from response. -->\n";
          $output .= $response['body'];
          save_rendered_at($widget_identifier);
          save_widget_data_to_db($widget_identifier, $last_modified, $response['body']);
          break;
        case 304:
          # Widget not modified, try to render from cache
          if (!empty($widget_data) && !empty($widget_data->content)) {
            $output .= "<!-- Server response code 304, widget rendered from cache. -->\n";
            $output .= $widget_data->content;
            save_rendered_at($widget_identifier);
          } else {
            $output .= '<!-- Server response code 304 but widget is not cached. -->';
          }
          break;
        case 400:
          # Widget cannot be displayed, error message in response
          $output .= "<!-- Server response code 400, see error message below. -->\n";
          $output .= $response['body'];
          break;
        default:
          # Unexpected response code
          $output .= "<!-- Unexpected server response code $response_code. -->";
      }
    }
  }

  return $output;
}

# Redirect to ShowSpace settings page after activation
register_activation_hook(__FILE__, 'showspace_activate');
function showspace_activate() {
  global $showspace_web_url;

  # Set option to showspace_redirect_after_activation knows whether to redirect or not
  add_option('showspace_do_redirect_after_activation', true);
}

# Redirect to ShowSpace settings page
add_action('admin_init', 'showspace_redirect_after_activation');
function showspace_redirect_after_activation() {
  # Check if showspace_do_redirect_after_activation option has been set
  if (get_option('showspace_do_redirect_after_activation', false)) {
    delete_option('showspace_do_redirect_after_activation');
    wp_redirect(admin_url('options-general.php?page=showspace-settings'));
  }
}

# Helper function for debugging
function d($var, $var_name = null) {
?>
  <pre style="word-wrap: break-word; white-space: pre; font-size: 11px;">
<?php
  if (isset($var_name)) {
    echo "<strong>$var_name</strong>\n";
  }
  if (is_null($var) || is_string($var) || is_int($var) || is_bool($var) || is_float($var)) {
    var_dump($var);
  } else {
    print_r($var);
  }
?>
  </pre><br>
<?php
}

?>
