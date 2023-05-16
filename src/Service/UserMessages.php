<?php

namespace ICodeWP\Service;

/**
 * Functionalities to manage messages intended for users
 * (such as error or success messages, notices, etc.)
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @author     freepius
 */
class UserMessages {
	/**
	 * @var array User messages.
	 */
	protected array $messages;

	/**
	 * @var string Key used to store messages from the user's current request to next.
	 */
	protected readonly string $store_key;

	public function __construct( string $store_key ) {
		$this->store_key = $store_key;
		$this->store_pop();
		add_filter( 'wp_redirect', array( $this, 'store_before_redirect' ), 9999 );
	}

	/**
	 * Get message(s) for a given key, or all messages if key is null.
	 *
	 * @param string|null $key  Key identifying where to get the message.
	 *                          The key can be compound, using the dot `.` character.
	 *                          In that case, each part is a hierarchical level of the message.
	 *
	 * @return mixed|array<mixed>|array<array>|null Return:
	 * - a message: after using `set()`
	 * - an array of messages: after using `add()`
	 * - an array of arrays (of arrays...) of messages: when the key points to a non-final level
	 * - all messages if key is null
	 * - or *null* if nothing was found for the key.
	 */
	public function get( ?string $key = null ) {
		return null === $key ? $this->messages : $this->get_last_level_ref( $key );
	}

	/**
	 * Add a message to a given key.
	 *
	 * @param string $key      Key identifying where to add the message.
	 *                         The key can be compound, using the dot `.` character.
	 *                         In that case, each part is a hierarchical level of the message.
	 * @param mixed  $message  Anything that can be serialized.
	 */
	public function add( string $key, $message ): void {
		$level   = &$this->get_last_level_ref( $key );
		$level[] = $message;
	}

	/**
	 * Set a message for a given key.
	 *
	 * @param string $key      Key identifying where to set the message.
	 *                         The key can be compound, using the dot `.` character.
	 *                         In that case, each part is a hierarchical level of the message.
	 * @param mixed  $message  Anything that can be serialized.
	 */
	public function set( string $key, $message ): void {
		$level = &$this->get_last_level_ref( $key );
		$level = $message;
	}

	/**
	 * Store user messages before WordPress does an HTTP redirection.
	 */
	public function store_before_redirect( string $location ): string {
		$this->store_push();
		return $location;
	}

	/**
	 * Store user messages using WordPress Transients API.
	 */
	protected function store_push(): void {
		set_transient( $this->store_key(), $this->messages, 2 * 60 );
	}

	/**
	 * Pop user messages from the store (ie retrieve and remove them).
	 */
	protected function store_pop(): void {
		$this->messages = get_transient( $this->store_key() ) ?: array();
		delete_transient( $this->store_key() );
	}

	/**
	 * Full key to identify user messages in the storage.
	 */
	protected function store_key(): string {
		return $this->store_key . '-' . get_current_user_id();
	}

	/**
	 * Get a reference to the last level of a compound key.
	 */
	protected function &get_last_level_ref( string $key ) {
		$level = &$this->messages;

		foreach ( explode( '.', $key ) as $key ) {
			$level = &$level[ $key ];
		}

		return $level;
	}
}
