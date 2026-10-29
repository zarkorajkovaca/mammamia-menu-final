<?php require __DIR__ . '/includes/bootstrap.php'; page_head('Dobro došli / Welcome', 'sr'); ?>
<body class="welcome-page">
<main class="welcome">
<a class="brand welcome-brand" href="index.php" aria-label="Mamma Mia Sombor"><img src="assets/img/logo.png" width="160" height="112" alt="Pizzeria Mamma Mia"></a>
<div class="eyebrow">PIZZERIA · SOMBOR</div>
<h1>Dobro došli<br><em>za naš sto.</em></h1>
<p class="welcome-sub" lang="en">Welcome to our table.</p>
<div class="rule"></div>
<p class="choose">Izaberite jezik <span lang="en">/ Choose your language</span></p>
<nav class="language-grid" aria-label="Izbor jezika / Language selection">
<?php foreach ($languages as $code=>$name): ?>
<a href="menu.php?lang=<?= e($code) ?>" lang="<?= e($code) ?>" hreflang="<?= e($code) ?>"><span class="language-code"><?= e(strtoupper($code)) ?></span><span><?= e($name) ?></span><span aria-hidden="true">↗</span></a>
<?php endforeach; ?>
</nav>
<p class="welcome-address"><?= e($site['address']) ?><br><a href="tel:<?= e($site['phones'][0]['href']) ?>"><?= e($site['phones'][0]['display']) ?></a> · <a href="tel:<?= e($site['phones'][1]['href']) ?>"><?= e($site['phones'][1]['display']) ?></a></p>
</main>
<footer class="welcome-footer">Mamma Mia · Mamma di tutte le pizze</footer>
</body></html>
