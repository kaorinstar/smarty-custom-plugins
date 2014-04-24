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
 * @copyright  2014 Kaoru Ishikura
 * @author     Kaoru Ishikura
 * @package    Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty escape JSON special characters modifier plugin
 *
 * Type:     modifier<br>
 * Name:     escape_json<br>
 * Purpose:  gets the string contain escaped json special characters
 * Examples: {$string|json_escape}
 *
 * @param string  $string json string
 * @return string returns the string contain escaped json special characters
 */
function smarty_modifier_escape_json($string)
{
    return str_replace(
        array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c"),
        array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b"),
        $string
    );
}

?>