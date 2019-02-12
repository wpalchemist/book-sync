<?php
/**
 * The plugin settings.
 *
 * @link       https://wpalchemists.com
 * @since      1.0.0
 *
 * @package    Book_Sync
 * @subpackage Book_Sync/admin
 */

/**
 * The plugin settings.
 *
 * Defines the plugin default settings and creates the settings page.
 *
 * @package    Book_Sync
 * @subpackage Book_Sync/admin
 * @author     Morgan Kay <morgan@wpalchemists.com>
 */
class Book_Sync_Options {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The plugin options.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The options for this plugin.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since      1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->options = $this->get_options();

	}

	/**
	 * Get plugin options with default fallbacks.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function get_options() {
		$defaults = array(
			'librarything_username' => '',
			'librarything_user_key' => ''
		);
		$options = wp_parse_args( get_option( 'book_sync_settings' ), $defaults );
		return $options;
	}

	/**
	 * Add the settings page to the settings menu
	 *
	 * @since 1.0.0
	 */
	public function menu_page() {
		add_submenu_page(
			'options-general.php',
			esc_attr__( 'Book Sync Settings', 'book-sync' ),
			esc_attr__( 'Book Sync Settings', 'book-sync' ),
			'manage_options',
			'book_sync',
			array( $this, 'options_page' )
		);
	}

	/**
	 * Register the settings
	 *
	 * @since 1.0.0
	 */
	public function settings_init() {
		register_setting( 'book_sync_settings', 'book_sync_settings', array( $this, 'sanitize_settings' ) );

		add_settings_section(
			'book_sync_settings_section',
			__( 'Book Sync Settings', 'book-sync' ),
			array( $this, 'settings_section_callback' ),
			'book_sync_settings'
		);

		add_settings_field(
			'librarything_username',
			__( 'Your LibraryThing username', 'book-sync' ),
			array( $this, 'librarything_username_render' ),
			'book_sync_settings',
			'book_sync_settings_section',
			array(
				esc_attr__( 'Enter your LibraryThing username', 'book-sync' )
			)
		);

		add_settings_field(
			'librarything_user_key',
			__( 'Instructions for how to get the user key', 'book-sync' ),
			array( $this, 'librarything_user_key_render' ),
			'book_sync_settings',
			'book_sync_settings_section',
			array(
				// translators: URL for finding user key on LibraryThing.com
				sprintf( __( 'To find your LibraryThing user key, go to <a href="%s" target="_blank">LibraryThing</a>.  In the code on that page, you will see "key=XXXXXXXXXX": that is your user key.', 'book-sync' ), 'http://www.librarything.com/api/json.php' )
			)
		);

	}

	/**
	 * Display the Librarything username field
	 *
	 * @param $args array
	 * @since 1.0.0
	 */
	public function librarything_username_render( $args ) {
		$options = $this->options;
		?>
		<input type='text' name='book_sync_settings[librarything_username]' value='<?php echo esc_attr( $options['librarything_username'] ); ?>'>
		<br/><span class="description"><?php echo esc_attr( $args[0] ); ?></span>
		<?php
	}

	/**
	 * Display the LibraryThing user key field
	 *
	 * @param $args array
	 * @since 1.0.0
	 */
	public function librarything_user_key_render( $args ) {
		$options = $this->options;
		?>
		<input type='text' name='book_sync_settings[librarything_user_key]' value='<?php echo esc_attr( $options['librarything_user_key'] ); ?>'>
		<br/><span class="description"><?php echo wp_kses_post( $args[0] ); ?></span>
		<?php
	}

	/**
	 * Sanitize the settings
	 *
	 * @since 1.0.0
	 * @param $input array
	 * @return mixed
	 */
	private function sanitize_settings( $input ) {
		if ( isset( $input['librarything_username'] ) ) {
			$input['librarything_username'] = sanitize_text_field( $input['librarything_username'] );
		}

		if ( isset( $input['librarything_user_key'] ) && '' !== $input['librarything_user_key'] ) {
			$input['librarything_user_key'] = sanitize_text_field( $input['librarything_user_key'] );
		}

		return $input;
	}

	/**
	 * Display a description of the settings section
	 *
	 * @since 1.0.0
	 */
	public function settings_section_callback(  ) {
		esc_attr_e( 'Enter your LibraryThing and Goodreads credentials to sync your libraries.', 'book-sync' );
	}

	/**
	 * Render the options page
	 *
	 * @since 1.0.0
	 */
	public function options_page(  ) {
		?>
		<h2><?php esc_attr_e( 'Book Sync', 'book-sync' ); ?></h2>
		<form action='options.php' method='post'>

			<?php
			settings_fields( 'book_sync_settings' );
			do_settings_sections( 'book_sync_settings' );
			submit_button();
			?>

		</form>
		<?php
	}

}
