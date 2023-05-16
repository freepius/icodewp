<?php

namespace ICodeWP\Service;

/**
 * Functionalities to manage and render the app templates.
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @author     freepius
 */
class Template {
	/**
	 * @param string $path Path to the templates directory.
	 */
	public function __construct(
		protected readonly string $path
	) {

	}

	/**
	 * Print a php template.
	 *
	 * @param string          $template  Template name, commonly the file name without `.php` extension.
	 * @param array|\stdClass $vars      Variables that the template has access.
	 *
	 * @return mixed If template returns a string, array, object... this value can be used by the caller.
	 * For example, it can print nothing but return a string instead. It can also print and return.
	 */
	public function render( string $template, $vars = array() ) {
		extract( (array) $vars ); // phpcs:ignore WordPress.PHP.DontExtract
		return include $tis->path . $template . '.php';
	}

	/**
	 * Render a php template and return its content as a string.
	 * Potential return value of template is ignored.
	 *
	 * @param string          $template  Template name, commonly the file name without `.php` extension.
	 * @param array|\stdClass $vars      Variables that the template has access.
	 * @return string
	 */
	public function render_as_string( string $template, $vars = array() ): string {
		ob_start();
			$this->render( $template, $vars );
			$rendered = ob_get_contents();
		ob_end_clean();

		return $rendered;
	}
}
