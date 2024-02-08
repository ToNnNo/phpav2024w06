<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?= $this->e($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <header class="pt-5">
            <h1>Formation PHP Avancé</h1>
            <hr />
        </header>
        <nav class="nav">
            <a href="/" class="nav-link">Accueil</a>
            <a href="/pattern" class="nav-link">Design Pattern</a>
            <a href="/products" class="nav-link">Liste des produits</a>
            <a href="/openssl" class="nav-link">Crypter un message</a>
        </nav>
        <main>
            <?php
                /** @var \Symfony\Component\HttpFoundation\Session\Session $session */
                $session = $this->getSession();
                foreach($session->getFlashBag()->all() as $type => $messages):
            ?>
                <div class="alert alert-<?=$type?>">
                    <?php foreach ($messages as $message): ?>
                    <?=$message?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <?= $this->section('content') ?>
        </main>
        <footer>
            <p class="text-center small">Dawan Lille/FOAD - PHP Avancé - Février 2024</p>
        </footer>
    </div>
</body>
</html>
