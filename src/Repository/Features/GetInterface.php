<?php

namespace ICodeWP\Repository\Feature;

/**
 * Interface for a repository implementing the get feature.
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @subpackage Repository\Feature
 * @author     freepius
 */
interface GetInterface {
	/**
	 * Get an entity given any data allowing to uniquely identify it.
	 *
	 * @param mixed             $data    Identification data of an entity.
	 * @param bool|string|array $fields  Entity field names.
	 *   - If `true`: retrieve all fields.
	 *   - If `false`: retrieve no fields (only the WordPress native ones).
	 *   - If other falsey value: retrieve the default fields.
	 *   - Otherwise: `wp_parse_list()` is used to parse `$fields` parameter.
	 *
	 * @return object|null  Return the entity, or null if none was found.
	 */
	public function get( $data, $fields = array() ): ?object;
}
