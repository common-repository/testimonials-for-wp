=== Testimonials for WP ===
Contributors: Catapult_Themes
Donate Link: https://www.paypal.me/catapultthemes
Tags: testimonials, testimonials shortcode, featured testimonials
Requires at least: 4.7
Tested up to: 4.8
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Add testimonials to your site

== Description ==
This plugin creates a Testimonials post type. You can then display testimonials using a simple shortcode. There are three different types of testimonial style - cards, quotes and simple - and you can display the testimonials in a standard grid format or masonry format.

[See a demo here](https://testimonials.catapultthemes.com/)

When you create a testimonial, use the standard title field for the name of the person giving the testimonial and use the content field for the text. You can also add the testimonial giver's position and company and the date of the testimonial.

If you wish, you can specify whether a testimonial is 'featured' then choose only to display featured testimonials.

You have several options for displaying an image for the testimonial giver: either as the featured image, or through a URL, or simply insert the testimonial giver's email address to display their gravatar.

= How to display testimonials =
1. Set default options in Settings > Testimonials for WP
1. Add the `[testimonials_for_wp] shortcode to your page`
1. That's it

= Or =
You can set parameters in the shortcode, e.g.:
`[testimonials_for_wp columns=3 layout="grid" style="cards" ids="167,170" featured='true']`

Parameters include:
* columns - from 1 to 4
* layout - either 'grid' or 'masonry'
* style - either 'cards', 'quotes' or 'simple'
* ids - a comma separated list of testimonial IDs to display
* featured - specify 'true' if you only want to include featured testimonials

= Layout =

The 'grid' layout uses CSS grid and flexbox to display testimonials in equal columns at equal heights. Older browsers will fall back and display testimonials in a single column.

== Installation ==
1. Upload the `testimonials-for-wp` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add your widgets

== Frequently Asked Questions ==

== Screenshots ==

1. 

== Changelog ==

= 1.0.1, June 28 2017 =

* Added: media query breakpoints

= 1.0.0 =

* Initial commit

== Upgrade Notice ==

Nothing here
