<?php

namespace ICodeWP\Util;

/**
 * Some useful functionalities on dates and times.
 *
 * @since      1.0.0
 * @package    ICodeWP
 * @subpackage Util
 * @author     freepius
 */
class  DateTime {
	/**
	 * Determine if a datetime as string has the correct format.
	 *
	 * @param string|null $datetime  Datetime to validate.
	 * @param string      $format    Datetime format to check.
	 * @return boolean
	 */
	public static function is_valid( ?string $datetime, string $format ): ?string {
		$object = \DateTime::createFromFormat( $format, $datetime );
		return false !== $object && $datetime === $object->format( 'Y-m-d' );
	}
}
