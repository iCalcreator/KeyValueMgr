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
namespace Kigkonsult\KeyValueMgr;

use function array_key_exists;
use function array_keys;
use function in_array;
use function is_array;
use function is_null;
use function ksort;
use function str_pad;
use function strlen;
use function sprintf;
use function var_export;

/**
 * Class KeyValueMgr
 *
 * Manages collection of key/value paired data
 *
 * @package Kigkonsult\KeyValueMgr
 */
class KeyValueMgr
{

    /**
     * @var array
     */
    private $data = [];

    /**
     * Class factory method
     *
     * @param array $data
     * @return static
     */
    public static function factory( array $data = [] ) {
        return new static( $data );
    }

    /**
     * Class singleton method
     *
     * @param array $data
     * @return static
     */
    public static function singleton( array $data = [] ) {
        static $instance = null;
        if( is_null( $instance )) {
            $instance = new static( $data );
        }
        return $instance;
    }

    /**
     * KeyValueMgr constructor
     *
     * @param array $data
     */
    public function __construct( array $data = [] ) {
        if( ! empty( $data )) {
            $this->set( $data );
        }
    }

    /**
     * Return bool true if config key 1. ! checkSetValuesAlso and exists OR 2. checkSetValuesAlso and non-empty
     *
     * An empty value here are defined as null, '' and []
     *
     * @param string $key
     * @param bool   $checkSetValuesAlso
     * @return bool
     */
    public function exists( $key, $checkSetValuesAlso = false ) {
        $EMPTYSTR = '';
        $EMPTYARR = [];
        if( ! $checkSetValuesAlso ) {
            return array_key_exists( $key, $this->data );
        }
        if( ! array_key_exists( $key, $this->data ) ||
            is_null( $this->data[$key] ) ||
            ( $EMPTYSTR == $this->data[$key] ) ||
            ( $EMPTYARR == $this->data[$key] )) {
            return false;
        }
        return true;
    }

    /**
     * Return array key-value pairs or key value, false on not found
     *
     * @param string $key
     * @return mixed
     */
    public function get( $key = null ) {
        if( is_null( $key )) {
            return $this->data;
        }
        return $this->exists( $key ) ? $this->data[$key] : false;
    }

    /**
     * Return array keys
     *
     * @return array
     */
    public function getKeys() {
        return array_keys( $this->data );
    }

    /**
     * Insert one key-value pair or array of key-value pairs (ifNotExists = false)
     *
     * ifNotExists = true gives only insert of keys NOT set
     *
     * @param array|string|int $key
     * @param mixed            $value
     * @param bool             $ifNotExists
     * @return static
     */
    public function set( $key, $value = null, $ifNotExists = false ) {
        if( ! is_array( $key )) {
            $key = [ $key => $value ];
        }
        foreach( $key as $key2 => $value2 ) {
            if( ! $ifNotExists ) {
                // overwrite if found
                $this->data[$key2] = $value2;
            }
            elseif( ! array_key_exists( $key2, $this->data )) {
                // insert if not found
                $this->data[$key2] = $value2;
            }
        } // end foreach
        return $this;
    }

    /**
     * Unset data key(s) (allButKeys = false) OR unset key(s) not given (allButKeys = true)
     *
     * @param string|array $key
     * @param bool         $allButKeys
     * @return static
     */
    public function remove( $key, $allButKeys = false ) {
        if( ! is_array( $key )) {
            $key = [ $key ];
        }
        $allowedCfg = [];
        foreach( $this->getKeys() as $dataKey ) {
            if( ! $allButKeys && in_array( $dataKey, $key )) {
                // dataKey is key to remove
                continue;
            }
            elseif( $allButKeys && ! in_array( $dataKey, $key )) {
                // dataKey is not allowed
                continue;
            }
            $allowedCfg[$dataKey] = $this->data[$dataKey];
        }
        ksort( $allowedCfg );
        $this->data = $allowedCfg;
        return $this;
    }

    /**
     * Return nice edited string content output, leading and row end eol, no trailing eol
     *
     * @return string
     */
    public function toString() {
        static $FMT = '%s%s : %s';
        $keyLen  = 0;
        $allKeys = $this->getKeys();
        foreach( $allKeys as $key ) {
            if( $keyLen < strlen( $key )) {
                $keyLen = strlen( $key );
            }
        }
        $output = '';
        foreach( $allKeys as $key ) {
            $output .=
                sprintf( $FMT, PHP_EOL, str_pad( $key, $keyLen ), var_export( $this->data[$key], true ));
        }
        return $output;
    }

}
