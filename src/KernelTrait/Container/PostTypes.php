<?php

namespace ICodeWP\KernelTrait\Container;

use ICodeWP\EntityManager\PostTypeInterface;

/**
 * Implements a post types container and a way to get them.
 */
trait PostTypes {
	protected array $post_types = array();

	/**
	 * Return a post type instance by its name, or null if it doesn't exist.
	 *
	 * @param string $name  Name of post type to get (can be short or full name, eg: 'Document' or 'myapp_Document').
	 * @return \ICodeWP\EntityManager\PostTypeInterface|null
	 */
	public function post_type( string $name ): ?PostTypeInterface {
		// Get first by short name, then by full name.
		return $this->post_types[ $name ] ?? get_post_type_object( $name )->icwp_em ?? null;
	}

	/**
	 * Return some or all post types.
	 *
	 * @param string ...$names  Names of post types to get, or none to get all.
	 * @return \ICodeWP\EntityManager\PostTypeInterface[]
	 */
	public function post_types( string ...$names ): array {
		return array() === $names
			? $this->post_types
			: array_filter(
				$this->post_types,
				fn ( string $name ): bool => in_array( $name, $names, true ),
				ARRAY_FILTER_USE_KEY
			);
	}
}
