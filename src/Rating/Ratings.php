<?php

namespace WPKB\Rating;

use WPDB;

class Ratings {

	/**
	 * @var WPDB
	 */
	protected $db;

	/**
	 * @var string
	 */
	protected $table_name = 'wpkb_post_ratings';

	public function __construct() {
		$this->db = $GLOBALS['wpdb'];
		$this->table_name = $this->db->prefix . $this->table_name;
	}

	/**
	 * @param $post_ID
	 *`
	 * @return false|int
	 */
	public function average( $post_ID ) {
		$this->db->show_errors();
		$sql = 	sprintf( 'SELECT AVG(`rating`) FROM `%s` WHERE `post_ID` = %d LIMIT 1', $this->table_name, $post_ID );

		return round( $this->db->get_var( $sql ), 2 );
	}

	/**
	 * @param $post_ID
	 * @param $ip
	 *
	 * @return false|int
	 */
	public function delete_by_ip( $post_ID, $ip ) {
		return $this->db->delete( $this->table_name, array(
				'post_ID' => $post_ID,
				'ip' => $ip
			)
		);
	}

	/**
	 * @param Rating $rating
	 *
	 * @return false|int
	 */
	public function save( Rating $rating ) {
		$id = $this->db->insert( $this->table_name, $rating->toArray() );

		if( $id > 0 ) {
			$rating->ID = $this->db->insert_id;
			return true;
		}

		return false;
	}
}