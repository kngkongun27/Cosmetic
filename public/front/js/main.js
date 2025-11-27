/*  ---------------------------------------------------
    Template Name: codelean
    Description: codelean eCommerce HTML Template
    Author: CodeLean
    Author URI: https://CodeLean.vn/
    Version: 1.0
    Created: CodeLean
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    /*------------------
        Navigation
    --------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Hero Slider
    --------------------*/
    $(".hero-items").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        dots: false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*------------------
        Product Slider
    --------------------*/
    $(".product-slider").owlCarousel({
        loop: false,
        margin: 25,
        nav: true,
        items: 4,
        dots: true,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: false,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 6,
            }
        }
    });
    // Indexx slider 


    $(".homepage-slider-section .product-slider-h").owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        items: 1,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoplay: true,
        autoplayTimeout: 3500,
        responsive: {
            0: { items: 1 },
            576: { items: 2 },
            768: { items: 3 },
            1200: { items: 1 }
        }
    });



    /*------------------
       logo Carousel
    --------------------*/
    $(".logo-carousel").owlCarousel({
        loop: false,
        margin: 30,
        nav: false,
        items: 5,
        dots: false,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        mouseDrag: false,
        autoplay: true,
        responsive: {
            0: {
                items: 3,
            },
            768: {
                items: 5,
            }
        }
    });

    /*-----------------------
       Product Single Slider
    -------------------------*/
    $(".ps-slider").owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        items: 3,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*------------------
        CountDown
    --------------------*/
    // For demo preview
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    if (mm == 12) {
        mm = '01';
        yyyy = yyyy + 1;
    } else {
        mm = parseInt(mm) + 1;
        mm = String(mm).padStart(2, '0');
    }
    var timerdate = mm + '/' + dd + '/' + yyyy;
    // For demo preview end

    console.log(timerdate);


    // Use this for real timer date
    /* var timerdate = "2020/01/01"; */

    $("#countdown").countdown(timerdate, function (event) {
        $(this).html(event.strftime("<div class='cd-item'><span>%D</span> <p>Ngày</p> </div>" + "<div class='cd-item' style=''><span>%H</span> <p>Giờ</p> </div>" + "<div class='cd-item'><span>%M</span> <p>Phút</p> </div>" + "<div class='cd-item'><span>%S</span> <p>Giây</p> </div>"));
    });


    /*----------------------------------------------------
     Language Flag js 
    ----------------------------------------------------*/
    $(document).ready(function (e) {
        //no use
        try {
            var pages = $("#pages").msDropdown({
                on: {
                    change: function (data, ui) {
                        var val = data.value;
                        if (val != "")
                            window.location = val;
                    }
                }
            }).data("dd");

            var pagename = document.location.pathname.toString();
            pagename = pagename.split("/");
            pages.setIndexByValue(pagename[pagename.length - 1]);
            $("#ver").html(msBeautify.version.msDropdown);
        } catch (e) {
            // console.log(e);
        }
        $("#ver").html(msBeautify.version.msDropdown);

        //convert
        $(".language_drop").msDropdown({ roundedBorder: false });
        $("#tech").data("dd");
    });
    /*-------------------
        Range Slider
    --------------------- */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val('$' + ui.values[0]);
            maxamount.val('$' + ui.values[1]);
        }
    });
    minamount.val('$' + rangeSlider.slider("values", 0));
    maxamount.val('$' + rangeSlider.slider("values", 1));

    /*-------------------
        Radio Btn
    --------------------- */
    $(".fw-size-choose .sc-item label, .pd-size-choose .sc-item label").on('click', function () {
        $(".fw-size-choose .sc-item label, .pd-size-choose .sc-item label").removeClass('active');
        $(this).addClass('active');
    });

    /*-------------------
        Nice Select
    --------------------- */
    $('.sorting, .p-show').niceSelect();

    /*------------------
        Single Product
    --------------------*/
    $('.product-thumbs-track .pt').on('click', function () {
        $('.product-thumbs-track .pt').removeClass('active');
        $(this).addClass('active');
        var imgurl = $(this).data('imgbigurl');
        var bigImg = $('.product-big-img').attr('src');
        if (imgurl != bigImg) {
            $('.product-big-img').attr({ src: imgurl });
            $('.zoomImg').attr({ src: imgurl });
        }
    });

    $('.product-pic-zoom').zoom();

    /*-------------------
        Quantity change
    --------------------- */



    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);

        // Update Cart
        var rowId = $button.parent().find('input').data('rowid');
        updateCart(rowId, newVal);
    });

    // Lọc sản phẩm ở trang chủ 
    const product_men = $(".product-slider.adult");
    const product_women = $(".product-slider.child");

    $('.filter-control').on('click', '.item', function () {
        const $item = $(this);

        const filter = $item.data('tag');
        const category = $item.data('category');

        $item.siblings().removeClass('active');
        $item.addClass('active');

        if (category === 'adult') {
            product_men.owlcarousel2_filter(filter);
        }

        if (category === 'child') {
            product_women.owlcarousel2_filter(filter);
        }
    })

})(jQuery);



function addCart(productId, totalQuantity) {
    if (totalQuantity === 0) {
        alert("Sản phẩm này đã hết hàng!");
        return;
    }

    // Lấy màu nếu có
    let selectedColor = document.querySelector('.color-circle.active')?.title || null;
    // Lấy dung tích nếu có
    let selectedVolume = document.querySelector('#volumeSelect')?.value || null;

    $.ajax({
        type: "GET",
        url: "cart/add",
        data: {
            productId: productId,
            color: selectedColor,
            volume: selectedVolume
        },
        success: function (response) {
            // Cập nhật số lượng và tổng tiền
            $('.cart-count').text(response['count']);
            $('.cart-price').text('$' + response['total']);
            $('.select-total h5').text('$' + response['total']);

            // Cập nhật cart hover
            var cartHover_tbody = $('.select-items tbody');
            var cartHover_existItem = cartHover_tbody.find("tr[data-rowid='" + response['cart'].rowId + "']");

            if (cartHover_existItem.length) {
                cartHover_existItem.find('.product-selected p')
                    .text('$' + response['cart'].price.toFixed(2) + ' x ' + response['cart'].qty);
            } else {
                var newItem =
                    '<tr data-rowid="' + response['cart'].rowId + '">' +
                    '   <td class="si-pic">' +
                    '       <img style="height:70px;" src="front/img/products/' + response['cart'].options.images[0].path + '" alt="">' +
                    '   </td>' +
                    '   <td class="si-text">' +
                    '       <div class="product-selected">' +
                    '           <p>$' + response['cart'].price.toFixed(2) + ' x ' + response['cart'].qty + '</p>' +
                    '           <h6>' + response['cart'].name + '</h6>' +
                    (selectedColor ? '<small>Color: ' + selectedColor + '</small>' : '') +
                    (selectedVolume ? '<small>Volume: ' + selectedVolume + ' ml</small>' : '') +
                    '       </div>' +
                    '   </td>' +
                    '   <td class="si-close">' +
                    '       <i onclick="removeCart(\'' + response['cart'].rowId + '\')" class="icon_close"></i>' +
                    '   </td>' +
                    '</tr>';

                cartHover_tbody.append(newItem);
            }

            alert('Thêm vào giỏ hàng thành công! \nSản phẩm: ' + response['cart'].name);
            console.log(response);
        },
        error: function (response) {
            alert('Thêm sản phẩm thất bại. Vui lòng thử lại.');
            console.log(response);
        },
    });
}

// Bật active cho màu
document.querySelectorAll('.color-circle').forEach(el => {
    el.addEventListener('click', function () {
        document.querySelectorAll('.color-circle').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
    });
});
document.querySelectorAll('.color-circle, .size-circle').forEach(item => {
    item.addEventListener('click', () => {
        const parent = item.parentElement;
        // Bỏ active tất cả trong cùng parent
        parent.querySelectorAll('.color-circle, .size-circle').forEach(i => i.classList.remove('active'));
        // Thêm active cho item được click
        item.classList.add('active');

        // Lấy giá trị đang chọn
        const selectedValue = item.style.backgroundColor || item.dataset.size;
        console.log('Đang chọn:', selectedValue);
    });
});




function removeCart(rowId) {
    $.ajax({
        type: "GET",
        url: "cart/delete",
        data: { rowId: rowId },
        success: function (response) {

            // Xử lí ở phần layout
            $('.cart-count').text(response['count']);
            $('.cart-price').text('$' + response['total']);
            $('.select-total h5').text('$' + response['total']);


            var cartHover_tbody = $('.select-items tbody');
            var cartHover_existItem = cartHover_tbody.find("tr" + "[data-rowid='" + rowId + "']");

            cartHover_existItem.remove();
            // Xử lí phần shop/cart/index
            var cart_tbody = $('.cart-table tbody');
            var cart_existItem = cart_tbody.find("tr" + "[data-rowid='" + rowId + "']");
            cart_existItem.remove();


            alert(' Xóa thành công ! \nProduct: ' + response['cart'].name)
            console.log(response);
        },
        error: function (response) {
            alert('Thêm trật rồi , mần lại đi .');
            console.log(response);
        },
    });
}

function updateCart(rowId, qty) {
    $.ajax({
        type: "GET",
        url: "cart/update",
        data: { rowId: rowId, qty: qty },
        success: function (response) {
            $('.cart-count').text(response['count']);
            $('.cart-price').text('$' + response['total']);
            $('.select-total h5').text('$' + response['total']);

            var cart_tbody = $('.select-items tbody');
            var cartHover_existItem = cart_tbody.find("tr" + "[data-rowId='" + rowId + "']");
            if (qty === 0) {
                cartHover_existItem.remove();
            } else {
                cartHover_existItem.find('.product-selected p ').text("$" + response['cart'].price.toFixed(2) + ' x ' + response['cart'].qty);
            }


            // Xử lý ở trong shop/cart
            var cart_tbody = $('.cart-table tbody');
            var cart_existItem = cart_tbody.find("tr" + "[data-rowId='" + rowId + "']");
            if (qty == 0) {
                cart_existItem.remove();
            } else {
                cart_existItem.find('.total-price').text('$' + (response['cart'].price * response['cart'].qty).toFixed(2));
            }

            $('.subtotal span').text('$' + response['subtotal'])
            $('.cart-total span').text('$' + response['total'])

            alert('Update successful! \nProduct: ' + response['cart'].name)
            console.log(response);
        }
    })
}

function destroyCart() {
    $.ajax({
        type: "GET",
        url: "cart/destroy",
        data: {},
        success: function (response) {

            // Xử lí ở phần layout hover cart
            $('.cart-count').text('0');
            $('.cart-price').text('0');
            $('.select-total h5').text('0');


            var cartHover_tbody = $('.select-items tbody');

            cartHover_tbody.children().remove();

            // Xử lí phần shop/cart/index
            var cart_tbody = $('.cart-table tbody');

            cart_tbody.children().remove();

            $('.subtotal span').text('0');
            $('cart-total span').text('0');

            alert(' Xóa thành công ! \nProduct: ' + response['cart'].name)
            console.log(response);
        },
        error: function (response) {
            alert('Thêm trật rồi , mần lại đi .');
            console.log(response);
        },
    });
}