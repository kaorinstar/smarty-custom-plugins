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
 * Smarty link to emails modifier plugin
 *
 * Type:     modifier<br>
 * Name:     mail2link<br>
 * Purpose:  gets html string contain automatically linked emails<br>
 * Examples: {$string|mail2link}
 *
 * @param string $string html string
 * @return string returns html string contain automatically linked emails
 * @uses smarty_function_mailto()
 */
function smarty_modifier_mail2link($string)
{
    $string = str_replace(array("\x0D\x0A", "\x0D"), "\x0A", $string);

    $pattern = "/((?:\A|<\/(?:a|pre|script|style|select|textarea)(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*"
             . "(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z)))(.*?)"
             . "((?:\z|<(?:a|pre|script|style|select|textarea)(?:|[^\"'<>a-zA-Z0-9][^\"'<>]*"
             . "(?:\"[^\"]*\"[^\"'<>]*|'[^']*'[^\"'<>]*)*)(?:>|(?=<)|\z)))/is"
             . Smarty::$_UTF8_MODIFIER;
    $string  = preg_replace_callback(
        $pattern,
        function($matches)
        {
            if (trim($matches[2]) !== '') {
                $pattern    = "/(=[\"'])?(?:[-!#-'*+\/-9=?A-Z^-~]+(?:\.[-!#-'*+\/-9=?A-Z^-~]+)*"
                            . "|\"(?:[!#-\[\]-~]|\\[\x09 -~])*\")@[-!#-'*+\/-9=?A-Z^-~]+"
                            . "(?:\.[-!#-'*+\/-9=?A-Z^-~]+)*/i"
                            . Smarty::$_UTF8_MODIFIER;
                $matches[2] = preg_replace_callback(
                    $pattern,
                    function($matches)
                    {
                        if ( ! empty($matches[1])) {
                            return $matches[0];
                        }
                        $address = '';
                        for ($i = 0, $len = strlen($matches[0]); $i < $len; $i++) {
                            if (preg_match('/\w/' . Smarty::$_UTF8_MODIFIER, $matches[0][$i])) {
                                $address .= '%' . bin2hex($matches[0][$i]);
                            } else {
                                $address .= $matches[0][$i];
                            }
                        }
                        $text = '';
                        for ($i = 0, $len = strlen($matches[0]); $i < $len; $i++) {
                            $text .= '&#x' . bin2hex($matches[0][$i]) . ';';
                        }

                        return '<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;' . $address . '">' . $text . '</a>';
                    },
                    $matches[2]
                );

                return $matches[1] . $matches[2] . $matches[3];
            }

            return $matches[0];
        },
        $string
    );

    return $string;
}

?>