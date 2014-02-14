<?php
// auto-generated by sfViewConfigHandler
// date: 2013/12/17 10:18:18
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);

  $response->addStylesheet('jquery-ui-1.8.custom.css', '', array ());
  $response->addStylesheet('layout.css', '', array ());
  $response->addStylesheet('content.css', '', array ());
  $response->addStylesheet('menu.css', '', array ());
  $response->addStylesheet('jquery.autocompleter.css', '', array ());
  $response->addJavascript('jquery-1.4.2.min.js', '', array ());
  $response->addJavascript('menuAnimation.js', '', array ());
  $response->addJavascript('resize.js', '', array ());
  $response->addJavascript('jquery-ui-1.8.custom.min.js', '', array ());
  $response->addJavascript('jquery.autocompleter.js', '', array ());
  $response->addJavascript('jquery.dataTables.js', '', array ());

