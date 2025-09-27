
/*
 Theme Name:        LongHair Records
 Theme URI:         https://www.longhairrecords.com
 Description:       Divi child theme for the LongHair Records website.
 Tags:              music, entertainment, e-commerce, woocommerce, responsive-design, custom-header, custom-menu, featured-images, threaded-comments, translation-ready, divi-child
 Author:            Richard Bakos @ Resonance Designs
 Author URI:        https://resonancedesigns.dev
 Template:          Divi
 Version:           2.0.0
 Requires at least: 5.0
 Tested up to:      6.7
 Requires PHP:      7.4
 License:           GNU General Public License v2 or later
 License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 Text Domain:       longhairrecords
*/

jQuery(function($){
    // URL ReWrites for product categories
    $("a[href='https://longhairrecords.com/product-category/records/']").attr('href', 'https://longhairrecords.com/12-inch/');
    $("a[href='https://longhairrecords.com/product-category/7-inch/']").attr('href', 'https://longhairrecords.com/7-inch/');
    $("a[href='https://longhairrecords.com/product-category/8-track/']").attr('href', 'https://longhairrecords.com/8-track/');
    $("a[href='https://longhairrecords.com/product-category/artwork/']").attr('href', 'https://longhairrecords.com/artwork/'); // Need to create this page
    $("a[href='https://longhairrecords.com/product-category/betamax/']").attr('href', 'https://longhairrecords.com/beta/');
    $("a[href='https://longhairrecords.com/product-category/bluray/']").attr('href', 'https://longhairrecords.com/bluray/');
    $("a[href='https://longhairrecords.com/product-category/books/']").attr('href', 'https://longhairrecords.com/books/');
    $("a[href='https://longhairrecords.com/product-category/cards/']").attr('href', 'https://longhairrecords.com/cards/'); // Need to create this page
    $("a[href='https://longhairrecords.com/product-category/cassette/']").attr('href', 'https://longhairrecords.com/cassette/');
    $("a[href='https://longhairrecords.com/product-category/cd/']").attr('href', 'https://longhairrecords.com/cd/');
    $("a[href='https://longhairrecords.com/product-category/clothes/']").attr('href', 'https://longhairrecords.com/clothes/'); // Need to create this page
    $("a[href='https://longhairrecords.com/product-category/dvd/']").attr('href', 'https://longhairrecords.com/dvd/');
    $("a[href='https://longhairrecords.com/product-category/game/']").attr('href', 'https://longhairrecords.com/games/'); // Need to create this page
    $("a[href='https://longhairrecords.com/product-category/laserdisc/']").attr('href', 'https://longhairrecords.com/laserdisc/');
    $("a[href='https://longhairrecords.com/product-category/patch/']").attr('href', 'https://longhairrecords.com/patches/'); // Need to create this page
    $("a[href='https://longhairrecords.com/product-category/poster/']").attr('href', 'https://longhairrecords.com/posters/'); // Need to create this page
    $("a[href='https://longhairrecords.com/product-category/selectavision/']").attr('href', 'https://longhairrecords.com/selectavision/'); // Need to create this page
    $("a[href='https://longhairrecords.com/product-category/slipmat/']").attr('href', 'https://longhairrecords.com/slipmats/'); // Need to create this page
    $("a[href='https://longhairrecords.com/product-category/t-shirts/']").attr('href', 'https://longhairrecords.com/t-shirts/'); // Need to create this page
    $("a[href='https://longhairrecords.com/product-category/vhs/']").attr('href', 'https://longhairrecords.com/vhs/');
    $("a[href='https://longhairrecords.com/product-category/gift-cards/']").attr('href', 'https://longhairrecords.com/gift-cards/');
    $("a[href='https://longhairrecords.com/product-category/new-records/']").attr('href', 'https://longhairrecords.com/new-12-inch/');
    $("a[href='https://longhairrecords.com/product-category/new-7-inch/']").attr('href', 'https://longhairrecords.com/new-7-inch/');
    $("a[href='https://longhairrecords.com/product-category/new-cassette/']").attr('href', 'https://longhairrecords.com/new-cassette/');
    $("a[href='https://longhairrecords.com/product-category/new-cd/']").attr('href', 'https://longhairrecords.com/new-cd/');
    $("a[href='https://longhairrecords.com/product-category/new-vhs/']").attr('href', 'https://longhairrecords.com/new-vhs/');
    $("a[href='https://longhairrecords.com/product-category/japanese-vhs/']").attr('href', 'https://longhairrecords.com/japanese-vhs/'); // Need to create this page

    // Hide certain categories
    $("a[href='https://longhairrecords.com/product-category/wash/']").hide().next().hide();
    $("a[href='https://longhairrecords.com/product-category/uncategorized/']").hide().next().hide();
    $("a[href='https://longhairrecords.com/product-category/equipment/']").hide().next().hide();
    $("a[href='https://longhairrecords.com/product-category/machine/']").hide().next().hide();
    $("a[href='https://longhairrecords.com/product-category/machines/']").hide().next().hide();

    // Append classes to coupon code and gift card number inputs on click
    $('#coupon_code').on('click', function(){
        $('#coupon_code').removeClass('gc-selected');
        $(this).addClass('cc-selected');
    });
    $('#pwgc-redeem-gift-card-number').on('click', function(){
        $('#pwgc-redeem-gift-card-number').removeClass('gc-selected');
        $(this).addClass('gc-selected');
    });

    // Store Annoucement Pop-Up
    DiviArea.addAction('ready', function() {
        // Option 2: Show the Popup after 2 seconds.
        var popupId = 'square-issue';

        window.setTimeout(function() {
            DiviArea.show(popupId);
        }, 2000);
    });

    // Set search-bar filter by URL slug
    $(document).ready(function() {
        const pathname = window.location.pathname;
        const pathSegments = pathname.split('/').filter(Boolean);
        const urlSlug = pathSegments.pop();

        const filterElement = $('.aws-main-filter__current');
        const filterInput = $('input[name="aws_filter"]')
        let filterText;
        let filterValue;

        switch (urlSlug) {
            case '12-inch':
                filterText = '12-INCH';
                filterValue = 4;
                break;
            case '7-inch':
                filterText = '7-INCH';
                filterValue = 2;
                break;
            case '8-track':
                filterText = '8-TRACK';
                filterValue = 13;
                break;
            case 'artwork':
                filterText = 'ARTWORK';
                filterValue = 16;
                break;
            case 'beta':
                filterText = 'BETA';
                filterValue = 14;
                break;
            case 'bluray':
                filterText = 'BLURAY';
                filterValue = 15;
                break;
            case 'books':
                filterText = 'BOOKS';
                filterValue = 5;
                break;
            case 'cards':
                filterText = 'CARDS';
                filterValue = 17;
                break;
            case 'cassette':
                filterText = 'CASSETTE';
                filterValue = 6;
                break;
            case 'cd':
                filterText = 'CD';
                filterValue = 7;
                break;
            case 'clothes':
                filterText = 'CLOTHES';
                filterValue = 18;
                break;
            case 'dvd':
                filterText = 'DVD';
                filterValue = 8;
                break;
            case 'games':
                filterText = 'GAMES';
                filterValue = 19;
                break;
            case 'patches':
                filterText = 'PATCHES';
                filterValue = 20;
                break;
            case 'selectavision':
                filterText = 'SELECTAVISION';
                filterValue = 21;
                break;
            case 'slipmats':
                filterText = 'SLIPMATS';
                filterValue = 22;
                break;
            case 't-shirts':
                filterText = 'T-SHIRTS';
                filterValue = 23;
                break;
            case 'vhs':
                filterText = 'VHS';
                filterValue = 9;
                break;
            default:
                filterText = 'ALL';
        }

        filterElement.text(filterText);
        filterInput.val(filterValue);
    });

});
