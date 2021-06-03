<?php
/**
 * KeyValueMgr manages collection of key/value paired data.
 *
 * This file is part of KeyValueMgr.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2020-2021 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * @link      https://kigkonsult.se
 * @version   1.4
 * @license   Subject matter of licence is the software KeyValueMgr.
 *            The above copyright, link, package and version notices,
 *            this licence notice shall be included in all copies or substantial
 *            portions of the KeyValueMgr.
 *
 *            KeyValueMgr is free software: you can redistribute it and/or modify
 *            it under the terms of the GNU Lesser General Public License as
 *            published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *            KeyValueMgr is distributed in the hope that it will be useful,
 *            but WITHOUT ANY WARRANTY; without even the implied warranty of
 *            MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *            GNU Lesser General Public License for more details.
 *
 *            You should have received a copy of the GNU Lesser General Public License
 *            along with KeyValueMgr. If not, see <https://www.gnu.org/licenses/>.
 */
/**
 * Kigkonsult\KeyValueMgr autoloader
 */
spl_autoload_register(
    function( $class ) {
        static $PREFIX   = 'Kigkonsult\\KeyValueMgr\\';
        static $BS       = '\\';
        static $PATHSRC  = null;
        static $SRC      = 'src';
        static $PATHTEST = null;
        static $TEST     = 'test';
        static $FMT      = '%s%s.php';
        if( empty( $PATHSRC ) ) {
            $PATHSRC  = __DIR__ . DIRECTORY_SEPARATOR . $SRC . DIRECTORY_SEPARATOR;
            $PATHTEST = __DIR__ . DIRECTORY_SEPARATOR . $TEST . DIRECTORY_SEPARATOR;
        }
        if( 0 != strncmp( $PREFIX, $class, 23 ) ) {
            return;
        }
        $class = substr( $class, 23 );
        if( false !== strpos( $class, $BS ) ) {
            $class = str_replace( $BS, DIRECTORY_SEPARATOR, $class );
        }
        $file = sprintf( $FMT, $PATHSRC, $class );
        if( file_exists( $file ) ) {
            include $file;
        }
        else {
            $file = sprintf( $FMT, $PATHTEST, $class );
            if( file_exists( $file ) ) {
                include $file;
            }
        }
    }
);
