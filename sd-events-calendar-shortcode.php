<?php
/***
 Plugin Name: Sulli Digital Events Calendar Shortcode
 Plugin URI: https://github.com/wforest/sd-ecs
 Description: An addon to add shortcode functionality for <a href="http://wordpress.org/plugins/the-events-calendar/">The Events Calendar Plugin by Modern Tribe</a>.
 Version: 1.0
 Author: Bill Sullivan - Sulli Digital
 Author URI: https://sullidigital.com
 Contributors: wforest
 License: GPL2 or later
 License URI: http://www.gnu.org/licenses/gpl-2.0.html
 Text Domain: sd-events-calendar-shortcode
*/

// Avoid direct calls to this file
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'TECS_CORE_PLUGIN_FILE', __FILE__ );

/**
 * Events calendar shortcode addon main class
 *
 * @package sd-events-calendar-shortcode
 * @author Bill Sullivan
 * @version 1.0
 */

if ( ! class_exists( 'SD_Events_Calendar_Shortcode' ) ) {

class SD_Events_Calendar_Shortcode
{
	/**
	 * Current version of the plugin.
	 *
	 * @since 1.0.0
	 */
	const VERSION = '1.0';

	private $admin_page = null;

	const MENU_SLUG = 'sdecs-admin';

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @see	 add_shortcode()
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'verify_tec_installed' ), 2 );
		add_action( 'admin_menu', array( $this, 'add_menu_page' ), 1000 );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'add_action_links' ) );
		add_shortcode( 'sdecs-list-events', array( $this, 'sdecs_fetch_events' ) );
		add_filter( 'sdecs_ending_output', array( $this, 'add_event_schema_json' ), 10, 3 );
		add_action( 'plugins_loaded', array( $this, 'load_languages' ) );

	} // END __construct()

	public function load_languages() {
		if ( function_exists( 'tecsp_load_textdomain' ) )
			return;
		load_plugin_textdomain( 'sd-events-calendar-shortcode', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}

	public function verify_tec_installed() {
		if ( ! class_exists( 'Tribe__Events__Main' ) or ! defined( 'Tribe__Events__Main::VERSION' )) {
			add_action( 'admin_notices', array( $this, 'show_tec_not_installed_message' ) );
		}
	}

	public function show_tec_not_installed_message() {
		if ( current_user_can( 'activate_plugins' ) ) {
			$url = 'plugin-install.php?tab=plugin-information&plugin=the-events-calendar&TB_iframe=true';
			$title = __( 'The Events Calendar', 'tribe-events-ical-importer' );
			echo '<div class="error"><p>' . sprintf( esc_html( __( 'To begin using %s, please install the latest version of %s%s%s and add an event.', 'the-events-calendar-shortcode' ) ), 'The Events Calendar Shortcode', '<a href="' . esc_url( $url ) . '" class="thickbox" title="' . esc_attr( $title ) . '">', 'The Events Calendar', '</a>' ) . '</p></div>';
		}
	}

	public function add_menu_page() {
		if ( ! class_exists( 'Tribe__Settings' ) or ! method_exists( Tribe__Settings::instance(), 'should_setup_pages' ) or ! Tribe__Settings::instance()->should_setup_pages() ) {
			return;
		}

		$page_title = esc_html__( 'Shortcode', 'sd-events-calendar-shortcode' );
		$menu_title = esc_html__( 'Shortcode', 'tribe-common' );
		$capability = apply_filters( 'sdecs_admin_page_capability', 'install_plugins' );

		$where = Tribe__Settings::instance()->get_parent_slug();

		$this->admin_page = add_submenu_page( $where, $page_title, $menu_title, $capability, self::MENU_SLUG, array( $this, 'do_menu_page' ) );

		add_action( 'admin_print_styles-' . $this->admin_page, array( $this, 'enqueue' ) );
		add_action( 'admin_print_styles', array( $this, 'enqueue_submenu_style' ) );
	}

	public function enqueue() {
		wp_enqueue_style( 'sdecs-admin-css', plugins_url( 'static/sdecs-admin.css', __FILE__ ), array(), self::VERSION );
		wp_enqueue_script( 'sdecs-admin-js', plugins_url( 'static/sdecs-admin.js', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Function to add a small CSS file to add some colour to the Shortcode submenu item
	 */
	public function enqueue_submenu_style() {
		wp_enqueue_style( 'sdecs-submenu-css', plugins_url( 'static/sdecs-submenu.css', __FILE__ ), array(), self::VERSION );
	}

	public function do_menu_page() {
		include dirname( __FILE__ ) . '/templates/admin-page.php';
	}

	public function add_action_links( $links ) {
		$mylinks = array();
		if ( class_exists( 'Tribe__Settings' ) and method_exists( Tribe__Settings::instance(), 'should_setup_pages' ) and Tribe__Settings::instance()->should_setup_pages() )
			$mylinks[] = '<a href="' . admin_url( 'edit.php?post_type=tribe_events&page=sdecs-admin' ) . '">' . esc_html__( 'Settings', 'sd-events-calendar-shortcode' ) . '</a>';

		return array_merge( $links, $mylinks );
	}

	/**
	 * Fetch and return required events.
	 * @param  array $atts 	shortcode attributes
	 * @return string 	shortcode output
	 */
	public function sdecs_fetch_events( $atts ) {
		/**
		 * Check if events calendar plugin method exists
		 */
		if ( !function_exists( 'tribe_get_events' ) ) {
			return '';
		}

		global $post;
		$output = '';

		$atts = shortcode_atts( apply_filters( 'sdecs_shortcode_atts', array(
			'cat' => '',
			'month' => '',
			'limit' => 5,
			'eventdetails' => 'true',
			'time' => null,
			'past' => null,
			'venue' => 'false',
			'author' => null,
			'schema' => 'true',
			'message' => 'There are no upcoming %s at this time.',
			'key' => 'End Date',
			'order' => 'ASC',
			'orderby' => 'startdate',
			'viewall' => 'false',
			'excerpt' => 'false',
			'thumb' => 'false',
			'thumbsize' => '',
			'thumbwidth' => '',
			'thumbheight' => '',
			'contentorder' => apply_filters( 'sdecs_default_contentorder', 'title, thumbnail, excerpt, date, venue', $atts ),
			'event_tax' => '',
		), $atts ), $atts, 'sdecs-list-events' );

		// Category
		if ( $atts['cat'] ) {
			if ( strpos( $atts['cat'], "," ) !== false ) {
				$atts['cats'] = explode( ",", $atts['cat'] );
				$atts['cats'] = array_map( 'trim', $atts['cats'] );
			} else {
				$atts['cats'] = array( trim( $atts['cat'] ) );
			}

			$atts['event_tax'] = array(
				'relation' => 'OR',
			);

			foreach ( $atts['cats'] as $cat ) {
				$atts['event_tax'][] = array(
					'taxonomy' => 'tribe_events_cat',
					'field' => 'name',
					'terms' => $cat,
				);
				$atts['event_tax'][] = array(
					'taxonomy' => 'tribe_events_cat',
					'field' => 'slug',
					'terms' => $cat,
				);
			}
		}

		// Past Event
		$meta_date_compare = '>=';
		$meta_date_date = current_time( 'Y-m-d H:i:s' );

		if ( $atts['time'] == 'past' || !empty( $atts['past'] ) ) {
			$meta_date_compare = '<';
		}

		// Key, used in filtering events by date
		if ( str_replace( ' ', '', trim( strtolower( $atts['key'] ) ) ) == 'startdate' ) {
			$atts['key'] = '_EventStartDate';
		} else {
			$atts['key'] = '_EventEndDate';
		}

		// Orderby
		if ( str_replace( ' ', '', trim( strtolower( $atts['orderby'] ) ) ) == 'enddate' ) {
			$atts['orderby'] = '_EventEndDate';
		} elseif ( trim( strtolower( $atts['orderby'] ) ) == 'title' ) {
			$atts['orderby'] = 'title';
		} else {
			$atts['orderby'] = '_EventStartDate';
		}

		// Date
		$atts['meta_date'] = array(
			array(
				'key' => $atts['key'],
				'value' => $meta_date_date,
				'compare' => $meta_date_compare,
				'type' => 'DATETIME'
			)
		);

		// Specific Month
		if ( 'current' == $atts['month'] ) {
			$atts['month'] = current_time( 'Y-m' );
		}
		if ( 'next' == $atts['month'] ) {
			$atts['month'] = date( 'Y-m', strtotime( '+1 months', current_time( 'timestamp' ) ) );
		}
		if ($atts['month']) {
			$month_array = explode("-", $atts['month']);
			
			$month_yearstr = $month_array[0];
			$month_monthstr = $month_array[1];
			$month_startdate = date( "Y-m-d", strtotime( $month_yearstr . "-" . $month_monthstr . "-01" ) );
			$month_enddate = date( "Y-m-01", strtotime( "+1 month", strtotime( $month_startdate ) ) );

			$atts['meta_date'] = array(
				'relation' => 'AND',
				array(
					'key' => $atts['key'],
					'value' => $month_startdate,
					'compare' => '>=',
					'type' => 'DATETIME'
				),
				array(
					'key' => $atts['key'],
					'value' => $month_enddate,
					'compare' => '<',
					'type' => 'DATETIME'
				)
			);
		}

		$posts = tribe_get_events( apply_filters( 'sdecs_get_events_args', array(
			'post_status' => 'publish',
			'hide_upcoming' => true,
			'posts_per_page' => $atts['limit'],
			'tax_query'=> $atts['event_tax'],
			'meta_key' => ( ( trim( $atts['orderby'] ) and 'title' != $atts['orderby'] ) ? $atts['orderby'] : $atts['key'] ),
			'orderby' => ( $atts['orderby'] == 'title' ? 'title' : 'meta_value' ),
			'author' => $atts['author'],
			'order' => $atts['order'],
			'meta_query' => apply_filters( 'sdecs_get_meta_query', array( $atts['meta_date'] ), $atts, $meta_date_date, $meta_date_compare ),
		), $atts, $meta_date_date, $meta_date_compare ) );
        $posts = apply_filters( 'sdecs_filter_events_after_get', $posts, $atts );

		if ( $posts or apply_filters( 'sdecs_always_show', false, $atts ) ) {
			$output = apply_filters( 'sdecs_beginning_output', $output, $posts, $atts );
			$output .= apply_filters( 'sdecs_start_tag', '<div class="sdecs-event-list wpb_row vc_row">', $atts );
			$atts['contentorder'] = explode( ',', $atts['contentorder'] );

			foreach( (array) $posts as $post_index => $post ) {
				setup_postdata( $post );
				$event_output = '';
				if ( apply_filters( 'sdecs_skip_event', false, $atts, $post ) )
				    continue;
				$category_slugs = array();
				$category_list = get_the_terms( $post, 'tribe_events_cat' );
				$featured_class = ( get_post_meta( get_the_ID(), '_tribe_featured', true ) ? ' sdecs-featured-event' : '' );
				if ( is_array( $category_list ) ) {
					foreach ( (array) $category_list as $category ) {
						$category_slugs[] = ' ' . $category->slug . '_sdecs_category';
					}
				}
				$event_output .= apply_filters( 'sdecs_event_start_tag', '<div class="sdecs-event wpb_column vc_column_container vc_col-sm-4' . implode( '', $category_slugs ) . $featured_class . apply_filters( 'sdecs_event_classes', '', $atts, $post ) . '"> <div class="vc_column-inner"><div class="wpb_wrapper"><div class="content-box content-box-default content-box-classic">', $atts, $post );

				// Put Values into $event_output
				foreach ( apply_filters( 'sdecs_event_contentorder', $atts['contentorder'], $atts, $post ) as $contentorder ) {
					switch ( trim( $contentorder ) ) {
						case 'title':
							$event_output .= apply_filters( 'sdecs_event_title_tag_start', '<h3 class="entry-title summary">', $atts, $post ) .
											apply_filters( 'sdecs_event_list_title_link_start', '<a href="' . tribe_get_event_link() . '" rel="bookmark">', $atts, $post ) . apply_filters( 'sdecs_event_list_title', get_the_title(), $atts, $post ) . apply_filters( 'sdecs_event_list_title_link_end', '</a>', $atts, $post ) .
							           apply_filters( 'sdecs_event_title_tag_end', '</h3>', $atts, $post );
							break;

						case 'thumbnail':
							if ( self::isValid( $atts['thumb'] ) ) {
								$thumbWidth = is_numeric($atts['thumbwidth']) ? $atts['thumbwidth'] : '';
								$thumbHeight = is_numeric($atts['thumbheight']) ? $atts['thumbheight'] : '';
								if( !empty( $thumbWidth ) && !empty( $thumbHeight ) ) {
									$event_output .= apply_filters( 'sdecs_event_thumbnail', get_the_post_thumbnail( get_the_ID(), apply_filters( 'sdecs_event_thumbnail_size', array( $thumbWidth, $thumbHeight ), $atts, $post ) ), $atts, $post );
								} else {
									if ( $thumb = get_the_post_thumbnail( get_the_ID(), apply_filters( 'sdecs_event_thumbnail_size', ( trim( $atts['thumbsize'] ) ? trim( $atts['thumbsize'] ) : 'medium' ), $atts, $post ) ) ) {
										$event_output .= apply_filters( 'sdecs_event_thumbnail_link_start', '<a href="' . tribe_get_event_link() . '">', $atts, $post );
										$event_output .= apply_filters( 'sdecs_event_thumbnail', $thumb, $atts, $post );
										$event_output .= apply_filters( 'sdecs_event_thumbnail_link_end', '</a>', $atts, $post );
									}
								}
							}
							break;

						case 'excerpt':
							if ( self::isValid( $atts['excerpt'] ) ) {
								$excerptLength = is_numeric($atts['excerpt']) ? $atts['excerpt'] : 100;
								$event_output .= apply_filters( 'sdecs_event_excerpt_tag_start', '<p class="sdecs-excerpt">', $atts, $post ) .
								           apply_filters( 'sdecs_event_excerpt', self::get_excerpt( $excerptLength ), $atts, $post, $excerptLength ) .
								           apply_filters( 'sdecs_event_excerpt_tag_end', '</p><a href="' . tribe_get_event_link() . '" class="btn btn-default semi-round border-thin btn-sdecs" rel="bookmark"><span>See Details</span></a>', $atts, $post );
							}
							break;

						case 'date':
							if ( self::isValid( $atts['eventdetails'] ) ) {
								$event_output .= apply_filters( 'sdecs_event_date_tag_start', '<h4 class="duration time">', $atts, $post ) .
								           apply_filters( 'sdecs_event_list_details', tribe_events_event_schedule_details(), $atts, $post ) .
								           apply_filters( 'sdecs_event_date_tag_end', '</h4>', $atts, $post );
							}
							break;

						case 'venue':
							if ( self::isValid( $atts['venue'] ) and function_exists( 'tribe_has_venue' ) and tribe_has_venue() ) {
								$event_output .= apply_filters( 'sdecs_event_venue_tag_start', '<span class="duration venue">', $atts, $post ) .
								           apply_filters( 'sdecs_event_venue_at_tag_start', '<em> ', $atts, $post ) .
								           apply_filters( 'sdecs_event_venue_at_text', __( 'at', 'sd-events-calendar-shortcode' ), $atts, $post ) .
								           apply_filters( 'sdecs_event_venue_at_tag_end', ' </em>', $atts, $post ) .
								           apply_filters( 'sdecs_event_list_venue', tribe_get_venue(), $atts, $post ) .
								           apply_filters( 'sdecs_event_venue_tag_end', '</span>', $atts, $post );
							}
							break;
						case 'date_thumb':
							if ( self::isValid( $atts['eventdetails'] ) ) {
								$event_output .= apply_filters( 'sdecs_event_date_thumb', '<div class="date_thumb"><div class="month">' . tribe_get_start_date( null, false, 'M' ) . '</div><div class="day">' . tribe_get_start_date( null, false, 'j' ) . '</div></div>', $atts, $post );
							}
							break;
						default:
							$event_output .= apply_filters( 'sdecs_event_list_output_custom_' . strtolower( trim( $contentorder ) ), '', $atts, $post );
					}
				}
				$event_output .= apply_filters( 'sdecs_event_end_tag', '</div></div></div></div>', $atts, $post );
				$output .= apply_filters( 'sdecs_single_event_output', $event_output, $atts, $post, $post_index, $posts );
			}
			$output .= apply_filters( 'sdecs_end_tag', '</div>', $atts );
			$output = apply_filters( 'sdecs_ending_output', $output, $posts, $atts );

			if( self::isValid( $atts['viewall'] ) ) {
				$output .= apply_filters( 'sdecs_view_all_events_tag_start', '<span class="sdecs-all-events">', $atts ) .
				           '<a href="' . apply_filters( 'ecs_event_list_viewall_link', tribe_get_events_link(), $atts ) .'" rel="bookmark">' . apply_filters( 'sdecs_view_all_events_text', sprintf( __( 'View All %s', 'the-events-calendar' ), tribe_get_event_label_plural() ), $atts ) . '</a>';
				$output .= apply_filters( 'sdecs_view_all_events_tag_end', '</span>' );
			}

		} else { //No Events were Found
			$output .= apply_filters( 'sdecs_no_events_found_message', sprintf( translate( $atts['message'], 'the-events-calendar' ), tribe_get_event_label_plural_lowercase() ), $atts );
		} // endif

		wp_reset_postdata();

		return $output;
	}

	public function add_event_schema_json( $output, $posts, $atts ) {
		if ( self::isValid( $atts['schema'] ) and $posts and class_exists( 'Tribe__Events__JSON_LD__Event' ) and ( ! defined( 'DOING_AJAX' ) or ! DOING_AJAX ) )
			$output .= Tribe__Events__JSON_LD__Event::instance()->get_markup( $posts );
		return $output;
	}

	/**
	 * Checks if the plugin attribute is valid
	 *
	 * @since 1.0
	 *
	 * @param string $prop
	 * @return boolean
	 */
	public static function isValid( $prop )
	{
		return ( $prop !== 'false' );
	}

	/**
	 * Fetch and trims the excerpt to specified length
	 *
	 * @param integer $limit Characters to show
	 * @param string $source  content or excerpt
	 *
	 * @return string
	 */
	public static function get_excerpt( $limit, $source = null )
	{
		$excerpt = get_the_excerpt();
		if( $source == "content" ) {
			$excerpt = get_the_content();
		}

		$excerpt = preg_replace( " (\[.*?\])", '', $excerpt );
		$excerpt = strip_tags( strip_shortcodes($excerpt) );
		$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
		if ( strlen( $excerpt ) > $limit ) {
			$excerpt = substr( $excerpt, 0, $limit );
			$excerpt .= '...';
		}

		return $excerpt;
	}
}

}

/**
 * Instantiate the main class
 *
 * @since 1.0.0
 * @access public
 *
 * @var	object	$sd_events_calendar_shortcode holds the instantiated class {@uses Events_Calendar_Shortcode}
 */
global $sd_events_calendar_shortcode;
$sd_events_calendar_shortcode = new SD_Events_Calendar_Shortcode();
