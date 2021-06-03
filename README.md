
# KeyValueMgr

> Manages collection of key/value pairs like system config etc


###### USAGE 
 
``` php
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
```

###### Methods

```KeyValueMgr::__construct( [ configDataArray ] )```
* ```configDataArray``` array 

```KeyValueMgr::factory( [ configDataArray ] )```
* ```configDataArray```  array
* static
* Return static

```KeyValueMgr::singleton( [ configDataArray ] )```
* ```configDataArray```  array
* static
* Return singleton KeyValueMgr
---

```KeyValueMgr::exists( key )```
* ```key``` mixed
* Return bool true on found

```KeyValueMgr::exists( key, true )```
* ```key``` mixed
* ```true``` bool ```true```
* Return bool true on found and value NOT is ```null, '' or []```
---

```KeyValueMgr::get()```
* Return array *( key => value )

```KeyValueMgr::get( key )```
* ```key``` mixed
* Return value for key, false on not found

```KeyValueMgr::getKeys()```
* Return array *( key )
---

```KeyValueMgr::set( key, value )```
* Insert key/value-pair (overwrite if key exists)
* ```key```    string|int 
* ```value```  mixed 
* Return static

```KeyValueMgr::set( key, value, true  )```
* Insert key/value-pair if key is NOT set
* ```key```    string|int 
* ```value```  mixed 
* ```true``` bool ```true```
* Return static

```KeyValueMgr::set( configDataArray )```
* Insert array key/value-pairs (overwrite if key exists)
* ```configDataArray```  array *( key => value )
* Return static

```KeyValueMgr::set( configDataArray, null, true )```
* Insert array key/value-pairs where key NOT exists
* ```configDataArray```  array *( key => value )
* ```true``` bool ```true```
* Return static
---

```KeyValueMgr::remove( key )```
* Unset key/value pair
* ```key```    string|int 
* Return static

```KeyValueMgr::remove( keyArr )```
* Unset key/value pairs
* ```keyArr```  array *( key )
* Return static

```KeyValueMgr::remove( keyToKeep, true )```
* Unset all OTHER key/value-pairs 
* ```keyToKeep```  string|int 
* ```true``` bool ```true```
* Return static

```KeyValueMgr::remove( keyArrToKeep, true )```
* Unset all OTHER key/value-pairs 
* ```keyArrToKeep```  array *( key )
* ```true``` bool ```true```
* Return static
---

```KeyValueMgr::toString()```
* Return nice edited string content output
---

###### Sponsorship

Donation using <a href="https://paypal.me/kigkonsult?locale.x=en_US" rel="nofollow">paypal.me/kigkonsult</a> are appreciated. 
For invoice, <a href="mailto:ical@kigkonsult.se">please e-mail</a>.

###### INSTALL

KeyValueMgr 1.4 require PHP 7+

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
