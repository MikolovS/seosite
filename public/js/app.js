(function(Vue, VueAwesomeSwiper, Headroom, document, window) {
  Vue.use(VueAwesomeSwiper);

  var header = new Vue({
    el: '#header',
    created() {
      var mobileMenu = document.querySelector('#mobile-menu');
      mobileMenu.style.display = 'block';
    },
    data() {
      return {
        mobileMenu: false,
        didScroll: false
      };
    },
    methods: {
      toggleMobileMenu() {
        this.mobileMenu = !this.mobileMenu;
        if (this.mobileMenu) {
          document.body.style.overflow = 'hidden';
        } else {
          document.body.style.overflow = 'auto';
        }
      },
      showSub(event) {
        var parentNodeEl = event.target.parentNode;
        var icon = parentNodeEl.querySelector('i');
        var subList = parentNodeEl.querySelector('ul');
        subList.classList.toggle('display-block');
        icon.classList.toggle('wsi-remove');
      }
    }
  });

  var mainSlider = new Vue({
    el: '#hero-slider',
    created() {
      var heroSlider = document.getElementById('hero-slider');
      if (heroSlider) {
        heroSlider.style.display = 'block';
      } else {
        this.$destroy();
      }
    },
    components: {
      LocalSwiper: VueAwesomeSwiper.swiper,
      LocalSlide: VueAwesomeSwiper.swiperSlide
    },
    data: {
      swiperOptions: {
        loop: true,
        lazy: true,
        effect: 'fade',
        autoplay: {
          delay: 2500,
          disableOnInteraction: true
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        }
      }
    },
    computed: {
      swiper() {
        return this.$refs.awesomeSwiper.swiper;
      }
    }
  });

  var newsSlider = new Vue({
    el: '#news-slider',
    created() {
      var newsSlider = document.getElementById('news-slider');
      if (newsSlider) {
        newsSlider.style.display = 'block';
      } else {
        this.$destroy();
      }
    },
    components: {
      LocalSwiper: VueAwesomeSwiper.swiper,
      LocalSlide: VueAwesomeSwiper.swiperSlide
    },
    data: {
      swiperOptions: {
        slidesPerView: window.innerWidth < 991 ? 2 : 3,
        spaceBetween: 30,
        loop: true,
        lazy: true,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }
      }
    },
    computed: {
      swiper() {
        return this.$refs.newsSwiper.swiper;
      }
    }
  });

  var myElement = document.getElementById('header');
  var headroom = new Headroom(myElement, {
    offset: 5,
    tolerance: 5,
    classes: {
      initial: 'animated',
      pinned: 'slideDown',
      unpinned: 'slideUp'
    }
  });
  headroom.init();
})(Vue, VueAwesomeSwiper, Headroom, document, window);
