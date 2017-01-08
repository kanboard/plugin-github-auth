Github Authentication
=====================

[![Build Status](https://travis-ci.org/kanboard/plugin-github-auth.svg?branch=master)](https://travis-ci.org/kanboard/plugin-github-auth)

Link a Github account to a Kanboard user profile.

Author
------

- Frédéric Guillot
- License MIT

Requirements
------------

- Kanboard >= 1.0.37
- OAuth Github API credentials (available in your [Settings > Applications > Developer applications](https://github.com/settings/applications))

Installation
------------

You have the choice between 3 methods:

1. Install the plugin from the Kanboard plugin manager in one click
2. Download the zip file and decompress everything under the directory `plugins/GithubAuth`
3. Clone this repository into the folder `plugins/GithubAuth`

Note: Plugin folder is case-sensitive.

Documentation
-------------

### How does this work?

The Github authentication in Kanboard uses the [OAuth 2.0](http://oauth.net/2/) protocol, so any user of Kanboard can be linked to a Github account.

That means you can use your Github account to login on Kanboard.

### How to link a Github account

1. Go to your user profile
2. Click on **External accounts**
3. Click on the link **Link my Github Account**
4. You are redirected to the **Github Authorize application form**
5. Authorize Kanboard by clicking on the button **Accept**
6. Your account is now linked

Now, on the login page you can be authenticated in one click with the link **Login with my Github Account**.

Your name and email are automatically updated from your Github Account if defined.

### Installation instructions

#### Setting up OAuth 2.0

- On Github, go to the page [Register a new OAuth application](https://github.com/settings/applications/new)
- Just follow the [official Github documentation](https://developer.github.com/guides/basics-of-authentication/#registering-your-app)
- In Kanboard, you can get the **callback url** in **Settings > Integrations > Github Authentication**

#### Setting up Kanboard

1. The easiest way is to copy and paste the Github OAuth2 credentials in the form **Settings > Integrations > Github Authentication**.
2. Or add the credentials in your custom config file

![github-auth](https://cloud.githubusercontent.com/assets/323546/12696019/a42a31a2-c72c-11e5-9181-ed146ed0b74c.png)

If you use the second method, use these parameters in your `config.php`:

```php
// Github client id (Copy it from your settings -> Applications -> Developer applications)
define('GITHUB_CLIENT_ID', 'YOUR_GITHUB_CLIENT_ID');

// Github client secret key (Copy it from your settings -> Applications -> Developer applications)
define('GITHUB_CLIENT_SECRET', 'YOUR_GITHUB_CLIENT_SECRET');
```

#### Github Entreprise

To use this authentication method with Github Enterprise you have to change the default urls.

Replace these values by your self-hosted instance of Github:

```php
// Github oauth2 authorize url
define('GITHUB_OAUTH_AUTHORIZE_URL', 'https://github.com/login/oauth/authorize');

// Github oauth2 token url
define('GITHUB_OAUTH_TOKEN_URL', 'https://github.com/login/oauth/access_token');

// Github API url (don't forget the slash at the end)
define('GITHUB_API_URL', 'https://api.github.com/');
```

### Notes

Kanboard uses these information from your public Github profile:

- Full name
- Public email address
- Github unique id

The Github unique id is used to link the local user account and the Github account.
