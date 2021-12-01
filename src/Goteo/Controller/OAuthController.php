<?php
/*
* This file is part of the Goteo Package.
*
* (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
*
* For the full copyright and license information, please view the README.md
* and LICENSE files that was distributed with this source code.
*/

namespace Goteo\Controller;

use Goteo\Core\Controller;
use Symfony\Component\HttpFoundation\Request;


class OAuthController extends Controller {

    public function accessTokenAction(Request $request)
    {
        return $this->viewResponse('about/sample');
    }

    public function authorizationAction(Request $request)
    {
        return $this->viewResponse('about/sample');
    }
}
