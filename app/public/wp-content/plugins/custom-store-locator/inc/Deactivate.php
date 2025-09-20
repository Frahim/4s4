<?php
/**
 * @package  Custom_Store_Locator
 */
namespace CSLInc;
class Deactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
	}
}