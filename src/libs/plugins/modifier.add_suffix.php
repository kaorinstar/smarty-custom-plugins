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
 * Smarty add suffix modifier plugin
 *
 * Type:     modifier<br>
 * Name:     add_suffix<br>
 * Purpose:  gets the path with specified suffix before extension<br>
 * Examples: {$path|add_suffix:'_s'}
 *
 * @param string  $path   file path
 * @param string  $suffix suffix
 * @return string returns the path with specified suffix before extension
 */
function smarty_modifier_add_suffix($path, $suffix)
{
    // Set a parent directory's path
    $dirname = dirname($path);
    if ($dirname === '.' && $path !== '.') {
        $dirname = '';
    }

    // Set a separator character
    $separator = '';
    if ($dirname !== '') {
        if (Smarty::$_MBSTRING) {
            if ($dirname !== '/' && mb_strrpos($dirname, '/', 0, Smarty::$_CHARSET) !== false) {
                $separator = '/';
            } else if ($dirname !== '\\' && mb_strrpos($dirname, '\\', 0, Smarty::$_CHARSET) !== false) {
                $separator = '\\';
            }
        } else {
            if ($dirname !== '/' && strrpos($dirname, '/') !== false) {
                $separator = '/';
            } else if ($dirname !== '\\' && strrpos($dirname, '\\') !== false) {
                $separator = '\\';
            }
        }
    }

    // Set a file name and a file name extension
    $basename = basename($path);
    if (Smarty::$_MBSTRING) {
        $position = mb_strrpos($basename, '.', 0, Smarty::$_CHARSET);
        if ($position === false) {
            $filename  = $basename;
            $extension = '';
        } else {
            $filename  = mb_substr($basename, 0, $position, Smarty::$_CHARSET);
            $extension = mb_substr($basename, $position, mb_strlen($basename, Smarty::$_CHARSET), Smarty::$_CHARSET);
        }
    } else {
        $position = strrpos($basename, '.');
        if ($position === false) {
            $filename  = $basename;
            $extension = '';
        } else {
            $filename  = substr($basename, 0, $position);
            $extension = substr($basename, $position, strlen($basename));
        }
    }

    return $dirname . $separator . $filename . basename($suffix) . $extension;
}

?>