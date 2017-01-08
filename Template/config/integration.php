<h3><i class="fa fa-github fa-fw"></i><?= t('Github Authentication') ?></h3>
<div class="panel">
    <?= $this->form->label(t('Github OAuth callback URL'), 'github_oauth_url') ?>
    <input type="text" class="auto-select" readonly="readonly" value="<?= $this->url->href('OAuthController', 'handler', array('plugin' => 'GithubAuth'), false, '', true) ?>"/>

    <?= $this->form->label(t('Github Client Id'), 'github_client_id') ?>
    <?= $this->form->text('github_client_id', $values) ?>

    <?= $this->form->label(t('Github Client Secret'), 'github_client_secret') ?>
    <?= $this->form->password('github_client_secret', $values) ?>

    <?= $this->form->label(t('Github Authorize URL'), 'github_authorize_url') ?>
    <?= $this->form->text('github_authorize_url', $values) ?>
    <p class="form-help"><?= t('Leave blank to use the default URL.') ?></p>

    <?= $this->form->label(t('Github Token URL'), 'github_token_url') ?>
    <?= $this->form->text('github_token_url', $values) ?>

    <?= $this->form->label(t('Github API URL'), 'github_api_url') ?>
    <?= $this->form->text('github_api_url', $values) ?>

    <p class="form-help"><a href="https://github.com/kanboard/plugin-github-auth/blob/master/README.md"><?= t('Help on Github authentication') ?></a></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
