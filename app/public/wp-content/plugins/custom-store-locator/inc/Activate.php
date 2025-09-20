<?php
/**
 * @package  Custom_Store_Locator
 */
namespace CSLInc;
class Activate
{
	public static function activate() {
		flush_rewrite_rules();
	}
}