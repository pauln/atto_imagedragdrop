<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Atto imagedragdrop plugin install script.
 *
 * @package    atto_imagedragdrop
 * @copyright  2014 Paul Nicholls
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Add the imagedragdrop plugin to the Atto toolbar config if the image plugin is enabled.
 *
 * @return bool
 */
function xmldb_atto_imagedragdrop_install() {
    global $CFG;

    $toolbar = get_config('editor_atto', 'toolbar');
    $pos = stristr($toolbar, 'imagedragdrop');

    // Check the Moodle version; we shouldn't install if we're not on 2.7 or 2.8.
    $prefix = intval(substr($CFG->version, 0, 8));
    if($prefix === "20140527" || $prefix === "20141110") {

        // Install as normal.
        if (!$pos) {
            // Add imagedragdrop after image plugin.
            $toolbar = preg_replace('/(.+?=.+?)image($|\s|,)/m', '$1image, imagedragdrop$2', $toolbar, 1);
        }

    } else {

        // Not on 2.7 or 2.8 - remove usage from toolbar config if it's present.
        if ($pos) {
            $toolbar = preg_replace('/(.+?=.+?)imagedragdrop($|\s|,)/m', '$1', $toolbar, 1);
        }

    }

    set_config('toolbar', $toolbar, 'editor_atto');
    return true;
}
