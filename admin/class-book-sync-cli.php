<?php
/**
 * WP-CLI Commands.
 *
 * @link       https://wpalchemists.com
 * @since      1.0.0
 *
 * @package    Book_Sync
 * @subpackage Book_Sync/admin
 */

/**
 * WP-CLI Commands.
 *
 * Defines WP-CLI commands to sync books to and from book cataloging services.
 *
 * @package    Book_Sync
 * @subpackage Book_Sync/admin
 * @author     Morgan Kay <morgan@wpalchemists.com>
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

/**
 * Implements import fixers.
 */
class Book_Sync_Cli extends WP_CLI_Command {

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
	 */
	public function __construct() {

		$book_sync_options = new Book_Sync_Options( $this->plugin_name, $this->version );
		$this->options     = $book_sync_options->get_options();

	}

	/**
	 * Import books from LibraryThing or Goodreads.
	 *
	 * @subcommand import-books
	 *
	 * ## OPTIONS
	 *
	 * [--source=<source>]
	 * : specify where to get books - LibraryThing or Goodreads.
	 *
	 * @since 1.0.0
	 * @param array $args Command args.
	 * @param array $assoc_args User-inputted args.
	 */
	public function import_books( $args, $assoc_args ) {
		if ( 'LibraryThing' === $assoc_args['source'] ) {
			WP_CLI::line( 'Importing books from LibraryThing' );
			$book_list = $this->retrieve_books_from_librarything();
		} elseif ( 'Goodreads' === $assoc_args['source'] ) {
			WP_CLI::line( 'Importing books from Goodreads' );
			$book_list = 'tbd';
		} else {
			WP_CLI::error( 'invalid source' );
			return;
		}

		foreach ( $book_list as $book ) {
			$this->add_book( $book );
		}
	}

	/**
	 * Get books from LibraryThing, and put them an an array we can use.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function retrieve_books_from_librarything() {
		$books = array();

		$userid = $this->options['librarything_username'];
		if ( '' === $userid ) {
			WP_CLI::error( 'You must go to the plugin options page and enter your LibraryThing username' );
			die;
		}

		$key = $this->options['librarything_username'];
		if ( '' === $key ) {
			WP_CLI::error( 'You must go to the plugin options page and enter your LibraryThing key' );
			die;
		}

		// @todo - change "max" to a really high number, or maybe make it a parameter
		$raw_books = wp_remote_get( 'https://www.librarything.com/api_getdata.php?userid=' . $userid . '&key=' . $key . '&limit=review&max=5&reviewmax=10000&booksort=title&responseType=json&resultsets=books,bookratings&showReviews=1' );
		if ( is_wp_error( $raw_books ) ) {
			WP_CLI::error( $raw_books );
			die;
		}

		$body = json_decode( $raw_books['body'] );
		foreach ( $body->books as $book ) {
			$books[ $book->book_id ] = array(
				'lt_id'       => $book->book_id,
				'title'       => $book->title,
				'author'      => $book->author_lf,
				// phpcs:disable
				'isbn'        => $book->ISBN,
				// phpcs:enable
				'publication' => $book->publicationdate,
				'rating'      => $book->rating,
				'cover'       => $book->cover,
				'review'      => $book->bookreview,
			);
		}

		return $books;
	}

	/**
	 * Insert a post for a given book
	 *
	 * @param array $book_details Book info to be inserted.
	 */
	public function add_book( $book_details ) {
		WP_CLI::line( 'Importing ' . $book_details['title'] );
		// @todo Make sure the book doesn't already exist - if it does, update instead of insert
		$post     = array(
			'post_content' => $book_details['review'],
			'post_title'   => $book_details['title'],
			'post_type'    => 'book',
			'post_status'  => 'publish',
		);
		$new_book = wp_insert_post( $post, true );
		if ( is_wp_error( $new_book ) ) {
			WP_CLI::error( $new_book );
		} else {
			update_post_meta( $new_book, '_book_sync_rating', $book_details['rating'] );
			update_post_meta( $new_book, '_book_sync_pub_date', $book_details['publication'] );
			update_post_meta( $new_book, '_book_sync_isbn', $book_details['isbn'] );
			update_post_meta( $new_book, '_book_sync_lt_id', $book_details['lt_id'] );
			WP_CLI::line( '-- Created book with post id ' . $new_book );
		}

	}

}

WP_CLI::add_command( 'book-sync', 'Book_Sync_Cli' );
