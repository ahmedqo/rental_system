const Neo = (function Neo() {
    const
        NEO_SYMBOLS_MAP = "`1234567890-=qwertyuiop[]\\asdfghjkl;'zxcvbnm ,./~!@#$%^&*()_+QWERTYUIOP{}|ASDFGHJKL:\"ZXCVBNM<>?",
        NEO_BLUE_PRINTS = (function blueprint() {
            const repository = {};

            for (let i = 0; i < NEO_SYMBOLS_MAP.length; i++) {
                const key = NEO_SYMBOLS_MAP[i];
                const firstPart = NEO_SYMBOLS_MAP.slice(i);
                const secondPart = NEO_SYMBOLS_MAP.slice(0, i);
                const value = firstPart + secondPart;
                repository[key] = value;
            }

            return repository;
        })(),
        NEO_TEXT_SYMBOL = Symbol.for("$NEOTEXTSYMBOL$"),
        NEO_LOAD_MAPS = [],
        NEO_NODE_MAPS = {},
        NEO_THEME_MAP = {
            COLORS: {
                WHITE: "254 254 254",
                LIGHT: "245 245 245",
                SHADE: "209 209 209",
                PRIME: "33 150 243",
                BLACK: "29 29 29",
                RED: {
                    50: "254 242 242",
                    100: "254 226 226",
                    200: "254 202 202",
                    300: "252 165 165",
                    400: "248 113 113",
                    500: "239 68 68",
                    600: "220 38 38",
                    700: "185 28 28",
                    800: "153 27 27",
                    900: "127 29 29",
                    950: "69 10 10",
                },
                GRAY: {
                    50: "249 250 251",
                    100: "243 244 246",
                    200: "229 231 235",
                    300: "209 213 219",
                    400: "156 163 175",
                    500: "107 114 128",
                    600: "75 85 99",
                    700: "55 65 81",
                    800: "31 41 55",
                    900: "17 24 39",
                    950: "3 7 18",
                },
                BLUE: {
                    50: "239 246 255",
                    100: "219 234 254",
                    200: "191 219 254",
                    300: "147 197 253",
                    400: "96 165 250",
                    500: "59 130 246",
                    600: "37 99 235",
                    700: "29 78 216",
                    800: "30 64 175",
                    900: "30 58 138",
                    950: "23 37 84",
                },
                GREEN: {
                    50: "240 253 244",
                    100: "220 252 231",
                    200: "187 247 208",
                    300: "134 239 172",
                    400: "74 222 128",
                    500: "34 197 94",
                    600: "22 163 74",
                    700: "21 128 61",
                    800: "22 101 52",
                    900: "20 83 45",
                    950: "5 46 22",
                },
                YELLOW: {
                    50: "254 252 232",
                    100: "254 249 195",
                    200: "254 240 138",
                    300: "253 224 71",
                    400: "250 204 21",
                    500: "234 179 8",
                    600: "202 138 4",
                    700: "161 98 7",
                    800: "133 77 14",
                    900: "113 63 18",
                    950: "66 32 6",
                },
                PURPLE: {
                    50: "250 245 255",
                    100: "243 232 255",
                    200: "233 213 255",
                    300: "216 180 254",
                    400: "192 132 252",
                    500: "168 85 247",
                    600: "147 51 234",
                    700: "126 34 206",
                    800: "107 33 168",
                    900: "88 28 135",
                    950: "59 7 100",
                },
            },
            SIZES: {
                XSMALL: "0.75rem",
                SMALL: "0.875rem",
                BASE: "1rem",
                MEDIUM: "1.125rem",
                LARGE: "1.25rem",
                XLARGE: "1.5rem",
            },
            LINES: {
                THIN: "0.75rem",
                XSMALL: "1rem",
                SMALL: "1.25rem",
                BASE: "1.5rem",
                MEDIUM: "1.75rem",
                LARGE: "1.75rem",
                XLARGE: "2rem",
            },
        },
        NEO_SVG_NODES = {
            svg: true,
            animate: true,
            animateMotion: true,
            animateTransform: true,
            circle: true,
            clipPath: true,
            defs: true,
            desc: true,
            discard: true,
            ellipse: true,
            feBlend: true,
            feColorMatrix: true,
            feFiberTransfer: true,
            feComposite: true,
            feConvolveMatrix: true,
            feDiffuseLighting: true,
            feDisplacementMap: true,
            feDistantLight: true,
            feDropShadow: true,
            feFlood: true,
            feFuncA: true,
            feFuncB: true,
            feFuncG: true,
            feFuncR: true,
            feGaussianBlur: true,
            feImage: true,
            feMerge: true,
            feMergeNode: true,
            feMorphology: true,
            feOffset: true,
            fePointLight: true,
            feSpecularLighting: true,
            feSpotLight: true,
            feTile: true,
            feTurbulence: true,
            filter: true,
            foreignObject: true,
            g: true,
            hatch: true,
            hatchpath: true,
            image: true,
            line: true,
            linearGradient: true,
            marker: true,
            mask: true,
            metadata: true,
            mpath: true,
            path: true,
            pattern: true,
            polygon: true,
            polyline: true,
            radialGradient: true,
            rect: true,
            script: true,
            set: true,
            stop: true,
            style: true,
            switch: true,
            symbol: true,
            text: true,
            textPath: true,
            title: true,
            tspan: true,
            use: true,
            compiler: true,
            animateColor: true,
            "missing-glyph": true,
            font: true,
            "font-face": true,
            "font-face-format": true,
            "font-face-name": true,
            "font-face-src": true,
            "font-face-uri": true,
            hkern: true,
            vkern: true,
            solidcolor: true,
            altGlyph: true,
            altGlyphDef: true,
            altGlyphItem: true,
            glyph: true,
            glyphRef: true,
            tref: true,
            cursor: true,
        },
        NEO_CSS_PROPS = {
            "animation-iteration-count": true,
            "border-image-slice": true,
            "border-image-width": true,
            "column-count": true,
            "counter-increment": true,
            "counter-reset": true,
            flex: true,
            "flex-grow": true,
            "flex-shrink": true,
            "font-size-adjust": true,
            "font-weight": true,
            "line-height": true,
            "nav-index": true,
            opacity: true,
            order: true,
            orphans: true,
            "tab-size": true,
            widows: true,
            "z-index": true,
            "pitch-range": true,
            richness: true,
            "speech-rate": true,
            stress: true,
            volume: true,
            "lood-opacity": true,
            "mask-box-outset": true,
            "mask-border-outset": true,
            "mask-box-width": true,
            "mask-border-width": true,
            "shape-image-threshold": true,
        },
        NEO_MOMENT_OBJ = {
            $: {
                props: [
                    ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                ],
                zeros: function(nbr, len) {
                    for (var sign = nbr < 0 ? "-" : "", output = Math.abs(nbr).toString(); output.length < len;) output = "0" + output;
                    return sign + output;
                },
                clean: function(input) {
                    var matches = input.match(/^'([^]*?)'?$/);
                    return matches ? matches[1].replace(/''/g, "'") : input;
                },
            },
            y: (date, token) => {
                var signedYear = date.getFullYear(),
                    year = signedYear > 0 ? signedYear : 1 - signedYear;
                return NEO_MOMENT_OBJ.$.zeros("yy" === token ? year % 100 : year, token.length);
            },
            m: (date, token) => {
                var month = date.getMonth();
                switch (token) {
                    case "mmm":
                        return Neo.Helper.trans(NEO_MOMENT_OBJ.$.props[0][month]).slice(0, 3);
                    case "mmmm":
                        return Neo.Helper.trans(NEO_MOMENT_OBJ.$.props[0][month]);
                    default:
                        return NEO_MOMENT_OBJ.$.zeros(month + 1, token.length);
                }
            },
            d: (date, token) => {
                switch (token) {
                    case "ddd":
                        return Neo.Helper.trans(NEO_MOMENT_OBJ.$.props[1][date.getDay()]).slice(0, 3);
                    case "dddd":
                        return Neo.Helper.trans(NEO_MOMENT_OBJ.$.props[1][date.getDay()]);
                    default:
                        return NEO_MOMENT_OBJ.$.zeros(date.getDate(), token.length);
                }
            },
            A: (date, token) => {
                var dayPeriodEnumValue = date.getHours() / 12 >= 1 ? "pm" : "am";
                switch (token) {
                    case "A":
                    case "AA":
                        return dayPeriodEnumValue.toUpperCase();
                    case "AAA":
                        return dayPeriodEnumValue;
                    case "AAAAA":
                        return dayPeriodEnumValue[0];
                    case "AAAA":
                    default:
                        return "am" === dayPeriodEnumValue ? "a.m." : "p.m.";
                }
            },
            h: (date, token) => {
                return NEO_MOMENT_OBJ.$.zeros(date.getHours() % 12 || 12, token.length);
            },
            H: (date, token) => {
                return NEO_MOMENT_OBJ.$.zeros(date.getHours(), token.length);
            },
            M: (date, token) => {
                return NEO_MOMENT_OBJ.$.zeros(date.getMinutes(), token.length);
            },
            S: (date, token) => {
                return NEO_MOMENT_OBJ.$.zeros(date.getSeconds(), token.length);
            },
        };

    class Instance {
        constructor(dom, fiber, children) {
            this.dom = dom;
            this.fiber = fiber;
            this.children = children;
        }
    }

    class Fiber {
        constructor(type = null, props = {}) {
            this.type = type;
            this.props = props;
            this.props.children = this.props.children || [];
        }
    }

    class Parser {
        static {
            this.join = new RegExp("\\$JOIN\\$\\d+\\$");
            this.nbr = new RegExp("\\d+");

            this.compose = function compose(source, props) {
                return source.reduce((acc, part, i) => {
                    return acc + part + (i < props.length ? (["string", "number", "boolean"].includes(typeof props[i]) ? props[i] : "$JOIN$" + i + "$") : "")
                }, "").trim();
            }

            this.parse = function parse(source) {
                const template = document.createElement("template");
                template.innerHTML = source;
                return template.content;
            }
        }

        constructor(source, ...props) {
            this.source = source;
            this.props = props;
        }

        attrs(target, fiber) {
            if (target.attributes && target.attributes.length) {
                for (let i = 0; i < target.attributes.length; i++) {
                    const value = Parser.join.test(target.attributes[i].nodeValue) ? this.props[+target.attributes[i].nodeValue.match(Parser.nbr)] : target.attributes[i].nodeValue;
                    fiber.props[target.attributes[i].nodeName] = value;
                }
            }
        }

        nodes(target, fiber) {
            if (target && target.length) {
                for (let i = 0; i < target.length; i++) {
                    if (target[i].nodeType === 3) {
                        if (target[i].nodeValue.trim()) {
                            const index = target[i].nodeValue.replace(/\s\s+|\n|\r\n/g, '');
                            const isElement = Parser.join.test(index) && this.props[+index.match(Parser.nbr)];
                            if (isElement) {
                                const _fiber = new Fiber(isElement, { children: [] });
                                fiber.props.children.push(_fiber);
                                //this.attrs(isElement, _fiber);
                                this.tree(isElement, fiber.props.children[fiber.props.children.length - 1]);
                            } else {
                                fiber.props.children.push(new Fiber(NEO_TEXT_SYMBOL, { nodeValue: index }));
                            }
                        }
                    } else {
                        fiber.props.children.push(new Fiber());
                        this.tree(target[i], fiber.props.children[fiber.props.children.length - 1]);
                    }
                }
            }
        }

        tree(target, fiber) {
            fiber.type = target.nodeName.toLowerCase();
            this.nodes(target.childNodes, fiber);
            this.attrs(target, fiber);
        }

        exec() {
            const source = Parser.compose(this.source, this.props),
                fiber = new Fiber();

            this.tree(Parser.parse(source), fiber);
            return fiber.props.children;
        }
    }

    class Neo {
        static Wrapper = null;
        static Toaster = null;
        static Locales = {
            fr: {
                /** months */
                "January": "Janvier",
                "February": "Fevrier",
                "March": "Mars",
                "April": "Avril",
                "May": "Mai",
                "June": "Juin",
                "July": "Juillet",
                "August": "Août",
                "September": "Septembre",
                "October": "Octobre",
                "November": "Novembre",
                "December": "Decembre",
                /** days */
                "Sunday": "Dimanche",
                "Monday": "Lundi",
                "Tuesday": "Mardi",
                "Wednesday": "Mercredi",
                "Thursday": "Jeudi",
                "Friday": "Vendredi",
                "Saturday": "Samedi",
                /** components */
                "Print": "Imprimer",
                "Search": "Recherche",
                "Columns": "Colonnes",
                "Download": "Telecharger",
                "No data found": "Aucune donnee disponible",
            },
            ar: {
                /** months */
                "January": "يناير",
                "February": "فبراير",
                "March": "مارس",
                "April": "أبريل",
                "May": "مايو",
                "June": "يونيو",
                "July": "يوليو",
                "August": "أغسطس",
                "September": "سبتمبر",
                "October": "أكتوبر",
                "November": "نوفمبر",
                "December": "ديسمبر",
                /** days */
                "Sunday": "الأحد",
                "Monday": "الاثنين",
                "Tuesday": "الثلاثاء",
                "Wednesday": "الأربعاء",
                "Thursday": "الخميس",
                "Friday": "الجمعة",
                "Saturday": "السبت",
                /** components */
                "Print": "طباعة",
                "Search": "بحث",
                "Columns": "أعمدة",
                "Download": "تحميل",
                "No data found": "لا توجد بيانات",
            }
        }

        static load = function load(callable) {
            typeof callable === "function" && NEO_LOAD_MAPS.push(callable);
        };

        static upgrade = function upgrade() {
            Object.keys(NEO_NODE_MAPS).forEach(selector => {
                Array.from(document.querySelectorAll(selector), (el) => el.paint());
            });
        }

        static getComponent(name) {
            return NEO_NODE_MAPS[name];
        }
    }

    Neo.Helper = (function Helper() {
        const blend = function blend(content, key) {
            let code = "";

            for (let i = 0, j = 0; i < content.length; i++) {
                if (NEO_SYMBOLS_MAP.includes(content[i])) {
                    code += key[j % key.length];
                    j++;
                } else {
                    code += content[i];
                }
            }

            return code;
        }

        class Helper {
            static secure = function secure(original, alternative) {
                return Helper.truty(original) ? original : alternative;
            }

            static random = function random(length = 10) {
                var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                var charLength = chars.length;
                var result = "";
                for (var i = 0; i < length; i++) {
                    result += chars.charAt(Math.floor(Math.random() * charLength));
                }
                return result;
            }

            static option = function option(cases, target) {
                if (!cases || !target) return;
                for (const [key, value] of Object.entries(cases))
                    if (key.split(",").map(str => str.trim()).includes(target)) return value();
            }

            static choice = function choice(items, length = 1) {
                const random = items.slice().sort(() => Math.random() - 0.5); // Shuffle the items
                const result = random.slice(0, Math.min(length, items.length));
                return length > 1 ? result : result[0];
            }

            static falsy = function falsy(data) {
                return [
                    "false", "null", "undefined", "0", ""
                ].includes(String(data).trim());
            }

            static truty = function truty(data) {
                return !Helper.falsy(data);
            }

            static trans = function trans(text, context = {}) {
                if (typeof text !== "string") return text;
                var dict = Neo.Locales[context["#locale"] || document.documentElement.lang || "en"];
                return ((dict && dict[text]) || text).replace(/#([\w\d._-]+)/g, (full, key) => context[key] || full);
            }

            static range = function range(startOrEnd, end, step = 1) {
                const start = end === undefined ? 0 : +startOrEnd;
                end = end === undefined ? +startOrEnd : +end;
                const length = Math.ceil((end - start) / step);
                return Array.from({ length }, (_, index) => start + index * step);
            }

            static style = function style(cssObj) {
                const rules = [];

                for (const key in cssObj) {
                    const rule = Helper.Str.kebab(key);
                    var value = cssObj[key];

                    if (Helper.truty(value)) {
                        if (typeof value === "number" && !(rule in NEO_CSS_PROPS)) value += "px";
                        rules.push(rule + ":" + value + ";")
                    }
                }

                return rules.join("");
            }

            static when = function when(condition, truecase, falsecase) {
                return Helper.truty(condition) ?
                    (typeof truecase === "function" ? truecase(condition) : truecase) :
                    (typeof falsecase === "function" ? falsecase(condition) : falsecase);
            }

            static Theme = class Theme {
                static MEDIA = ["", "-o-", "-ms-", "-moz-", "-webkit-"];

                static assign = function assign(type, name, value) {
                    if (Object.keys(NEO_THEME_MAP).includes(type.toUpperCase()))
                        NEO_THEME_MAP[type.toUpperCase()][name.toUpperCase()] = value;
                }

                static colors = function colors(name, shade, opacity) {
                    name = name.toUpperCase();
                    const isobj = typeof NEO_THEME_MAP.COLORS[name] === "object";
                    return "rgb(" + ((isobj ? NEO_THEME_MAP.COLORS[name][shade] : NEO_THEME_MAP.COLORS[name]) || NEO_THEME_MAP.COLORS.BLACK) + " / " + (((isobj ? opacity : shade) || 100) / 100) + ")";
                }

                static sizes = function sizes(name) {
                    return NEO_THEME_MAP.SIZES[name.toUpperCase()];
                }

                static lines = function lines(name) {
                    return NEO_THEME_MAP.LINES[name.toUpperCase()];
                }

                static layer = function layer() {
                    return Math.max(
                        ...[...document.querySelectorAll("body *")].reduce((a, c) => {
                            if ("root" in c) {
                                a.push(...c.root.querySelectorAll("*"));
                            }
                            a.push(c);
                            return a;
                        }, []).map(el => parseFloat(window.getComputedStyle(el).zIndex)).filter(
                            zIndex => !Number.isNaN(zIndex)
                        ), 0
                    ) + 1;
                }
            }

            static Cipher = class Cipher {
                static encrypt = function encrypt(content, key) {
                    for (let x = 0; x < key.length; x++) {
                        const blendstr = blend(content, key);
                        let code = "";

                        for (let i = 0; i < blendstr.length; i++) {
                            code += NEO_SYMBOLS_MAP.includes(content[i]) ? NEO_BLUE_PRINTS[blendstr[i]][NEO_SYMBOLS_MAP.indexOf(content[i])] : content[i];
                        }
                        content = code;
                    }

                    return content;
                }

                static decrypt = function decrypt(content, key) {
                    for (let x = 0; x < key.length; x++) {
                        const blendstr = blend(content, key);
                        let code = "";

                        for (let i = 0; i < blendstr.length; i++) {
                            code += NEO_SYMBOLS_MAP.includes(content[i]) ? NEO_SYMBOLS_MAP[NEO_BLUE_PRINTS[blendstr[i]].indexOf(content[i])] : content[i];
                        }
                        content = code;
                    }

                    return content;
                }
            }

            static Str = class Str {
                static moment = function moment(date, format = "yyyy-mm-dd") {
                    if (typeof date !== "string") return null;
                    const tokens = (format).match(/(\w)\1*|''|'(''|[^'])+('|$)|./g);
                    date = new Date(date);

                    return tokens ?
                        tokens
                        .map(function(substringing) {
                            if ("''" === substringing) return "'";
                            var firstCharacter = substringing[0];
                            if ("'" === firstCharacter) return NEO_MOMENT_OBJ.$.clean(substringing);
                            var formatter = NEO_MOMENT_OBJ[firstCharacter];
                            return formatter ? formatter(date, substringing) : substringing;
                        })
                        .join("") :
                        null;
                }

                static kebab = function kebab(string) {
                    return string.replace(/([a-z])([A-Z])/g, "$1-$2").split(/[-_.\\\/\s]/g).join("-").toLowerCase();
                }

                static snake = function snake(string) {
                    return string.replace(/[-_.\\\/\s](\w+)/g, (_, w) => w[0].toUpperCase() + w.slice(1).toLowerCase());
                }

                static money = function money(number, zeros = 2) {
                    return number.toLocaleString('en-US', {
                        minimumFractionDigits: Math.max(zeros, (number.toFixed(zeros).toString().split('.')[1] || '').length)
                    });
                }

                static compact = function compact(number = 0, zeros = 0) {
                    return new Intl.NumberFormat('en-US', {
                        notation: 'compact',
                        compactDisplay: 'short',
                        minimumFractionDigits: Math.max(zeros, (number.toString().split('.')[1] || '').length)
                    }).format(number);
                }

                static titlize = function titlize(string) {
                    return (!string || typeof string !== 'string') ? '' : string.trim().replace(/\b\w/g, function(char) {
                        return char.toUpperCase();
                    });
                }

                static capitalize = function capitalize(string) {
                    return (!string || typeof string !== 'string') ? '' : string.trim().charAt(0).toUpperCase() + string.trim().slice(1);
                }
            }
        }

        return Helper;
    })();

    Neo.Sketch = (function Sketch() {
        class Sketch {
            constructor(source, context, helpers = {}) {
                this.source = source
                    .replace(/\n.*?(\(\$)-/g, '$1') // tag starting with {\$-
                    .replace(/-(\$\)).*?\n/g, '$1') // tag ending with -\$}
                    .replace(/\n.*?(\{\{)-/g, '$1') // tag starting with {{-
                    .replace(/-(}\}).*?\n/g, '$1');
                this.helpers = {...helpers, ...Neo.Helper };
                this.context = context;
            }

            build(source) {
                return new Function("", source)()(
                    this.context,
                    this.helpers,
                    function $EACH$(iterable, callback) {
                        if (iterable === null) return iterable;
                        let index = 0;
                        for (const key in iterable) {
                            callback(key, iterable[key], {
                                index: index,
                                round: index + 1,
                                odd: index % 2 > 0,
                                even: index % 2 === 0,
                                first: index === 0,
                                last: index + 1 === Object.keys(iterable).length,
                            });
                            index++;
                        }
                    },
                    function $SIZE$(iterable) {
                        try { return Object.keys(iterable).length } catch (e) { return null }
                    },
                    function $ESCAPE$(string) {
                        const escapeMap = {
                            "&": "&amp;",
                            "<": "&lt;",
                            ">": "&gt;",
                            '"': "&quot;",
                            "'": "&apos;",
                        };

                        return string.replace(/[&<>"']/g, (char) => escapeMap[char] || char);
                    },
                    Error
                );
            }

            str() {
                const source = this.build(Sketch.test(this.source) ? this.source : Sketch.compile(this.source));
                return source
                    .shift()
                    .reduce((acc, part, i) => acc + part + (["string", "number", "boolean"].includes(typeof source[i]) ? source[i] : ""), "")
                    .trim();
            }

            exec() {
                return new Parser(...this.build(Sketch.test(this.source) ? this.source : Sketch.compile(this.source))).exec();
            }
        }

        Sketch.delemiters = [/\{\$/, /\$\}/];
        Sketch.variables = [/\{\{/, /\}\}/];
        Sketch.helpers = new RegExp("(?<![\"'`])@+(\\w+)(?![\"'`])", "g");
        Sketch.chained = new RegExp("([.]+[\\w\\d-_]+)(?=(?:[^'\"`]|[\"'`][^'\"`]*[\"'`])*$)", "g");
        Sketch.parseed = RegExp(
            '(' + Sketch.delemiters[0].source + '.*?' + Sketch.delemiters[1].source +
            '|' + Sketch.variables[0].source + '.*?' + Sketch.variables[1].source +
            '|' + Sketch.variables[0].source + '|' + Sketch.delemiters[0].source + ')'
        );
        Sketch.isLogic = RegExp('^' + Sketch.delemiters[0].source);
        Sketch.isVariable = RegExp('^' + Sketch.variables[0].source);
        Sketch.fullToken = RegExp('^' + Sketch.delemiters[0].source + '\\s*(\\w+)\\s*(.*)?' + Sketch.delemiters[1].source + '$');
        Sketch.contentOfVariable = RegExp('^' + Sketch.variables[0].source + '(.*)' + Sketch.variables[1].source + '$');

        Sketch.loop = function loop(args) {
            var mth = /\[(.*),(.*)\]/g.exec(args[0]),
                arr = args[1].trim(),
                val = args[0].trim(),
                key = "_";
            return [arr, mth ? mth[1].trim() : key, mth ? mth[2].trim() : val];
        }

        Sketch.logic = function logic(name) {
            return {
                //  ($ make name = "ahmed" $)
                make: (line) => "var " + line + ";",

                //  ($ code name = "ahmed" $)
                code: (line) => line + ";",

                //  ($ until age > 10 $)
                until: (line) => "while(!(" + line + ")){",
                //  ($ enduntil $)
                enduntil: () => "}",

                //  ($ until age < 10 $)
                while: (line) => "while(" + line + "){",
                //  ($ endwhile $)
                endwhile: () => "}",

                //  ($ unless age < 10 $)
                unless: (line) => "if(!(" + line + ")){",
                //  ($ endunless $)
                endunless: () => "}",

                //  ($ each name into names $)
                each: (line) => {
                    var [arr, key, val] = Sketch.loop(line.split(/into|INTO/));
                    return "$EACH$(" + arr + ",function(" + key + "," + val + ",$LOOP$){";
                },
                //  ($ endeach $)
                endeach: () => "});",

                //  ($ forelse name into names $)
                forelse: (line) => {
                    var [arr, key, val] = Sketch.loop(line.split(/into|INTO/));
                    return "if($SIZE$(" + arr + ")){$EACH$(" + arr + ",function(" + key + "," + val + ",$LOOP$){";
                },
                //  ($ empty $)
                empty: () => "})}else{",
                //  ($ endforelse $)
                endforelse: () => "}",

                //  ($ if age > 10 $)
                if: (line) => "if(" + line + "){",
                //  ($ elif age === 18 $)
                elif: (line) => "}else if(" + line + "){",
                //  ($ else $)
                else: () => "}else{",
                //  ($ endif $)
                endif: () => "}",

                //  ($ try $)
                try: () => "try{",
                //  ($ catch error $)
                catch: (line) => "}catch(" + line + "){",
                //  ($ finally $)
                finally: () => "}finally{",
                //  ($ endtry $)
                endtry: () => "}",

                //  ($ info name, age $)
                info: (line) => "console['trace'](" + line + ");",
                //  ($ warn name, age $)
                warn: (line) => "console['warn'](" + line + ");",
                //  ($ error name, age $)
                error: (line) => "console['error'](" + line + ");",
            }[name.toLowerCase()];
        }

        Sketch.regex = function regex(line) {
            return line.replace(Sketch.helpers, (_, name) => name === "loop" ? "$LOOP$" : ("$HELPER$." + name))
                .replace(Sketch.chained, (obj) => "[\"" + obj.substring(1) + "\"]");
        }

        Sketch.tokens = function tokens(source) {
            source = String(source);
            if (source.length === 0) return [];

            const tokens = source
                .split(Sketch.parseed)
                .filter(token => token.length > 0)

            let line = 1
            let col = 1

            return tokens.map(value => {
                const result = { value, col, line }
                const lastIndex = value.lastIndexOf('\n')

                if (lastIndex < 0) {
                    col += value.length
                } else {
                    const linebreaks = value.split('\n').length - 1
                    line += linebreaks
                    col = value.length - lastIndex
                }

                return result
            })
        }

        Sketch.parse = function parse(tokens) {
            if (tokens.length === 0) return "";
            const options = { macro: false };
            return tokens.reduce((carry, token) => {
                try {
                    return carry + "$LINE$=" + token.line + ";$COL$=" + token.col + ";" + Sketch.token(token, options);
                } catch (err) {
                    throw Sketch.error(err, token);
                }
            }, "");
        }

        Sketch.token = function token(token, options) {
            if (Sketch.isLogic.test(token.value)) {
                const match = Sketch.fullToken.exec(token.value);
                return ["macro", "endmacro"].includes(match[1].toLowerCase()) ?
                    (options.macro = match[1].toLowerCase() === "macro", "") :
                    Sketch.logic(match[1].toLowerCase())(match[2] && Sketch.regex(match[2].trim()));
            } else if (Sketch.isVariable.test(token.value)) {
                const ref = Sketch.contentOfVariable.exec(token.value);
                const match = ref != null ? ref[1] : void 0;
                return "$ADDJSX$(" + (match[0] === ">" ? "$ESCAPE$(" + Sketch.regex(match.substring(1).trim()) + ")" : Sketch.regex(match.trim())) + ");";
            } else if (token.value.length !== 0) {
                return options.macro ?
                    token.value.replace(/(\n\r+|\n\s+|\r+|\n+)/g, " ") :
                    "$ADDTXT$(\"" + token.value.replace(/(`|'|")/g, "\\$1") + "\");";
            }
        }

        Sketch.compile = function compile(source) {
            source = Sketch.tokens(source);
            source = Sketch.parse(source);
            source = source.replace(/(\n|\n\s+)/g, "\\n");

            return "return function($CONTEXT$,$HELPER$,$EACH$,$SIZE$,$ESCAPE$,$ERROR$){var $TXT$=[],$JSX$=[],$INDEX$=0,$LINE$=0,$COL$=0;function $ADDTXT$($LINE$){if(!$TXT$[$INDEX$]){$TXT$[$INDEX$]=''}$TXT$[$INDEX$]=($TXT$[$INDEX$]+$LINE$).replace(/\\n(:?\\s*\\n)+/g,'\\n')}function $ADDJSX$($LINE$){$JSX$[$INDEX$]=$LINE$,$INDEX$++}with($CONTEXT$||{}){try{" +
                source + "}catch(e){throw new $ERROR$([e.message,'\\n\\tat','Line:','\"'+$LINE$+'\"','Col:','\"'+$COL$+'\"'].join(' '))}}return [$TXT$,...$JSX$]}"
        }

        Sketch.test = function test(source) {
            return source.startsWith("return function($CONTEXT$,$HELPER$,$EACH$,$SIZE$,$ESCAPE$,$ERROR$){var $TXT$=[],$JSX$=[],$INDEX$=0,$LINE$=0,$COL$=0;function $ADDTXT$($LINE$){if(!$TXT$[$INDEX$]){$TXT$[$INDEX$]=''}$TXT$[$INDEX$]=($TXT$[$INDEX$]+$LINE$).replace(/\\n(:?\\s*\\n)+/g,'\\n')}function $ADDJSX$($LINE$){$JSX$[$INDEX$]=$LINE$,$INDEX$++}");
        }

        Sketch.error = function error(err, token) {
            err.message = err.message + '\n    at ' + token.value + ' (' + token.line + ':' + token.col + ')'
            if (!err.location) {
                err.location = {
                    col: token.col,
                    line: token.line,
                }
            }
        }

        return Sketch;
    })();

    Neo.Driver = (function Driver() {
        class Driver {
            constructor(container, tree, refs = {}) {
                this.container = container;
                this.instance = null;
                this.refs = refs;
                this.tree = tree;
            }

            create(fiber) {
                const { type, props } = fiber;
                const dom =
                    type === NEO_TEXT_SYMBOL ?
                    document.createTextNode("") : type instanceof HTMLElement ? type :
                    type in NEO_SVG_NODES ?
                    document.createElementNS("http://www.w3.org/2000/svg", type) :
                    document.createElement(type);
                const children = this.children({ dom }, fiber);
                Driver.properties(dom, {}, props, this.refs);
                return new Instance(dom, fiber, children);
            }

            reconcile(parentDom, oldNode, fiber) {
                var node;
                if (null == oldNode) {
                    if (Array.isArray(fiber)) {
                        node = fiber.map((e) => this.create(e));
                        node.forEach((e) => {
                            parentDom.appendChild(e.dom);
                        });
                    } else {
                        node = this.create(fiber);
                        if (Array.isArray(node.dom)) {
                            Driver.flatten(node.dom).forEach((e) => {
                                parentDom.appendChild(e);
                            });
                        } else {
                            node.dom && parentDom.appendChild(node.dom);
                        }
                    }
                    return node;
                }

                if (null == fiber) {
                    if (Array.isArray(oldNode)) {
                        oldNode.forEach((e) => {
                            parentDom.removeChild(e.dom);
                        });
                    } else {
                        oldNode.dom && parentDom.removeChild(oldNode.dom);
                    }
                    return null;
                }

                if (Array.isArray(oldNode) && Array.isArray(fiber)) {
                    return this.children({ dom: parentDom, children: oldNode }, { props: { children: fiber } });
                }

                if ((oldNode.fiber || {}).type !== fiber.type) {
                    node = this.create(fiber);
                    if (oldNode.dom || oldNode[0].dom) {
                        parentDom.replaceChild(node.dom, oldNode.dom || oldNode[0].dom);
                    }
                    return node;
                }

                if (typeof fiber.type === "string" || fiber.type === NEO_TEXT_SYMBOL) {
                    oldNode.children = this.children(oldNode, fiber);
                    Driver.properties(oldNode.dom, oldNode.fiber.props, fiber.props, this.refs);
                    oldNode.fiber = fiber;
                    return oldNode;
                }

                return undefined;
            }

            children(oldNode, fiber) {
                const oldChildNodes = (oldNode.children || []).filter((node) => null != node),
                    childElements = (fiber.props.children || []).filter((node) => null != node),
                    length = Math.max(oldChildNodes.length, childElements.length),
                    children = [];

                for (var i = 0; i < length; i++) {
                    const childNode = this.reconcile(oldNode.dom, oldChildNodes[i], childElements[i]);
                    children.push(childNode);
                }

                return children;
            }

            exec(tree) {
                this.tree = tree || this.tree;
                for (let prop in this.refs) delete this.refs[prop];
                this.instance = this.reconcile(this.container, this.instance, this.tree);
            }
        }

        Driver.flatten = function flatten(array) {
            return array.reduce((flat, toFlatten) => [...flat, ...(Array.isArray(toFlatten) ? Driver.flatten(toFlatten) : [toFlatten])], []);
        }

        Driver.properties = function properties(node, prev, next, refs) {
            Driver.properties.clear(node, prev, next);
            Driver.properties.apply(node, next, refs);
        }

        Driver.object = function object(node, prop, value) {
            const props = prop.split("."),
                target = props.pop(),
                object = props.reduce((carry, curr) => carry[curr], node);
            object[target] = value;
        }

        Driver.reference = function reference(node, prop, refs) {
            if (refs[prop])
                Array.isArray(refs[prop]) ?
                refs[prop].push(node) :
                (refs[prop] = [refs[prop], node]);
            else refs[prop] = node;
        }

        Driver.properties.clear = function clear(node, prev, next) {
            Driver.listeners.clear(node, next);
            for (var prop in prev) {
                if (!(prop in next)) {
                    const tag = node && node.tagName && node.tagName.toLowerCase(),
                        isObj = prop.split(".").length > 1,
                        isSvg = tag in NEO_SVG_NODES,
                        isProp = prop in node;

                    if (isProp && !isSvg) node[prop] = "";
                    else if (isObj)
                        this.applyObject(
                            node, {
                                [prop]: "",
                            },
                            prop
                        );
                    else node.removeAttribute(prop);
                }
            }
        }

        Driver.properties.apply = function apply(node, next, refs) {
            for (var prop in next) {
                if (prop === "children") continue;

                const tag = node && node.tagName && node.tagName.toLowerCase(),
                    isObj = prop.split(".").length > 1,
                    isSvg = tag in NEO_SVG_NODES,
                    isEvent = prop.startsWith("@"),
                    isRef = prop === "ref",
                    isProp = prop in node;

                if (isEvent) Driver.listeners.apply(node, prop, next[prop]);
                else if (isProp && !isSvg) {
                    node[prop] = ["false", "true"].includes(next[prop]) ? eval(next[prop]) : next[prop];
                } else if (isObj) Driver.object(node, prop, next[prop]);
                else if (isRef) Driver.reference(node, next[prop], refs);
                else node.setAttribute(prop, next[prop]);
            }
        }

        Driver.listeners = function listeners() {}

        Driver.listeners.clear = function clear(node, next) {
            for (const event in node.listeners) {
                if (!(event in next)) {
                    const eventString = event.split(":"),
                        eventName = eventString[0].substring(1);

                    node["on" + eventName] = null;
                    delete node.listeners[event];
                }
            }
        }

        Driver.listeners.apply = function apply(node, name, callable) {
            const eventString = name.split(":"),
                eventName = eventString.shift().substring(1);

            node.listeners = node.listeners || {};
            if (!node.listeners[name] ||
                (node.listeners[name] && node.listeners[name].toString() !== callable.toString())
            ) {
                node.listeners[name] = callable;
                node["on" + eventName] = (event) => {
                    (eventString[0] || "").split("|").forEach((type) => {
                        switch (type) {
                            case "prevent":
                                event.preventDefault();
                            case "propagation":
                                event.stopPropagation();
                            case "immediate":
                                event.stopImmediatePropagation();
                        }
                    });
                    callable(event);
                }
            }
        }

        return Driver;
    })();

    Neo.Segment = (function Segment() {
        const EFFECT_MAPS = [];

        class Segment {
            constructor(root, sketch, context = {}) {
                this.sketch = new Neo.Sketch(sketch, context, {
                    this: this
                });
                this.driver = new Neo.Driver(root, []);
                this.upgrade();
            }

            setEffect(callback) {
                EFFECT_MAPS.push(callback.bind(this));
            }

            setContext(props) {
                var prev = {...this.sketch.context },
                    upgrade = false;

                Object.entries(props).forEach(([key, val]) => {
                    if (prev[key] === val) return;

                    prev[key] = val;
                    upgrade = true;
                });

                if (!upgrade) return;

                this.sketch.context = prev;
                this.upgrade();
            }

            upgrade() {
                Segment.build(this.driver, this.sketch);
                EFFECT_MAPS.forEach((callable) => callable());
            }

            get context() {
                return this.sketch.context;
            }

            get effect() {
                return EFFECT_MAPS;
            }
        }

        Segment.build = function build(driver, sketch) {
            driver.exec(sketch.exec());
        }

        return Segment;
    })();

    Neo.Validator = (function Validator() {
        const dates = function dates(value, parts, query) {
            const contentDate = new Date(value);
            const compareDate = new Date(parts[0] === "today" ? (new Date()).toLocaleDateString() : (Validator.Rules.date(parts[0]) ? parts[0] : query(`[name="${parts[0]}"]`).value));
            return [contentDate, compareDate];
        }

        const split = function split(parts) {
            return String(parts).split(",").map(e => e.trim()).filter(e => e.length);
        }

        class Validator {
            static validate(selector, { rules = {}, message = {}, success = () => {}, failure = () => {}, execute = null }) {
                message = { success: {}, failure: {}, ...message };
                const element = typeof selector === "string" ? document.querySelector(selector) : selector;
                let isValid = true;

                Object.entries(rules).forEach(([rule, ruleValue]) => {
                    const currentRules = typeof ruleValue === "string" ? ruleValue.split("|") : ruleValue;
                    const currentField = element.querySelector(`[name="${rule}"]`);
                    const currentValue = String(currentField.value || '').trim();
                    let isSuccess = true;

                    currentRules.some(ruleItem => {
                        const [ruleName, ruleValue] = ruleItem.split(":");
                        const normalizedRuleName = ruleName.toLowerCase();
                        const parts = String(ruleValue || '').trim().split(",").map(e => e.trim()).filter(e => e.length);

                        if (!Validator.Rules[normalizedRuleName]) return false;
                        const isValidRule = Validator.Rules[normalizedRuleName](
                            currentValue, parts, {
                                field: currentField,
                                query: (s) => element.querySelector(s),
                                queryAll: (s) => element.querySelectorAll(s),
                            });

                        if (!isValidRule) {
                            const failureMessage = message.failure[rule] || {};
                            const messageText = typeof failureMessage === "string" ? failureMessage : failureMessage[normalizedRuleName];
                            failure(currentField, normalizedRuleName, messageText);
                            isSuccess = false;
                            isValid = false;
                            return true; // Exit `some` loop
                        }

                        return false; // Continue `some` loop
                    });

                    if (isSuccess) {
                        success(currentField, message.success[rule]);
                    }
                });

                return isValid && execute ? execute() : isValid;
            }

            static Rules = class Rules {
                static required = function required(value, parts, { field, queryAll }) {
                    if (["checkbox", "radio"].includes(field.type)) {
                        const checkboxes = queryAll(`[name="${field.name}"]`);
                        return Array.from(checkboxes).some(checkbox => checkbox.checked);
                    }
                    return value !== "";
                }

                static required_if = function required_if(value, parts, { field, query, queryAll }) {
                    const [fieldName, expectedValue] = parts;
                    const matchingField = query(`[name="${fieldName}"]`);
                    return !matchingField || expectedValue === String(matchingField.value).trim() ? Validator.Rules.required(value, "", { field, queryAll }) : true;
                }

                static required_unless = function required_unless(value, parts, { field, query, queryAll }) {
                    const [fieldName, expectedValue] = parts;
                    const matchingField = query(`[name="${fieldName}"]`);
                    return !matchingField || expectedValue !== String(matchingField.value).trim() ? Validator.Rules.required(value, "", { field, queryAll }) : true;
                }

                static required_with = function required_with(value, parts, { field, query, queryAll }) {
                    const isFieldPresent = parts.some(name => {
                        const fieldElement = query(`[name="${name}"]`);
                        return fieldElement && Validator.Rules.required(fieldElement.value, "", { field: fieldElement, queryAll });
                    });
                    return isFieldPresent ? Validator.Rules.required(value, "", { field, queryAll }) : true;
                }

                static required_without = function required_without(value, parts, { field, query }) {
                    const isFieldPresent = parts.some(name => {
                        const fieldElement = query(`[name="${name}"]`);
                        return fieldElement && Validator.Rules.required(fieldElement.value, "", { field: fieldElement, queryAll });
                    });
                    return !isFieldPresent ? Validator.Rules.required(value, "", { field, queryAll }) : true;
                }

                static required_with_all = function required_with_all(value, parts, { field, query }) {
                    const areFieldsPresent = parts.every(name => {
                        const fieldElement = query(`[name="${name}"]`);
                        return fieldElement && Validator.Rules.required(fieldElement.value, "", { field: fieldElement, queryAll });
                    });
                    return areFieldsPresent ? Validator.Rules.required(value, "", { field, queryAll }) : true;
                }

                static email = function email(value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(value);
                }

                static numeric = function numeric(value) {
                    return !isNaN(value) && value !== "";
                }

                static integer = function integer(value) {
                    return Number.isInteger(Number(value));
                }

                static float = function float(value) {
                    return !isNaN(parseFloat(value));
                }

                static alpha = function alpha(value) {
                    const alphaRegex = /^[A-Za-z]+$/;
                    return alphaRegex.test(value);
                }

                static date = function date(value) {
                    const dateRegex = /^(?:(?:\d{4}[-/]\d{2}[-/]\d{2})|(?:\d{2}[-/]\d{2}[-/]\d{4}))$/;
                    return dateRegex.test(value);
                }

                static date_before = function date_before(value, parts, { query }) {
                    const [contentDate, compareDate] = dates(value, parts, query);
                    return contentDate < compareDate;
                }

                static date_after = function date_after(value, parts, { query }) {
                    const [contentDate, compareDate] = dates(value, parts, query);
                    return contentDate > compareDate;
                }

                static date_before_or_equal = function date_before_or_equal(value, parts, { query }) {
                    const [contentDate, compareDate] = dates(value, parts, query);
                    return contentDate <= compareDate;
                }

                static date_after_or_equal = function date_after_or_equal(value, parts, { query }) {
                    const [contentDate, compareDate] = dates(value, parts, query);
                    return contentDate >= compareDate;
                }

                static url = function url(value) {
                    const urlRegex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
                    return urlRegex.test(value);
                }

                static phone = function phone(value) {
                    const phoneNumberRegex = /^(?:\+*([0-9]{3}|0))(?:[ \-]?[0-9]){9}$/;
                    return phoneNumberRegex.test(value);
                }

                static length = function length(value, parts) {
                    const [minLength, maxLength] = parts.map(Number);
                    return (minLength === undefined || value.length >= minLength) &&
                        (maxLength === undefined || value.length <= maxLength);
                }

                static strong = function strong(value, parts) {
                    return parts.every(rule => {
                        switch (rule) {
                            case "uppercase":
                                return /[A-Z]/.test(value);
                            case "lowercase":
                                return /[a-z]/.test(value);
                            case "numeric":
                                return /\d/.test(value);
                            case "special":
                                return /[!@#$%^&*]/.test(value);
                            default:
                                return true;
                        }
                    });
                }

                static min = function min(value, parts) {
                    return parseFloat(value) >= parseFloat(parts[0]);
                }

                static max = function max(value, parts) {
                    return parseFloat(value) <= parseFloat(parts[0]);
                }

                static regex = function regex(value, parts) {
                    const customRegex = new RegExp(parts[0]);
                    return customRegex.test(value);
                }

                static size = function size(value, parts, { field }) {
                    const maxSize = parseInt(parts[0]);
                    return field.files[0].size <= maxSize;
                }

                static type = function type(value, parts, { field }) {
                    return split(field.accept).some(type => parts.includes(type));
                }

                static match = function match(value, parts, { query }) {
                    const matchField = query(`[name="${parts[0]}"]`);
                    return matchField && value === String(matchField.value).trim();
                }

                static clash = function clash(value, parts, extra) {
                    return !Validator.Rules.match(value, parts, extra);
                }

                static exists = function exists(value, parts) {
                    return parts.includes(value);
                }

                static absent = function absent(value, parts, extra) {
                    return !Validator.Rules.exists(value, parts, extra);
                }

                static equal = function equal(value, parts) {
                    return value === parts[0];
                }

                static different = function different(value, parts) {
                    return !Validator.Rules.equal(value, parts);
                }

                static include = function include(value, parts) {
                    return parts.some(v => value.includes(v));
                }

                static exclude = function exclude(value, parts) {
                    return parts.every(v => !value.includes(v));
                }

                static contain = function contain(value, parts) {
                    return parts.some(substring => value.includes(substring));
                }
            }
        }

        return Validator;
    })();

    Neo.Component = (function Component() {
        function Component(options) {
            const selector = options.tag || "",
                controls = options.ctl || false,
                template = Neo.Sketch.test(options.tpl || "") ? options.tpl : Neo.Sketch.compile(options.tpl || ""),
                style = Neo.Sketch.test(options.css || "") ? options.css : Neo.Sketch.compile("<style>" + (options.css || "") + "</style>");

            return function(options) {
                const { attrs = [], dense = {}, props = {}, rules = {}, state = {}, cycle = {} } = options;

                return class extends HTMLElement {
                    static {
                        Object.entries(dense).forEach(([key, val]) => {
                            this[key] = val;
                        });

                        if (controls) this.formAssociated = true;
                        this.observedAttributes = attrs;
                        this.selector = selector;

                        this.define = function define(name) {
                            name = name || this.selector;

                            if (!customElements.get(name)) {
                                NEO_NODE_MAPS[name] = this;
                                customElements.define(name, this);
                            }

                            return this;
                        }
                    }

                    cache = {
                        drive: null,
                        props: {},
                        state: {},
                    };

                    cycle = {
                        created() {},
                        mounted() {},
                        adopted() {},
                        updated() {},
                        removed() {},
                        painted() {},
                    };

                    props = {};
                    state = {};
                    rules = {};
                    refs = {};

                    constructor() {
                        super();

                        this.root = this.attachShadow({ mode: "open" });

                        if (controls) {
                            this.ctl = this.attachInternals();

                            Object.defineProperties(this, {
                                form: {
                                    get: () => this.ctl.form,
                                },
                                name: {
                                    get: () => this.getAttribute("name"),
                                },
                                validity: {
                                    get: () => this.ctl.validity,
                                },
                                willValidate: {
                                    get: () => this.ctl.willValidate,
                                },
                                validationMessage: {
                                    get: () => this.ctl.validationMessage,
                                },
                            });

                            this.checkValidity = () => this.ctl.checkValidity();
                            this.reportValidity = () => this.ctl.reportValidity();
                        }

                        this.launch();
                        this.paint();

                        this.cycle.created();
                        this.emit("created");
                    }

                    attributeChangedCallback(name, prev, next) {
                        this.cycle.updated(name, prev, next, "attrs");
                    }

                    connectedCallback() {
                        Object.keys(props).forEach((property) => {
                            const attr = Neo.Helper.Str.kebab(property);
                            const prop = this.cache.props[property] !== props[property] ?
                                this.cache.props[property] : props[property];
                            if (attrs.includes(attr)) {
                                if (!prop) this.removeAttribute(attr);
                                else {
                                    this.getAttribute(attr) !== String(prop) && this.setAttribute(attr, prop);
                                }
                            }
                        });
                        this.cycle.mounted();
                        this.emit("mounted");
                    }

                    disconnectedCallback() {
                        this.cycle.removed();
                        this.emit("removed");
                    }

                    adoptedCallback() {
                        this.cycle.adopted();
                        this.emit("adopted");
                    }

                    launch() {
                        const update = (property, next) => {
                            const prev = this.cache.props[property];
                            if (prev === next) return;

                            this.cache.props[property] = next;
                            const attr = Neo.Helper.Str.kebab(property);
                            if (attrs.includes(attr)) {
                                if (!next) this.removeAttribute(attr);
                                else {
                                    this.getAttribute(attr) !== String(next) && this.setAttribute(attr, next);
                                }
                            }

                            this.paint();
                            this.cycle.updated(property, prev, next, "props");
                            this.emit("updated", {
                                name: property,
                                type: "props",
                                prev: prev,
                                next: next,
                            });
                        }

                        Object.keys(props).forEach((property) => {
                            this.cache.props[property] = props[property];

                            Object.defineProperty(this.props, property, {
                                set: (next) => {
                                    update(property, next);
                                },
                                get: () => {
                                    return this.cache.props[property];
                                },
                            });

                            Object.defineProperty(this, property, {
                                set: (next) => {
                                    update(property, next);
                                },
                                get: () => {
                                    return this.cache.props[property];
                                },
                            });
                        });

                        Object.keys(state).forEach((current) => {
                            this.cache.state[current] = state[current];

                            Object.defineProperty(this.state, current, {
                                set: (next) => {
                                    const prev = this.cache.state[current];
                                    if (prev === next) return;
                                    this.cache.state[current] = next;

                                    this.paint();
                                    this.cycle.updated(current, prev, next, "state");
                                    this.emit("updated", {
                                        name: current,
                                        type: "state",
                                        prev: prev,
                                        next: next,
                                    });
                                },
                                get: () => {
                                    return this.cache.state[current];
                                },
                            });
                        });

                        Object.keys(rules).forEach((callable) => {
                            if (typeof rules[callable] === "function")
                                this.rules[callable] = rules[callable].bind(this);
                        });

                        Object.keys(cycle).forEach((callable) => {
                            if (typeof cycle[callable] === "function")
                                this.cycle[callable] = cycle[callable].bind(this);
                        });
                    }

                    paint() {
                        const context = {
                            props: this.cache.props,
                            state: this.cache.state,
                            rules: this.rules,
                            refs: this.refs,
                            this: this,
                        };

                        const CSS = new Neo.Sketch(style, context, context),
                            TPL = new Neo.Sketch(template, context, context),
                            TREE = [...CSS.exec(), ...TPL.exec()];

                        if (!this.cache.drive)
                            this.cache.drive = new Neo.Driver(this.root, [], this.refs);

                        this.cache.drive.exec(TREE);
                        this.cycle.painted();
                        this.emit("painted");
                    }

                    emit(name, data, callable) {
                        const ev = new CustomEvent(name, {
                            bubbles: true,
                            cancelable: true,
                            composed: true,
                            isTrusted: true,
                            detail: data,
                        });
                        this.dispatchEvent(ev);
                        if (!ev.defaultPrevented && callable) {
                            callable.bind(this)(ev);
                        }
                    }

                    setProps(props = {}) {
                        var upgrade = false,
                            prev = {};

                        Object.entries(props).forEach(([key, val]) => {
                            if (this.cache.props[key] === val) return;
                            prev[key] = this.cache.props[key];
                            this.cache.props[key] = val;
                            const attr = Neo.Helper.Str.kebab(key);
                            if (attrs.includes(attr)) {
                                if (!val) this.removeAttribute(attr);
                                else {
                                    this.getAttribute(attr) !== String(val) && this.setAttribute(attr, val);
                                }
                            }
                            upgrade = true;
                        });

                        if (!upgrade) return;

                        this.paint();
                        Object.keys(prev).forEach(property => {
                            this.cycle.updated(property, prev[property], props[property], "props");
                        });
                    }

                    setState(state = {}) {
                        var upgrade = false,
                            prev = {};

                        Object.entries(state).forEach(([key, val]) => {
                            if (this.cache.state[key] === val) return;
                            prev[key] = this.cache.state[key];
                            this.cache.state[key] = val;
                            upgrade = true;
                        });

                        if (!upgrade) return;

                        this.paint();
                        Object.keys(prev).forEach(property => {
                            this.cycle.updated(property, prev[property], state[property], "state");
                        });
                    }
                }
            }
        }

        return Component;
    })();

    document.addEventListener("DOMContentLoaded", (e) => {
        NEO_LOAD_MAPS.forEach((callable) => callable(e));
    });

    return Neo;
})();