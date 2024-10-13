function Slider({
    root,
    next,
    prev,
    opts
}) {
    opts = {
        move: 1,
        cols: 1,
        gaps: 16,
        time: 5000,
        auto: false,
        flip: false,
        drag: false,
        ...opts,
    }
    if (!document.querySelector("#ui-carousel-style")) {
        const style = document.createElement("style");
        style.id = "ui-carousel-style";
        style.textContent =
            ".ui-hide{display:none!important}.ui-carousel>ul{margin:0;padding:0;display:grid;overflow-x:auto;align-items:start;scrollbar-width:none;grid-auto-flow:column;scroll-behavior:smooth;scroll-snap-type:x mandatory;}.ui-carousel>ul::-webkit-scrollbar{display:none;}.ui-carousel>ul.dragging{scroll-behavior:auto;scroll-snap-type:none;}.ui-carousel>ul.dragging>li{cursor:grab;user-select:none;}.ui-carousel>ul>li{scroll-snap-align:start;list-style: none;}";
        document.head.appendChild(style);
    }

    root.classList.add("ui-carousel");
    const carousel = root.querySelector("ul");
    const children = [...carousel.children];

    root.querySelectorAll("ul>li img,ul>li a").forEach((img) => {
        img.draggable = false;
    });

    let isDragging = false,
        startX,
        _move_ = opts.move,
        _time_ = opts.time,
        _flip_ = opts.flip,
        _cols_ = opts.cols,
        _gaps_ = opts.gaps,
        _maps_ = [],
        rtl = document.documentElement.dir === "rtl",
        startScrollLeft;

    var sm = {},
        md = {},
        lg = {},
        xl = {};

    const itemSize = () => {
        return Math.ceil((root.clientWidth - (_gaps_ * (_cols_ - 1))) / _cols_);
    }

    const nextItem = () => {
        while (_maps_ && _maps_.length) clearTimeout(_maps_.shift());
        if (carousel.scrollWidth - (carousel.scrollLeft * (rtl ? -1 : 1)) - carousel.clientWidth < 1) {
            carousel.scrollLeft = 0;
        } else {
            carousel.scrollLeft += itemSize() * _move_ * (rtl ? -1 : 1);
        }
        if (_maps_) requestAnimationFrame(autoPlay);
    };

    const prevItem = () => {
        while (_maps_ && _maps_.length) clearTimeout(_maps_.shift());
        if (carousel.scrollLeft === 0) {
            carousel.scrollLeft = itemSize() * children.length * (rtl ? -1 : 1);
        } else {
            carousel.scrollLeft -= itemSize() * _move_ * (rtl ? -1 : 1);
        }
        if (_maps_) requestAnimationFrame(autoPlay);
    };

    const dragStart = (e) => {
        isDragging = true;
        carousel.classList.add("dragging");
        startX = e.pageX;
        startScrollLeft = carousel.scrollLeft;
        while (_maps_ && _maps_.length) clearTimeout(_maps_.shift());
    };

    const dragging = (e) => {
        if (!isDragging) return;
        carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
    };

    const dragStop = () => {
        isDragging = false;
        carousel.classList.remove("dragging");
        if (_maps_) requestAnimationFrame(autoPlay);
    };

    const autoPlay = () => {
        _maps_.push(
            setTimeout(() => {
                requestAnimationFrame(autoPlay);
                _flip_ ? prevItem() : nextItem();
            }, _time_)
        );
    };

    const styling = (cn) => {
        while (_maps_ && _maps_.length) clearTimeout(_maps_.shift());
        carousel.style.gap = cn.gaps + "px";
        carousel.style.gridAutoColumns = `calc((100% - ${cn.gaps * (cn.cols - 1)}px) / ${cn.cols})`;

        _cols_ = cn.cols;
        _gaps_ = cn.gaps;

        if (cn.auto) {
            !_maps_ && (_maps_ = []);
            _time_ = cn.time;
            _flip_ = cn.flip;
            requestAnimationFrame(autoPlay);
        } else {
            _maps_ = null;
        }

        _move_ = cn.move || opts.move;

        if (cn.drag) {
            carousel.addEventListener("mousedown", dragStart);
            carousel.addEventListener("mousemove", dragging);
            document.addEventListener("mouseup", dragStop);
        } else {
            carousel.removeEventListener("mousedown", dragStart);
            carousel.removeEventListener("mousemove", dragging);
            document.removeEventListener("mouseup", dragStop);
        }
    };

    const exec = () => {
        var _opts = {};
        switch (true) {
            case matchMedia("(min-width: 1280px)").matches:
                _opts = xl;
                break;
            case matchMedia("(min-width: 1024px)").matches:
                _opts = lg;
                break;
            case matchMedia("(min-width: 768px)").matches:
                _opts = md;
                break;
            case matchMedia("(min-width: 640px)").matches:
                _opts = sm;
                break;
        }
        styling({
            move: "move" in _opts ? _opts.move : opts.move,
            cols: "cols" in _opts ? _opts.cols : opts.cols,
            gaps: "gaps" in _opts ? _opts.gaps : opts.gaps,
            auto: "auto" in _opts ? _opts.auto : opts.auto,
            time: "time" in _opts ? _opts.time : opts.time,
            flip: "flip" in _opts ? _opts.flip : opts.flip,
            drag: "drag" in _opts ? _opts.drag : opts.drag,
        });
    };

    const scrollArrow = () => {
        const _prev = rtl ? carousel.scrollLeft < 0 : carousel.scrollLeft > 0,
            _next = carousel.scrollWidth - (carousel.scrollLeft * (rtl ? -1 : 1)) - carousel.clientWidth > 1;

        setTimeout(() => {
            prev && prev.classList[_prev ? "remove" : "add"]("ui-hide");
            next && next.classList[_next ? "remove" : "add"]("ui-hide");
        }, 250);
    }

    prev && prev.addEventListener("click", prevItem);

    next && next.addEventListener("click", nextItem);

    window.addEventListener("resize", exec);
    carousel.addEventListener("scroll", scrollArrow);


    setTimeout(() => {
        exec();
        carousel.style.scrollBehavior = "unset";
        carousel.scrollLeft = (opts.flip ? itemSize() * children.length : 0) * (rtl ? -1 : 1);
        carousel.style.scrollBehavior = "";
        scrollArrow();
    }, 0);

    return {
        xs: function(obj) {
            opts = {...opts, ...obj };
            styling(opts);
            return this;
        },
        sm: function(obj) {
            sm = obj;
            return this;
        },
        md: function(obj) {
            md = obj;
            return this;
        },
        lg: function(obj) {
            lg = obj;
            return this;
        },
        xl: function(obj) {
            xl = obj;
            return this;
        },
        move: function(pos) {
            while (_maps_ && _maps_.length) clearTimeout(_maps_.shift());
            carousel.scrollLeft = itemSize() * ((_flip_ ? (children.length) : -1) - pos) * (rtl ? -1 : 1);
            if (_maps_) requestAnimationFrame(autoPlay);
            return this;
        },
        prev: function() {
            prevItem();
            return this;
        },
        next: function() {
            nextItem();
            return this;
        },
        hasPrev: function() {
            return rtl ? carousel.scrollLeft < 0 : carousel.scrollLeft > 0;
        },
        hasNext: function() {
            return carousel.scrollWidth - (carousel.scrollLeft * (rtl ? -1 : 1)) - carousel.clientWidth > 1;
        }
    };
}