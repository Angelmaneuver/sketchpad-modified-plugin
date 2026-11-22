<?php
/**
 * Enum Checkbox values.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

use SketchpadModifiedPlugin\Flag;

enum CheckBoxValue: string {
	case False = Flag::OFF;
	case True  = Flag::ON;
}
