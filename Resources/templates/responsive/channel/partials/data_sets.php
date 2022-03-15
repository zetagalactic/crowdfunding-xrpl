<?php
if ($section = current($this->channel->getSections('data_sets'))):
    $dataSets = $this->channel->getAllDataSet();
?>

<div class="section data-sets">
    <div class="container">
        <h2 class="title"><?= $section->main_title ?></h2>
        <p class="description">
            <?= $section->main_description ?>
        </p>
        <?= $this->insert('partials/components/data_sets', ['dataSets' => $this->dataSets]) ?>
    </div>
</div>

<?php endif; ?>
