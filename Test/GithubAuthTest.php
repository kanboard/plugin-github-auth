<?php

require_once 'tests/units/Base.php';

use Kanboard\Plugin\GithubAuth\Auth\GithubAuthProvider;
use Kanboard\Model\UserModel;

class GithubAuthTest extends Base
{
    public function testGetName()
    {
        $provider = new GithubAuthProvider($this->container);
        $this->assertEquals('Github', $provider->getName());
    }

    public function testGetClientId()
    {
        $provider = new GithubAuthProvider($this->container);
        $this->assertEmpty($provider->getClientId());

        $this->assertTrue($this->container['configModel']->save(array('github_client_id' => 'my_id')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('my_id', $provider->getClientId());
    }

    public function testGetClientSecret()
    {
        $provider = new GithubAuthProvider($this->container);
        $this->assertEmpty($provider->getClientSecret());

        $this->assertTrue($this->container['configModel']->save(array('github_client_secret' => 'secret')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('secret', $provider->getClientSecret());
    }

    public function testGetOAuthAuthorizeUrl()
    {
        $provider = new GithubAuthProvider($this->container);
        $this->assertEquals('https://github.com/login/oauth/authorize', $provider->getOAuthAuthorizeUrl());

        $this->assertTrue($this->container['configModel']->save(array('github_authorize_url' => 'my auth url')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('my auth url', $provider->getOAuthAuthorizeUrl());
    }

    public function testGetOAuthTokenUrl()
    {
        $provider = new GithubAuthProvider($this->container);
        $this->assertEquals('https://github.com/login/oauth/access_token', $provider->getOAuthTokenUrl());

        $this->assertTrue($this->container['configModel']->save(array('github_token_url' => 'my token url')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('my token url', $provider->getOAuthTokenUrl());
    }

    public function testGetApiUrl()
    {
        $provider = new GithubAuthProvider($this->container);
        $this->assertEquals('https://api.github.com/', $provider->getApiUrl());

        $this->assertTrue($this->container['configModel']->save(array('github_api_url' => 'my api url')));
        $this->container['memoryCache']->flush();

        $this->assertEquals('my api url', $provider->getApiUrl());
    }

    public function testAuthenticationSuccessful()
    {
        $profile = array(
            'id' => 1234,
            'email' => 'test@localhost',
            'name' => 'Test',
        );

        $provider = $this
            ->getMockBuilder('\Kanboard\Plugin\GithubAuth\Auth\GithubAuthProvider')
            ->setConstructorArgs(array($this->container))
            ->setMethods(array(
                'getProfile',
            ))
            ->getMock();

        $provider->expects($this->once())
            ->method('getProfile')
            ->will($this->returnValue($profile));

        $this->assertInstanceOf('Kanboard\Plugin\GithubAuth\Auth\GithubAuthProvider', $provider->setCode('1234'));

        $this->assertTrue($provider->authenticate());

        $user = $provider->getUser();
        $this->assertInstanceOf('Kanboard\Plugin\GithubAuth\User\GithubUserProvider', $user);
        $this->assertEquals('Test', $user->getName());
        $this->assertEquals('', $user->getInternalId());
        $this->assertEquals(1234, $user->getExternalId());
        $this->assertEquals('', $user->getRole());
        $this->assertEquals('', $user->getUsername());
        $this->assertEquals('test@localhost', $user->getEmail());
        $this->assertEquals('github_id', $user->getExternalIdColumn());
        $this->assertEquals(array(), $user->getExternalGroupIds());
        $this->assertEquals(array(), $user->getExtraAttributes());
        $this->assertFalse($user->isUserCreationAllowed());
    }

    public function testAuthenticationFailed()
    {
        $provider = $this
            ->getMockBuilder('\Kanboard\Plugin\GithubAuth\Auth\GithubAuthProvider')
            ->setConstructorArgs(array($this->container))
            ->setMethods(array(
                'getProfile',
            ))
            ->getMock();

        $provider->expects($this->once())
            ->method('getProfile')
            ->will($this->returnValue(array()));

        $this->assertFalse($provider->authenticate());
        $this->assertEquals(null, $provider->getUser());
    }

    public function testGetService()
    {
        $provider = new GithubAuthProvider($this->container);
        $this->assertInstanceOf('Kanboard\Core\Http\OAuth2', $provider->getService());
    }

    public function testUnlink()
    {
        $userModel = new UserModel($this->container);
        $provider = new GithubAuthProvider($this->container);

        $this->assertEquals(2, $userModel->create(array('username' => 'test', 'github_id' => '1234')));
        $this->assertNotEmpty($userModel->getByExternalId('github_id', 1234));

        $this->assertTrue($provider->unlink(2));
        $this->assertEmpty($userModel->getByExternalId('github_id', 1234));
    }
}
