
# KeyValueMgr

> Manages collection of key/value pairs like system config etc


###### USAGE 
 
~~~~~~~~
<?php
namespace Kigkonsult\KeyValueMgr;

// set up some config

$key   = 'key';
$value = 'value;
$configDataArray = [ $key => $value ];

// set up KeyValueMgr

$cfgMgr = new KeyValueMgr();
$cfgMgr->set( $configDataArray );
$cfgMgr->set( 'key2', 'value2' );

// usage exists / get / remove

if( $cfgMgr->exists( $key ) {
   $value = $cfgMgr->get( $key );
}
$cfgMgr->remove( $key )

~~~~~~~~

###### Methods

```KeyValueMgr::__construct( [ configDataArray ] )```
* configDataArray array 

```KeyValueMgr::factory( [ configDataArray ] )```
* configDataArray  array
* static
* return KeyValueMgr

```KeyValueMgr::singleton( [ configDataArray ] )```
* configDataArray  array
* static
* return singleton KeyValueMgr
<br><br>


```KeyValueMgr::exists( key )```
* return bool true on found

```KeyValueMgr::exists( key, true )```
* return bool true on found and value NOT is ```null, '' or []```
<br><br>

```KeyValueMgr::get()```
* return array *( key => value )

```KeyValueMgr::get( key )```
* return value for key, false on not found

```KeyValueMgr::getKeys()```
* return array *( key )
<br><br>


```KeyValueMgr::set( key, value )```
* insert key/value-pair (overwrite if key exists)
* key    string|int 
* value  mixed 
* return KeyValueMgr

```KeyValueMgr::set( key, value, true  )```
* insert key/value-pair if key is NOT set
* key    string|int 
* value  mixed 
* return KeyValueMgr

```KeyValueMgr::set( configDataArray )```
* insert array key/value-pairs (overwrite if key exists)
* configDataArray  array *( key => value )
* return KeyValueMgr

```KeyValueMgr::set( configDataArray, null, true )```
* insert array key/value-pairs where key NOT exists
* configDataArray  array *( key => value )
* return KeyValueMgr
<br><br>


```KeyValueMgr::remove( key )```
* unset key/value pair
* key    string|int
* return KeyValueMgr

```KeyValueMgr::remove( keyArr )```
* unset key/value pairs
* keyArr  array *( key )
* return KeyValueMgr

```KeyValueMgr::remove( keyToKeep, true )```
* unset all OTHER key/value-pairs 
* keyToKeep  string|int 
* return KeyValueMgr

```KeyValueMgr::remove( keyArrToKeep, true )```
* unset all OTHER key/value-pairs 
* keyArrToKeep  array *( key )
* return KeyValueMgr
<br><br>

```KeyValueMgr::toString()```
* Return nice edited string content output


###### Sponsorship

Donation using <a href="https://paypal.me/kigkonsult?locale.x=en_US" rel="nofollow">paypal.me/kigkonsult</a> are appreciated. 
For invoice, <a href="mailto:ical@kigkonsult.se">please e-mail</a>.

###### INSTALL

``` php
composer require kigkonsult\keyvaluemgr:dev-master
```

Composer, in your `composer.json`:

``` json
{
    "require": {
        "kigkonsult\keyvaluemgr": "dev-master"
    }
}
```

Composer, acquire access
``` php
use Kigkonsult\KeyValueMgr\KeyValueMgr;
...
include 'vendor/autoload.php';
```


Otherwise , download and acquire..

``` php
use Kigkonsult\KeyValueMgr\KeyValueMgr;
...
include 'pathToSource/kigkonsult/keyvaluemgr/autoload.php';
```


###### Support

For support go to [github.com KeyValueMgr]


###### License

This project is licensed under the LGPLv3 License.


[Composer]:https://getcomposer.org/
[github.com KeyValueMgr]:https://github.com/iCalcreator/keyvaluemgr
