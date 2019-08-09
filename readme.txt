=== Display Terms Shortcode ===
Contributors: seothemes
Tags: terms, shortcode, categories, tags, list
Donate link: https://seothemes.com/
Requires at least: 4.9.1
Tested up to: 5.2.2
Stable tag: trunk
License: GPL-3.0-or-later
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Display a listing of terms using the [display-terms] shortcode

== Description ==

The Display Terms Shortcode was written to allow users to easily display listings of terms without knowing PHP or editing template files.

Add the shortcode in a post, page or widget and use the arguments to query based on tag, category, post type, and many other possibilities. You can also customize the output with parameters like: include, child_of, and show_image.

To use the shortcode, simply place the `[display-terms]` shortcode in any post, page or widget and change the parameters to your liking.

= Available parameters (and defaults): =

* taxonomy               => 'category'
* orderby                => 'name'
* order                  => 'ASC'
* hide_empty             => true
* include                => 'all'
* exclude                => 'all'
* exclude_tree           => 'all'
* number                 => false
* offset                 => ''
* fields                 => 'all'
* name                   => ''
* slug                   => ''
* hierarchical           => true
* search                 => ''
* name__like             => ''
* description__like      => ''
* pad_counts             => false
* get                    => ''
* child_of               => false
* childless              => false
* cache_domain           => 'core'
* update_term_meta_cache => true
* meta_query             => ''
* meta_key               => array()
* meta_value             => ''
* show_link              => true
* show_name              => true
* show_description       => false
* show_count             => false
* show_image             => true
* image_size             => 'full'
* post_type              => 'post',
* post_include           => [],
* post_exclude           => [],
* post_order             => 'DESC',
* post_orderby           => 'modified',
* number_to_search       => 10,
* parent_element         => 'ul',
* child_element          => 'li',
* parent_class           => 'terms-list',
* child_class            => 'terms-list-item',

= Featured images = 

If the `show_image` parameter is set to `true`, the shortcode will look for the featured image of the latest post in the term. You can change the size of the featured image with the `image_size` attribute.

== Installation ==
Automatic Plugin Installation

1. Go to Plugins > Add New.
2. Type in the name of the WordPress Plugin or descriptive keyword, author, or tag in Search Plugins box or click a tag link below the screen.
3. Find the WordPress Plugin you wish to install.
4. Click Details for more information about the Plugin and instructions you may wish to print or save to help setup the Plugin.
5. Click Install Now to install the WordPress Plugin.
6. The resulting installation screen will list the installation as successful or note any problems during the install.
7. If successful, click Activate Plugin to activate it, or Return to Plugin Installer for further actions.

Manual Plugin Installation

1. Download your WordPress Plugin to your desktop.
2. If downloaded as a zip archive, extract the Plugin folder to your desktop.
3. Read through the \\\"readme\\\" file thoroughly to ensure you follow the installation instructions.
4. With your FTP program, upload the Plugin folder to the wp-content/plugins folder in your WordPress directory online.
5. Go to Plugins screen and find the newly uploaded Plugin in the list.
6. Click Activate to activate it.

== Changelog ==

= 2019/08/09 - 1.0.1 =
* Add ability to choose post type to retrieve image from.
* Add other get_posts parameters.

= 2019/08/09 - 1.0.0 =
* Plugin overhaul.
* Added more parameters and filters.
* Removed heavy function.

= 2017/08/09 - 0.1.1 =
* Plugin clean up.

= 2017/08/08 - 0.1.0 =
* Initial release.
