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
 * Smarty file size modifier plugin
 *
 * Type:     modifier<br>
 * Name:     filesize<br>
 * Purpose:  file size<br>
 * Examples: {$path|filesize:'kb'}
 *
 * @param string  $path      file path
 * @param string  $symbol    unit symbol
 * @param integer $decimals  decimal points
 * @param boolean $separator thousands separator
 * @return string file size
 */

function smarty_modifier_filesize($path, $symbol = '', $decimals = 0, $separator = true)
{
    $size = 0;
    if (is_file($path)) {
        $size = round(sprintf('%u', filesize($path)));
    }

    switch (str_replace("\x20", '', strtolower($symbol))) {
        case 'kb': case 'kib': case 'kilobyte':
            $power = 1;
            break;

        case 'mb': case 'mib': case 'megabyte':
            $power = 2;
            break;

        case 'gb': case 'gib': case 'gigabyte':
            $power = 3;
            break;

        case 'tb': case 'tib': case 'terabyte':
            $power = 4;
            break;

        case 'pb': case 'pib': case 'petabyte':
            $power = 5;
            break;

        case 'eb': case 'eib': case 'exabyte':
            $power = 6;
            break;

        case 'zb': case 'zib': case 'zettabyte':
            $power = 7;
            break;

        case 'yb': case 'yib': case 'yottabyte':
            $power = 8;
            break;

        case 'b': case 'byte': default:
            $power = 0;
            break;
    }

    if ($size > 0 && $power > 0) {
        $size = $size / pow(1024, $power);
    }

    $size = number_format($size, $decimals);
    if (!$separator) {
        $size = str_replace(',', '', $size);
    }

    return $size . $symbol;
}

?>