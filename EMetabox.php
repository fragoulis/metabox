<?php

/**
 * Metabox Yii Extension.
 * 
 * Easily draw a div and load remote content into it, refresh manually,
 * refresh with an internval or timeout.
 * 
 * @author Yannis Fragkoulis <yannis.fragkoulis@gmail.com>
 * @version 0.4
 */
class EMetabox extends CWidget
{

    /**
     * @var array the javascript options
     */
    public $options = array();

    /**
     * @var array the html options
     */
    public $htmlOptions = array();

    /**
     * @var string ajax loading indicator
     */
    public $loadingIndicator;

    /**
     * @var mixed the refresh url
     */
    public $url;

    /**
     * @var boolean if true the metabox will refresh on window load
     */
    public $refreshOnInit = false;

    /**
     * @var string the box header. Optional.
     * @since 0.4
     */
    public $header;

    /**
     * @var string the box footer. Optional.
     * @since 0.4
     */
    public $footer;

    /**
     * @var string the initial contents of the div. Optional.
     * @since 0.4
     */
    public $content;

    /**
     * @var string the default css class
     * @since 0.4
     */
    public $cssClass = 'metabox';

    /**
     * @var type 
     */
    static private $_assets;

    /**
     * 
     */
    public function init()
    {
        if (self::$_assets == null)
            self::$_assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', false, 1, YII_DEBUG);

        $id = $this->id;
        if (!isset($this->htmlOptions['id']))
            $this->htmlOptions['id'] = $id;

        if (!isset($this->htmlOptions['class']))
            $this->htmlOptions['class'] = $this->cssClass;
        else
            $this->htmlOptions['class'] = $this->cssClass . ' ' . $this->htmlOptions['class'];

        if ($this->loadingIndicator == null)
            $this->loadingIndicator = CHtml::image(self::$_assets . '/loader.gif', 'loading...');

        $this->url = CHtml::normalizeUrl($this->url);

        if (!$this->url)
            $this->url = Yii::app()->getRequest()->getUrl();

        $this->options['url'] = $this->url;
        $this->options['cssClass'] = $this->cssClass;
        $this->options['loadingText'] = $this->loadingIndicator;
        $this->options['refreshOnInit'] = $this->refreshOnInit;

        echo CHtml::openTag('div', $this->htmlOptions);
        $this->renderHeader();
        echo CHtml::openTag('div', array('class' => $this->cssClass . '-content'));
        $this->renderContent();
    }

    /**
     * Register extension assets
     */
    public function run()
    {
        echo '</div>'; // close content div
        $this->renderFooter();
        echo '</div>'; // close metabox div

        $id = $this->id;

        /* @var $cs CClientScript */
        $cs = Yii::app()->getClientScript();

        $min = YII_DEBUG ? '' : '.min';

        // Register jQuery scripts
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('bbq');

        $options = CJavaScript::encode($this->options);
        $cs->registerScriptFile(self::$_assets . '/jquery.metabox' . $min . '.js');
        $cs->registerCSSFile(self::$_assets . '/metabox' . $min . '.css');
        $cs->registerScript('metabox#' . $id, "$('#{$id}').metabox({$options});", CClientScript::POS_READY);
    }

    protected function renderHeader()
    {
        if ($this->header)
        {
            echo CHtml::openTag('div', array('class' => $this->cssClass . '-header'));
            echo $this->header;
            echo '</div>'; // close header div
        }
    }

    protected function renderFooter()
    {
        if ($this->footer)
        {
            echo CHtml::tag('div', array('class' => $this->cssClass . '-footer'), $this->footer);
        }
    }

    protected function renderContent()
    {
        echo $this->content;
    }

}

?>