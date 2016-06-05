<ul class="no-bullet">
    <li>
        <i class="fa fa-github fa-fw"></i>
        <?= $this->url->link(t('Login with my Github Account'), 'OAuthController', 'handler', array('plugin' => 'GithubAuth')) ?>
    </li>
</ul>
