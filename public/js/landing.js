(function () {
    "use strict";

    // Navbar: berubah saat scroll
    var nav = document.querySelector(".lp-nav");
    function onScroll() {
        if (!nav || nav.classList.contains("solid")) return;
        nav.classList.toggle("scrolled", window.scrollY > 30);
    }
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();

    // Menu mobile
    var burger = document.querySelector(".lp-burger");
    var menu = document.querySelector(".lp-menu");
    if (burger && menu) {
        burger.addEventListener("click", function () {
            var open = menu.classList.toggle("open");
            burger.setAttribute("aria-expanded", open ? "true" : "false");
            if (nav && !nav.classList.contains("solid"))
                nav.classList.add("scrolled");
        });
        menu.addEventListener("click", function (e) {
            if (e.target.tagName === "A") menu.classList.remove("open");
        });
    }

    // Reveal saat discroll
    var items = document.querySelectorAll(".reveal");
    if ("IntersectionObserver" in window) {
        var io = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (en) {
                    if (en.isIntersecting) {
                        en.target.classList.add("in");
                        io.unobserve(en.target);
                    }
                });
            },
            { threshold: 0.12 },
        );
        items.forEach(function (el) {
            io.observe(el);
        });
    } else {
        items.forEach(function (el) {
            el.classList.add("in");
        });
    }

    // Hitung naik untuk angka statistik (mis. "1000+" -> animasi 0..1000+)
    var reduce =
        window.matchMedia &&
        window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    document.querySelectorAll("[data-count]").forEach(function (el) {
        var raw = el.getAttribute("data-count");
        var m = raw.match(/^(\D*)(\d+)(.*)$/);
        if (!m || reduce) return;
        var pre = m[1],
            target = parseInt(m[2], 10),
            post = m[3];
        if (target > 100000) return;
        var started = false;
        var obs = new IntersectionObserver(
            function (es) {
                if (!es[0].isIntersecting || started) return;
                started = true;
                var t0 = null,
                    dur = 1400;
                function tick(ts) {
                    if (!t0) t0 = ts;
                    var p = Math.min((ts - t0) / dur, 1);
                    var eased = 1 - Math.pow(1 - p, 3);
                    el.textContent = pre + Math.round(target * eased) + post;
                    if (p < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
                obs.disconnect();
            },
            { threshold: 0.6 },
        );
        obs.observe(el);
    });
})();
