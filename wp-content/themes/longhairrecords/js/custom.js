/*
 Theme Name:        LongHair Records
 Theme URI:         https://www.longhairrecords.com
 Description:       Divi child theme for the LongHair Records website.
 Tags:              music, entertainment, e-commerce, woocommerce, responsive-design, custom-header, custom-menu, featured-images, threaded-comments, translation-ready, divi-child
 Author:            Richard Bakos @ Resonance Designs
 Author URI:        https://resonancedesigns.dev
 Template:          Divi
 Version:           2.0.4
 Requires at least: 5.0
 Tested up to:      6.8.2
 Requires PHP:      7.4
 License:           GNU General Public License v2 or later
 License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 Text Domain:       longhairrecords
*/

jQuery(function($){
    // Configuration objects for better maintainability
    const URL_REWRITES = {
        'records': '12-inch',
        '7-inch': '7-inch',
        '8-track': '8-track',
        'artwork': 'artwork',
        'beta': 'beta',
        'bluray': 'bluray',
        'books': 'books',
        'cards': 'cards',
        'cassette': 'cassette',
        'cd': 'cd',
        'clothes': 'clothes',
        'dvd': 'dvd',
        'game': 'games',
        'laserdisc': 'laserdisc',
        'patch': 'patches',
        'poster': 'posters',
        'selectavision': 'selectavision',
        'slipmat': 'slipmats',
        't-shirts': 't-shirts',
        'vhs': 'vhs',
        'gift-cards': 'gift-cards',
        'new-records': 'new-12-inch',
        'new-7-inch': 'new-7-inch',
        'new-cassette': 'new-cassette',
        'new-cd': 'new-cd',
        'new-vhs': 'new-vhs',
        'japanese-vhs': 'japanese-vhs'
    };

    const CATEGORIES_TO_HIDE = [
        'wash',
        'uncategorized',
        'equipment',
        'machine',
        'machines'
    ];

    const AWS_FILTER_MAP = {
        '12-inch': { text: '12-INCH', value: 4 },
        '7-inch': { text: '7-INCH', value: 2 },
        '8-track': { text: '8-TRACK', value: 13 },
        'artwork': { text: 'ARTWORK', value: 16 },
        'beta': { text: 'BETA', value: 14 },
        'bluray': { text: 'BLURAY', value: 15 },
        'books': { text: 'BOOKS', value: 5 },
        'cards': { text: 'CARDS', value: 17 },
        'cassette': { text: 'CASSETTE', value: 6 },
        'cd': { text: 'CD', value: 7 },
        'clothes': { text: 'CLOTHES', value: 18 },
        'dvd': { text: 'DVD', value: 8 },
        'games': { text: 'GAMES', value: 19 },
        'patches': { text: 'PATCHES', value: 20 },
        'selectavision': { text: 'SELECTAVISION', value: 21 },
        'slipmats': { text: 'SLIPMATS', value: 22 },
        't-shirts': { text: 'T-SHIRTS', value: 23 },
        'vhs': { text: 'VHS', value: 9 }
    };

    // URL Rewrites - Dynamic approach
    function setupURLRewrites() {
        const baseURL = 'https://longhairrecords.com';

        Object.entries(URL_REWRITES).forEach(([oldSlug, newSlug]) => {
            const oldHref = `${baseURL}/product-category/${oldSlug}/`;
            const newHref = `${baseURL}/${newSlug}/`;
            $(`a[href='${oldHref}']`).attr('href', newHref);
        });
    }

    // Hide categories - Dynamic approach
    function hideCertainCategories() {
        const baseURL = 'https://longhairrecords.com';

        CATEGORIES_TO_HIDE.forEach(category => {
            const href = `${baseURL}/product-category/${category}/`;
            $(`a[href='${href}']`).hide().next().hide();
        });
    }

    // Coupon/Gift Card input styling
    function setupInputStyling() {
        $('#coupon_code').on('click', function(){
            $('#coupon_code').removeClass('gc-selected');
            $(this).addClass('cc-selected');
        });

        $('#pwgc-redeem-gift-card-number').on('click', function(){
            $('#pwgc-redeem-gift-card-number').removeClass('cc-selected');
            $(this).addClass('gc-selected');
        });
    }

    // Store Announcement Pop-Up
    function setupStorePopup() {
        if (typeof DiviArea !== 'undefined') {
            DiviArea.addAction('ready', function() {
                const popupId = 'square-issue';
                setTimeout(() => DiviArea.show(popupId), 2000);
            });
        }
    }

    // AWS Filter Auto-Selection
    function setupAWSFilter() {
        const pathname = window.location.pathname;
        const pathSegments = pathname.split('/').filter(Boolean);
        const urlSlug = pathSegments.pop();

        // Check if we have a filter mapping for this slug
        const filterConfig = AWS_FILTER_MAP[urlSlug];

        if (filterConfig) {
            const filterElement = $('.aws-main-filter__current');
            const filterInput = $('input[name="aws_filter"]');

            // Only update if elements exist
            if (filterElement.length && filterInput.length) {
                filterElement.text(filterConfig.text);
                filterInput.val(filterConfig.value);
            }
        }
    }

    // Initialize all functionality
    function init() {
        setupURLRewrites();
        hideCertainCategories();
        setupInputStyling();
        setupStorePopup();

        // AWS filter setup - run when DOM is ready
        $(document).ready(setupAWSFilter);
    }

    // Run initialization
    init();
});