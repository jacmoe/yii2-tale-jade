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

## Related
Yii2 Tale Jade works well with [Jade Gii Generator for Yii2](https://packagist.org/packages/jacmoe/yii2-gii-jade)

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
Taken from my Yii2 bug report:

*I am using the Tale Jade Yii renderer with Yii and it works great, except for modules.*

*I am setting the default view extension to '.jade' and everything works with Yii::Application: if I have two view files like 'account.php' and 'account.jade', Yii will intelligently use the Jade version.*

*However, for modules, the behaviour is quite funky. ;D*


*I am using Dektrium/yii2-user and I have setup the pathmap for the view component.*

*It works for php views, but when I change the overridden views to jade views, Yii rudely chooses to use the php versions from the user module..*

*BUT...!*

*If I create an empty view file in the Dektrium view folder, Yii suddenly chooses to respect my rules :lol:*


*For example:*

*I have `'@common/views/profile/show.php'` and Yii does indeed use that instead of `'@dektrium/user/views/profile/show.php'`*

*When I change `'@common/views/profile/show.php'` to `'@common/views/profile/show.jade'` I would expect Yii to use that, but it doesn't.*

*So, I create a completely empty show.jade and drop it in '@dektrium/user/views/profile/' and it works - Yii uses my overridden jade view file. :P*
*Even if the original 'show.php' view file is present.*

That really threw me for a loop and appears to be a bug in Yii. ;)

To overcome that problem, without dumping empty view files in third-party code, you can add this custom View component to your project:

```php
class View extends \yii\web\View {

    /**
     * Override to always pass the current context to render
     * https://github.com/yiisoft/yii2/issues/4382
	 * @inheritDoc
	 */
    public function render($view, $params = array(), $context = null)
    {
        if ($context === null) {
            $context = $this->context;
        }

        return parent::render($view, $params, $context);
    }

    /**
     * If the view is not found by normal means
     * then use the theme pathmap to find it.
	 * @inheritDoc
	 */
    protected function findViewFile($view, $context = null)
    {
        $path = $view . '.' . $this->defaultExtension;
        if ($this->theme !== null) {
            $path = $this->theme->applyTo($path);
        }
        $viewfile = parent::findViewFile($path, $context);

        return $viewfile;
    }

}
```

And then, configure the View component in your config like this:

```php
        'view' => [
            'class' => 'app\components\View',
            'defaultExtension' => 'jade',
```
Not only will it allow you to override module views using a custom view extension (.jade), it will also enable you to override it with views that doesn't even exist in the overridden module!  
Yii is a neat framework. :)

## Links
[Tale Jade for PHP](http://jade.talesoft.io/)

[Jade Tutorial](http://www.learnjade.com/tour/intro/)


## License

Tale Jade extension for Yii2 Framework is released under the MIT license.
