'use strict';

function initSplash() {
  var el = document.querySelector('.splash');
  if (!el) return;

  var bar = document.createElement('div');
  bar.className = 'splash__progress';
  el.appendChild(bar);

  var imgs = Array.from(document.querySelectorAll('.card__image'));
  var total = imgs.length;
  var loaded = 0;
  var dismissed = false;
  var MIN_MS = 400;
  var startTime = Date.now();

  function hideSplash() {
    if (dismissed) return;
    dismissed = true;
    var wait = Math.max(0, MIN_MS - (Date.now() - startTime));
    setTimeout(function() {
      el.style.transition = 'opacity 0.5s';
      el.style.opacity = '0';
      var removed = false;
      function removeSplash() {
        if (removed) return;
        removed = true;
        el.remove();
      }
      el.addEventListener('transitionend', removeSplash, { once: true });
      setTimeout(removeSplash, 600);
    }, wait);
  }

  if (total === 0) {
    hideSplash();
    return;
  }

  function onLoad() {
    loaded++;
    bar.style.width = (loaded / total * 100) + '%';
    if (loaded >= total) hideSplash();
  }

  imgs.forEach(function(img) {
    if (img.complete && img.naturalHeight !== 0) { onLoad(); return; }
    img.addEventListener('load', onLoad, { once: true });
    img.addEventListener('error', onLoad, { once: true });
  });
}

function getColumnWidth() {
  return window.innerWidth <= 540 ? Math.floor(window.innerWidth / 2) : 300;
}

function initMasonry(containerSelector, itemSelector) {
  var container = document.querySelector(containerSelector);
  if (!container) return;

  var imgs = Array.from(container.querySelectorAll('img'));
  var promises = imgs.map(function(img) {
    if (img.complete && img.naturalHeight !== 0) return Promise.resolve();
    return new Promise(function(resolve) {
      img.addEventListener('load', resolve, { once: true });
      img.addEventListener('error', resolve, { once: true });
    });
  });

  Promise.all(promises).then(function() {
    var msnry = new Masonry(container, {
      itemSelector: itemSelector,
      columnWidth: getColumnWidth(),
      isFitWidth: true,
      transitionDuration: '0.4s'
    });

    window.addEventListener('resize', function() {
      msnry.options.columnWidth = getColumnWidth();
      msnry.layout();
    });
  });
}

function initOnScreen(selector) {
  var elements = document.querySelectorAll(selector);
  if (!elements.length) return;

  elements.forEach(function(el) {
    el.style.opacity = '0';
    el.style.transition = 'opacity 0.8s';
  });

  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      entry.target.style.opacity = entry.isIntersecting ? '1' : '0';
    });
  }, { rootMargin: '-100px 0px' });

  elements.forEach(function(el) { observer.observe(el); });
}

function initPageTop() {
  var pagetop = document.querySelector('.page-top');
  if (!pagetop) return;

  pagetop.style.opacity = '0';
  pagetop.style.visibility = 'hidden';
  pagetop.style.transition = 'opacity 0.4s, visibility 0.4s';

  window.addEventListener('scroll', function() {
    var show = window.scrollY > 100;
    pagetop.style.opacity = show ? '1' : '0';
    pagetop.style.visibility = show ? 'visible' : 'hidden';
  });

  pagetop.addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

function initHamburgerMenu() {
  var footerMenu = document.querySelector('.footer__menu');
  if (!footerMenu) return;

  // iOS Safari バウンススクロール防止（メニューが開いているとき）
  document.body.addEventListener('touchmove', function(e) {
    var hm = document.querySelector('.hamburger-menu');
    if (hm && hm.classList.contains('is-active')) e.preventDefault();
  }, { passive: false });

  // フッターメニューの内容からハンバーガーメニューを生成
  var menuContent = footerMenu.innerHTML.replace(/\[|\]|\||&nbsp;/g, '');

  document.body.insertAdjacentHTML('beforeend',
    '<div class="hamburger">' +
      '<span class="hamburger__line"></span>' +
      '<span class="hamburger__line"></span>' +
      '<span class="hamburger__line"></span>' +
    '</div>' +
    '<div class="hamburger-menu">' +
      '<div class="hamburger-menu__list">' + menuContent + '</div>' +
    '</div>'
  );

  var hamburger = document.querySelector('.hamburger');
  var hamburgerMenu = document.querySelector('.hamburger-menu');
  var scrollPos = 0;
  var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

  function toggleMenu(open) {
    hamburger.classList.toggle('is-active', open);
    hamburgerMenu.classList.toggle('is-active', open);

    if (open) {
      scrollPos = window.pageYOffset;
      document.body.style.position = 'fixed';
      document.body.style.width = '100%';
      document.body.style.top = -scrollPos + 'px';
      document.body.style.overflow = 'hidden';
      if (isIOS) document.body.style.height = '100%';
    } else {
      document.body.style.position = '';
      document.body.style.width = '';
      document.body.style.top = '';
      document.body.style.overflow = '';
      if (isIOS) document.body.style.height = '';
      window.scrollTo(0, scrollPos);
    }
  }

  // ハンバーガーボタンの操作
  var tsX = 0, tsY = 0;

  hamburger.addEventListener('touchstart', function(e) {
    tsX = e.touches[0].clientX;
    tsY = e.touches[0].clientY;
    e.preventDefault();
  }, { passive: false });

  hamburger.addEventListener('touchend', function(e) {
    var dx = Math.abs(e.changedTouches[0].clientX - tsX);
    var dy = Math.abs(e.changedTouches[0].clientY - tsY);
    if (dx < 10 && dy < 10) toggleMenu(!hamburger.classList.contains('is-active'));
  });

  hamburger.addEventListener('click', function() {
    toggleMenu(!hamburger.classList.contains('is-active'));
  });

  // メニュー内リンクのタップ/クリック
  hamburgerMenu.querySelectorAll('a').forEach(function(link) {
    link.addEventListener('touchstart', function(e) {
      e.preventDefault();
      var href = this.getAttribute('href');
      toggleMenu(false);
      setTimeout(function() { window.location.href = href; }, 300);
    });
    link.addEventListener('click', function(e) {
      e.preventDefault();
      var href = this.getAttribute('href');
      toggleMenu(false);
      setTimeout(function() { window.location.href = href; }, 300);
    });
  });

  // メニュー外タップ/クリックで閉じる
  function outsideHandler(e) {
    if (!hamburger.contains(e.target) && !hamburgerMenu.contains(e.target)) {
      if (hamburger.classList.contains('is-active')) toggleMenu(false);
    }
  }
  document.addEventListener('touchstart', outsideHandler);
  document.addEventListener('click', outsideHandler);

  // 画面回転・リサイズ時に閉じる
  function resizeHandler() {
    if (hamburger.classList.contains('is-active')) toggleMenu(false);
  }
  window.addEventListener('resize', resizeHandler);
  window.addEventListener('orientationchange', resizeHandler);

  // iOS バックグラウンド復帰時に閉じる
  document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'visible' && hamburger.classList.contains('is-active')) {
      toggleMenu(false);
    }
  });
}

function initGLightbox() {
  if (typeof GLightbox === 'undefined') return;
  GLightbox({ selector: '[data-gallery]', touchNavigation: true });
}

function init() {
  initSplash();
  initPageTop();
  initHamburgerMenu();
  initGLightbox();

  if (document.querySelector('.container') && document.querySelector('.card')) {
    // トップ・カテゴリページ
    initMasonry('.container', '.card');
    initOnScreen('.card');
  } else if (document.querySelector('.entry__container')) {
    // 作品詳細ページ
    initOnScreen('.entry__container');
  } else if (document.querySelector('.entry__content')) {
    // 固定ページ
    initOnScreen('.entry__content');
  }
}

// </body>直前に読み込まれるが、defer対応のためreadyState確認
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
