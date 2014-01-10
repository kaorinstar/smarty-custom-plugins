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
 * Smarty link to urls modifier plugin
 *
 * Type:     modifier<br>
 * Name:     url2link<br>
 * Purpose:  gets html string including automatically linked urls<br>
 * Examples: {$string|url2link}
 *
 * @param string $string html string
 * @param string $target target attribute
 * @return string returns html string including automatically linked urls
 */
$_smarty_modifier_url2link_var_target = null;
function smarty_modifier_url2link($string, $target = null)
{
    global $_smarty_modifier_url2link_var_target;
    $_smarty_modifier_url2link_var_target = $target;

    $string  = str_replace(array("\x0D\x0A", "\x0D"), "\x0A", $string);
    $pattern = "/(?:\A|<\/(?:a|pre|script|style|textarea)(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z)).*?"
             . "(?:\z|<(?:a|pre|script|style|textarea)(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z))/isu";

    return preg_replace_callback($pattern, '_smarty_modifier_url2link_func1', $string);
}

/**
 * @param array $matches matche strings
 * @return string returns html string including automatically linked urls
 */
function _smarty_modifier_url2link_func1($matches)
{
    $pattern = "/(?:\A|(?<=>))(?:[^<>\x0A][^<>]*?|\x0A[^<>]+?)(?:(?=[<>])|\z)/isu";

    return preg_replace_callback($pattern, '_smarty_modifier_url2link_func2', $matches[0]);
}

/**
 * @param array $matches matche strings
 * @return string returns html string including automatically linked urls
 */
function _smarty_modifier_url2link_func2($matches)
{
    global $_smarty_modifier_url2link_var_target;

    if (trim($matches[0]) !== '') {
        if ($_smarty_modifier_url2link_var_target === null) {
            if (isset($_SERVER['HTTP_HOST'])) {
                $pattern    = '/(?:ftps?|s?https?):\/\/' . preg_quote($_SERVER['HTTP_HOST'], '/')
                            . '[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/u';
                $matches[0] = preg_replace($pattern, '<a href="' . "$0" . '">' . "$0" . '</a>', $matches[0]);
            }
            $matches[0] = smarty_modifier_url2link($matches[0], '_blank');
            $_smarty_modifier_url2link_var_target = null;
        } else {
            $pattern    = '/(?:ftps?|s?https?):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/u';
            $matches[0] = preg_replace(
                $pattern,
                '<a href="' . "$0" . '" target="' . $_smarty_modifier_url2link_var_target . '">' . "$0" . '</a>',
                $matches[0]
            );
        }
    }

    return $matches[0];
}

?>