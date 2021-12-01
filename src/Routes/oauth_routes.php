<?php
/*
 * This file is part of the Goteo Package.
 *
 * (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
 *
 * For the full copyright and license information, please view the README.md
 * and LICENSE files that was distributed with this source code.
 */

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$oauthRoutes = new RouteCollection();

$oauthRoutes->add('oauth_access_token', new Route(
    '/access_token',
    [
        '_controller' => 'Goteo\Controller\OAuthController::accessTokenAction',
    ]
));
$oauthRoutes->add('oauth_authorization', new Route(
    '/authorization',
    [
        '_controller' => 'Goteo\Controller\OAuthController::authorizationAction',
    ]
));

return $oauthRoutes;
