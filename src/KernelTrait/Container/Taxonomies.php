<?php

namespace ICodeWP\KernelTrait\Container;

use ICodeWP\EntityManager\TaxonomyInterface;

/**
 * Implements a taxonomies container and a way to get them.
 */
trait Taxonomies {
	protected array $taxonomies = array();

	/**
	 * Return a taxonomy instance by its name, or null if it doesn't exist.
	 *
	 * @param string $name  Name of taxonomy to get (can be short or full name, eg: 'Category' or 'myapp_Category').
	 * @return \ICodeWP\EntityManager\TaxonomyInterface|null
	 */
	public function taxonomy( string $name ): ?TaxonomyInterface {
		// Get first by short name, then by full name.
		return $this->taxonomies[ $name ] ?? get_taxonomy( $name )->icwp_em ?? null;
	}

	/**
	 * Return some or all taxonomies.
	 *
	 * @param string ...$names  Names of taxonomies to get, or none to get all.
	 * @return \ICodeWP\EntityManager\TaxonomyInterface[]
	 */
	public function taxonomies( string ...$names ): array {
		return array() === $names
			? $this->taxonomies
			: array_filter(
				$this->taxonomies,
				fn ( string $name ): bool => in_array( $name, $names, true ),
				ARRAY_FILTER_USE_KEY
			);
	}
}
