<?php
/**
 * KeyValueMgr manages collection of key/value paired data.
 *
 * This file is part of KeyValueMgr.
 *
 * @author    Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @copyright 2020-2021 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * @link      https://kigkonsult.se
 * @version   1.0
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
namespace Kigkonsult\KeyValueMgr;

use PHPUnit\Framework\TestCase;

class KeyValueMgrTest extends TestCase
{
    /**
     * Test keyValueMgrTest1 provider
     *
     * @return array
     */
    public function dataProvider1() : array
    {
        $dataArr = [];

        $dataArr[] = [
            1001,
            'key',
            'value'
        ];

        $dataArr[] = [
            1002,
            'key',
            ''
        ];

        return $dataArr;
    }

    /**
     * @test
     * @dataProvider dataProvider1
     *
     * @param int $case
     * @param string $key
     * @param string $value
     */
    public function keyValueMgrTest1( int $case, string $key, string $value )
    {
        $FMT = 'Error in case %d#%d, key : \'%s\', value : \'%s\'';

        $kvMgr = new KeyValueMgr();

        $this->assertFalse(
            $kvMgr->exists( $key ),
            sprintf( $FMT, $case, 1, $key, $value )
        );

        $this->assertTrue(
            $kvMgr->set( $key, $value )->exists( $key ),
            sprintf( $FMT, $case, 2, $key, $value )
        );

        $this->assertTrue(
            is_array( $kvMgr->get()),
            sprintf( $FMT, $case, 3, $key, $value )
        );
        $this->assertEquals(
            1,
            count( $kvMgr->get()),
            sprintf( $FMT, $case, 4, $key, $value )
        );

        $this->assertEquals(
            $value ,
            $kvMgr->get( $key ),
            sprintf( $FMT, $case, 5, $key, $value )
        );

        $this->assertFalse(
            $kvMgr->remove( $key )->exists( $key ),
            sprintf( $FMT, $case, 6, $key, $value )
        );

        $this->assertFalse(
            $kvMgr->set( [ $key => $value ] )->remove( [ $key ] )->exists( $key ),
            sprintf( $FMT, $case, 7, $key, $value )
        );


        $this->assertTrue(
            $kvMgr->set( $key, $value, true )->exists( $key ),
            sprintf( $FMT, $case, 8, $key, $value )
        );

        $this->assertFalse(
            $kvMgr->remove( 'keyTokeep', true )->exists( $key ),
            sprintf( $FMT, $case, 9, $key, $value )
        );


        $this->assertTrue(
            $kvMgr->set( [ $key => $value ] )->remove( [ $key ], true )->exists( $key ),
            sprintf( $FMT, $case, 10, $key, $value )
        );

        if( empty( $value )) {
            $this->assertFalse(
                $kvMgr->exists( $key, true ),
                sprintf( $FMT, $case, 11, $key, $value )
            );
        }
        else {
            $this->assertTrue(
                $kvMgr->exists( $key, true ),
                sprintf( $FMT, $case, 12, $key, $value )
            );
        }

        $kvMgr = KeyValueMgr::factory( [ $key => $value ] );
        $this->assertTrue(
            $kvMgr->exists( $key ),
            sprintf( $FMT, $case, 13, $key, $value )
        );

        $kvMgr->set( $key, $value . $case, true );
        $this->assertEquals(
            $value ,
            $kvMgr->get( $key ),
            sprintf( $FMT, $case, 14, $key, $value )
        );

        $this->assertStringEndsWith( PHP_EOL, $kvMgr->toString());

        $kvMgr = KeyValueMgr::singleton( [ $key => $value ] );
        $this->assertTrue(
            $kvMgr->exists( $key ),
            sprintf( $FMT, $case, 13, $key, $value )
        );
    }
}
