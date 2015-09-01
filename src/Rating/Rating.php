<?php
namespace WPKB\Rating;

class Rating {

	public $ID = 0;

	/**
	 * @var int
	 */
	public $rating = 1;

	/**
	 * @var int
	 */
	public $post_ID;

	/**
	 * @var string
	 */
	public $ip;

	/**
	 * @var int
	 */
	public $timestamp;

	/**
	 * @var string
	 */
	public $message = '';

	/**
	 * @param int $post_ID
	 * @param      $rating
	 * @param string $message
	 * @param null $ip
	 * @param null $timestamp
	 */
	public function __construct( $post_ID, $rating, $message = '', $ip = null, $timestamp = null ) {
		$this->post_ID = $post_ID;
		$this->rating = $rating;
		$this->message = $message;
		$this->ip = $ip;
		$this->timestamp = $timestamp;

		if( $timestamp === null ) {
			$this->timestamp = date( 'Y-m-d H:i:s' );
		}

	}



	/**
	 * @param $array
	 *
	 * @return Rating
	 */
	public static function fromArray( $array ) {
		$object = new Rating( $array['post_ID'], $array['rating'] );

		// optional keys
		$keys = array( 'ID', 'message', 'ip', 'timestamp' );
		foreach( $keys as $key ) {
			if( ! empty( $array[ $key ] ) ) {
				$object->{$key} = $array[ $key ];
			}
		}

		return $object;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$data =  array(
			'post_ID' => $this->post_ID,
			'ip' => $this->ip,
			'rating' => $this->rating,
			'timestamp' => $this->timestamp,
			'message' => $this->message
		);

		if( ! empty( $this->ID ) ) {
			$data['ID'] = $this->ID;
		}

		return $data;
	}
}