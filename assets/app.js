'use strict';
(() => {
  const tools = document.querySelector('#tools');
  if (!tools) return;
  tools.hidden = false;
  const search = document.querySelector('#search');
  const sections = [...document.querySelectorAll('.menu-section')];
  const buttons = [...document.querySelectorAll('[data-filter]')];
  const count = document.querySelector('#result-count');
  const normalize = text => text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g,'dj').replace(/Đ/g,'dj').toLowerCase();
  const texts = new Map([...document.querySelectorAll('[data-item]')].map(el => [el,normalize(el.textContent)]));
  let filter = 'all';
  function update() {
    const terms = normalize(search.value.trim()).split(/\s+/).filter(Boolean);
    let total = 0;
    sections.forEach(section => {
      let visible = 0;
      const allowed = filter === 'all' || section.dataset.group === filter;
      section.querySelectorAll('[data-item]').forEach(item => {
        const match = allowed && terms.every(term => texts.get(item).includes(term));
        item.hidden = !match;
        if (match) visible++;
      });
      section.hidden = visible === 0;
      const link = document.querySelector(`.category-nav a[href="#${section.id}"]`);
      link.hidden = !visible;
      total += visible;
    });
    count.textContent = `${count.dataset.label}: ${total}`;
    document.querySelector('#empty').hidden = total !== 0;
  }
  search.addEventListener('input', update);
  buttons.forEach(button => button.addEventListener('click', () => {
    filter = button.dataset.filter;
    buttons.forEach(b => b.setAttribute('aria-pressed', String(b === button)));
    update();
  }));
  update();
})();
