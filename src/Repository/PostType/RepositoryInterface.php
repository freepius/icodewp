<?php

namespace ICodeWP\Repository\PostType;

use ICodeWP\Repository\EntityRepositoryInterface;

/**
 * Repository interface for a WordPress post type.
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @subpackage Repository\PostType
 * @author     freepius
 */
interface RepositoryInterface extends \ICodeWP\Repository\RepositoryInterface {
	/**
	 * Get posts based on eventual filters.
	 * By default, get all posts of the post type.
	 *
	 * @param array             $args  Array of arguments accepted by `\WP_Query::__construct()`.
	 * @param bool|string|array $fields  Post field names.
	 *   - If `true`: retrieve all fields.
	 *   - If `false`: retrieve no fields (only the WordPress native ones).
	 *   - If other falsey value: retrieve the default fields.
	 *   - Otherwise: `wp_parse_list()` is used to parse `$fields` parameter.
	 *
	 * @return \WP_Post[]
	 */
	public function find( array $args = array(), $fields = array() ): array;

	/**
	 * Retrieves post data given a post ID or post object.
	 *
	 * @param int|\WP_Post      $data    Post ID or post object.
	 * @param bool|string|array $fields  Post field names.
	 *   - If `true`: retrieve all fields.
	 *   - If `false`: retrieve no fields (only the WordPress native ones).
	 *   - If other falsey value: retrieve the default fields.
	 *   - Otherwise: `wp_parse_list()` is used to parse `$fields` parameter.
	 *
	 * @return \WP_Post|null
	 */
	public function find_one( $data, $fields = array() ): ?\WP_Post;

	/**
	 * Suggest posts given a context.
	 *
	 * @param mixed $context  A context helping to suggest posts.
	 * @return \WP_Post[]
	 */
	public function suggest( $context ): array;

	/**
	 * Return all the ancestors of a given post.
	 *
	 * @return \WP_Post[]
	 */
	public function get_ancestors( \WP_Post $post ): array;

	/**
	 * Return all the children of a given post.
	 *
	 * @return \WP_Post[]
	 */
	public function get_children( \WP_Post $post ): array;

	/**
	 * Return the siblings of a given post, ie posts having the same parent.
	 *
	 * @return \WP_Post[]
	 */
	public function get_siblings( \WP_Post $post ): array;

	/**
	 * Delete all posts of the post type (even if post type is not registered anymore).
	 */
	public function delete_posts(): void;
}
