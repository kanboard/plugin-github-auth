<?php

namespace Kanboard\Plugin\GithubAuth\Auth;

use Kanboard\Core\Base;
use Kanboard\Core\Security\OAuthAuthenticationProviderInterface;
use Kanboard\Plugin\GithubAuth\User\GithubUserProvider;

/**
 * Github Authentication Provider
 *
 * @package  auth
 * @author   Frederic Guillot
 */
class GithubAuthProvider extends Base implements OAuthAuthenticationProviderInterface
{
    /**
     * User properties
     *
     * @access protected
     * @var \Kanboard\Plugin\GithubAuth\User\GithubUserProvider
     */
    protected $userInfo = null;

    /**
     * OAuth2 instance
     *
     * @access protected
     * @var \Kanboard\Core\Http\OAuth2
     */
    protected $service;

    /**
     * OAuth2 code
     *
     * @access protected
     * @var string
     */
    protected $code = '';

    /**
     * Get authentication provider name
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'Github';
    }

    /**
     * Authenticate the user
     *
     * @access public
     * @return boolean
     */
    public function authenticate()
    {
        $profile = $this->getProfile();

        if (! empty($profile)) {
            $this->userInfo = new GithubUserProvider($profile);
            return true;
        }

        return false;
    }

    /**
     * Set Code
     *
     * @access public
     * @param  string  $code
     * @return GithubAuthProvider
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get user object
     *
     * @access public
     * @return GithubUserProvider
     */
    public function getUser()
    {
        return $this->userInfo;
    }

    /**
     * Get configured OAuth2 service
     *
     * @access public
     * @return \Kanboard\Core\Http\OAuth2
     */
    public function getService()
    {
        if (empty($this->service)) {
            $this->service = $this->oauth->createService(
                $this->getClientId(),
                $this->getClientSecret(),
                $this->helper->url->to('OAuthController', 'handler', array('plugin' => 'GithubAuth'), '', true),
                $this->getOAuthAuthorizeUrl(),
                $this->getOAuthTokenUrl(),
                array()
            );
        }

        return $this->service;
    }

    /**
     * Get Github profile
     *
     * @access public
     * @return array
     */
    public function getProfile()
    {
        $this->getService()->getAccessToken($this->code);

        return $this->httpClient->getJson(
            $this->getApiUrl().'user',
            array($this->getService()->getAuthorizationHeader())
        );
    }

    /**
     * Unlink user
     *
     * @access public
     * @param  integer $userId
     * @return bool
     */
    public function unlink($userId)
    {
        return $this->userModel->update(array('id' => $userId, 'github_id' => ''));
    }

    /**
     * Get client id
     *
     * @access public
     * @return string
     */
    public function getClientId()
    {
        if (defined('GITHUB_CLIENT_ID') && GITHUB_CLIENT_ID) {
            return GITHUB_CLIENT_ID;
        }

        return $this->configModel->get('github_client_id');
    }

    /**
     * Get client secret
     *
     * @access public
     * @return string
     */
    public function getClientSecret()
    {
        if (defined('GITHUB_CLIENT_SECRET') && GITHUB_CLIENT_SECRET) {
            return GITHUB_CLIENT_SECRET;
        }

        return $this->configModel->get('github_client_secret');
    }

    /**
     * Get authorize url
     *
     * @access public
     * @return string
     */
    public function getOAuthAuthorizeUrl()
    {
        if (defined('GITHUB_OAUTH_AUTHORIZE_URL') && GITHUB_OAUTH_AUTHORIZE_URL) {
            return GITHUB_OAUTH_AUTHORIZE_URL;
        }

        return $this->configModel->get('github_authorize_url', 'https://github.com/login/oauth/authorize');
    }

    /**
     * Get token url
     *
     * @access public
     * @return string
     */
    public function getOAuthTokenUrl()
    {
        if (defined('GITHUB_OAUTH_TOKEN_URL') && GITHUB_OAUTH_TOKEN_URL) {
            return GITHUB_OAUTH_TOKEN_URL;
        }

        return $this->configModel->get('github_token_url', 'https://github.com/login/oauth/access_token');
    }

    /**
     * Get API url
     *
     * @access public
     * @return string
     */
    public function getApiUrl()
    {
        if (defined('GITHUB_API_URL') && GITHUB_API_URL) {
            return GITHUB_API_URL;
        }

        return $this->configModel->get('github_api_url', 'https://api.github.com/');
    }
}
