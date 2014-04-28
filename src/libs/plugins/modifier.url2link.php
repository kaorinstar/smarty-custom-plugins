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
 * Smarty link to urls modifier plugin
 *
 * Type:     modifier<br>
 * Name:     url2link<br>
 * Purpose:  gets html string contain automatically linked urls<br>
 * Examples: {$string|url2link}
 *
 * @param string $string html string
 * @param string $target target attribute
 * @return string returns html string contain automatically linked urls
 */
function smarty_modifier_url2link($string, $target = null)
{
    $string = str_replace(array("\x0D\x0A", "\x0D"), "\x0A", $string);

    $pattern = "/((?:\A|<\/(?:a|pre|script|style|select|textarea)(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*"
             . "(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z)))(.*?)"
             . "((?:\z|<(?:a|pre|script|style|select|textarea)(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*"
             . "(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z)))/is"
             . Smarty::$_UTF8_MODIFIER;
    $string  = preg_replace_callback(
        $pattern,
        function($matches) use($target)
        {
            if (trim($matches[2]) !== '') {
                if ($target === null) {
                    if ( ! empty($_SERVER['HTTP_HOST'])) {
                        $pattern    = '/(?:\A|(?<!=["\']))(?:ftps?|s?https?):\/\/' . preg_quote($_SERVER['HTTP_HOST'], '/')
                                    . '[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]*/i'
                                    . Smarty::$_UTF8_MODIFIER;
                        $matches[2] = preg_replace($pattern, '<a href="$0">$0</a>', $matches[2]);
                    }
                    $matches[2] = smarty_modifier_url2link($matches[2], '_blank');
                } else {
                    $pattern    = '/(?:\A|(?<!=["\']))(?:ftps?|s?https?):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/i'
                                . Smarty::$_UTF8_MODIFIER;
                    $matches[2] = preg_replace($pattern, '<a href="$0" target="' . $target . '">$0</a>', $matches[2]);
                }

                return $matches[1] . $matches[2] . $matches[3];
            }

            return $matches[0];
        },
        $string
    );

    return $string;
}

?>