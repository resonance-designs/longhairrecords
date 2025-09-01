
jQuery(function($){
    // URL ReWrites for product categories
    $("a[href='https://longhairrecords.com/product-category/7-inch/']").attr('href', 'https://longhairrecords.com/7-inch/');
    $("a[href='https://longhairrecords.com/product-category/records/']").attr('href', 'https://longhairrecords.com/12-inch/');
    $("a[href='https://longhairrecords.com/product-category/books/']").attr('href', 'https://longhairrecords.com/books/');
    $("a[href='https://longhairrecords.com/product-category/cassette/']").attr('href', 'https://longhairrecords.com/cassette/');
    $("a[href='https://longhairrecords.com/product-category/cd/']").attr('href', 'https://longhairrecords.com/cd/');
    $("a[href='https://longhairrecords.com/product-category/dvd/']").attr('href', 'https://longhairrecords.com/dvd/');
    $("a[href='https://longhairrecords.com/product-category/vhs/']").attr('href', 'https://longhairrecords.com/vhs/');
    $("a[href='https://longhairrecords.com/product-category/bluray/']").attr('href', 'https://longhairrecords.com/bluray/');
    $("a[href='https://longhairrecords.com/product-category/betamax/']").attr('href', 'https://longhairrecords.com/beta/');
    $("a[href='https://longhairrecords.com/product-category/8-track/']").attr('href', 'https://longhairrecords.com/8-track/');
    $("a[href='https://longhairrecords.com/product-category/laserdisc/']").attr('href', 'https://longhairrecords.com/laserdisc/');
    $("a[href='https://longhairrecords.com/product-category/gift-cards/']").attr('href', 'https://longhairrecords.com/gift-cards/');
    $("a[href='https://longhairrecords.com/product-category/new-records/']").attr('href', 'https://longhairrecords.com/new-records/');
    $("a[href='https://longhairrecords.com/product-category/new-cd/']").attr('href', 'https://longhairrecords.com/new-cd/');
    $("a[href='https://longhairrecords.com/product-category/new-vhs/']").attr('href', 'https://longhairrecords.com/new-vhs/');
    $("a[href='https://longhairrecords.com/product-category/new-cassette/']").attr('href', 'https://longhairrecords.com/new-cassette/');
    // Hide certain categories
    $("a[href='https://longhairrecords.com/product-category/wash/']").hide().next().hide();
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
        var popupId = 'square-issue'; // TODO: ← Enter the ID of your Popup here!
          
        window.setTimeout(function() {
            DiviArea.show(popupId);
        }, 2000);
    });
});