<?php
/**
 * Class BookSyncTest
 *
 * @package Book_Sync
 */

/**
 * Test Book Sync functionality.
 */
class BookSyncTest extends WP_UnitTestCase {


	/**
	 * Test whether the Book CPT exists.
	 */
	public function test_book_cpt() {
		$book = $this->factory->post->create(
			array(
				'post_title' => 'Test Book',
				'post_type'  => 'book',
			)
		);
		$test = false;

		$query = new WP_Query(
			array(
				's' => 'Test Book',
			)
		);

		while ( $query->have_posts() ) {
			$query->the_post();
			$test = get_the_id();
		}

		$this->assertEquals( $book, $test );
	}

	/**
	 * Test saving and retrieving book meta data.
	 */
	public function test_book_meta() {
		// create a book.
		$book = $this->factory->post->create(
			array(
				'post_title' => 'Meta Test',
				'post_type'  => 'book',
			)
		);

		// list meta fields.
		$fields = array(
			'_book_sync_rating'   => 5,
			'_book_sync_pub_date' => '2000',
			'_book_sync_isbn'     => '0765336928',
			'_book_sync_lt_id'    => '110378285',
		);

		// add meta fields to book.
		foreach ( $fields as $key => $value ) {
			update_post_meta( $book, $key, $value );
		}

		// retrieve meta fields from book.
		$retrieved_fields = array();
		foreach ( $fields as $key => $value ) {
			$retrieved_fields[ $key ] = get_post_meta( $book, $key, true );
		}

		// make sure retrieved data is what we expect.
		$this->assertEquals( $fields, $retrieved_fields );
	}
}
