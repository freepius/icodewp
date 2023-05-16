<?php

namespace ICodeWP;

use ICodeWP\EntityManager\PostTypeInterface;
use ICodeWP\EntityManager\TaxonomyInterface;
use ICodeWP\Service\Assets;
use ICodeWP\Service\Template;
use ICodeWP\Service\UserMessages;

/**
 * Default implementation of the `KernelInterface`.
 * You can directly use this class as kernel of your app (or plugin, or theme).
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @author     freepius
 */
class Kernel implements KernelInterface {
	protected readonly string $path;
	protected array $parameters = array();
	protected array $post_types = array();
	protected array $taxonomies = array();

	public function __construct( string $file ) {
		$this->path = dirname( $file );

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_init', array( $this, 'init_admin' ) );
	}

	public function type(): string {
		switch ( basename( dirname( $this->path() ) ) ) {
			case 'plugins':
				return 'plugin';
			case 'themes':
				return 'theme';
			default:
				return 'app';
		}
	}

	public function directory(): string {
		return basename( $this->path() );
	}

	public function path(): string {
		return $this->path;
	}

	public function url(): string {
		switch ( $this->type() ) {
			case 'plugin':
				return plugin_dir_url( $this->path() );
			case 'theme':
				return get_theme_file_uri( $this->path() );
			default:
				return site_url( $this->path() );
		}
	}

	public function namespace(): string {
		static $namespace;

		return $namespace ??=
			// Basic CamelCase of the directory name.
			// @todo Use a better algorithm, for example through the String Symfony component.
			str_replace( ' ', '', ucwords( str_replace( '-', ' ', $this->directory() ) ) );
	}

	public function prefix(): string {
		return strtolower( $this->directory() ) . '_';
	}

	public function textdomain(): string {
		return strtolower( $this->directory() );
	}

	public function version(): string {
		return '1.0.0';
	}

	public function parameter( string $name, $new_value = null, bool $overwrite = false ): mixed {
		if ( ! isset( $this->parameters[ $name ] ) || $overwrite ) {
			$this->parameters[ $name ] = $new_value;
		}

		return $this->parameters[ $name ];
	}

	public function parameters( array $new_values = array(), bool $overwrite = false ): array {
		if ( ! empty( $new_values ) ) {
			foreach ( $new_values as $name => $value ) {
				$this->parameter( $name, $value, $overwrite );
			}
		}

		return $this->parameters;
	}

	public function post_type( string $name ): ?PostTypeInterface {
		// Get first by short name, then by full name.
		return $this->post_types[ $name ] ?? get_post_type_object( $name )->em ?? null;
	}

	public function taxonomy( string $name ): ?TaxonomyInterface {
		// Get first by short name, then by full name.
		return $this->taxonomies[ $name ] ?? get_taxonomy( $name )->em ?? null;
	}

	public function post_types( string ...$names ): array {
		return array() === $names
			? $this->post_types
			: array_filter(
				$this->post_types,
				fn ( string $name ): bool => in_array( $name, $names, true ),
				ARRAY_FILTER_USE_KEY
			);
	}

	public function taxonomies( string ...$names ): array {
		return array() === $names
			? $this->taxonomies
			: array_filter(
				$this->taxonomies,
				fn ( string $name ): bool => in_array( $name, $names, true ),
				ARRAY_FILTER_USE_KEY
			);
	}

	public function init(): void {
		$this->load_textdomains();
		$this->load_post_types();
		$this->load_taxonomies();
	}

	public function init_admin(): void {}

	/**
	 * Loads the internationalization files.
	 */
	protected function load_textdomains(): void {
		switch ( $this->type() ) {
			case 'plugin':
				load_plugin_textdomain( $this->textdomain(), false, $this->directory() . '/languages/' );
				break;
			case 'theme':
				load_theme_textdomain( $this->textdomain(), $this->path() . '/languages/' );
				break;
			default:
				load_textdomain( $this->textdomain(), $this->path() . '/languages/' );
		}
	}

	/**
	 * Loads post types and related objects (repository, controller, etc).
	 */
	protected function load_post_types(): void {
		foreach ( glob( $this->path() . '/src/EntityManager/PostType/*.php' ) as $file ) {
			$name = basename( $file, '.php' );
			$fqcn = "\\{$this->namespace()}\\EntityManager\\PostType\\$name";

			$this->post_types[ $name ] = new $fqcn( $this );
		}
	}

	/**
	 * Loads taxonomies and related objects (repository, controller, etc).
	 */
	protected function load_taxonomies(): void {
		foreach ( glob( $this->path() . '/src/EntityManager/Taxonomy/*.php' ) as $file ) {
			$name = basename( $file, '.php' );
			$fqcn = "\\{$this->namespace()}\\EntityManager\\Taxonomy\\$name";

			$this->taxonomies[ $name ] = new $fqcn( $this );
		}
	}

	public function assets(): Assets {
		static $assets;
		return $assets ??= new Assets(
			$this->path() . '/assets',
			$this->url() . '/assets',
			$this->version()
		);
	}

	public function template(): Template {
		static $template;
		return $template ??= new Template( $this->path() . 'templates/' );
	}

	public function user_messages(): UserMessages {
		static $user_messages;
		return $user_messages ??= new UserMessages( $this->prefix() . 'user_messages' );
	}
}
