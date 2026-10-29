'use strict';
(() => {
  const form = document.querySelector('#qr-form');
  const input = document.querySelector('#qr-url');
  const error = document.querySelector('#qr-error');
  const result = document.querySelector('#qr-result');
  let blobUrl;
  const reset = () => {
    result.hidden = true;
    error.textContent = '';
    if (blobUrl) URL.revokeObjectURL(blobUrl);
    blobUrl = undefined;
    document.querySelector('#qr-download').removeAttribute('href');
  };
  input.addEventListener('input', reset);
  form.addEventListener('submit', event => {
    event.preventDefault();
    reset();
    try {
      const url = new URL(input.value.trim());
      if (url.protocol !== 'https:' || !url.hostname.includes('.') || url.username || url.password || /^(localhost|127\.|0\.|192\.168\.|10\.)/.test(url.hostname)) {
        throw new Error('Unesite javnu HTTPS adresu bez korisničkog imena i lozinke.');
      }
      // Percent-encode non-ASCII characters so the QR payload uses portable ASCII bytes.
      const target = url.href.replace(/[^\x00-\x7F]/g, c => encodeURIComponent(c));
      const qr = qrcode(0, 'M');
      qr.addData(target, 'Byte');
      qr.make();
      const svg = qr.createSvgTag({cellSize:8,margin:32,scalable:true});
      document.querySelector('#qr-image').innerHTML = svg;
      document.querySelector('#qr-target').textContent = target;
      blobUrl = URL.createObjectURL(new Blob([svg], {type:'image/svg+xml;charset=utf-8'}));
      document.querySelector('#qr-download').href = blobUrl;
      result.hidden = false;
    } catch (err) {
      error.textContent = err instanceof TypeError ? 'Adresa nije ispravna. Primer: https://vas-domen.rs/cenovnik/' : (err.message || 'Adresa je predugačka. Koristite kraću javnu adresu.');
    }
  });
  document.querySelector('#print-qr').addEventListener('click', () => window.print());
})();
