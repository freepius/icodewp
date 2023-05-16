<?php

namespace ICodeWP\Service;

/**
 * Functionalities to manage the app assets.
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @author     freepius
 */
class Assets {
	/**
	 * @param string $path        Path to the assets directory.
	 * @param string $url         Url to the assets directory.
	 * @param string $version     Version of the assets.
	 * @param string $images_dir  Directory containing the images.
	 * @param string $build_dir   Directory containing the builded assets.
	 */
	public function __construct(
		protected readonly string $path,
		protected readonly string $url,
		protected readonly string $version = '',
		protected readonly string $images_dir = 'images',
		protected readonly string $build_dir = 'build'
	) {
	}

	/**
	 * Return the full versionized url of an image.
	 */
	public function img( string $image ): string {
		return $this->versionize( "$this->url/$this->images_dir/$image" );
	}

	/**
	 * Enqueue a CSS file.
	 *
	 * @param string $file  Name of the file (without extension).
	 * @param array  $deps  Dependencies.
	 */
	public function enqueue_css( string $file, array $deps = array() ): void {
		list(, $version, $url) = $this->file_metadata( $file );
		wp_enqueue_style( $file, "$url.css", $deps, $version );
	}

	/**
	 * Enqueue a JS file.
	 *
	 * @param string $file  Name of the file (without extension).
	 * @param array  $deps  Dependencies.
	 */
	public function enqueue_js( string $file, array $deps = array() ): void {
		list($more_deps, $version, $url) = $this->file_metadata( $file );
		wp_enqueue_script( $file, "$url.js", array_merge( $deps, $more_deps ), $version, true );
	}

	/**
	 * Enqueue a CSS and a JS file.
	 *
	 * @param string $file      Name of the file (without extension).
	 * @param array  $css_deps  CSS dependencies.
	 * @param array  $js_deps   JS dependencies.
	 */
	public function enqueue_css_js( string $file, array $css_deps = array(), array $js_deps = array() ): void {
		$this->enqueue_css( $file, $css_deps );
		$this->enqueue_js( $file, $js_deps );
	}

	/**
	 * Return the metadata of a file (loaded from its `asset.php` file).
	 */
	protected function file_metadata( string $file ): array {
		$asset_file = "$this->path/$this->build_dir/$file.asset.php";

		return array_values(
			( file_exists( $asset_file ) ? (array) include $asset_file : array() )
			+ array(
				'dependencies' => array(),
				'version'      => $this->version,
				'url'          => "$this->url/$this->build_dir/$file",
			)
		);
	}

	/**
	 * Versionize the given file.
	 */
	protected function versionize( string $file ): string {
		return $file . ( $this->version ? "?ver=$this->version" : '' );
	}
}
