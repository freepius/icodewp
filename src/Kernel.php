<?php

namespace ICodeWP;

/**
 * Default implementation of the `KernelInterface`.
 * You can directly use this class as kernel of your app (or plugin, or theme).
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @author     freepius
 */
class Kernel implements KernelInterface {
	use KernelTrait\Container\Parameters;
	use KernelTrait\Container\PostTypes;
	use KernelTrait\Container\Taxonomies;
	use KernelTrait\Services;

	protected readonly string $path;

	public function __construct( string $file ) {
		$this->path = dirname( $file );

		add_action( 'init', fn () => $this->init() );
		add_action( 'admin_init', fn () => $this->admin_init() );
	}

	public function type(): string {
		static $type;
		return $type ??= match ( basename( dirname( $this->path() ) ) ) {
			'plugins' => 'plugin',
			'themes'  => 'theme',
			default   => 'app',
		};
	}

	public function directory(): string {
		return basename( $this->path() );
	}

	public function path(): string {
		return $this->path;
	}

	public function url(): string {
		static $url;
		return $url ??= match ( $this->type() ) {
			'plugin' => plugin_dir_url( $this->path() ),
			'theme'  => get_theme_file_uri( $this->path() ),
			default  => site_url( $this->path() ),
		};
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

	protected function init(): void {
		$this->load_textdomains();
		$this->load_post_types();
		$this->load_taxonomies();
	}

	protected function admin_init(): void {
	}

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
}
