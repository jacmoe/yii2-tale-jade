<?php

namespace jacmoe\talejade;

use Yii;
use yii\base\ViewRenderer as BaseViewRenderer;
use Tale\Jade;

class JadeViewRenderer extends BaseViewRenderer
{

    /**
    * @var mixed The parser
    */
    protected $parser;
    
    /**
    * @var string the directory or path alias pointing to where Haml cache will be stored.
    */
    public $cachePath = '@runtime/Jade/cache';

    /**
    * @var bool Whether to by-pass cache, useful when debugging
    */
    public $debug = false;

    /**
    * Init a haml parser instance
    */
    public function init()
    {
        parent::init();

        $this->parser = new Jade\Renderer();

        $this->parser = new Jade\Renderer([
            'adapterOptions' => [
            'path' => Yii::getAlias($this->cachePath)
        ]
        ]);
        
        //$haml = new MtHaml\Environment('php', $this->options, $this->getFilters());
        //$this->parser = new \mervick\mthaml\override\Executor($haml, [
        //'cache' => Yii::getAlias($this->cachePath),
        //'debug' => $this->debug
        //]);
    }

    /**
    * Renders a view file.
    *
    * This method is invoked by [[View]] whenever it tries to render a view.
    * Child classes must implement this method to render the given view file.
    *
    * @param View $view the view object used for rendering the file.
    * @param string $file the view file.
    * @param array $params the parameters to be passed to the view file.
    * @return string the rendering result
    */
    public function render($view, $file, $params)
    {
        $this->parser->addPath(dirname($file));
        return $this->parser->render(pathinfo($file, PATHINFO_BASENAME), $params + ['app' => Yii::$app, 'this' => $view, 'view' => $view]);
    }
}
