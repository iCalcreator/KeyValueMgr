<?php
/**
 * KeyValueMgr manages collection of key/value paired data.
 *
 * This file is part of KeyValueMgr.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2020-2021 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * @link      https://kigkonsult.se
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
declare( strict_types = 1 );
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
     * The key/value paired collection
     *
     * @var mixed[]
     */
    private array $data = [];

    /**
     * Class factory method
     *
     * @param mixed[] $data
     * @return self
     */
    public static function factory( array $data = [] ) : self
    {
        return new self( $data );
    }

    /**
     * Class singleton method
     *
     * @param mixed[] $data
     * @return self
     */
    public static function singleton( array $data = [] ) : self
    {
        static $instance = null;
        if( is_null( $instance )) {
            $instance = new self( $data );
        }
        return $instance;
    }

    /**
     * KeyValueMgr constructor
     *
     * @param mixed[] $data
     */
    public function __construct( array $data = [] )
    {
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
    public function exists( string $key, bool $checkSetValuesAlso = false ) : bool
    {
        $EMPTYSTR = '';
        $EMPTYARR = [];
        $exist    = array_key_exists( $key, $this->data );
        if( ! $checkSetValuesAlso ) {
            return $exist;
        }
        if( ! $exist ||
            is_null( $this->data[$key] ) ||
            ( $EMPTYSTR === $this->data[$key] ) ||
            ( $EMPTYARR === $this->data[$key] )) {
            return false;
        }
        return true;
    }

    /**
     * Return array key-value pairs or key value, false on not found
     *
     * @param null|string $key
     * @return mixed
     */
    public function get( ? string $key = null )
    {
        if( is_null( $key )) {
            return $this->data;
        }
        return $this->exists( $key ) ? $this->data[$key] : false;
    }

    /**
     * Return array keys
     *
     * @return string[]
     */
    public function getKeys() : array
    {
        return array_keys( $this->data );
    }

    /**
     * Insert one key-value pair or array of key-value pairs (ifNotExists = false)
     *
     * ifNotExists = true gives only insert of key(s) NOT set
     *
     * @param array|string  $key
     * @param null|mixed    $value
     * @param null|bool     $ifNotExists
     * @return self
     */
    public function set( $key, $value = null, ? bool $ifNotExists = false ) : self
    {
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
     * @param string|array  $key
     * @param null|bool     $allButKeys
     * @return self
     */
    public function remove( $key, ? bool $allButKeys = false ) : self
    {
        if( ! is_array( $key )) {
            $key    = [ $key ];
        }
        $allowedCfg = [];
        foreach( $this->getKeys() as $dataKey ) {
            $found  = in_array( $dataKey, $key );
            if( ! $allButKeys && $found ) {
                // dataKey is key to remove (found in 'remove'-keys)
                continue;
            }

            if( $allButKeys && ! $found ) {
                // dataKey is not found in 'save'-keys
                continue;
            }
            $allowedCfg[$dataKey] = $this->data[$dataKey];
        } // end foreach
        ksort( $allowedCfg );
        $this->data = $allowedCfg;
        return $this;
    }

    /**
     * Return nice edited string content output, each row has a trailing eol
     *
     * @return string
     */
    public function toString() : string
    {
        static $FMT = '%s : %s%s';
        $keyLen  = 0;
        $allKeys = $this->getKeys();
        foreach( $allKeys as $key ) {
            $len = strlen( $key );
            if( $keyLen < $len ) {
                $keyLen = $len;
            }
        }
        $output = '';
        foreach( $allKeys as $key ) {
            $output .=
                sprintf(
                    $FMT,
                    str_pad( $key, $keyLen ),
                    var_export( $this->data[$key], true )
                    , PHP_EOL
                );
        }
        return $output;
    }
}
