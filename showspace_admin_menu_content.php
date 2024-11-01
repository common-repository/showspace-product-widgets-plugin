<div class="wrap">
  <h2>ShowSpace Settings</h2>

  <div id="showspace-sidebar">
    <h3>
      Welcome to ShowSpace!
    </h3>
    <p>
      ShowSpace lets you painlessly gather products from all over the web and display them on your blog!
    </p>
    <p>
      <em>
        NEW: Embed product widgets in your sidebar (available from version 1.4.0)!
      </em>
    </p>
    <p>
      <strong>
        To get your API key and use this plugin you have to
        <a href="<?php echo $showspace_web_url ?>/signup" target="_blank">sign up for a free account</a>
        on the ShowSpace website.
      </strong>
      <br>
      It only takes a second and you can start creating widgets immediately!
    </p>
    <p>
      Once you signed up, here is how to get your first widget up and running:
    </p>
    <ol>
      <li>
        <p>
          <strong>
            Create a widget
          </strong>
        </p>
        <p>
          Watch a quick <a href="<?php echo $showspace_web_url ?>/knowledge-base/basics/create-widget" target="_blank">video</a> on how it works.
        </p>
      </li>
      <li>
        <p>
          <strong>
            Add some products to your widget
          </strong>
        </p>
        <p>
          You can use products from Amazon, Ebay or any other merchant. This short
          <a href="<?php echo $showspace_web_url ?>/knowledge-base/basics/add-products" target="_blank">video</a> has the step-by-step instructions.
        </p>
      </li>
      <li>
        <p>
          <strong>
            Add the widget to your post or sidebar
          </strong>
        </p>
        <ul>
          <li>
            <p>
              <strong>
                To add a widget to a post:
              </strong>
            </p>
            <p>
              Simple: just add the widget tag to your post.
            </p>
            <p>
              It looks like this:
              <code>[ss-widget id=my_widget_identifier]</code>
            </p>
            <p>
              <strong>
                Important:
              </strong>
              You need to replace
              <code>my_widget_identifier</code>
              with the identifier of your widget.
              <br>
              You can find the tag for your widget by clicking on the "Installation" link in your
              <a href="<?php echo $showspace_admin_url ?>/widgets" target="_blank">widget list</a>.
            </p>
          </li>
          <li>
            <p>
              <strong>
                To add a widget to the sidebar:
              </strong>
            </p>
            <p>
              First go to
              <em>
                Appearance > Widgets
              </em>
              in your Wordpress admin area and drag a "ShowSpace Product Widget" to your sidebar.
              <br>
              Then enter the widget identifier, which you can find in your
              <a href="<?php echo $showspace_admin_url ?>/widgets" target="_blank">widget list</a>.
            </p>
          </li>
        </ul>
      </li>
      <li>
        <strong>
          Add your API key on this page
        </strong>
        <br>
        You can find your API key in the widget installation instructions or in the
        <a href="<?php echo $showspace_admin_url ?>/my-account" target="_blank">ShowSpace backend</a>.
      </li>
    </ol>
    <p>
      View the post and the plugin should have replaced the widget tag with your widget!
    </p>
    <p>
      If you run into any problems, check out the
      <a href="http://wordpress.org/extend/plugins/showspace-product-widgets-plugin/faq/" target="_blank">Plugin FAQ</a>
      , the
      <a href="<?php echo $showspace_web_url ?>/knowledge-base" target="_blank">ShowSpace Knowledge Base</a>
      or get in touch via
      <a href="mailto:hello@show-space.com">email</a>.
    </p>
  </div>

  <form method="post" action="options.php">
    <?php settings_fields('showspace_options') ?>
    <?php do_settings_sections('showspace') ?>
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>">
    </p>
  </form>
</div>
