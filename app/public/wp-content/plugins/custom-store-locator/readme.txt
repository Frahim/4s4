=== Custom WP Store Locator ===

Contributors: umangmetatagg
Donate link: https://www.devxcel.com/
Tags: store locator, store map, store finder, map, locator plugin
Requires at least: 5.0
Tested up to: 6.8.1
Requires PHP: 7.4
Stable tag: 1.5.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Create and manage multiple locations on Map. you can use a search widget, store locator map, category filter, and near location finder features.


== Description ==


Custom WP Store Locator is useful plugin to manage multiple locations in map. 

Custom WP Store Locator plugin allow to use zipcode search widget, option to enable category filter and near location finder functionality.

Whether you're managing multiple retail locations, offices, or any other type of physical presence, this plugin provides a comprehensive set of features to help your customers find you quickly and conveniently.

= Core plugin Features =

* **Category filter** : Allow your users to filter store locations by category, making it effortless for them to find exactly what they're looking for.
* **Zip Code search widget to use anywhere on website** : A handy Zip Code search widget can be placed anywhere on your website, allowing users to quickly locate nearby stores using their Zip Code.
* **Show map of specific Category locations only** : Display maps that show only specific categories of store locations, ensuring a tailored experience for your visitors.
* **Find nearest locations by zipcode** : Customers can easily find the nearest store locations by entering their Zip Code, making their shopping or visit planning more convenient.
* **Allow to use custom marker icon from backend** : Customize the marker icons for your store locations right from the WordPress backend, so your maps can match your brand's style.
* **Cluster marker feature for store map** : For stores in close proximity, the plugin offers cluster marker functionality, maintaining map clarity and usability.
* **Get direction link on map infowindow popup** : Each store location on the map provides a "Get Directions" link in the infowindow popup, making navigation a breeze.
* **Store hours feature** : Display store hours, so customers know when each location is open, improving their visit experience.
* **Geo-locate the customer's initial location** : Automatically geo-locate the customer's initial location for a more personalized experience.
* **Import and Export Locations using csv** : Easily manage your store locations by importing and exporting them using CSV files, saving you time and effort.
* **Street view option** : Offer a Street View option for your store locations, giving users a visual preview of their destination.
* **Multiple layout option** : Choose from multiple layout options to seamlessly integrate the store locator with your website's design.
* **List update based on viewport change** : Ensure a great user experience on all devices, as the plugin is fully responsive.
* **Multi Language Support** : Reach a global audience with multi-language support, making your store locator accessible to a diverse range of users.
* **Distance Unit Setting** : Enhance user experience by allowing users to choose their preferred distance unit. With the option to set the distance unit in either kilometers (KM) or miles, your store locator becomes more user-friendly and caters to a global audience, accommodating different regional preferences.


Custom WP Store Locator is the perfect solution for businesses with physical locations, helping you provide exceptional service and convenience to your customers.

Get started today and enhance your website with a feature-rich store locator. Install Custom WP Store Locator now!


[Main Site](https://www.devxcel.com/)


== Installation ==


1. Upload the entire `custom-store-locator` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the **Plugins** screen (**Plugins > Installed Plugins**).



== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. screenshot-3.png
4. screenshot-4.png
5. screenshot-5.png
6. screenshot-6.png



== Changelog ==

= 1.5.1.1 =
* Fixed : Search functionality fixed for bulgarian words input

= 1.5.1 =
* Fixed : Woocommerce compatibility issue with "Modern Style 1" layout

= 1.5 =
* Feature : Added "Modern Style 1" layout
* Feature : Enabled search functionality by store name
* Feature : Introduced "Appearance" tab in plugin settings to manage global color options
* Enhanced : Added new strings in language/translation files


= 1.4.9.3 =
* Fixed : blank map issue due to line break on address content
* Added support for Wordpress 6.8.1

= 1.4.9.2 =
* Fixed : category icons not showing

= 1.4.9.1 =
* Fixed : sample csv file missing issue on import section
* Added support for Wordpress 6.8

= 1.4.9 =
* Fixed : Search result scroll to top of page on load
* Fixed : Updated CSS file to support css custom properties
* Added support for custom marker icon for location categories


= 1.4.8 =
* Fixed : fixed XSS related issue
* Added support for Wordpress 6.7.1

= 1.4.7 =
* Fixed : map loading issue fixed
* Added support for Wordpress 6.6.2


= 1.4.6 =
* Added : Included Categories to import export csv feature
* Added : Option to enable/disable clustering and default map zoom 
* Added : Included a new strings for translation
* Added support for Wordpress 6.6.1

= 1.4.5 =
* Added : Option to set Distance Unit in KM/Miles
* Fixed : Search box autocompleted restriction based on Country Search Restriction option.
* Added : Included a new strings for translation
* Added support for Wordpress 6.5.3

= 1.4.4 =
* Enhanced : Added hide/show option for some of optional fields on store map.
* Added support for PHP 8.3

= 1.4.3 =
* Fixed : Fixed issue of infowindow open issue when using too close multiple locations.
* Fixed : Fixed issue of header broken on Astra theme.
* Fixed : Street view back button color issue.
* Added support for Wordpress 6.4.3

= 1.4.2.4 =
* Fixed : Fixed issue of map when using shortcode multiple times on same page
* Added support for Wordpress 6.4.2

= 1.4.2.3 =
* Fixed : Fixed issue of rendering Address and lat,long values based on search or marker position change for backend locations edit page.
* Enhanced : Added autocomplete search option for zipcode search box on front-end store map page. You can find out option on plugin setting page to enable it.

= 1.4.2.2 =
* Fixed : Implemented fix for email not displaying on store map
* Added support for Wordpress 6.3.1

= 1.4.2.1 =
* Added new field called "Country Search Restriction". This is helpful when all of your stores are located in single country and you are facing incorrect search result problems. Just select country from above list. 
* Fixed : New "Country Search Restriction" field fixes incorrect search result issues on some of zip codes which exist on more than one country

= 1.4.2 =
* Fixed : Added missing strings in translation

= 1.4.1 =
* Feature: plugin is now translation ready.
* Added support for Wordpress 6.2.2

= 1.4 =
* Feature - store list automatically update based on view port change
* Added support for Wordpress 6.2

= 1.3 =
* Feature - Added street view option for locations
* Feature - Added new fullwidth map layout option.
* Fixed - Styling fixed


= 1.2 =
* Feature - Added multiple language support for plugin localization
* Added support for Wordpress 6.1.1

= 1.1.3 =
* Added styling to default wordpress themes
* Added support for PHP 8.1

= 1.1.2 =
* Feature - Added Feature to sorting locations
* Added support for Wordpress 6.0.2


= 1.1.1 =
* Feature - Import and Export Locations using csv file
* Fixed : Fixed critical error which occurred when plugin deactivated

= 1.1 =
* Feature - Cluster marker feature for store map
* Feature - Get direction link on map infowindow popup
* Feature - Store hours feature
* Feature - Option to geo-locate the customer's initial location
* Feature - Included distance to location when search by zip code
* Fixed : map search issue when applied search to store


= 1.0.2 =
* Added a feature to show all fields on store locator
* Added map field on backend to automatically set address, latitude and longitude field based on map marker selection
* Fixed : Map Issue occur when no result found


= 1.0.1 =
* Fixed : Search filter map fixed


= 1.0.0 =
* Fixed : Sanitized input fields for security
* Added Category Filter

 

== Frequently Asked Questions ==


= Can i use zipcode search widget anywhere? =

Yes you can.  You need to use '[csl-search pageid="your store listing page id"]' shortcode to display widget anywhere.

= Will Custom Store Locator Plugin work with my theme? =

Yes, Custom Store Locator will work with any well-written, WP 4.x compliant theme. 

= Can i change default store list order for sorting? = 

Yes, you can choose any option from "Locations Default Sorting" dropdown field in store locator plugin settings to sort order.

= How can I add a store locator to my WordPress site after installing the plugin?

You can add a store locator to your site by using the provided shortcode [csl-store-list]. Simply insert this shortcode into any page or post where you want the store locator to appear.

= How can I import my store locations into the plugin?

You can easily import your store locations by going to the import tab of plugin's settings in the WordPress admin area and using the CSV import feature. You can also get there sample example csv file.

= Does the plugin support multiple languages?

Yes, the Custom WP Store Locator plugin offers multi-language support, making it accessible to a global audience. You can translate the plugin into different languages or use translation plugins.

= Can I display store hours for each location on the map?

Yes, the Custom WP Store Locator plugin allows you to display store hours for each location, helping customers plan their visits.

= How can I get support if I encounter issues or have questions about the plugin?

For support, you can visit our dedicated support page <https://wordpress.org/support/plugin/custom-store-locator/>.