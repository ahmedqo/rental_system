(function() {
    const Style = `:host {gap: 1px;display: flex;margin: 0 auto;flex-wrap: wrap;overflow: hidden;width: max-content;border-radius: .25rem;}[part="btns"] {display: flex;border: unset;outline: unset;background: unset;align-items: center;padding: .25rem .5rem;border-radius: .20rem;text-decoration: unset;justify-content: center;color: {{ @Theme.colors("WHITE") }};}[part="btns"]:hover,[part="btns"]:focus,[part="btns"]:focus-within {cursor: pointer;color: {{ @Theme.colors("BLACK") }};}[part="svgs"] {width: 1rem;height: 1rem;display: block;pointer-events: none;}{$ if @props.scene $}[part="btns"][title="scene"] {background: {{ @Theme.colors("GRAY", 400) }};}[part="btns"][title="scene"]:hover,[part="btns"][title="scene"]:focus,[part="btns"][title="scene"]:focus-within {background: {{ @Theme.colors("GRAY", 400, 60) }};}{$ endif $}{$ if @props.print $}[part="btns"][title="print"] {background: {{ @Theme.colors("GREEN", 400) }};}[part="btns"][title="print"]:hover,[part="btns"][title="print"]:focus,[part="btns"][title="print"]:focus-within {background: {{ @Theme.colors("GREEN", 400, 60) }};}{$ endif $}{$ if @props.patch $}[part="btns"][title="patch"] {background: {{ @Theme.colors("YELLOW", 400) }};}[part="btns"][title="patch"]:hover,[part="btns"][title="patch"]:focus,[part="btns"][title="patch"]:focus-within {background: {{ @Theme.colors("YELLOW", 400, 60) }};}{$ endif $}{$ if @truty(@props.clear) && @truty(@props.csrf) $}[part="btns"][title="clear"] {background: {{ @Theme.colors("RED", 400) }};}[part="btns"][title="clear"]:hover,[part="btns"][title="clear"]:focus,[part="btns"][title="clear"]:focus-within {background: {{ @Theme.colors("RED", 400, 60) }};}{$ endif $}`;

    const Template = `{$ if @props.scene $}<a title="scene" href="{{ @props.scene.replace('XXX', @props.target) }}" part="btns"><svg part="svgs" fill="currentcolor" viewBox="0 -960 960 960"><path d="M99-272q-19.325 0-32.662-13.337Q53-298.675 53-318v-319q0-20.3 13.338-33.15Q79.675-683 99-683h73q18.9 0 31.95 12.85T217-637v319q0 19.325-13.05 32.663Q190.9-272 172-272H99Zm224 96q-20.3 0-33.15-13.05Q277-202.1 277-221v-513q0-19.325 12.85-32.662Q302.7-780 323-780h314q20.3 0 33.15 13.338Q683-753.325 683-734v513q0 18.9-12.85 31.95T637-176H323Zm465-96q-18.9 0-31.95-13.337Q743-298.675 743-318v-319q0-20.3 13.05-33.15Q769.1-683 788-683h73q19.325 0 33.162 12.85Q908-657.3 908-637v319q0 19.325-13.838 32.663Q880.325-272 861-272h-73Z" /></svg></a>{$ endif $}{$ if @props.print $}<a title="print" href="{{ @props.print.replace('XXX', @props.target) }}" part="btns"><svg part="svgs" fill="currentcolor" viewBox="0 -960 960 960"><path d="M741-701H220v-160h521v160Zm-17 236q18 0 29.5-10.812Q765-486.625 765-504.5q0-17.5-11.375-29.5T724.5-546q-18.5 0-29.5 12.062-11 12.063-11 28.938 0 18 11 29t29 11Zm-75 292v-139H311v139h338Zm92 86H220v-193H60v-264q0-53.65 36.417-91.325Q132.833-673 186-673h588q54.25 0 90.625 37.675T901-544v264H741v193Z" /></svg></a>{$ endif $}{$ if @props.patch $}<a title="patch" href="{{ @props.patch.replace('XXX', @props.target) }}" part="btns"><svg part="svgs" fill="currentcolor" viewBox="0 -960 960 960"><path d="M170-103q-32 7-53-14.5T103-170l39-188 216 216-188 39Zm235-78L181-405l435-435q27-27 64.5-27t63.5 27l96 96q27 26 27 63.5T840-616L405-181Z" /></svg></a>{$ endif $}{$ if @truty(@props.clear) && @truty(@props.csrf) $}<form action="{{ @props.clear.replace('XXX', @props.target) }}" method="POST"><input type="hidden" name="_token" value="{{ @props.csrf }}" autocomplete="off" /><input type="hidden" name="_method" value="delete" /><button type="submit" title="clear" part="btns"><svg part="svgs" fill="currentcolor" viewBox="0 -960 960 960"><path d="M253-99q-36.462 0-64.231-26.775Q161-152.55 161-190v-552h-11q-18.75 0-31.375-12.86Q106-767.719 106-787.36 106-807 118.613-820q12.612-13 31.387-13h182q0-20 13.125-33.5T378-880h204q19.625 0 33.312 13.75Q629-852.5 629-833h179.921q20.279 0 33.179 13.375 12.9 13.376 12.9 32.116 0 20.141-12.9 32.825Q829.2-742 809-742h-11v552q0 37.45-27.069 64.225Q743.863-99 706-99H253Zm104-205q0 14.1 11.051 25.05 11.051 10.95 25.3 10.95t25.949-10.95Q431-289.9 431-304v-324q0-14.525-11.843-26.262Q407.313-666 392.632-666q-14.257 0-24.944 11.738Q357-642.525 357-628v324Zm173 0q0 14.1 11.551 25.05 11.551 10.95 25.8 10.95t25.949-10.95Q605-289.9 605-304v-324q0-14.525-11.545-26.262Q581.91-666 566.93-666q-14.555 0-25.742 11.738Q530-642.525 530-628v324Z" /></svg></button></form>{$ endif $}`;

    Neo.Component({
        tag: "action-tools",
        tpl: Template,
        css: Style
    })({
        props: {
            "csrf": null,
            "scene": null,
            "print": null,
            "patch": null,
            "clear": null,
            "target": null
        },
        cycle: {
            mounted() {
                if (this.hasAttribute("csrf")) {
                    this.props.csrf = this.getAttribute("csrf");
                    this.removeAttribute("csrf");
                }

                if (this.hasAttribute("target")) {
                    this.props.target = this.getAttribute("target");
                    this.removeAttribute("target");
                }

                if (this.hasAttribute("scene")) {
                    this.props.scene = this.getAttribute("scene");
                    this.removeAttribute("scene");
                }

                if (this.hasAttribute("print")) {
                    this.props.print = this.getAttribute("print");
                    this.removeAttribute("print");
                }

                if (this.hasAttribute("patch")) {
                    this.props.patch = this.getAttribute("patch");
                    this.removeAttribute("patch");
                }

                if (this.hasAttribute("clear")) {
                    this.props.clear = this.getAttribute("clear");
                    this.removeAttribute("clear");
                }
            }
        }
    }).define();
})();

function empty() {
    return "N/A";
}

function bgdate(row) {
    const now = (new Date).getTime(),
        fix = (new Date(row.dropoff_date)).getTime();

    if (row.status === "pending") {
        if (fix < now) return { background: "#fecaca" };
        if (fix - 86400 >= now) return { background: "#fef08a" };
    }
    return {};
}

function bgtick(row) {
    if (row.awaiting_response_from === "App\\Models\\Admin" && row.status !== 'closed') return { background: "#bbf7d0" };
    return {};
}

async function getData(url, createLinks) {
    const req = await fetch(url);
    const res = await req.json();
    createLinks && createLinks(res.prev_cursor, res.next_cursor, (new URL(url)).searchParams.get("search"));
    return res.data;
}

function searchable(field, route, callback) {
    const hidden = $query("input", field);
    var timer;

    field.addEventListener("input", e => {
        if (timer) clearTimeout(timer);
        field.loading = true;
        timer = setTimeout(async() => {
            const data = await getData(route + "?search=" + encodeURIComponent(e.target.query));
            field.data = callback(data);
            field.loading = false;
        }, 2000);
    });

    hidden && field.addEventListener("select", e => {
        hidden.value = e.detail.data.name;
    });
}

function TableVisualizer(dataVisualizer, callback, routes) {
    var timer;
    const _routes = {
        ...$routes,
        ...routes
    }
    const Links = document.createElement("div");
    Links.innerHTML = `<a id="prev" slot="end" aria-label="prev_page_link" class="flex w-8 h-8 items-center justify-center text-x-black outline-none rounded-x-thin !bg-opacity-5 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black"><svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960"><path d="M452-219 190-481l262-262 64 64-199 198 199 197-64 65Zm257 0L447-481l262-262 63 64-198 198 198 197-63 65Z" /></svg></a><a id="next" slot="end" aria-label="next_page_link" class="flex w-8 h-8 items-center justify-center text-x-black outline-none rounded-x-thin !bg-opacity-5 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black"><svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960"><path d="M388-481 190-679l64-64 262 262-262 262-64-65 198-197Zm257 0L447-679l63-64 262 262-262 262-63-65 198-197Z" /></svg></a>`;

    async function event(e) {
        e.preventDefault();
        dataVisualizer.loading = true;
        dataVisualizer.rows = await getData(e.target.href, createLinks);
        dataVisualizer.loading = false;
    }

    function createLinks(prev, next, str) {
        const search = "?search" + (str ? ("=" + str) : "");
        const preva = $query("#prev", dataVisualizer);
        const nexta = $query("#next", dataVisualizer);
        if (prev) {
            const href = $routes.search + search + "&cursor=" + prev;
            if (preva) preva.href = href
            else {
                const _preva = $query("#prev", Links).cloneNode(true);
                _preva.addEventListener("click", event);
                if (nexta) nexta.insertAdjacentElement('beforebegin', _preva);
                else dataVisualizer.insertAdjacentElement("afterbegin", _preva);
                _preva.title = $trans("Prev");
                _preva.href = href;
            }
        } else {
            if (preva) {
                preva.removeEventListener("click", event);
                preva.remove();
            }
        }
        if (next) {
            const href = $routes.search + search + "&cursor=" + next;
            if (nexta) nexta.href = href
            else {
                const _nexta = $query("#next", Links).cloneNode(true);
                _nexta.addEventListener("click", event);
                if (preva) preva.insertAdjacentElement('afterend', _nexta);
                else dataVisualizer.insertAdjacentElement("afterbegin", _nexta);
                _nexta.title = $trans("Next");
                _nexta.href = href;
            }
        } else {
            if (nexta) {
                nexta.removeEventListener("click", event);
                nexta.remove();
            }
        }
    }

    (async function() {
        dataVisualizer.loading = true;
        dataVisualizer.rows = await getData(_routes.search + window.location.search, createLinks);
        dataVisualizer.loading = false;
    })();

    dataVisualizer.refs.wrapper.style.background = Neo.Helper.Theme.colors("WHITE");
    dataVisualizer.addEventListener("change:loading", e => {
        dataVisualizer.refs.wrapper.style.background = e.detail.data ? Neo.Helper.Theme.colors("WHITE") : "";
    });

    dataVisualizer.cols = callback(_routes);

    dataVisualizer.addEventListener("search", async e => {
        e.preventDefault();
        if (timer) clearTimeout(timer);
        dataVisualizer.loading = true;
        dataVisualizer.rows = await new Promise((resolver, rejecter) => {
            timer = setTimeout(async() => {
                const data = await getData(_routes.search + "?search=" +
                    encodeURIComponent(e.detail
                        .data), createLinks);
                resolver(data);
            }, 2000);
        });
        dataVisualizer.loading = false;
    });
}

const
    $queryAll = (selector, context = document) => [...context.querySelectorAll(selector)],
    $query = (selector, context = document) => context.querySelector(selector),
    $capitalize = Neo.Helper.Str.capitalize,
    $titlize = Neo.Helper.Str.titlize,
    $routes = (() => {
        const routes = $query("meta[name=routes]");
        var $data = {};
        if (routes) {
            $data = JSON.parse(routes.content);
            routes.remove();
        }
        return { search: "", ...$data };
    })(),
    $core = (() => {
        const core = $query("meta[name=core]");
        var $data = {};
        if (core) {
            $data = JSON.parse(core.content);
            core.remove();
        }
        return $data;
    })(),
    $moment = Neo.Helper.Str.moment,
    $money = Neo.Helper.Str.money,
    $trans = Neo.Helper.trans;

const $Colors = {
    detachment: '#F97316',
    scratches: '#EAB308',
    cracks: '#22C55E',
    broken: '#6366F1',
    dents: '#D946EF',
    rust: '#EC4899'
};

$queryAll("neo-tab-wrapper").forEach(wrapper => {
    var nextTrigger, nextOutlet;

    wrapper.triggers = $queryAll("neo-tab-trigger", wrapper);
    wrapper.outlets = $queryAll("neo-tab-outlet", wrapper);

    wrapper.activate = (function activate(e) {
        wrapper.activeTrigger = nextTrigger;
        wrapper.activeOutlet = nextOutlet;

        if (!wrapper.activeTrigger || !wrapper.activeOutlet) return;

        wrapper.triggers.forEach(t => {
            t.classList.remove("bg-x-prime", "text-x-white");
            t.classList.add("text-x-black", "bg-x-white");
        });

        wrapper.outlets.forEach(t => {
            t.style.display = "none";
        });

        wrapper.activeTrigger.classList.remove("text-x-black", "bg-x-white");
        wrapper.activeTrigger.classList.add("bg-x-prime", "text-x-white");
        wrapper.activeOutlet.style.display = "";
    }).bind(wrapper);

    (new MutationObserver((mutationsList) => {
        for (const mutation of mutationsList) {
            if (mutation.type === "attributes" && mutation.attributeName === "outlet") {
                const target = wrapper.getAttribute("outlet");

                nextTrigger = wrapper.triggers.find(e => e.getAttribute("for") === target);
                nextOutlet = wrapper.outlets.find(e => e.getAttribute("name") === target);

                const ev = new CustomEvent("change:tab", {
                    bubbles: true,
                    cancelable: true,
                    composed: true,
                    isTrusted: true,
                    detail: {
                        nextTrigger,
                        nextOutlet
                    },
                });
                wrapper.dispatchEvent(ev);
                if (!ev.defaultPrevented) {
                    wrapper.activate();
                }
            }
        }
    })).observe(wrapper, { attributes: true });

    wrapper.triggers.forEach(t => {
        function active() {
            wrapper.setAttribute("outlet", t.getAttribute("for"));
        }

        t.addEventListener("click", active);
        t.addEventListener("keydown", e => {
            if (e.keyCode === 13) active();
        });
    });

    wrapper.outlets.forEach(o => {
        o.style.display = "none";
    });

    wrapper.setAttribute("outlet", wrapper.getAttribute("outlet"));
});

Neo.load(function() {
    $queryAll("neo-tab-wrapper").forEach(wrapper => {
        const tabPrev = $query("#prev", wrapper),
            tabSave = $query("#save", wrapper),
            tabNext = $query("#next", wrapper),
            track = $query("#track", wrapper);

        wrapper.addEventListener("change:tab", e => {
            if (wrapper.triggers.indexOf(wrapper.activeTrigger) < wrapper.triggers.indexOf(e.detail.nextTrigger)) {
                e.preventDefault();
                Neo.Validator.validate(wrapper.activeOutlet, {
                    ...($queryAll("[rules]", wrapper.activeOutlet).reduce((carry, item) => {
                        carry.rules[item.name] = (item.getAttribute("rules") || "").split("|");
                        carry.message.failure[item.name] = JSON.parse(item.getAttribute("errors") || "");
                        return carry;
                    }, { rules: {}, message: { failure: {} } })),
                    failure(field, __, message) {
                        Neo.Toaster.toast(message, "error");
                        field.classList.add("outline", "outline-2", "-outline-offset-2", "outline-red-400");
                    },
                    success(field) {
                        field.classList.remove("outline", "outline-2", "-outline-offset-2", "outline-red-400");
                    },
                    execute() {
                        wrapper.activate();
                    }
                });
            }

            setTimeout(() => {
                const tabIndex = wrapper.triggers.indexOf(wrapper.activeTrigger);
                tabPrev.style.display = tabIndex > 0 ? "" : "none";
                tabNext.style.display = tabIndex < wrapper.triggers.length - 1 ? "" : "none";
                tabSave.style.display = tabIndex === wrapper.triggers.length - 1 ? "" : "none";
                track.style.width = ((100 / (wrapper.triggers.length - 1)) * tabIndex) + "%";

                wrapper.triggers.forEach((t, i) => {
                    const txt = $query("span", t),
                        svg = $query("svg", t)
                    if (i < tabIndex) {
                        t.classList.add("bg-x-light");
                        t.classList.remove("bg-x-white");
                        svg.classList.remove("hidden");
                        txt.classList.add("hidden");
                        svg.classList.add("block");
                    } else {
                        txt.classList.remove("hidden");
                        svg.classList.remove("block");
                        svg.classList.add("hidden");
                    }
                });
            }, 50);
        });

        tabPrev.addEventListener("click", e => {
            const tabIndex = wrapper.triggers.indexOf(wrapper.activeTrigger);
            if (tabIndex <= 0) return;

            wrapper.setAttribute("outlet", "outlet-" + tabIndex);
        });

        tabNext.addEventListener("click", e => {
            const tabIndex = wrapper.triggers.indexOf(wrapper.activeTrigger);
            if (tabIndex >= wrapper.triggers.length - 1) return;

            wrapper.setAttribute("outlet", "outlet-" + (tabIndex + 2));
        })
    });

    $queryAll("form[validate]").forEach(form => {
        form.addEventListener("submit", e => {
            e.preventDefault();
            Neo.Validator.validate(form, {
                ...($queryAll("[rules]", form).reduce((carry, item) => {
                    carry.rules[item.name] = (item.getAttribute("rules") || "").split("|");
                    carry.message.failure[item.name] = JSON.parse(item.getAttribute("errors") || "");
                    return carry;
                }, { rules: {}, message: { failure: {} } })),
                failure(field, __, message) {
                    Neo.Toaster.toast(message, "error");
                    field.classList.add("outline", "outline-2", "-outline-offset-2", "outline-red-400");
                },
                success(field) {
                    field.classList.remove("outline", "outline-2", "-outline-offset-2", "outline-red-400");
                },
                execute() {
                    form.submit();
                }
            });
        });
    });

    $queryAll("[show-unless]").forEach(field => {
        const [target, value] = field.getAttribute("show-unless").split(",").map(e => e.trim()).filter(Boolean),
            targetField = $query("[name=" + target + "]");

        function exec() {
            if (targetField.value && targetField.value !== value) field.style.display = "";
            else field.style.display = "none";
        }

        targetField.addEventListener("change", exec);

        exec();
    });

    $queryAll("[show-if]").forEach(field => {
        const [target, value] = field.getAttribute("show-if").split(",").map(e => e.trim()).filter(Boolean),
            targetField = $query("[name=" + target + "]");

        function exec() {
            if (targetField.value === value) field.style.display = "";
            else field.style.display = "none";
        }

        targetField.addEventListener("change", exec);

        exec();
    });
});