<?php
/**
 * Class BookSyncTest
 *
 * @package Book_Sync
 */

/**
 * Sample test case.
 */
class BookSyncTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	public function text_book_cpt() {
		$book = $this->factory->post->create( array( 'post_title' => 'Test Book', 'post_type' => 'book' ) );

		$query = new WP_Query( array(
			's' => 'Test Book'
		) );

		$args = array(
			'post_title' => 'Test Book'
		);

		$posts = $query->query( $args );

		$this->assertEqualSets( array( $book ), wp_list_pluck( $posts, 'ID' ) );
	}
}
