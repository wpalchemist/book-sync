<?php

/**
 * Manage the object cache.
 *
 * ## EXAMPLES
 *
 *     wp cache set my_key my_value my_group 300
 *
 *     wp cache get my_key my_group
 */
class Cache_Command extends WP_CLI_Command {

	/**
	 * Add a value to the object cache.
	 *
	 * If a value already exists for the key, the value isn't added.
	 *
	 * <key>
	 * : Cache key.
	 *
	 * <value>
	 * : Value to add to the key.
	 *
	 * [<group>]
	 * : Method for grouping data within the cache which allows the same key to be used across groups.
	 *
	 * [<expiration>]
	 * : Define how long to keep the value, in seconds. Defaults to 0 (as long as possible).
	 */
	public function add( $args, $assoc_args ) {
		list( $key, $value ) = $args;

		$group = \WP_CLI\Utils\get_flag_value( $args, 2, '' );

		$expiration = \WP_CLI\Utils\get_flag_value( $args, 3, 0 );

		if ( ! wp_cache_add( $key, $value, $group, $expiration ) ) {
			WP_CLI::error( "Could not add object '$key' in group '$group'. Does it already exist?" );
		}

		WP_CLI::success( "Added object '$key' in group '$group'." );
	}

	/**
	 * Decrement a value in the object cache.
	 *
	 * <key>
	 * : Cache key.
	 *
	 * [<offset>]
	 * : The amount by which to decrement the item's value. Default is 1.
	 *
	 * [<group>]
	 * : Method for grouping data within the cache which allows the same key to be used across groups.
	 */
	public function decr( $args, $assoc_args ) {
		$key = $args[0];

		$offset = \WP_CLI\Utils\get_flag_value( $args, 1, 1 );

		$group = \WP_CLI\Utils\get_flag_value( $args, 2, '' );

		$value = wp_cache_decr( $key, $offset, $group );

		if ( false === $value ) {
			WP_CLI::error( 'The value was not decremented.' );
		}

		WP_CLI::print_value( $value, $assoc_args );
	}

	/**
	 * Remove a value from the object cache.
	 *
	 * <key>
	 * : Cache key.
	 *
	 * [<group>]
	 * : Method for grouping data within the cache which allows the same key to be used across groups.
	 */
	public function delete( $args, $assoc_args ) {
		$key = $args[0];

		$group = \WP_CLI\Utils\get_flag_value( $args, 1, '' );

		$result = wp_cache_delete( $key, $group );

		if ( false === $result ) {
			WP_CLI::error( 'The object was not deleted.' );
		}

		WP_CLI::success( 'Object deleted.' );
	}

	/**
	 * Flush the object cache.
	 */
	public function flush( $args, $assoc_args ) {
		$value = wp_cache_flush();

		if ( false === $value ) {
			WP_CLI::error( 'The object cache could not be flushed.' );
		}

		WP_CLI::success( 'The cache was flushed.' );
	}

	/**
	 * Get a value from the object cache.
	 *
	 * <key>
	 * : Cache key.
	 *
	 * [<group>]
	 * : Method for grouping data within the cache which allows the same key to be used across groups.
	 */
	public function get( $args, $assoc_args ) {
		$key = $args[0];

		$group = \WP_CLI\Utils\get_flag_value( $args, 1, '' );

		$value = wp_cache_get( $key, $group );

		if ( false === $value ) {
			WP_CLI::error( "Object with key '$key' and group '$group' not found." );
		}

		WP_CLI::print_value( $value, $assoc_args );
	}

	/**
	 * Increment a value in the object cache.
	 *
	 * <key>
	 * : Cache key.
	 *
	 * [<offset>]
	 * : The amount by which to increment the item's value. Default is 1.
	 *
	 * [<group>]
	 * : Method for grouping data within the cache which allows the same key to be used across groups.
	 */
	public function incr( $args, $assoc_args ) {
		$key = $args[0];

		$offset = \WP_CLI\Utils\get_flag_value( $args, 1, 1 );

		$group = \WP_CLI\Utils\get_flag_value( $args, 2, '' );

		$value = wp_cache_incr( $key, $offset, $group );

		if ( false === $value ) {
			WP_CLI::error( 'The value was not incremented.' );
		}

		WP_CLI::print_value( $value, $assoc_args );
	}

	/**
	 * Replace a value in the object cache, if the value already exists.
	 *
	 * <key>
	 * : Cache key.
	 *
	 * <value>
	 * : Value to replace.
	 *
	 * [<group>]
	 * : Method for grouping data within the cache which allows the same key to be used across groups.
	 *
	 * [<expiration>]
	 * : Define how long to keep the value, in seconds. Defaults to 0 (as long as possible).
	 */
	public function replace( $args, $assoc_args ) {
		list( $key, $value ) = $args;

		$group = \WP_CLI\Utils\get_flag_value( $args, 2, '' );

		$expiration = \WP_CLI\Utils\get_flag_value( $args, 3, 0 );

		$result = wp_cache_replace( $key, $value, $group, $expiration );

		if ( false === $result ) {
			WP_CLI::error( "Could not replace object '$key' in group '$group'. Does it already exist?" );
		}

		WP_CLI::success( "Replaced object '$key' in group '$group'." );
	}

	/**
	 * Set a value to the object cache, regardless of whether it already exists.
	 *
	 * <key>
	 * : Cache key.
	 *
	 * <value>
	 * : Value to set on the key.
	 *
	 * [<group>]
	 * : Method for grouping data within the cache which allows the same key to be used across groups.
	 *
	 * [<expiration>]
	 * : Define how long to keep the value, in seconds. Defaults to 0 (as long as possible).
	 */
	public function set( $args, $assoc_args ) {
		list( $key, $value ) = $args;

		$group = \WP_CLI\Utils\get_flag_value( $args, 2, '' );

		$expiration = \WP_CLI\Utils\get_flag_value( $args, 3, 0 );

		$result = wp_cache_set( $key, $value, $group, $expiration );

		if ( false === $result ) {
			WP_CLI::error( "Could not add object '$key' in group '$group'." );
		}

		WP_CLI::success( "Set object '$key' in group '$group'." );
	}

	/**
	 * Attempts to determine which object cache is being used.
	 *
	 * Note that the guesses made by this function are based on the WP_Object_Cache classes
	 * that define the 3rd party object cache extension. Changes to those classes could render
	 * problems with this function's ability to determine which object cache is being used.
	 */
	public function type( $args, $assoc_args ) {
		global $_wp_using_ext_object_cache, $wp_object_cache;

		if ( false !== $_wp_using_ext_object_cache ) {
			// Test for Memcached PECL extension memcached object cache (https://github.com/tollmanz/wordpress-memcached-backend)
			if ( isset( $wp_object_cache->m ) && is_a( $wp_object_cache->m, 'Memcached' ) ) {
				$message = 'Memcached';

			// Test for Memcache PECL extension memcached object cache (http://wordpress.org/extend/plugins/memcached/)
			} elseif ( isset( $wp_object_cache->mc ) ) {
				$is_memcache = true;
				foreach ( $wp_object_cache->mc as $bucket ) {
					if ( ! is_a( $bucket, 'Memcache' ) )
						$is_memcache = false;
				}

				if ( $is_memcache )
					$message = 'Memcache';

			// Test for Xcache object cache (http://plugins.svn.wordpress.org/xcache/trunk/object-cache.php)
			} elseif ( is_a( $wp_object_cache, 'XCache_Object_Cache' ) ) {
				$message = 'Xcache';

			// Test for WinCache object cache (http://wordpress.org/extend/plugins/wincache-object-cache-backend/)
			} elseif ( class_exists( 'WinCache_Object_Cache' ) ) {
				$message = 'WinCache';

			// Test for APC object cache (http://wordpress.org/extend/plugins/apc/)
			} elseif ( class_exists( 'APC_Object_Cache' ) ) {
				$message = 'APC';

			// Test for Redis Object Cache (https://github.com/alleyinteractive/wp-redis)
			} elseif ( isset( $wp_object_cache->redis ) && is_a( $wp_object_cache->redis, 'Redis' ) ) {
				$message = 'Redis';

			} else {
				$message = 'Unknown';
			}
		} else {
			$message = 'Default';
		}

		WP_CLI::line( $message );
	}
}

WP_CLI::add_command( 'cache', 'Cache_Command' );

