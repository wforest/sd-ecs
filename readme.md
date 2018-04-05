=== The Events Calendar Shortcode ===
Contributors: wforest
Tags: event, events, calendar, shortcode, modern tribe
Requires at least: 4.1
Tested up to: 4.9
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds shortcode functionality to The Events Calendar Plugin (Free Version) by Modern Tribe, so you can list your events anywhere.

== Description ==

This plugin is derived from The Events Calendar Shortcode by brianhogg, https://eventcalendarnewsletter.com/the-events-calendar-shortcode/. It adds a shortcode for use with The Events Calendar Plugin (by Modern Tribe).

With this plugin, just add the shortcode on a page to display a list of your events. For example to show next 8 events in the category festival:

`[sdecs-list-events cat="festival" limit="8"]`

= Shortcode Options: =
* Basic shortcode: `[sdecs-list-events]`
* cat - Represents single event category. `[sdecs-list-events cat='festival']`  Use commas when you want multiple categories `[sdecs-list-events cat='festival, workshops']`
* limit - Total number of events to show. Default is 5. `[sdecs-list-events limit='3']`
* order - Order of the events to be shown. Value can be 'ASC' or 'DESC'. Default is 'ASC'. Order is based on event date. `[sdecs-list-events order='DESC']`
* date - To show or hide date. Value can be 'true' or 'false'. Default is true. `[sdecs-list-events eventdetails='false']`
* venue - To show or hide the venue. Value can be 'true' or 'false'. Default is false. `[sdecs-list-events venue='true']`
* excerpt - To show or hide the excerpt and set excerpt length. Default is false. 
  * `[sdecs-list-events excerpt='true']` //displays excerpt with length 100
  * `[sdecs-list-events excerpt='300']` //displays excerpt with length 300
* thumb - To show or hide thumbnail image. Default is false. `[ecs-list-events thumb='true']` //displays post thumbnail in default thumbnail dimension from media settings.
* You can use thumbwidth and thumbheight to customize the thumbnail size `[ecs-list-events thumb='true' thumbwidth='150' thumbheight='150']` or thumbsize for a registered WordPress size `[sdecs-list-events thumb='true' thumbsize='large']`
* message - Message to show when there are no events. Defaults to 'There are no upcoming events at this time.'
* viewall - Determines whether to show 'View all events' or not. Values can be 'true' or 'false'. Default to 'true' `[sdecs-list-events cat='festival' limit='3' order='DESC' viewall='false']`
* contentorder - Manage the order of content with commas. Default to `title, thumbnail, excerpt, date, venue`. `[sdecs-list-events cat='festival' limit='3' order='DESC' viewall='false' contentorder='title, thumbnail, excerpt, date, venue']`
* month - Show only specific Month. Type `'current'` for displaying current month only or `'next'` for next month `[sdecs-list-events cat='festival' month='2015-06']`
* past - Show Outdated Events. `[ecs-list-events cat='festival' past='yes']`
* key - Hide the event when the start date/time has passed `[ecs-list-events cat='festival' key='start date']`
* orderby - Order by end date `[ecs-list-events orderby='enddate']`


This plugin is not developed by or affiliated with The Events Calendar or Modern Tribe in any way.

== Installation ==

1. Install Sulli Digital Events Calendar Shortcode Plugin from the WordPress.org repository or by uploading sulli-digital-ecs folder to the /wp-content/plugins directory. You must also install The Event Calendar Plugin by Modern Tribe and add your events to the calendar.

2. Activate the plugin through the Plugins menu in WordPress

3. If you don't already have The Events Calendar (the calendar you add your events to) you will be prompted to install it

You can then add the `[sdecs-list-events]` shortcode to the page or post you want to list events on.


== Frequently Asked Questions ==

= What are the shortcode options? =

* Basic shortcode: `[sdecs-list-events]`
* cat - Show events from an event category `[sdecs-list-events cat='festival']` or specify multiple categories `[sdecs-list-events cat='festival, workshops']`
* limit - Total number of events to show. Default is 5. `[sdecs-list-events limit='3']`
* order - Order of the events to be shown. Value can be 'ASC' or 'DESC'. Default is 'ASC'. Order is based on event date. `[sdecs-list-events order='DESC']`
* date - To show or hide date. Value can be 'true' or 'false'. Default is true. `[sdecs-list-events eventdetails='false']`
* venue - To show or hide the venue. Value can be 'true' or 'false'. Default is false. `[sdecs-list-events venue='true']`
* excerpt - To show or hide the excerpt and set excerpt length. Default is false. `[sdecs-list-events excerpt='true']` //displays excerpt with length 100
 excerpt='300' //displays excerpt with length 300
* thumb - To show or hide thumbnail image. Default is false. `[sdecs-list-events thumb='true']` //displays post thumbnail in default thumbnail dimension from media settings.
* thumbsize - Specify the size of the thumbnail. `[sdecs-list-events thumb='true' thumbsize='large']`
* thumbwidth / thumbheight - Customize the thumbnail size in pixels `[sdecs-list-events thumb='true' thumbwidth='150' thumbheight='150']`
* message - Message to show when there are no events. Defaults to 'There are no upcoming events at this time.'
* viewall - Determines whether to show 'View all events' or not. Values can be 'true' or 'false'. Default to 'true' `[sdecs-list-events cat='festival' limit='3' order='DESC' viewall='false']`
* contentorder - Manage the order of content with commas. Default to `title, thumbnail, excerpt, date, venue`. `[sdecs-list-events cat='festival' limit='3' order='DESC' viewall='false' contentorder='title, thumbnail, excerpt, date, venue']`
* month - Show only specific month (in YYYY-MM format). Type `'current'` for displaying current month only or `'next'` for next month. `[sdecs-list-events cat='festival' month='2015-06']`
* past - Show Outdated Events. `[sdecs-list-events cat='festival' past='yes']`
* key - Hide events when the start date has passed `[sdecs-list-events cat='festival' key='start date']`
* orderby - Change the ordering to the end date `[sdecs-list-events orderby="enddate"]`

= How do I use this shortcode in a widget? =

You can put the shortcode in a text widget, though not all themes support use of a shortcode in a widget.

If a regular text widget doesn't work, put the shortcode in a <a href="https://wordpress.org/plugins/black-studio-tinymce-widget/">Visual Editor Widget</a>.

= What are the classes for styling the list of events? =

By default the plugin does not include styling. Events are listed in ul li tags with appropriate classes for styling with a bit of CSS.

* ul class="sdecs-event-list"
* li class="sdecs-event" and "sdecs-featured-event" (if featured)
* event title link is H4 class="entry-title summary"
* date class is time
* venue class is venue
* span .sdecs-all-events
* p .sdecs-excerpt

= How do I include a list of events in a page template? =

`include echo do_shortcode("[sdecs-list-events]");`

Put this in the template where you want the events list to display.

== Screenshots ==

1. After adding the plugin, add the shortcode where you want the list of events to appear in the page
2. Events will appear in a list
3. Many settings you can use in the shortcode to change what details appear in the events listing

== Upgrade Notice ==

= 1 =
* Initial Release
