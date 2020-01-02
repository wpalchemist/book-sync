<?php
/**
 * Class BookSyncCliTest
 *
 * @package Book_Sync
 */

/**
 * Test Book Sync custom CLI commands.
 */
class BookSyncCliTest extends WP_UnitTestCase {

	/**
	 * Test the book sync command with LibraryThing.
	 */
	public function test_book_sync_librarything() {
		$Book_Sync_Cli = new Book_Sync_Cli();
		$args = '';
		$assoc_args = array(
			'number' => 10,
			'source' => 'LibraryThing',
		);

		$Book_Sync_Cli->import_books( $args, $assoc_args );




	}

}
