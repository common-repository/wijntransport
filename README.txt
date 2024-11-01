=== Wijntransport  ===
Contributors: mdsilviu
Tags: wijntransport, wine, wines, wine listing
Requires at least: 4.9
Tested up to: 5.7
Stable tag: 1.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Host a catalog of wijntransport.com products on your own website.

== Description ==

Wijntransport wordpress plugin will allow you to display the list of products you acquired from wijntransport.com on your wordpress website.
The users will be able to filter the list displayed choosing to show the products he purchased in the past months or all the available wines from Wijntransport.
Also the user will have the ability to block individual products from showing in the listing on their wordpress website

This plugin will:
1. Retrieve products from wijntransport.com
2. Display a list of products on your website
3. Display the details of a single product on your website

== Installation ==

This section describes how to install the plugin and get it working.

1. Login into the admin area of your website
2. Go to "Plugins" -> "Add New"
3. Click "Upload Plugin" link at the top of the page
4. Click "Browse" and navigate to the plugin's zip file and choose that file.
5. Click "Install Now" button
6. Wait while plugin is uploaded to your server
7. Click "Activate Plugin" button

After the installation

1. In the admin area of wordpress go to "Wijntransport" -> "Settings" -> add your valid api key in the "Api key" field and press "Save settings"
2. In the admin area of wordpress go to "Settings" -> "Permalinks" and press "Save changes" (you don't have to modify anything here just save the changes to activate single wine display page)
3. In the admin area of wordpress create a new page with the page themplate "[Wijntransport] Wine listing". Go to 'Pages' -> "Add new Page" -> add a page title -> in the "Page attributes" area in the right side under "Template" select "[Wijntransport] Wine listing" and after that press "Publish". If you have a valid api key the wine listing will be displayed on this page.


== Frequently Asked Questions ==

= What Do I Need To Use The Plugin =

1. You need an account on Wijntransport (https://wijntransport.com/)
2. You will need an api key from Wijntransport

= How To Set up the plugin to display the wines on my website =

1. Install the plugin
2. In the admin area of wordpress go to "Wijntransport" -> "Settings" -> add your valid api key in the "Api key" field and press "Save settings"
3. In the admin area of wordpress go to "Settings" -> "Permalinks" and press "Save changes" (you don't have to modify anything here just save the changes to activate single wine display page)
4. In the admin area of wordpress create a new page with the page themplate "[Wijntransport] Wine listing". Go to 'Pages' -> "Add new Page" -> add a page title -> in the "Page attributes" area in the right side under "Template" select "[Wijntransport] Wine listing" and after that press "Publish". If you have a valid api key the wine listing will be displayed on this page.


== Screenshots ==

1. Plugin Options
1. Plugin Block options
2. Wine listing page
3. Wine single page


== Changelog ==
= 1.4.1 =
Release Date: April 12, 2021

* Update api url

= 1.4.0 =
Release Date: December 15, 2020

* Generate sitemap with wines for yoast seo

= 1.3.0 =
Release Date: October 15, 2020

* Add vintage to single wine
* Add seo head links: canonical, prev, next

= 1.2.0 =
Release Date: September 17, 2020

* Update translation
* Update styles

= 1.1.0 =
Release Date: September 16, 2020

* Update placeholder image
* Fix translation
* Styles fixes

= 1.0.0 =
Release Date: August 20, 2020

* Initial release
