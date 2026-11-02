// Visionneuse des captures et surlignage du module visible dans la navigation.
(function () {
    const frames = Array.from(document.querySelectorAll('.shot__frame'));
    const dialog = document.getElementById('lightbox');
    const image = document.getElementById('lightbox-img');
    const caption = document.getElementById('lightbox-caption');
    const counter = document.getElementById('lightbox-count');
    let current = 0;

    function show(index) {
        current = (index + frames.length) % frames.length;
        const frame = frames[current];
        const thumb = frame.querySelector('img');
        const text = frame.parentElement.querySelector('figcaption');
        const tag = text && text.querySelector('.tag');
        const description = text ? text.textContent.replace(tag ? tag.textContent : '', '').trim() : '';
        image.src = frame.dataset.full;
        image.alt = thumb.alt;
        caption.textContent = thumb.alt + (tag ? ' (' + tag.textContent.trim() + ')' : '') + (description ? ' — ' + description : '');
        counter.textContent = (current + 1) + ' / ' + frames.length;
        dialog.querySelector('.lightbox__stage').scrollTop = 0;
    }

    if (dialog && typeof dialog.showModal === 'function') {
        frames.forEach(function (frame, index) {
            frame.addEventListener('click', function () {
                show(index);
                dialog.showModal();
            });
        });

        dialog.addEventListener('click', function (event) {
            const action = event.target.closest('[data-action]');
            if (action) {
                if (action.dataset.action === 'close') dialog.close();
                if (action.dataset.action === 'prev') show(current - 1);
                if (action.dataset.action === 'next') show(current + 1);
            } else if (event.target === dialog) {
                dialog.close(); // clic sur le fond
            }
        });

        dialog.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowLeft') show(current - 1);
            if (event.key === 'ArrowRight') show(current + 1);
        });
    } else {
        // Navigateur sans <dialog> : ouverture de l'image dans un nouvel onglet
        frames.forEach(function (frame) {
            frame.addEventListener('click', function () { window.open(frame.dataset.full, '_blank'); });
        });
    }

    // Module actif dans la barre de navigation
    const links = Array.from(document.querySelectorAll('.modnav a'));
    const bar = document.querySelector('.modnav__inner');
    if (bar && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                links.forEach(function (link) {
                    const active = link.getAttribute('href') === '#' + entry.target.id;
                    link.classList.toggle('is-active', active);
                    // Défilement horizontal de la barre seulement : scrollIntoView interromprait le défilement de la page
                    if (active) bar.scrollLeft = link.offsetLeft - (bar.clientWidth - link.offsetWidth) / 2;
                });
            });
        }, { rootMargin: '-45% 0px -50% 0px' });
        document.querySelectorAll('.module').forEach(function (section) { observer.observe(section); });
    }
})();
