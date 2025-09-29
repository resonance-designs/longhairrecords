/*
 Theme Name:        LongHair Records
 Theme URI:         https://www.longhairrecords.com
 Description:       Divi child theme for the LongHair Records website.
 Tags:              music, entertainment, e-commerce, woocommerce, responsive-design, custom-header, custom-menu, featured-images, threaded-comments, translation-ready, divi-child
 Author:            Richard Bakos @ Resonance Designs
 Author URI:        https://resonancedesigns.dev
 Template:          Divi
 Version:           2.0.2
 Requires at least: 5.0
 Tested up to:      6.8.2
 Requires PHP:      7.4
 License:           GNU General Public License v2 or later
 License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 Text Domain:       longhairrecords
*/

/**
 * Admin collapsible menu JS
 */
jQuery(function($){
    console.log("✅ admin-custom.js loaded and running");
    const headers = document.querySelectorAll('.lhr-admin-menu-hl');

    headers.forEach(header => {
        header.classList.add('lhr-collapsible-header');

        // Create wrapper <li> with inner <ul> for submenu items
        const wrapperLi = document.createElement('li');
        wrapperLi.className = 'lhr-submenu-group-li';
        const innerUl = document.createElement('ul');
        innerUl.className = 'lhr-submenu-group';
        wrapperLi.appendChild(innerUl);

        // Move following siblings into the inner <ul>
        let sibling = header.nextElementSibling;
        while (sibling && !sibling.classList.contains('lhr-admin-menu-hl') && !sibling.classList.contains('wp-menu-separator')) {
            const next = sibling.nextElementSibling;
            innerUl.appendChild(sibling);
            sibling = next;
        }
        header.parentNode.insertBefore(wrapperLi, sibling);

        // localStorage key
        const key = 'lhr-group-' + header.innerText.trim();

        // Restore state
        if (localStorage.getItem(key) === 'open') {
            header.classList.add('lhr-open');
            innerUl.style.maxHeight = innerUl.scrollHeight + 'px';
            innerUl.style.opacity = '1';
            // reveal children immediately
            innerUl.querySelectorAll('li').forEach(child => {
                child.style.opacity = '1';
                child.style.transform = 'translateY(0)';
            });
        } else {
            innerUl.style.maxHeight = '0';
            innerUl.style.opacity = '0';
        }

        // Toggle open/close
        const anchor = header.querySelector('a');
        if (anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                header.classList.toggle('lhr-open');

                if (header.classList.contains('lhr-open')) {
                    innerUl.style.display = 'block';
                    const height = innerUl.scrollHeight + 'px';
                    innerUl.style.maxHeight = '0';
                    innerUl.style.opacity = '0';

                    requestAnimationFrame(() => {
                        innerUl.style.transition = 'max-height 0.3s ease, opacity 0.3s ease';
                        innerUl.style.maxHeight = height;
                        innerUl.style.opacity = '1';

                        // staggered child animation
                        const children = innerUl.querySelectorAll('li');
                        children.forEach((child, index) => {
                            child.style.transitionDelay = (index * 50) + 'ms';
                            child.style.opacity = '1';
                            child.style.transform = 'translateY(0)';
                        });
                    });
                } else {
                    innerUl.style.maxHeight = '0';
                    innerUl.style.opacity = '0';

                    // collapse children all together
                    const children = innerUl.querySelectorAll('li');
                    children.forEach(child => {
                        child.style.transitionDelay = '0ms';
                        child.style.opacity = '0';
                        child.style.transform = 'translateY(-4px)';
                    });

                    innerUl.addEventListener('transitionend', function handler() {
                        innerUl.style.display = 'none';
                        innerUl.removeEventListener('transitionend', handler);
                    });
                }

                localStorage.setItem(key, header.classList.contains('lhr-open') ? 'open' : 'closed');
            });
        }

        // Recalculate height on window resize
        window.addEventListener('resize', () => {
            if (header.classList.contains('lhr-open')) {
                innerUl.style.display = 'block';
                const height = innerUl.scrollHeight + 'px';
                innerUl.style.maxHeight = height;
            }
        });
    });
});