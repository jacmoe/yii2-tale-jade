Yii2 Tale Jade
=========================

A Tale Jade for PHP integration for the Yii2 framework.  


## Requirements

* YII 2.0
* PHP 5.4+
* Composer


## Installation with Composer

Installation is recommended to be done via [composer](https://getcomposer.org) by running:
```bash
composer require jacmoe/yii2-tale-jade "*"
```

## Usage

Add this to your `config/main.php` file:
```php
return [
    //....
    'components' => [
        'view' => [
            'renderers' => [
                'jade' => [
                    'class' => 'jacmoe\talejade\JadeViewRenderer',
                ],
            ],
        ],
    ],
];
```
 
Rendering in Controllers:
```php
class SiteController extends Controller
{
    //....
    public function actionIndex()
    {
        return $this->render('index.jade', $params);
    }
    //....
}
```


## Tale Jade Configuration


## Examples


## License

Tale Jade extension for Yii2 Framework is released under the MIT license.

