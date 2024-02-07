<?php $this->layout('base', ['title' => "Liste des produits"]); ?>

<h2>Liste des produits</h2>

<div class="mb-3">
    <a href="/products/add" class="btn btn-outline-dark btn-sm">Ajouter un produit</a>
</div>

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Updated At</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    /** @var \App\Entity\Product $product */
    foreach ($products as $product): ?>
    <tr>
        <td><?= $this->e($product->getId())?></td>
        <td><?= $this->e($product->getName())?></td>
        <td><?= $this->e($product->getDescription())?></td>
        <td><?= $this->e($product->getPrice())?></td>
        <td><?= $product->getUpdatedAt() ? date("c", $product->getUpdatedAt()->getTimestamp()) : "-"?></td>
        <td>
            <a href="/products/<?= $this->e($product->getId())?>/edit">Modifier</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
