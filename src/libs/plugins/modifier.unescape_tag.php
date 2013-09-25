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
 * Smarty unescape tags modifier plugin
 *
 * Type:     modifier<br>
 * Name:     unescape_tag<br>
 * Purpose:  gets html string including specified unescape tags<br>
 * Examples: {$string|unescape_tag:'a,b,strong'}
 *
 * @param string  $string html string
 * @param mixed   $tags   unescape tags, comma separated list of tag names or array of tag names
 * @return string returns html string including specified unescape tags
 */
function smarty_modifier_unescape_tag($string, $tags = null)
{
    $string = str_replace(array("\x0D\x0A", "\x0D"), "\x0A", $string);

    if ($tags === null) {
        $pattern = "/&lt;[^&]*(?:&quot;.*?&quot;[^&]*|&#039;.*?&#039;[^&]*)*(?:&gt;|(?=&lt;)|\z)/is"
                 . Smarty::$_UTF8_MODIFIER;
    } else {
        $pattern = '/&lt;\/?(?:' . str_replace("\x20", '', str_replace(',', '|', preg_quote(implode(',', (array)$tags), '/')))
                 . ")(?:|[^&a-zA-Z0-9][^&]*(?:&quot;.*?&quot;[^&]*|&#039;.*?&#039;[^&]*)*)(?:&gt;|(?=&lt;)|\z)/is"
                 . Smarty::$_UTF8_MODIFIER;
    }

    $string = preg_replace_callback(
        $pattern,
        function($matches)
        {
            return str_replace(array('&lt;', '&gt;', '&quot;', '&#039;'), array('<', '>', '"', '\''), $matches[0]);
        },
        $string
    );

    return $string;
}

?>