<?php
/**
 * KeyValueMgr manages collection of key/value paired data.
 *
 * Copyright 2020 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * Link <https://kigkonsult.se>
 * Support <https://github.com/iCalcreator/keyvalueMgr>
 *
 * This file is part of KeyValueMgr.
 *
 * KeyValueMgr is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * KeyValueMgr is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with KeyValueMgr. If not, see <https://www.gnu.org/licenses/>.
 */
/**
 * Kigkonsult\KeyValueMgr autoloader
 */
spl_autoload_register(
    function( $class ) {
        static $PREFIX   = 'Kigkonsult\\KeyValueMgr\\';
        static $BS       = '\\';
        static $SRC      = 'src';
        static $PHP      = '.php';
        if ( 0 != strncmp( $PREFIX, $class, 23 )) {
            return;
        }
        $class = substr( $class, 23 );
        if ( false !== strpos( $class, $BS )) {
            $class = str_replace( $BS, DIRECTORY_SEPARATOR, $class );
        }
        $file = __DIR__ . DIRECTORY_SEPARATOR . $SRC . DIRECTORY_SEPARATOR . $class . $PHP;
        if ( is_file( $file )) {
            include $file;
        }
    }
);
