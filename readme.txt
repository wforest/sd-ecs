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

`[ecs-list-events cat="festival" limit="8"]`

= Shortcode Options: =
* Basic shortcode: `[ecs-list-events]`
* cat - Represents single event category. `[ecs-list-events cat='festival']`  Use commas when you want multiple categories `[ecs-list-events cat='festival, workshops']`
* limit - Total number of events to show. Default is 5. `[ecs-list-events limit='3']`
* order - Order of the events to be shown. Value can be 'ASC' or 'DESC'. Default is 'ASC'. Order is based on event date. `[ecs-list-events order='DESC']`
* date - To show or hide date. Value can be 'true' or 'false'. Default is true. `[ecs-list-events eventdetails='false']`
* venue - To show or hide the venue. Value can be 'true' or 'false'. Default is false. `[ecs-list-events venue='true']`
* excerpt - To show or hide the excerpt and set excerpt length. Default is false. 
  * `[ecs-list-events excerpt='true']` //displays excerpt with length 100
  * `[ecs-list-events excerpt='300']` //displays excerpt with length 300
* thumb - To show or hide thumbnail image. Default is false. `[ecs-list-events thumb='true']` //displays post thumbnail in default thumbnail dimension from media settings.
* You can use thumbwidth and thumbheight to customize the thumbnail size `[ecs-list-events thumb='true' thumbwidth='150' thumbheight='150']` or thumbsize for a registered WordPress size `[ecs-list-events thumb='true' thumbsize='large']`
* message - Message to show when there are no events. Defaults to 'There are no upcoming events at this time.'
* viewall - Determines whether to show 'View all events' or not. Values can be 'true' or 'false'. Default to 'true' `[ecs-list-events cat='festival' limit='3' order='DESC' viewall='false']`
* contentorder - Manage the order of content with commas. Default to `title, thumbnail, excerpt, date, venue`. `[ecs-list-events cat='festival' limit='3' order='DESC' viewall='false' contentorder='title, thumbnail, excerpt, date, venue']`
* month - Show only specific Month. Type `'current'` for displaying current month only or `'next'` for next month `[ecs-list-events cat='festival' month='2015-06']`
* past - Show Outdated Events. `[ecs-list-events cat='festival' past='yes']`
* key - Hide the event when the start date/time has passed `[ecs-list-events cat='festival' key='start date']`
* orderby - Order by end date `[ecs-list-events orderby='enddate']`

<blockquote>
<h4>Additional options and benefits in the pro version</h4>
<ul>
<li>design - Shows <a href="https://eventcalendarnewsletter.com/the-events-calendar-shortcode/?utm_source=wordpress.org&utm_medium=link&utm_campaign=tecs-readme-design&utm_content=description#designs" target="_blank">improved design by default</a>, 'compact' for a more compact listing, 'calendar' for a monthly calendar view, 'columns' to show events horizontally in columns, or 'grouped' to group events by day</li>
<li>days - Specify how many days in the future, for example [ecs-list-events days="1"] for one day or [ecs-list-events days="7"] for one week</li>
<li>date - Show only events for a specific day [ecs-list-events date='2017-04-16']</li>
<li>tag - Filter by one or more tags.  Use commas when you want to filter by multiple tags.</li>
<li>city, state, country - Display events by location.</li>
<li>featured only - Show only events marked as "featured"</li>
<li>id - Show a single event, useful for displaying details of the event on a blog post or page</li>
<li>description - Use the full description instead of the excerpt of an event in the listing</li>
<li>raw_description - Avoid filtering any HTML (spacing, links, bullet points, etc) in the description</li>
<li>raw_excerpt - Avoid filtering any HTML (spacing, links, etc) in the excerpt</li>
<li>year - Show only events for a specific year</li>
<li>date range - Show only events between certain days</li>
<li>timeonly - To show just the start time of the event. [ecs-list-events timeonly='true']</li>
<li>offset - Skip a certain number of events from the beginning, useful for using multiple shortcodes on the same page (with ads in between) or splitting into columns</li>
<li>custom design - Create one or more of your own templates for use with the shortcode</li>
<li>hiderecurring - To only show the first instance of a recurring event, set to 'true'</li>
</ul>
<p><a href="https://eventcalendarnewsletter.com/the-events-calendar-shortcode?utm_source=wordpress.org&utm_medium=link&utm_campaign=tecs-readme&utm_content=description">View more Pro features</a></p>
</blockquote>

This plugin is not developed by or affiliated with The Events Calendar or Modern Tribe in any way.

== Installation ==

1. Install Sulli Digital Events Calendar Shortcode Plugin from the WordPress.org repository or by uploading sulli-digital-ecs folder to the /wp-content/plugins directory. You must also install The Event Calendar Plugin by Modern Tribe and add your events to the calendar.

2. Activate the plugin through the Plugins menu in WordPress

3. If you don't already have The Events Calendar (the calendar you add your events to) you will be prompted to install it

You can then add the `[sdecs-list-events]` shortcode to the page or post you want to list events on.  [Full list of options available in the documentation](https://eventcalendarnewsletter.com/events-calendar-shortcode-pro-options/?utm_source=wordpress.org&utm_medium=link&utm_campaign=tecs-readme-install-docs&utm_content=description).


== Frequently Asked Questions ==

= What are the shortcode options? =

* Basic shortcode: `[sdecs-list-events]`
* cat - Show events from an event category `[ecs-list-events cat='festival']` or specify multiple categories `[ecs-list-events cat='festival, workshops']`
* limit - Total number of events to show. Default is 5. `[ecs-list-events limit='3']`
* order - Order of the events to be shown. Value can be 'ASC' or 'DESC'. Default is 'ASC'. Order is based on event date. `[ecs-list-events order='DESC']`
* date - To show or hide date. Value can be 'true' or 'false'. Default is true. `[ecs-list-events eventdetails='false']`
* venue - To show or hide the venue. Value can be 'true' or 'false'. Default is false. `[ecs-list-events venue='true']`
* excerpt - To show or hide the excerpt and set excerpt length. Default is false. `[ecs-list-events excerpt='true']` //displays excerpt with length 100
 excerpt='300' //displays excerpt with length 300
* thumb - To show or hide thumbnail image. Default is false. `[ecs-list-events thumb='true']` //displays post thumbnail in default thumbnail dimension from media settings.
* thumbsize - Specify the size of the thumbnail. `[ecs-list-events thumb='true' thumbsize='large']`
* thumbwidth / thumbheight - Customize the thumbnail size in pixels `[ecs-list-events thumb='true' thumbwidth='150' thumbheight='150']`
* message - Message to show when there are no events. Defaults to 'There are no upcoming events at this time.'
* viewall - Determines whether to show 'View all events' or not. Values can be 'true' or 'false'. Default to 'true' `[ecs-list-events cat='festival' limit='3' order='DESC' viewall='false']`
* contentorder - Manage the order of content with commas. Default to `title, thumbnail, excerpt, date, venue`. `[ecs-list-events cat='festival' limit='3' order='DESC' viewall='false' contentorder='title, thumbnail, excerpt, date, venue']`
* month - Show only specific month (in YYYY-MM format). Type `'current'` for displaying current month only or `'next'` for next month. `[ecs-list-events cat='festival' month='2015-06']`
* past - Show Outdated Events. `[ecs-list-events cat='festival' past='yes']`
* key - Hide events when the start date has passed `[ecs-list-events cat='festival' key='start date']`
* orderby - Change the ordering to the end date `[ecs-list-events orderby="enddate"]`

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
