<?php

namespace ICodeWP\EntityManager;

use ICodeWP\Controller\ControllerInterface;
use ICodeWP\Repository\RepositoryInterface;

/**
 * Interface for an entity manager.
 *
 * An entity manager is a class defining an entity type and managing its entities
 * (such as a post, term, user or any type of custom data).
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @subpackage EntityManager
 * @author     freepius
 */
interface EntityManagerInterface {
	/**
	 * Get the controller associated with the entity manager.
	 */
	public function controller(): ControllerInterface;

	/**
	 * Get the repository associated with the entity manager.
	 */
	public function repository(): RepositoryInterface;

	/**
	 * Return the type of the managed entities. Eg: post, term, user, log...
	 * It could be used by WordPress for caching, metadata, hooks, etc.
	 */
	public function type(): string;

	/**
	 * Return the **full unique name** of the entity manager,
	 * including a potential plugin/theme prefix.
	 */
	public function __toString(): string;

	/**
	 * Return the **short name** of the entity.
	 * It could be used by the framework and its users.
	 */
	public function name(): string;

	/**
	 * Determine if a given entity is managed.
	 *
	 * @param mixed $entity  An entity, or any data allowing to identify one.
	 */
	public function managed( $entity ): bool;
}
