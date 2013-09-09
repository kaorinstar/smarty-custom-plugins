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
 * Smarty unescape entity tag modifier plugin
 *
 * Type:     modifier<br>
 * Name:     unescape_tag<br>
 * Purpose:  unescape entity tag<br>
 * Examples: {$string|unescape:'a,b,strong'}
 *
 * @param string  $string input string
 * @param mixed   $tags   unescape tags, comma separated list of tag names or array of tag names
 * @return string unescaped input html string
 */
function smarty_modifier_unescape_tag($string, $tags = null)
{
    if ($tags === null) {
        $pattern = "/&lt;[^&]*(?:&quot;.*?&quot;[^&]*|&#039;.*?&#039;[^&]*)*(?:&gt;|(?=&lt;)|$(?!\x0A))/is"
                 . Smarty::$_UTF8_MODIFIER;
    } else {
        $pattern = '/&lt;\/?(?:' . str_replace("\x20", '', str_replace(',', '|', preg_quote(implode(',', (array)$tags), '/')))
                 . ")(?:|[^&a-zA-Z0-9][^&]*(?:&quot;.*?&quot;[^&]*|&#039;.*?&#039;[^&]*)*)(?:&gt;|(?=&lt;)|$(?!\x0A))/is"
                 . Smarty::$_UTF8_MODIFIER;
    }

    if (preg_match_all($pattern, $string, $matches)) {
        $characters = array('<', '>', '"', '\'');
        $entities   = array('&lt;', '&gt;', '&quot;', '&#039;');
        $matches[0] = array_unique($matches[0]);
        foreach ($matches[0] as $match) {
            $replacement = str_replace($entities, $characters, $match);
            $string      = str_replace($match, $replacement, $string);
        }
    }

    return $string;
}

?>