<div class="wrap">
	<h2><?php _e( 'Sulli Digital Events Calendar Shortcode' ); ?></h2>

	<p><?php echo sprintf( esc_html__( 'The shortcode displays lists of your events. For example the shortcode to show next 8 events in the category "%s" in ASC order with date showing:', 'sd-events-calendar-shortcode' ), 'festival' ); ?></p>

	<pre>[sdecs-list-events cat='festival' limit='8']</pre>

	<table>
		<tbody>
		<tr valign="top">
			<td valign="top">

				<div>
					<h2><?php echo esc_html( __( 'Basic shortcode', 'sd-events-calendar-shortcode' ) ); ?></h2>
						<blockquote>[ecs-list-events]</blockquote>

					<h2><?php echo esc_html( __( 'Shortcode Options', 'sd-events-calendar-shortcode' ) ); ?></h2>
					<?php do_action( 'sdecs_admin_page_options_before' ); ?>

					<h3>cat</h3>
					<p><?php echo esc_html( __( 'Represents single event category.  Use commas when you want multiple categories', 'sd-events-calendar-shortcode' ) ); ?>
						<blockquote>[sdecs-list-events cat='festival']</blockquote>
						<blockquote>[sdecs-list-events cat='festival, workshops']</blockquote>

					<?php do_action( 'ecs_admin_page_options_after_cat' ); ?>

					<h3>limit</h3>
					<p><?php echo esc_html( __( 'Total number of events to show. Default is 5.', 'sd-events-calendar-shortcode' ) ); ?></p>
						<blockquote>[sdecs-list-events limit='3']</blockquote>
					<h3>order</h3>
					<p><?php echo esc_html( __( "Order of the events to be shown. Value can be 'ASC' or 'DESC'. Default is 'ASC'. Order is based on event date.", 'sd-events-calendar-shortcode' ) ); ?></p>
						<blockquote>[sdecs-list-events order='DESC']</blockquote>
					<h3>date</h3>
					<p><?php echo esc_html( __( "To show or hide date. Value can be 'true' or 'false'. Default is true.", 'sd-events-calendar-shortcode' ) ); ?></p>
						<blockquote>[sdecs-list-events eventdetails='false']</blockquote>
					<h3>venue</h3>
					<p><?php echo esc_html( __( "To show or hide the venue. Value can be 'true' or 'false'. Default is false.", 'sd-events-calendar-shortcode' ) ); ?></p>
						<blockquote>[sdecs-list-events venue='true']</blockquote>
					<h3>excerpt</h3>
					<p><?php echo esc_html( __( 'To show or hide the excerpt and set excerpt length. Default is false.', 'sd-events-calendar-shortcode' ) ); ?><p>
						<blockquote>[sdecs-list-events excerpt='true']</blockquote>
						<blockquote>[sdecs-list-events excerpt='300']</blockquote>
					<h3>thumb</h3>
					<p><?php echo esc_html( __( 'To show or hide thumbnail/featured image. Default is false.', 'sd-events-calendar-shortcode' ) ); ?></p>
						<blockquote>[sdecs-list-events thumb='true']</blockquote>
					<p><?php echo sprintf( esc_html( __( 'You can use 2 other attributes: %s and %s to customize the thumbnail size', 'sd-events-calendar-shortcode' ) ), 'thumbwidth', 'thumbheight' ); ?></p>
						<blockquote>[sdecs-list-events thumb='true' thumbwidth='150' thumbheight='150']</blockquote>
					<p><?php echo sprintf( esc_html( __( 'or use %s to specify the pre-set size to use, for example:', 'sd-events-calendar-shortcode' ) ), 'thumbsize' ); ?></p>
						<blockquote>[sdecs-list-events thumb='true' thumbsize='large']</blockquote>

					<h3>message</h3>
					<p><?php echo esc_html( sprintf( __( "Message to show when there are no events. Defaults to '%s'", 'sd-events-calendar-shortcode' ), translate( 'There are no upcoming events at this time.', 'tribe-events-calendar' ) ) ); ?></p>
					<h3>viewall</h3>
					<?php if ( function_exists( 'tribe_get_event_label_plural' ) ): ?>
						<p><?php echo esc_html( sprintf( __( "Determines whether to show '%s' or not. Values can be 'true' or 'false'. Default to 'true'", 'sd-events-calendar-shortcode' ), sprintf( __( 'View All %s', 'the-events-calendar' ), tribe_get_event_label_plural() ) ) ); ?></p>
					<?php endif; ?>
						<blockquote>[sdecs-list-events cat='festival' limit='3' order='DESC' viewall='false']</blockquote>
					<h3>contentorder</h3>
					<p><?php echo esc_html( sprintf( __( 'Manage the order of content with commas. Defaults to %s', 'sd-events-calendar-shortcode' ), 'title, thumbnail, excerpt, date, venue' ) ); ?> </p>
						<blockquote>[sdecs-list-events cat='festival' limit='3' order='DESC' viewall='false' contentorder='title, thumbnail, excerpt, date, venue']</blockquote>
					<h3>month</h3>
					<p><?php echo esc_html( sprintf( __( "Show only specific Month. Type '%s' for displaying current month only or '%s' for next month, ie:", 'sd-events-calendar-shortcode' ), 'current', 'next' ) ); ?></p>
						<blockquote>[sdecs-list-events cat='festival' month='2015-06']</blockquote>
					<h3>past</h3>
					<p><?php echo esc_html( __( 'Show outdated events (ie. events that have already happened)', 'sd-events-calendar-shortcode' ) ); ?></p>
						<blockquote>[sdecs-list-events cat='festival' past='yes']</blockquote>
					<h3>key</h3>
					<p><?php echo esc_html( __( 'Use to hide events when the start date has passed, rather than the end date.  Will also change the order of events by start date instead of end date.', 'sd-events-calendar-shortcode' ) ); ?></p>
						<blockquote>[sdecs-list-events cat='festival' key='start date']</blockquote>
					<h3>orderby</h3>
					<p><?php echo esc_html( __( 'Used to order by the end date instead of the start date.', 'sd-events-calendar-shortcode' ) ); ?></p>
						<blockquote>[sdecs-list-events orderby='enddate']</blockquote>
                    <p><?php echo esc_html( __( 'You can also use this to order by title if you wish:', 'sd-events-calendar-shortcode' ) ); ?></p>
                        <blockquote>[sdecs-list-events orderby='title']</blockquote>
					<?php do_action( 'sdecs_admin_page_options_after' ); ?>

				</div>

			</td>
			<td valign="top" class="styling">
				<h3>Styling/Design</h3>

				<?php do_action( 'sdecs_admin_page_styling_before' ); ?>

				<?php if ( apply_filters( 'sdecs_show_upgrades', true ) ): ?>

					<p><?php echo esc_html( __( 'By default the plugin does not include styling. Events are listed in ul li tags with appropriate classes for styling and you can add your own CSS:', 'sd-events-calendar-shortcode' ) ) ?></p>

					<ul>
						<li>ul class="sdecs-event-list"</li>
						<li>li class="sdecs-event" &amp; "sdecs-featured-event" <?php echo esc_html( __( '(if featured)', 'sd-events-calendar-shortcode' ) ) ?></li>
						<li><?php echo esc_html( sprintf( __( 'event title link is %s', 'sd-events-calendar-shortcode' ), 'H4 class="entry-title summary"' ) ); ?> </li>
						<li><?php echo esc_html( sprintf( __( 'date class is %s', 'sd-events-calendar-shortcode' ), 'time' ) ); ?></li>
						<li><?php echo esc_html( sprintf( __( 'venue class is %s', 'sd-events-calendar-shortcode' ), 'venue' ) ); ?></li>
						<li>span .sdecs-all-events</li>
						<li>p .sdecs-excerpt</li>
					</ul>

				<?php endif; ?>
			</td>
		</tr>
		</tbody>
	</table>

	<p><small><?php echo sprintf( esc_html__( 'This plugin is not developed by or affiliated with The Events Calendar or %s in any way.', 'sd-events-calendar-shortcode' ), 'Modern Tribe' ); ?></small></p>
</div>