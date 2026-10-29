<?php
require __DIR__ . '/includes/bootstrap.php';
$menu = data('menu');
page_head($t['menu'], $lang);
?>
<body id="top">
<a class="skip-link" href="#menu-content"><?= e($t['menu']) ?></a>
<header class="topbar"><div class="topbar-inner">
<a class="brand" href="index.php" aria-label="<?= e($t['home']) ?>"><img src="assets/img/logo.png" alt="Pizzeria Mamma Mia" width="100" height="70"></a>
<span class="topbar-city">PIZZERIA · SOMBOR</span>
<nav class="language-nav" aria-label="<?= e($t['change']) ?>">
<?php foreach($languages as $code=>$name): ?>
<a href="menu.php?lang=<?= e($code) ?>" lang="<?= e($code) ?>" hreflang="<?= e($code) ?>" aria-label="<?= e($name) ?>" <?= $code===$lang ? 'aria-current="page"' : '' ?>><?= e(strtoupper($code)) ?></a>
<?php endforeach; ?>
</nav></div></header>
<section class="hero"><div class="hero-inner"><span class="eyebrow">MAMMA DI TUTTE LE PIZZE</span><h1><?= e($t['menu']) ?></h1><p><?= e($t['intro']) ?></p><div class="hero-line"></div></div></section>
<main id="menu-content" class="menu-layout">
<aside class="sidebar"><div class="sidebar-inner"><p class="eyebrow">MAMMA MIA</p><nav aria-label="<?= e($t['menu']) ?>" class="category-nav">
<?php foreach($menu['categories'] as $cat): ?><a href="#<?= e($cat['id']) ?>"><?= e($cat['name'][$lang]) ?><span aria-hidden="true">↗</span></a><?php endforeach; ?>
</nav><div class="delivery-box"><span><?= e($t['delivery']) ?></span><strong><?= money($site['deliveryPrice']) ?> <small>RSD</small></strong><a href="tel:<?= e($site['phones'][0]['href']) ?>"><?= e($site['phones'][0]['display']) ?></a></div></div></aside>
<div class="menu-main">
<div class="tools" hidden id="tools"><label class="search-label" for="search"><?= e($t['search']) ?></label><input id="search" type="search" placeholder="<?= e($t['search']) ?>…" autocomplete="off" maxlength="150"><div class="filters" role="group" aria-label="<?= e($t['menu']) ?>"><?php foreach(['all','food','drinks'] as $group): ?><button type="button" data-filter="<?= e($group) ?>" aria-pressed="<?= $group==='all'?'true':'false' ?>"><?= e($t[$group]) ?></button><?php endforeach; ?></div><p class="result-count" id="result-count" role="status" data-label="<?= e($t['results']) ?>"></p></div>
<noscript><p class="notice"><?= e($t['noscript']) ?></p></noscript>
<p class="price-note"><?= e($t['prices']) ?></p>
<p id="empty" class="empty" hidden><?= e($t['empty']) ?></p>
<?php foreach($menu['categories'] as $index=>$cat): ?>
<section class="menu-section" id="<?= e($cat['id']) ?>" data-group="<?= e($cat['group']) ?>">
<div class="section-heading"><span class="section-number"><?= sprintf('%02d',$index+1) ?></span><h2><?= e($cat['name'][$lang]) ?></h2><span class="heading-line"></span></div>
<div class="items">
<?php foreach($menu['items'] as $item): if($item['category']!==$cat['id']) continue; ?>
<article class="menu-item" data-item="<?= e($item['id']) ?>"><div class="item-copy"><h3><?= e($item['name'][$lang]) ?></h3><?php if($item['description'][$lang]): ?><p><?= e($item['description'][$lang]) ?></p><?php endif; ?></div><dl class="prices <?= count($item['variants'])>1?'multiple':'' ?>">
<?php foreach($item['variants'] as $variant): ?>
<div><dt><?= e($variant['label'] ? $t[$variant['label']] : '') ?><?= $variant['label'] && $variant['volume']?' · ':'' ?><?= e(str_replace('.', ',', $variant['volume'])) ?></dt><dd><?= money($variant['price']) ?> <small>RSD</small></dd></div>
<?php endforeach; ?>
</dl></article>
<?php endforeach; ?>
</div></section>
<?php endforeach; ?>
<p class="allergens"><?= e($t['allergens']) ?></p>
</div></main>
<footer class="footer"><div><span class="eyebrow">PIZZERIA · SOMBOR</span><h2>Mamma Mia</h2><p><?= e($site['address']) ?></p><p><?= e($t['delivery']) ?> · <?= money($site['deliveryPrice']) ?> RSD</p></div><div><p><?= e($t['call']) ?></p><?php foreach($site['phones'] as $phone): ?><a href="tel:<?= e($phone['href']) ?>"><?= e($phone['display']) ?></a><?php endforeach; ?></div><a class="back-top" href="#top"><?= e($t['back']) ?> ↑</a></footer>
<script src="assets/app.js" defer></script>
</body></html>
