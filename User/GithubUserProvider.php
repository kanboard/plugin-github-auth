<?php

namespace Kanboard\Plugin\GithubAuth\User;

use Kanboard\User\OAuthUserProvider;

/**
 * Github OAuth User Provider
 *
 * @package  user
 * @author   Frederic Guillot
 */
class GithubUserProvider extends OAuthUserProvider
{
    /**
     * Get external id column name
     *
     * @access public
     * @return string
     */
    public function getExternalIdColumn()
    {
        return 'github_id';
    }
}
