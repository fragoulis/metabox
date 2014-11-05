A metabox is simply part of the website, whose contents can be drawn from an AJAX call and get refreshed anytime or using an interval.

##Changelog

**0.4**  
Added custom css, header and footer support.

**0.3**  
Added begin/end support to render initial content.

##Update guide

**From 0.3 to 0.4**  
PHP: Replace attribute _initHtml_ with _content_  
JS: Replace _this.$element_ with _this.$content_ in ajax callbacks 

##Requirements

Tested on Yii 1.1.12

##Usage

Simple initialisation:
~~~php
$this->widget('ext.metabox.EMetabox', array(
 'id' => 'mymetabox',
 'url' => array('/myurl'),
));
~~~

This prints:
~~~html
<div id="mymetabox" class="metabox">
  <div class="metabox-content"></div>
</div>
~~~

and
~~~javascript
$('#mymetabox').metabox({url : 'myurl'});
~~~

You can refresh it manually, using JavaScript, without parameters
~~~javascript
$('#mymetabox').metabox('refresh');
~~~
or with extra parameters
~~~javascript
$('#mymetabox').metabox('refresh', {
  type: 'POST', 
  data : {
  }
});
~~~

You can initialize it with an interval so that it auto-refreshes:
~~~php
$this->widget('ext.metabox.EMetabox', array(
 'id' => 'mymetabox',
 'url' => array('/myurl'),
 'options' => array(
  'refreshInterval' => 1000, // refresh every second
 )
));
~~~

The metabox can have initial content. You can use the content attribute:
~~~php
$this->widget('ext.metabox.EMetabox', array(
  ...
  'content' => 'Initial content'
));
~~~

or the begin/end:
~~~php
$this->beginWidget('ext.metabox.EMetabox', array(
  ...
));
echo 'Initial content';
$this->endWidget();
~~~

You can optionally add a header and/or a footer to the metabox:
~~~php
$this->widget('ext.metabox.EMetabox', array(
  'header' => 'My title',
  'footer' => date('H:i:s'),
  'content' => 'Initial content'
));
~~~

There are also three callbacks you can override which are called in the order shown below:

- beforeRefresh()  
- handleResponse(response data)  
- afterRefresh(response data)  

Metabox::handleResponse by default updates the div's contents with the response data. Within the scope of these methods, **this** refers to the metabox object. You can access the outer div element by calling the **$element** attribute and the inner content div by calling the **$content** attribute as shown below in the example.  
_Also, you can access the header and footer divs (if they exist) by callcing the **$header** and **$footer** attribute respectively._

~~~php
$this->widget('ext.metabox.EMetabox', array(
 ...
 'options' => array(
  'handleResponse' => 'js:function(data){this.$content.html(data);}
 )
));
~~~

##Examples
[With HTML response](http://jsfiddle.net/jfragoulis/dqEHC/40/ "With Html Response")  
[With JSON response](http://jsfiddle.net/jfragoulis/wf5Xb/4/ "With Json Response")

##Installation

Unzip into the extensions folder.

##Resources

[Github](https://github.com/jfragoulis/metabox "Github")  

test
