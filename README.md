Yii2 Tale Jade
=========================

A Tale Jade for PHP integration for the Yii2 framework.  


## Requirements

* YII 2.0
* PHP 5.5+
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
            'cachePath' => '@runtime/Jade/cache',
            'options' => [
              'pretty' => true,
              'lifeTime' => 0,
            ],
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


## Example

```jade
-use yii\helpers\Html
-use yii\bootstrap\Nav
-use yii\bootstrap\NavBar
-use frontend\assets\AppAsset
-use frontend\widgets\Alert
-use yii\widgets\Breadcrumbs
-AppAsset::register($view)
-$view->beginPage()

doctype html
html(lang=Yii::$app->language)
  head
    meta(charset=Yii::$app->charset)
    meta(name="viewport", content="width=device-width, initial-scale=1")
    !=Html::csrfMetaTags()
    title #{$view->title} | Bugitor
    -$view->head()
  body
    -$view->beginBody()
    .wrap
      -NavBar::begin(['brandLabel' => 'Bugitor',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-inverse navbar-fixed-top',],])

      -$menuItems[] = ['label' => 'Home', 'url' => ['/site/index']]
      -$menuItems[] = ['label' => 'Projects', 'url' => ['/project/index']]
      -$menuItems[] = ['label' => 'Issues', 'url' => ['/issue/index']]
      if (Yii::$app->user->isGuest)
        -$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']]
        -$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']]
      else
        -$menuItems[] = ['label' => 'Users', 'url' => ['/user/index']]
        -$menuItems[] = ['label' => 'Gii', 'url' => ['/gii']]
        -$menuItems[] = ['label' => 'Logout (' . Yii::$app->user->identity->username . ')','url' => ['/site/logout'],'linkOptions' =>['data-method' => 'post']]

      !=Nav::widget(['options' => ['class' => 'navbar-nav navbar-right'],'items' => $menuItems,])
      -NavBar::end()

      .container
        !=Breadcrumbs::widget(['links' => isset($view->params['breadcrumbs']) ? $view->params['breadcrumbs'] : [],])
        !=$content

    footer.footer
      .container
        p.pull-left &copy; My Company&nbsp;
          =date('Y')
        p.pull-right
          !=Yii::powered()
    -$view->endBody()
-$view->endPage()
```

## License

Tale Jade extension for Yii2 Framework is released under the MIT license.