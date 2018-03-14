<?php

namespace App;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('kontakt/', 'Core:Contact:default');
		$router[] = new Route('administracte/', 'Core:Administration:default');
		$router[] = new Route('[<action>/][<url>]', array(
            'presenter' => 'Core:Article',
            'action' => array(
                Route::VALUE => 'default',
                Route::FILTER_TABLE => array(
                    'seznam-clanku' => 'list',
                    'editor' => 'editor',
                    'odstranit' => 'remove'
                ),
                Route::FILTER_STRICT => true
            ),
            'url' => null,
        ));
		$router[] = new Route('[<url>]', 'Core:Article:default');
		return $router;
	}
}
