<?php

namespace ICodeWP\Repository\Taxonomy;

/**
 * Repository interface for a WordPress taxonomy.
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @subpackage Repository\Taxonomy
 * @author     freepius
 */
interface RepositoryInterface extends \ICodeWP\Repository\RepositoryInterface {
	/**
	 * Get taxonomy terms based on eventual filters.
	 * By default, get all terms.
	 *
	 * @param array $args  Array of arguments accepted by `\WP_Term_Query::__construct()`.
	 * @return \WP_Term[]
	 */
	public function find( array $args = array() ): array;

	/**
	 * Get one taxonomy term based on eventual filters.
	 *
	 * @param array $args  Array of arguments accepted by `\WP_Term_Query::__construct()`.
	 * @return \WP_Term|null
	 */
	public function find_one( array $args = array() ): ?\WP_Term;

	/**
	 * Get the taxonomy terms for a given WordPress post.
	 *
	 * @param \WP_Post $post  The post for which get the taxonomy terms.
	 * @return \WP_Term[]
	 */
	public function find_by_post( \WP_Post $post ): array;

	/**
	 * Get the taxonomy unique term for a given WordPress post.
	 * If several exist for this couple *taxonomy-post*, get the first one.
	 * If none exists, return null.
	 *
	 * @param \WP_Post $post  The post for which get the taxonomy unique term (if one exists).
	 * @return \WP_Term|null
	 */
	public function find_one_by_post( \WP_Post $post ): ?\WP_Term;

	/**
	 * Suggest terms given a context.
	 *
	 * @param mixed $context  A context helping to suggest terms.
	 * @return \WP_Term[]
	 */
	public function suggest( $context ): array;

	/**
	 * Insert into taxonomy some initialization terms.
	 * This function should only be called once, for example when activating the plugin.
	 * Of course, the taxonomy must already exist.
	 */
	public function insert_init_terms(): void;

	/**
	 * Delete all the taxonomy terms (even if taxonomy is not registered anymore).
	 */
	public function delete_terms(): void;

	/**
	 * Return the count term for a given post type.
	 *
	 * @param int|\WP_Term $term       The term we want to count occurrences for.
	 * @param string       $post_type  The WordPress name of a post type.
	 */
	public function count_by_post_type( $term, string $post_type ): int;
}
