<h3><i class="fa fa-github fa-fw"></i> <?= t('Github Account') ?></h3>

<p class="listing">
<?php if ($this->user->isCurrentUser($user['id'])): ?>
    <?php if (empty($user['github_id'])): ?>
        <?= $this->url->link(t('Link my Github Account'), 'OAuth', 'handler', array('plugin' => 'GithubAuth'), true) ?>
    <?php else: ?>
        <?= $this->url->link(t('Unlink my Github Account'), 'oauth', 'unlink', array('backend' => 'Github'), true) ?>
    <?php endif ?>
<?php else: ?>
    <?= empty($user['github_id']) ? t('No account linked.') : t('Account linked.') ?>
<?php endif ?>
</p>