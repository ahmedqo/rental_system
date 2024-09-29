const fs = require('fs');
const path = require('path');
const min = require("uglify-js");
const ENTER = process.argv[2];
const LEAVE = process.argv[3];
const TYPES = process.argv[4];
const FILES = (process.argv[5] || "").split(',').map(e => e.trim());
const MDATA = [];
var ATTRS = {}

const Sketch = {};
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
            throw Sketch.error(err, token, carry);
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
        source + "}catch(e){throw new $ERROR$([e.message,'\\n\\tat','Line:','\"'+$LINE$+'\"','Col:','\"'+$COL$+'\"'].join(' '))}}return [$TXT$,...$JSX$]}";
}

Sketch.error = function error(err, token, carry) {
    console.log(err, token, carry);
    err.message = err.message + '\n    at ' + token.value + ' (' + token.line + ':' + token.col + ')'
    if (!err.location) {
        err.location = {
            col: token.col,
            line: token.line,
        }
    }
}

function attrs(tagString) {
    const match = tagString.match(/<template\s+([^>]*)>/);
    if (!match) return {}; // No match found

    const attributeString = match[1];
    const attributeRegex = /(\S+)=["']?((?:.(?!["']?\s+(?:\S+)=|[>"']))+.)["']?/g;

    attributeString.replace(attributeRegex, function(match, name, value) {
        ATTRS[name] = value;
    });
}

function extract(code, type) {
    const regex = new RegExp(`<${type}[^>]*>([\\s\\S]*?)<\/${type}>`, 'gi');
    const matches = code.match(regex);
    return matches ? matches.map(match => {
        type === "template" && attrs(match);
        return match.replace(new RegExp(`<${type}[^>]*>|<\/${type}>`, 'gi'), '').trim()
    })[0] : "";
}

function shrink(content) {
    return content
        .replace(/("|'|`)/g, "\$1")
        .split(/\r\n|\n/)
        .map(e => e.trim() + "\n")
        .reduce((a, c) => a + c, "")
        .trim();
}

function create(enter, leave) {
    const stats = fs.statSync(enter);
    if (stats.isFile()) {
        if (path.extname(enter) !== ".neo") return;
        const content = fs.readFileSync(enter, 'utf8');
        const STYLES = Sketch.compile(shrink("<style>" + extract(content, 'style') + "</style>"));
        const TEMPLATE = Sketch.compile(shrink(extract(content, 'template')));
        const SCRIPT = (extract(content, 'script') || "export default {}").replace(/\s*export default\s*/g, "");
        const DATA = min.minify(`//? Component: ${ATTRS.name}\nNeo.Component({\n\tctl: ${"ctl" in ATTRS},\n\ttag: "${ATTRS.name}",\n\ttpl: ${JSON.stringify(TEMPLATE)},\n\tcss: ${JSON.stringify(STYLES)}\n})(${SCRIPT}).define();`, { mangle: true, compress: true, rename: true });

        if (DATA.error) console.log(DATA.error);
        if (TYPES === "--mix" || TYPES === "--use") MDATA.push(DATA.code);
        else fs.writeFileSync(leave.replace(/.neo/, ".js"), DATA.code, 'utf8');
        console.log("compiled: " + path.basename(leave.replace(/.neo/, ".js")));
    } else if (stats.isDirectory()) {
        leave = leave || enter;
        if (!fs.existsSync(leave) && TYPES !== "--mix" && TYPES !== "--use") {
            fs.mkdirSync(leave, { recursive: true });
        }

        const files = fs.readdirSync(enter);
        files.forEach(file => {
            if (TYPES === "--use" && !FILES.includes(path.basename(file).split(".")[0])) return
            const enterFilePath = path.join(enter, file);
            const leaveFilePath = path.join(leave, file);
            console.log("compiling: " + path.basename(file));
            create(enterFilePath, leaveFilePath);
        });

        if (TYPES === "--mix" || TYPES === "--use") {
            fs.writeFileSync(leave, MDATA.join(''), 'utf8');
        }
    }
}

create(ENTER, LEAVE);