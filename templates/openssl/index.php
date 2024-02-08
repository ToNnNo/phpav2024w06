<?php $this->layout('base', ['title' => "Open SSL"]); ?>

<h2>Open Ssl</h2>

<form method="post" action="">
    <div class="mb-3">
        <label class="form-label" for="message">Message Secret</label>
        <textarea class="form-control" name="message" id="message"></textarea>
        <p class="form-text">Maximum 245 caractères</p>
    </div>

    <button class="btn btn-outline-dark">Enregistrer le message</button>
</form>
