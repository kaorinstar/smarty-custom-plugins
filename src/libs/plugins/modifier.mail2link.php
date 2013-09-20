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
 * Smarty link to email addresses modifier plugin
 *
 * Type:     modifier<br>
 * Name:     mail2link<br>
 * Purpose:  link to email addresses<br>
 * Examples: {$string|mail2link}
 *
 * @param string $string input string
 * @return string linked to emails addresses string
 * @uses smarty_function_mailto()
 */
function smarty_modifier_mail2link($string)
{
    require_once(SMARTY_PLUGINS_DIR . 'function.mailto.php');

    $string  = str_replace(array("\x0D\x0A", "\x0D"), "\x0A", $string);
    $pattern = "/(?:\A|<\/(?:a|pre|script|style|textarea)(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z)).*?"
             . "(?:\z|<(?:a|pre|script|style|textarea)(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z))/is"
             . Smarty::$_UTF8_MODIFIER;

    return preg_replace_callback($pattern, '_smarty_modifier_mail2link_func1', $string);
}

/**
 * @param array $matches matche strings
 * @return string linked to emails string
 */
function _smarty_modifier_mail2link_func1($matches)
{
    $pattern = "/(?:\A|(?<=>))(?:[^<>\x0A][^<>]*?|\x0A[^<>]+?)(?:(?=[<>])|\z)/is"
             . Smarty::$_UTF8_MODIFIER;

    return preg_replace_callback($pattern, '_smarty_modifier_mail2link_func2', $matches[0]);
}

/**
 * @param array $matches matche strings
 * @return string linked to emails string
 */
function _smarty_modifier_mail2link_func2($matches)
{
    if (trim($matches[0]) !== '') {
        $pattern    = "/(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+\/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+\/=?\^`{}~|\-]+))*)|(?:\"(?:\\[^\x0D\x0A]|[^\\\"])*\")))"
                    . "\@(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+\/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+\/=?\^`{}~|\-]+))*))/"
                    . Smarty::$_UTF8_MODIFIER;
        $matches[0] = preg_replace_callback($pattern, '_smarty_modifier_mail2link_func3', $matches[0]);
    }

    return $matches[0];
}

/**
 * @param array $matches matche strings
 * @return string linked to mails string
 */
function _smarty_modifier_mail2link_func3($matches)
{
    return smarty_function_mailto(array('address' => $matches[0], 'encode'  => 'hex'), null);
}

?>