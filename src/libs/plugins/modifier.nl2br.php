<?php
/**
 * Smarty plugin
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @copyright  2013 Kaoru Ishikura
 * @author     Kaoru Ishikura
 * @package    Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty insert br tags modifier plugin
 *
 * Type:     modifier<br>
 * Name:     nl2br<br>
 * Purpose:  gets html string including automatically inserted br tags<br>
 * Examples: {$string|nl2br}
 *
 * @param string  $string html string
 * @param boolean $xhtml  xhtml compatible line breaks or not
 * @return string returns html string including automatically inserted br tags
 */
function smarty_modifier_nl2br($string, $xhtml = false)
{
    $tag    = ($xhtml) ? '<br />' : '<br>';
    $string = str_replace(array("\x0D\x0A", "\x0D"), "\x0A", $string);

    // Replace line breaks to space in tags
    $pattern = "/<[^\"'<>]*(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*(?:>|(?=<)|\z)/isu";
    $string  = preg_replace_callback(
        $pattern,
        create_function('$matches', 'return str_replace("\x0A", "\x20", $matches[0]);'),
        $string
    );

    // Replace line breaks to br tags
    $pattern = "/(?<![>\x09\x20])([\x09\x20]*\x0A[\x09\x0A\x20]*)(?![<\x09\x0A\x20])/isu";
    $string  = preg_replace_callback(
        $pattern,
        create_function('$matches', 'return str_replace("\x0A", "' . $tag . '\x0A", $matches[0]);'),
        $string
    );

    // Remove br tags in between specified tags
    $pattern = "/<(pre|script|style|textarea)(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z).*?"
             . "<\/\\1(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z)/isu";
    $string  = preg_replace_callback(
        $pattern,
        create_function('$matches', 'return str_replace("' . $tag . '\x0A", "\x0A", $matches[0]);'),
        $string
    );

    return $string;
}

?>