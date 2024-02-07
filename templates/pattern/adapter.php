<?php $this->layout('base', ['title' => "Design Pattern"]) ?>

<?php
    $intl = new NumberFormatter("Fr_fr", NumberFormatter::CURRENCY);
?>

<h2>Les Design Pattern</h2>
<h3>Adapter</h3>

<h4>Produit</h4>
<dl>
    <dt>Nom</dt>
    <dd><?= $this->e($product->getName()) ?></dd>
    <dt>Prix TTC</dt>
    <dd><?= $intl->format($product->getIncludingTaxes()) ?></dd>
</dl>
