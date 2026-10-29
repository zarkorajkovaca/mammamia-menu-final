<?php require __DIR__ . '/includes/bootstrap.php'; page_head('QR kod', 'sr'); ?>
<body><main class="qr-page">
<div class="no-print"><a href="index.php">← Mamma Mia</a><p class="eyebrow">ALAT ZA ŠTAMPU</p><h1>Jedan kod.<br>Šest jezika.</h1>
<p>Unesite konačnu HTTPS adresu početne stranice cenovnika na vašem hostingu. QR kod se generiše lokalno u pregledaču.</p>
<form id="qr-form"><label for="qr-url">Javna adresa cenovnika</label><input id="qr-url" type="url" required maxlength="500" placeholder="https://vas-domen.rs/cenovnik/" value="<?= e($site['publicUrl']) ?>"><button type="submit">Generiši QR kod</button></form>
<p class="error" id="qr-error" role="alert"></p>
<p class="qr-help">Kod vodi na izbor jezika. Pri promeni cena isti kod nastavlja da radi, sve dok adresa ostaje ista. Posle generisanja skenirajte ga telefonom i proverite adresu pre štampe.</p>
<noscript><p>Uključite JavaScript da biste generisali QR kod.</p></noscript></div>
<section id="qr-result" class="qr-result" hidden aria-label="QR kod za štampu"><p class="eyebrow">PIZZERIA · SOMBOR</p><h2>Mamma Mia</h2><div class="qr-image" id="qr-image"></div><p>Jelovnik · Menu · Étlap · Speisekarte · Menú · Меню</p><p class="qr-url" id="qr-target"></p><div class="no-print"><a class="download" id="qr-download" download="mamma-mia-qr.svg">Preuzmi SVG</a><button class="secondary" type="button" id="print-qr">Štampaj karticu</button></div></section>
</main><script src="assets/vendor/qrcode.js" defer></script><script src="assets/qr.js" defer></script></body></html>
