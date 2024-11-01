=== ShowSpace Product Widgets ===
Contributors: showspace
Tags: showspace, products, affiliate, affiliate widgets, affiliate plugins, affiliate marketing, product widgets, product comparison, price comparison, monetize, skimlinks, viglink
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: trunk

ShowSpace lets you painlessly gather products from all over the web and display them on your blog!

== Description ==

**ShowSpace lets you painlessly gather products from all over the web and display them on your blog!**

*NEW: Embed product widgets in your sidebar (available from version 1.4.0)!*

*NEW: Widgets are cached in Wordpress which speeds up displaying them and makes them display even if the ShowSpace website is down or not available (available from version 2.1.0)!*

While Wordpress is a great CMS and blogging engine, it's not good at:

* **Making list posts**, e.g. "Top 100 Sci-fi Movie DVDs", or displaying curated product collections like **Pinterest** or **List.ly**. Using ShowSpace it's really easy to create "Top 100" posts really quickly! (and not having Wordpress screw with your formatting)

* **Making price comparison tables.** With ShowSpace you can easily collect services and products and display them in an attractive table in you blog post!

* **Monetizing your content by displaying affiliate products.** All your ShowSpace widgets can contain affiliate products. We even integrate with **SkimLinks** and **VigLink** automatically if you want us to, so there is no reason for you to ever create another deeplink by hand.

* **Showing related products or services with each post.** You don't want to manually enter lists of related products and services in the WYSIWYG editor each time you write a blog post. That's duplicated effort and when one is out of date, they all are. Use ShowSpace to build your own database of products and show each product in as many widgets as you like! Adding them is just a couple of clicks and when you update the product, it automatically updates in all widgets! So if you want a **Batman t-shirt** to appear at the end of a post about t-shirts and a post about superheroes as well, it's trivially simple! **Price updates for the t-shirt?** No problem, update it at ShowSpace and it updates in every widget, in every post.

= See examples of widgets in the wild here: =

* http://journal.hipstery.com/2012/02/10-signs-youve-become-a-berlin-hipster/
* http://www.tee-junction.com/2012/mighty-boosh-tshirts/
* http://fashionstyleadvice.com/how-to-dress-like-aria-montgomery/

== Installation ==

= Install the plugin directly from Wordpress or manually =

**Manual installation:** Extract the zip file and copy the extracted folder into the `wp-content/plugins/` directory of your WordPress installation.

= Activate plugin =

Activate the plugin from the plugins page.

= Add API key =

Open the ShowSpace settings page (Settings > ShowSpace) and enter your API key. You can look up your API key in your settings in the [ShowSpace backend](http://admin.show-space.com/login).

= Add widgets to your posts or sidebar =

To add a widget, you have to create it first in the [ShowSpace backend](http://admin.show-space.com/login). Watch a quick video on how it works [here](http://www.show-space.com/knowledge-base/basics/create-widget).

**To add a widget to a post:**

* Edit the post that you want to show a widget in.
* Add the widget code where you want it to appear:  
  `[ss-widget id=my_widget]`  
  **Note:**
  You have to replace `my_widget` with the widget identifier which you find in your widget list in the [ShowSpace backend](http://admin.show-space.com/login).

**To add a widget to the sidebar:**

* Go to Appearance > Widgets in your Wordpress admin area.
* Drag a "ShowSpace Product Widget" to your sidebar.
* Enter the widget identifier, which you can find in your widget list in the [ShowSpace backend](http://admin.show-space.com/login).

The plugin will do the rest and replace the tag or sidebar widget with the actual product widget. All widget configuration and styling is then done in the [ShowSpace backend](http://admin.show-space.com/login).

== Frequently Asked Questions ==

= I installed and configured everything and added a widget tag to a post, but nothing is displayed in the front-end. =

In case there is an error (wrong API key, wrong widget identifier, etc.) the plugin will replace the widget tag with a HTML comment containing an error message.
So if neither your widget nor the widget tag shows up, please open the HTML source of the page and look for `Error displaying ShowSpace widget`. Below that phrase there will be the error message.

= I can't find the "ShowSpace Product Widget" to add my widget to the sidebar. =

Make sure the version of your ShowSpace plugin is 1.4.0 or higher. Sidebar widgets are not supported in lower versions.

= What happens if the ShowSpace website is down? Will my widgets still appear? =

Yes! Widgets are cached in your Wordpress installation. If the ShowSpace website is temporarily down, the cached version will be displayed, so the user doesn't notice anything. Notice that you'll need plugin version 2.0.0 or higher for this.

== Screenshots ==

1. A widget displaying "Hipster tote bags" - from http://journal.hipstery.com/2012/02/10-signs-youve-become-a-berlin-hipster/
2. A widget showing "Assorted Hipster nonsense" in the context of the page - from http://journal.hipstery.com/2012/02/10-signs-youve-become-a-berlin-hipster/
3. A vertical widget displaying t-shirts - from http://www.tee-junction.com/2012/mighty-boosh-tshirts/
4. A horizontal widget displaying fashion accessories - from http://fashionstyleadvice.com/how-to-dress-like-aria-montgomery/

== Changelog ==

= 2.2.2 =

* Fix requiring files to avoid "Fatal error: Cannot redeclare class..."

= 2.2.1 =

* Fixes in how user agent is determined

= 2.2.0 =

* Split up code in several files, refactor
* Indicate if user is a bot when requesting widget so that bots can be excluded from the stats

= 2.1.1 =

* Fixed widget rendering, render returned error message if present

= 2.1.0 =

* Fixed caching header

= 2.0.0 =

* Added caching - widgets are now cached in Wordpress which makes displaying them much faster. Also, all widgets are still displayed even if the ShowSpace website is down or doesn't respond.

= 1.6.0 =

* Speed up rendering by not enqueuing Javascript and Stylesheet files via Wordpress but letting the widget load it by itself.

= 1.5.0 =

* Major rewrite
* Improve validations and error messages
* Improve instructions on settings page
* Add field to accept T&C
* Remove tags from readme.txt

= 1.4.0 =

* Add custom ShowSpace sidebar widget

= 1.3.0 =

* Update instructions in settings page
* Improve performance
* Optimize code

= 1.2.1 =

* Fix callback URL and parameters

= 1.2.0 =

* Improved widget fetching by replacing old method (file_get_contents) with more up-to-date and robust method (wp_remote_get)
* Refactored code, wording
* Styled instructions in settings page

= 1.1.0 =

* Added detailed instructions in admin settings page how to sign up and create a widget
* Added more text to readme.txt

= 1.0.1 =

* Fixed typo in code
* Added screenshots

= 1.0.0 =

* Initial version
