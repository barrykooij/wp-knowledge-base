<?php

namespace WPKB\Rating;

use WPDB;

class UpgradeRoutine {

	/**
	 * @var string
	 */
	public $from_version = '';

	/**
	 * @var string
	 */
	public $to_version = '';

	/**
	 * @var WPDB
	 */
	protected $db;

	/**
	 * @param $from_version
	 * @param $to_version
	 */
	public function __construct( $from_version, $to_version ) {
		$this->from_version = $from_version;
		$this->to_version = $to_version;
		$this->db = $GLOBALS['wpdb'];
	}

	/**
	 *
	 */
	public function run() {

		if( ! $this->at_version( '1.1' ) ) {
			$this->create_ratings_table();
			$this->migrate_ratings_from_post_meta();
		}

		update_option( 'wpkb_version', $this->to_version );
	}

	/**
	 * @param $version
	 *
	 * @return bool
	 */
	protected function at_version( $version ) {
		return version_compare( $this->from_version, $version, '>=' );
	}

	/**
	 *
	 */
	protected function create_ratings_table() {
		$sql = sprintf( "CREATE TABLE IF NOT EXISTS %s (
		  `ID` BIGINT(20) NOT NULL AUTO_INCREMENT,
		  `post_ID` BIGINT(20) NOT NULL,
		  `ip` VARCHAR(255) DEFAULT '',
		  `rating` TINYINT(2) NOT NULL,
		  `message` VARCHAR(255) DEFAULT '',
		  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY  (ID)
	) %s", $this->db->prefix . 'wpkb_post_ratings', $GLOBALS['charset_collate'] );

		$this->db->query( $sql );
	}

	/**
	 *
	 */
	protected function migrate_ratings_from_post_meta() {

	}

}