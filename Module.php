<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link http://github.com/zendframework/ZendSkeletonModule for the canonical source
 *       repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ZendSkeletonModule;

use Zend\EventManager\EventManager;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ControllerProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface
{

	public function getAutoloaderConfig ()
	{
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php'
			), 
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					// if we're in a namespace deeper than one level we need to fix the \
					// in the path
					__NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__)
				)
			)
		);
	}

	/**
	 * Module configuration
	 *
	 * @see \Zend\ModuleManager\Feature\ConfigProviderInterface::getConfig()
	 */
	public function getConfig ()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	/**
	 * Service Manager config for models, tables, etc
	 *
	 * @return array
	 */
	public function getServiceConfig ()
	{
		return include __DIR__ . '/config/module.service.php';
	}

	/**
	 * Service Manager config for the Controllers
	 *
	 * @return array
	 */
	public function getControllerConfig ()
	{
		return include __DIR__ . '/config/module.controller.php';
	}

	public function getViewHelperConfig ()
	{
	}

	public function onBootstrap ($e)
	{
		// You may not need to do this if you're doing it elsewhere in your
		// application
		$eventManager = $e->getApplication()
			->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}
}
