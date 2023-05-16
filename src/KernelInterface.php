<?php

namespace ICodeWP;

use ICodeWP\EntityManager\PostTypeInterface;
use ICodeWP\EntityManager\TaxonomyInterface;
use ICodeWP\Service\Template;
use ICodeWP\Service\UserMessages;

/**
 * Interface for the kernel class of an app (or plugin, or theme) builds with ICodeWP.
 * The base class `Kernel` provides a default implementation of this interface.
 *
 * A such kernel class should be used to :
 * - define the app prefix, textdomain, version, api namespaces, parameters, etc.
 * - provide a way to initialize the app (textdomain, admin, front-end, API, services, etc)
 * - serve as DIC (Dependency Injection Container) for the all app
 *
 * @since   1.0.0
 * @package ICodeWP
 * @author  freepius
 * @see     Kernel
 */
interface KernelInterface {
	/**
	 * Return the app type (plugin, theme, service, api, etc.)
	 */
	public function type(): string;

	/**
	 * Return the app absolute path.
	 */
	public function path(): string;

	/**
	 * Return the app directory name.
	 */
	public function directory(): string;

	/**
	 * Return the app base namespace.
	 */
	public function namespace(): string;

	/**
	 * Return a string used to prefix everything related to the app
	 * (post types, taxonomies, cache or transient keys, etc).
	 */
	public function prefix(): string;

	/**
	 * Return the app textdomain.
	 */
	public function textdomain(): string;

	/**
	 * Return the app version.
	 */
	public function version(): string;

	/**
	 * Return a parameter value, or set it if it doesn't exist yet.
	 *
	 * @param string $name       Name of parameter to get or set.
	 * @param mixed  $new_value  New value to set if the parameter doesn't exist yet.
	 * @param bool   $overwrite  Whether to overwrite the parameter if it already exists.
	 *
	 * @return mixed|null
	 */
	public function parameter( string $name, $new_value = null, bool $overwrite = false ): mixed;

	/**
	 * Return all parameters, or set them if they don't exist yet.
	 *
	 * @param array   $new_values New values to set if the parameters don't exist yet.
	 * @param boolean $overwrite  Whether to overwrite the parameters if they already exist.
	 *
	 * @return array
	 */
	public function parameters( array $new_values = array(), bool $overwrite = false ): array;

	/**
	 * Return a post type instance by its name, or null if it doesn't exist.
	 *
	 * @param string $name  Name of post type to get (can be short or full name, eg: 'Document' or 'myapp_Document').
	 * @return \ICodeWP\EntityManager\PostTypeInterface|null
	 */
	public function post_type( string $name ): ?PostTypeInterface;

	/**
	 * Return a taxonomy instance by its name, or null if it doesn't exist.
	 *
	 * @param string $name  Name of taxonomy to get (can be short or full name, eg: 'Date' or 'myapp_Date').
	 * @return \ICodeWP\EntityManager\TaxonomyInterface|null
	 */
	public function taxonomy( string $name ): ?TaxonomyInterface;

	/**
	 * Return some or all post types.
	 *
	 * @param string ...$names  Names of post types to get, or none to get all.
	 * @return \ICodeWP\EntityManager\PostTypeInterface[]
	 */
	public function post_types( string ...$names ): array;

	/**
	 * Return some or all taxonomies.
	 *
	 * @param string ...$names  Names of taxonomies to get, or none to get all.
	 * @return \ICodeWP\EntityManager\TaxonomyInterface[]
	 */
	public function taxonomies( string ...$names ): array;

	/*****
	 * Services of the DIC.
	 *****/

	/**
	 * Return the assets manager.
	 *
	 * @return \ICodeWP\Service\Assets
	 */
	// public function assets(): Assets;

	/**
	 * Return the template manager.
	 *
	 * @return \ICodeWP\Service\Template
	 */
	public function template(): Template;

	/**
	 * Return the user messages manager.
	 *
	 * @return \ICodeWP\Service\UserMessages
	 */
	public function user_messages(): UserMessages;
}
