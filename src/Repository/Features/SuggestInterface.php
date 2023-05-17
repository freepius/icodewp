<?php

namespace ICodeWP\Repository\Feature;

/**
 * Interface for a repository implementing the suggest feature.
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @subpackage Repository\Feature
 * @author     freepius
 */
interface SuggestInterface {
	/**
	 * Suggest entities given a context.
	 *
	 * @param mixed $context  A context helping to suggest entities.
	 * @return array  An array of suggested entities.
	 */
	public function suggest( $context ): array;
}
