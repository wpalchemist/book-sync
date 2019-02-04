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
	 * @param $args array
	 * @param $assoc_args array
	 */
	public function import_books( $args, $assoc_args ) {
		WP_CLI::line( 'importing books!' );

	}


}

WP_CLI::add_command( 'book-sync', 'Book_Sync_Cli' );
