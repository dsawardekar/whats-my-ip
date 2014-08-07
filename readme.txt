=== whats-my-ip ===
Contributors: dsawardekar
Donate link: http://pressing-matters.io/
Tags: ip, geoip
Requires at least: 3.5.0
Tested up to: 3.9.2
Stable tag: 0.5.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display the current User's IP address in Widgets & Shortcodes.

== Description ==

This plugin adds an `[whatsmyip]` shortcode tag to WordPress. You can use it
to embed the current User's IP address inline in a Post.

The shortcode takes 3 attributes, `ip`, `country` and `coords`. Each of
these can take boolean values like 1, yes, no, true. Truthy values
enable the display of the corresponding field.

For Eg:- To display `ip` and `country` details use,

        [whatsmyip ip='yes' country='yes']

The `ip` attributes defaults to true if absent. Rest of the attributes
are false by default.

A Widget is also provided for use inside sidebars. Use the checkboxes in
the Widget customization screen to change the displayed fields.

== Installation ==

1. Upload the `whatsmyip` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use `[whatsmyip]` shortcode in your posts or pages.
1. Or the What's my IP Widget.

== Frequently Asked Questions ==

= How is the IP Address Calculated? =

The IP address and other GeoIP data is obtained from the JSON API
provided by [Telize](http://www.telize.com).

== Upgrade Notice ==

* Initial Release

== Changelog ==

= 0.5.2 =

* Upgrades to Arrow 1.8.0.

= 0.5.1 =

* Smaller build, without development files.

= 0.5.0 =

* Upgrades to Arrow 1.6.0.

= 0.4.0 =

* Upgrades to Arrow 0.7.0

= 0.3.0 =

* Upgrades to Arrow 0.5.1.

= 0.2.2 =

* Fixes Typos.

= 0.2.1 =

* Upgrades to arrow 0.4.1.

= 0.2.0

* Switched to arrow 0.4.0.

= 0.1.8 =

* Updates encase-php to 0.1.3

= 0.1.7 =

* Fixed version sync issue.

= 0.1.6 =

* Adds SVN branches to script.

= 0.1.5 =

* Updates Composer
* Publish Script for Git to SVN sync.

= 0.1.0 =
* Initial Release
