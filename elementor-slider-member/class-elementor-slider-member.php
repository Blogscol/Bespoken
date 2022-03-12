<?php
/**
 * Elementor_Slider_Member class.
 *
 * @category   Class
 * @package    ElementorSliderMember
 * @subpackage WordPress
 * @author     Miguel Mariano <miguel@blogscol.com>
 * @copyright  2022 Miguel Mariano
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @since      1.0.0
 * php version 7.0.0
 */
namespace ElementorSliderMember;

if ( ! defined( 'ABSPATH' ) ) {
    // Exit if accessed directly.
    exit;
}

/**
 * Main Elementor Slider Member Class
 *
 * The init class that runs the Elementor Slider Member plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 */
final class Elementor_Slider_Member {

    /**
     * Plugin Version
     *
     * @since 1.0.0
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';


    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct() {
        // Load the translation.
        add_action( 'init', array( $this, 'i18n' ) );

        // Initialize the plugin.
        add_action( 'plugins_loaded', array( $this, 'init' ) );

        // Register the widgets.
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
    }

    /**
     * Include Widgets files
     *
     * Load widgets files
     *
     * @since 1.0.0
     * @access private
     */
    private function include_widgets_files() {
        require_once 'widget.php';
    }

    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.0.0
     * @access public
     */
    public function register_widgets() {
        // It's now safe to include Widgets files.
        $this->include_widgets_files();

        $slider_member_widget = new Slider_Member_Widget();

        // Let Elementor know about our widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( $slider_member_widget );
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain( 'elementor-slider-member' );
    }

    /**
     * Initialize the plugin
     *
     * Validates that Elementor is already loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed include the plugin class.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function init() {

        // Check if Elementor installed and activated.
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
            return;
        }

        // Check for required Elementor version.
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
            return;
        }

        // Check for required PHP version.
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
            return;
        }

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */

    public function admin_notice_missing_main_plugin() {
        deactivate_plugins( plugin_basename( ELEMENTOR_SLIDER_MEMBER ) );

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'text-domain' ),
            '<strong>' . esc_html__( 'Elementor Slider Member', 'text-domain' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'text-domain' ) . '</strong>'
        );

        printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {
        deactivate_plugins( plugin_basename( ELEMENTOR_SLIDER_MEMBER ) );

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'text-domain' ),
            '<strong>' . esc_html__( 'Elementor Slider Member', 'text-domain' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'text-domain' ) . '</strong>',
            '<strong>' . esc_html__( self::MINIMUM_ELEMENTOR_VERSION, 'text-domain' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version() {
        deactivate_plugins( plugin_basename( ELEMENTOR_SLIDER_MEMBER ) );

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'text-domain' ),
            '<strong>' . esc_html__( 'Elementor Slider Member', 'text-domain' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'text-domain' ) . '</strong>',
            '<strong>' . esc_html__( self::MINIMUM_PHP_VERSION, 'text-domain' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
}

// Instantiate Elementor_Slider_Member.
new Elementor_Slider_Member();