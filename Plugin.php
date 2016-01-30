<?php

namespace Kanboard\Plugin\GithubAuth;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Core\Security\Role;
use Kanboard\Plugin\GithubAuth\Auth\GithubAuthProvider;

class Plugin extends Base
{
    public function initialize()
    {
        $this->on('app.bootstrap', function ($container) {
            Translator::load($container['config']->getCurrentLanguage(), __DIR__.'/Locale');
        });

        $this->authenticationManager->register(new GithubAuthProvider($this->container));
        $this->applicationAccessMap->add('OAuth', 'handler', Role::APP_PUBLIC);

        $this->route->addRoute('/oauth/github', 'OAuth', 'handler', 'GithubAuth');

        $this->template->hook->attach('template:auth:login-form:after', 'GithubAuth:auth/login');
        $this->template->hook->attach('template:config:integrations', 'GithubAuth:config/integration');
        $this->template->hook->attach('template:user:external', 'GithubAuth:user/external');
        $this->template->hook->attach('template:user:authentication:form', 'GithubAuth:user/authentication');
        $this->template->hook->attach('template:user:create-remote:form', 'GithubAuth:user/create_remote');
    }

    public function getPluginName()
    {
        return 'Github Authentication';
    }

    public function getPluginDescription()
    {
        return t('Use Github as authentication provider');
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-github-auth';
    }
}
