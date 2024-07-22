var swiper = new Swiper('.swiper-container', {
    loop: true,
    autoplay: {
        delay: 5000, // 7초
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});
