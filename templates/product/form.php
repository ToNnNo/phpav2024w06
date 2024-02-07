<input type="hidden" name="token" value="<?=$this->e($token)?>" />

<div class="mb-3">
    <label class="form-label" for="name">Nom</label>
    <input type="text" name="name" id="name" class="form-control" value="<?=$this->e($product->getName())?>" />
</div>

<div class="mb-3">
    <label class="form-label" for="description">Description</label>
    <textarea class="form-control" name="description" id="description"><?=$this->e($product->getDescription())?></textarea>
</div>

<div class="mb-3">
    <label class="form-label" for="price">Prix</label>
    <input type="text" name="price" id="price" class="form-control" value="<?=$this->e($product->getPrice())?>" />
</div>
