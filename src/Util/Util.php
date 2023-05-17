<?php

namespace ICodeWP\Util;

/**
 * Some useful functionalities in bulk.
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @subpackage Util
 * @author     freepius
 */
class Util {
	/**
	 * Flatten HTML attributes, from array to string.
	 *
	 * @param array $attrs  HTML attributes (as keys) ant their value.
	 * @return string       Return **sanitized** HTML attributes as string.
	 */
	public static function flatten_html_attrs( array $attrs ): string {
		return implode(
			' ',
			array_map(
				fn ( string $key ): string => sprintf( '%s="%s"', sanitize_key( $key ), esc_attr( $attrs[ $key ] ) ),
				array_keys( $attrs )
			)
		);
	}

	/**
	 * Flatten / simplify a string to be easier to compare.
	 */
	public static function flatten_string( string $str ): string {
		static $trans;
		$trans ??= \Transliterator::create( 'NFD; [:Nonspacing Mark:] Remove; NFC' );

		$str = mb_strtolower( $str );                    // Make lowercase.
		$str = $trans->transliterate( $str );            // Remove accents.
		$str = preg_replace( '/[^a-z0-9]/', ' ', $str ); // Keep only letters and numbers.
		$str = preg_replace( '/ +/', ' ', $str );        // Keep only one contiguous space.
		$str = trim( $str );

		return $str;
	}
}
