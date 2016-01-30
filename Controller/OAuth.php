<?php

namespace Kanboard\Plugin\GithubAuth\Controller;

use Kanboard\Controller\Oauth as BaseOAuth;

/**
 * OAuth Controller
 *
 * @package  controller
 * @author   Frederic Guillot
 */
class Oauth extends BaseOAuth
{
    /**
     * Handle authentication
     *
     * @access public
     */
    public function handler()
    {
        $this->step1('Github');
    }
}
