<?php
    $section = $this->dataSetsSection;
?>

<div class="section data-sets-section">
    <div class="container" style="<?= $this->colors['secondary'] ? "color:".$this->colors['secondary'] : '' ?>" >
        <h2 class="title" style="<?= $this->colors['primary'] ? "color:".$this->colors['primary'] : '' ?>">
            <span class="icon icon-book icon-3x" style="<?= $this->colors['secondary'] ? "color:".$this->colors['secondary'] : '' ?>"></span>
            <?= $section->main_title ?>
        </h2>
        <p class="description">
            <?= $section->main_description ?>
        </p>
        <?= $this->insert('partials/components/data_sets', ['dataSets' => $this->dataSets]) ?>
    </div>
</div>
