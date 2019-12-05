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
	 * Test whether the Book CPT exists.
	 */
	public function test_book_cpt() {
		$book = $this->factory->post->create( array( 'post_title' => 'Test Book', 'post_type' => 'book' ) );
		$test = false;

		$query = new WP_Query( array(
			's' => 'Test Book'
		) );

		while ( $query->have_posts() ) {
			$query->the_post();
			$test = get_the_id();
		}

		$this->assertEquals( $book, $test );
	}
}
