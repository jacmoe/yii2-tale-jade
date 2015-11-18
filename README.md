Yii2 Tale Jade
=========================
[![Latest Stable Version](https://poser.pugx.org/jacmoe/yii2-tale-jade/v/stable)](https://packagist.org/packages/jacmoe/yii2-tale-jade) [![Total Downloads](https://poser.pugx.org/jacmoe/yii2-tale-jade/downloads)](https://packagist.org/packages/jacmoe/yii2-tale-jade) [![Latest Unstable Version](https://poser.pugx.org/jacmoe/yii2-tale-jade/v/unstable)](https://packagist.org/packages/jacmoe/yii2-tale-jade) [![License](https://poser.pugx.org/jacmoe/yii2-tale-jade/license)](https://packagist.org/packages/jacmoe/yii2-tale-jade)

A Tale Jade for PHP integration for the Yii2 framework.  


## Requirements

* YII 2.0
* PHP 5.5+
* Composer


## Installation with Composer

Installation is recommended to be done via [composer](https://getcomposer.org) by running:
~~~bash
composer require jacmoe/yii2-tale-jade "*"
~~~

## Configuration
### Add to renderers
Add this to your `config/main.php` file:
~~~php
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
              'lifeTime' => 0,//3600 -> 1 hour
            ],
          ],
        ],
      ],
    ],
  ];
~~~
### Set default layout
You also need to change the default layout.

You can do this either by setting the layout property of the individual controllers
~~~php
class SiteController extends Controller
{
  $layout = 'main.jade';
~~~
Or by setting it at the application level:

~~~php
return [
  'layout' => 'main.jade',
  'components' => [
  ..
~~~

### Rendering
To render a view:
~~~php
class SiteController extends Controller
{
    //....
    public function actionIndex()
    {
        return $this->render('index.jade', $params);
    }
    //....
}
~~~
Notice that the extension (.jade) is needed.

If you don't want to have to specify the extension all over the place, then you can set the default view file extension in the main config, like this:

~~~php
    'view' => [
      'defaultExtension' => 'jade',
      'renderers' => [
~~~

## Friends
Tale Jade will work well with [Jade Gii Generator for Yii2](https://bitbucket.org/jacmoe/yii2-gii-jade) once yii2-gii-jade has been written.

## Examples

### Main layout

~~~jade
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
      -
        NavBar::begin(['brandLabel' => 'Bugitor',
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
~~~

### Login

~~~jade
-use yii\helpers\Html
-use yii\bootstrap\ActiveForm
-$view->title = 'Login'
-$view->params['breadcrumbs'][] = $view->title;
.site-login
  h1 #{$view->title}
  p Please fill out the following fields to login:
  .row
    .col-lg-5
      -$form = ActiveForm::begin(['id' => 'login-form'])
      !=$form->field($model, 'username')
      !=$form->field($model, 'password')->passwordInput()
      !=$form->field($model, 'rememberMe')->checkbox()
      .form-group
        !=Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button'])
      -ActiveForm::end()
~~~

## Dirty Tricks
### The third-party trick
If you've got a module for which you want to override views by means of a `pathMap`, then you will probably find yourself in a peculiar situation: 

1) Yii will render the php version of the view even if you've told Yii that the default extension is '.jade'. 

2) It does not matter if you delete the php view from the overridden view path, because then Yii will rudely use the module's php version of that particular view. 

3) If you temporarily delete the view from the module, Yii will complain and tell you that the view in your view path (that you know is present) does not exist. 


The solution is dirty: 


Just put an empty file with the same name in the module's view directory - for example 'profile.jade', without touching anything else. And voilà: Yii sees the jade version in the modules view directory and happily renders your view file 'profile.jade' in your own (overridden) directory. 

That really threw me for a loop and appears to be a bug in Yii. ;)

## Links
[Tale Jade for PHP](http://jade.talesoft.io/)

[Jade Tutorial](http://www.learnjade.com/tour/intro/)


## License

Tale Jade extension for Yii2 Framework is released under the MIT license.