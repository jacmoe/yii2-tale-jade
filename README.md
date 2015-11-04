Yii2 Tale Jade
=========================

A Tale Jade for PHP integration for the Yii2 framework.  

Extension provides a `ViewRenders` that would allow you to use Haml/Twig view template engines, using [Multi target HAML (MtHaml)](https://github.com/arnaud-lb/MtHaml) library.


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


## Tale Jade Options

This is default options:
```php
    //....
    'renderers' => [
        'haml' => [
            'class' => 'mervick\mthaml\HamlViewRenderer',
            'cachePath' => '@runtime/Haml/cache',
            'debug' => false,
            'options' => [
                'format' => 'html5',
                // MtHaml escapes everything by default
                'enable_escaper' => true,
                'escape_html' => true,
                'escape_attrs' => true,
                'cdata' => true,
                'autoclose' => array('meta', 'img', 'link', 'br', 'hr', 'input', 'area', 'param', 'col', 'base'),
                'charset' => 'UTF-8',
                'enable_dynamic_attrs' => true,
            ],
        ],
        'twig' => [
            'class' => 'mervick\mthaml\TwigViewRenderer',
            'cachePath' => '@runtime/Twig/cache',
            'debug' => false,
            'options' => [
                // Same as for haml, except "enable_escaper"
                // Twig extension already supports auto escaping, so it turned off for MtHaml
                'enable_escaper' => false,
            ],
        ],
    //....
```


## License

Tale Jade extension for Yii2 Framework is released under the MIT license.

