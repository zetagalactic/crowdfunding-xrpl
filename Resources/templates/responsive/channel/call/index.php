<?php

//$meta_img = $this->workshop->header_image ? $this->workshop->getHeaderImage()->getLink(700, 700, false, true) : $this->asset('img/blog/header_default.png') ;

$this->layout('channel/call/layout', [
	'bodyClass' => 'channel-call',
    'title' => $this->channel->name,
    'meta_description' => $this->channel->subtitle,
    ]);

$this->section('channel-content');

?>

<?= $this->insert('channel/call/partials/banner_header') ?>

<?= $this->insert('channel/call/partials/main_info') ?>

<?= $this->insert('channel/call/partials/call_to_action') ?>

<?= $this->insert('channel/call/partials/projects') ?>

<?= $this->insert('partials/components/values', [
    'title' => $this->values->main_title,
    'footprints' => $this->footprints,
    'sdg_by_footprint' => $this->sdg_by_footprint,
    'projects_by_footprint' => $this->projects_by_footprint
]) ?>

<?= $this->insert('channel/call/partials/posts_section') ?>

<?= $this->insert('channel/call/partials/program') ?>

<?= $this->insert('channel/call/partials/stories') ?>

<?= $this->insert('channel/call/partials/related_workshops') ?>

<?= $this->insert('channel/call/partials/resources') ?>

<?php if ($dataSetsSection = $this->nodeSections['data_sets']): ?>
    <?= $this->insert("channel/call/partials/data_sets", ['dataSetsSection' => $dataSetsSection]); ?>
<?php endif; ?>

<?= $this->insert('channel/call/partials/map') ?>

<?= $this->insert('channel/call/partials/team') ?>

<?= $this->insert('channel/call/partials/sponsors') ?>

<?= $this->insert('channel/call/partials/modal_program') ?>

<?php $this->replace() ?>
