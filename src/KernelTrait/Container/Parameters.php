<?php

namespace ICodeWP\KernelTrait\Container;

/**
 * Implements a parameters container and a way to get/set them.
 */
trait Parameters {
	protected array $parameters = array();

	/**
	 * Return a parameter value, or set it if it doesn't exist yet.
	 *
	 * @param string $name       Name of parameter to get or set.
	 * @param mixed  $new_value  New value to set if the parameter doesn't exist yet.
	 * @param bool   $overwrite  Whether to overwrite the parameter if it already exists.
	 *
	 * @return mixed|null
	 */
	public function parameter( string $name, $new_value = null, bool $overwrite = false ): mixed {
		if ( ! isset( $this->parameters[ $name ] ) || $overwrite ) {
			$this->parameters[ $name ] = $new_value;
		}

		return $this->parameters[ $name ];
	}

	/**
	 * Return all parameters, or set them if they don't exist yet.
	 *
	 * @param array   $new_values New values to set if the parameters don't exist yet.
	 * @param boolean $overwrite  Whether to overwrite the parameters if they already exist.
	 *
	 * @return array
	 */
	public function parameters( array $new_values = array(), bool $overwrite = false ): array {
		if ( ! empty( $new_values ) ) {
			foreach ( $new_values as $name => $value ) {
				$this->parameter( $name, $value, $overwrite );
			}
		}

		return $this->parameters;
	}
}
