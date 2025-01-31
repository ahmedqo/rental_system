const brand = $query("neo-autocomplete[name=brand]"),
    model = $query("neo-autocomplete[name=model]"),
    fueltype = $query("neo-select[name=fuel_type]"),
    horsepower = $query("neo-select[name=horsepower]"),
    loan = $query("neo-textbox[name=loan_amount]"),
    labels = $queryAll(".required-label"),
    inputs = $queryAll(".required-input"),
    horsepower_tax = $query("neo-textbox[name=horsepower_tax]"),
    insurance = $query("neo-autocomplete[name=insurance_company]");

const Brands = {
        "seat": ["alhambra", "altea", "altea xl", "arosa", "cordoba", "cordoba vario", "exeo", "ibiza", "ibiza st", "exeo st", "leon", "leon st", "inca", "mii", "toledo"],
        "renault": ["captur", "clio", "clio grandtour", "espace", "express", "fluence", "grand espace", "grand modus", "grand scenic", "kadjar", "kangoo", "kangoo express", "koleos", "laguna", "laguna grandtour", "latitude", "mascott", "mégane", "mégane cc", "mégane combi", "mégane grandtour", "mégane coupé", "mégane scénic", "scénic", "talisman", "talisman grandtour", "thalia", "twingo", "wind", "zoé"],
        "peugeot": ["1007", "107", "106", "108", "2008", "205", "205 cabrio", "206", "206 cc", "206 sw", "207", "207 cc", "207 sw", "306", "307", "307 cc", "307 sw", "308", "308 cc", "308 sw", "309", "4007", "4008", "405", "406", "407", "407 sw", "5008", "508", "508 sw", "605", "806", "607", "807", "bipper", "rcz"],
        "dacia": ["dokker", "duster", "lodgy", "logan", "logan mcv", "logan van", "sandero", "solenza"],
        "citroën": ["berlingo", "c-crosser", "c-elissée", "c-zero", "c1", "c2", "c3", "c3 picasso", "c4", "c4 aircross", "c4 cactus", "c4 coupé", "c4 grand picasso", "c4 sedan", "c5", "c5 break", "c5 tourer", "c6", "c8", "ds3", "ds4", "ds5", "evasion", "jumper", "jumpy", "saxo", "nemo", "xantia", "xsara"],
        "opel": ["agila", "ampera", "antara", "astra", "astra cabrio", "astra caravan", "astra coupé", "calibra", "campo", "cascada", "corsa", "frontera", "insignia", "insignia kombi", "kadett", "meriva", "mokka", "movano", "omega", "signum", "vectra", "vectra caravan", "vivaro", "vivaro kombi", "zafira"],
        "alfa romeo": ["145", "146", "147", "155", "156", "156 sportwagon", "159", "159 sportwagon", "164", "166", "4c", "brera", "gtv", "mito", "crosswagon", "spider", "gt", "giulietta", "giulia"],
        "škoda": ["favorit", "felicia", "citigo", "fabia", "fabia combi", "fabia sedan", "felicia combi", "octavia", "octavia combi", "roomster", "yeti", "rapid", "rapid spaceback", "superb", "superb combi"],
        "chevrolet": ["alero", "aveo", "camaro", "captiva", "corvette", "cruze", "cruze sw", "epica", "equinox", "evanda", "hhr", "kalos", "lacetti", "lacetti sw", "lumina", "malibu", "matiz", "monte carlo", "nubira", "orlando", "spark", "suburban", "tacuma", "tahoe", "trax"],
        "porsche": ["911 carrera", "911 carrera cabrio", "911 targa", "911 turbo", "924", "944", "997", "boxster", "cayenne", "cayman", "macan", "panamera"],
        "honda": ["accord", "accord coupé", "accord tourer", "city", "civic", "civic aerodeck", "civic coupé", "civic tourer", "civic type r", "cr-v", "cr-x", "cr-z", "fr-v", "hr-v", "insight", "integra", "jazz", "legend", "prelude"],
        "subaru": ["brz", "forester", "impreza", "impreza wagon", "justy", "legacy", "legacy wagon", "legacy outback", "levorg", "outback", "svx", "tribeca", "tribeca b9", "xv"],
        "mazda": ["121", "2", "3", "323", "323 combi", "323 coupé", "323 f", "5", "6", "6 combi", "626", "626 combi", "b-fighter", "b2500", "bt", "cx-3", "cx-5", "cx-7", "cx-9", "demio", "mpv", "mx-3", "mx-5", "mx-6", "premacy", "rx-7", "rx-8", "xedox 6"],
        "mitsubishi": ["3000 gt", "asx", "carisma", "colt", "colt cc", "eclipse", "fuso canter", "galant", "galant combi", "grandis", "l200", "l200 pick up", "l200 pick up allrad", "l300", "lancer", "lancer combi", "lancer evo", "lancer sportback", "outlander", "pajero", "pajeto pinin", "pajero pinin wagon", "pajero sport", "pajero wagon", "space star"],
        "lexus": ["ct", "gs", "gs 300", "gx", "is", "is 200", "is 250 c", "is-f", "ls", "lx", "nx", "rc f", "rx", "rx 300", "rx 400h", "rx 450h", "sc 430"],
        "toyota": ["4-runner", "auris", "avensis", "avensis combi", "avensis van verso", "aygo", "camry", "carina", "celica", "corolla", "corolla combi", "corolla sedan", "corolla verso", "fj cruiser", "gt86", "hiace", "hiace van", "highlander", "hilux", "land cruiser", "mr2", "paseo", "picnic", "prius", "rav4", "sequoia", "starlet", "supra", "tundra", "urban cruiser", "verso", "yaris", "yaris verso"],
        "bmw": ["i3", "i8", "m3", "m4", "m5", "m6", "rad 1", "rad 1 cabrio", "rad 1 coupé", "rad 2", "rad 2 active tourer", "rad 2 coupé", "rad 2 gran tourer", "rad 3", "rad 3 cabrio", "rad 3 compact", "rad 3 coupé", "rad 3 gt", "rad 3 touring", "rad 4", "rad 4 cabrio", "rad 4 gran coupé", "rad 5", "rad 5 gt", "rad 5 touring", "rad 6", "rad 6 cabrio", "rad 6 coupé", "rad 6 gran coupé", "rad 7", "rad 8 coupé", "x1", "x3", "x4", "x5", "x6", "z3", "z3 coupé", "z3 roadster", "z4", "z4 roadster"],
        "volkswagen": ["amarok", "beetle", "bora", "bora variant", "caddy", "caddy van", "life", "california", "caravelle", "cc", "crafter", "crafter van", "crafter kombi", "crosstouran", "eos", "fox", "golf", "golf cabrio", "golf plus", "golf sportvan", "golf variant", "jetta", "lt", "lupo", "multivan", "new beetle", "new beetle cabrio", "passat", "passat alltrack", "passat cc", "passat variant", "passat variant van", "phaeton", "polo", "polo van", "polo variant", "scirocco", "sharan", "t4", "t4 caravelle", "t4 multivan", "t5", "t5 caravelle", "t5 multivan", "t5 transporter shuttle", "tiguan", "touareg", "touran"],
        "suzuki": ["alto", "baleno", "baleno kombi", "grand vitara", "grand vitara xl-7", "ignis", "jimny", "kizashi", "liana", "samurai", "splash", "swift", "sx4", "sx4 sedan", "vitara", "wagon r+"],
        "mercedes-benz": ["100 d", "115", "124", "126", "190", "190 d", "190 e", "200 - 300", "200 d", "200 e", "210 van", "210 kombi", "310 van", "310 kombi", "230 - 300 ce coupé", "260 - 560 se", "260 - 560 sel", "500 - 600 sec coupé", "trieda a", "a", "a l", "amg gt", "trieda b", "trieda c", "c", "c sportcoupé", "c t", "citan", "cl", "cl", "cla", "clc", "clk cabrio", "clk coupé", "cls", "trieda e", "e", "e cabrio", "e coupé", "e t", "trieda g", "g cabrio", "gl", "gla", "glc", "gle", "glk", "trieda m", "mb 100", "trieda r", "trieda s", "s", "s coupé", "sl", "slc", "slk", "slr", "sprinter"],
        "saab": ["9-3", "9-3 cabriolet", "9-3 coupé", "9-3 sportcombi", "9-5", "9-5 sportcombi", "900", "900 c", "900 c turbo", "9000"],
        "audi": ["100", "100 avant", "80", "80 avant", "80 cabrio", "90", "a1", "a2", "a3", "a3 cabriolet", "a3 limuzina", "a3 sportback", "a4", "a4 allroad", "a4 avant", "a4 cabriolet", "a5", "a5 cabriolet", "a5 sportback", "a6", "a6 allroad", "a6 avant", "a7", "a8", "a8 long", "q3", "q5", "q7", "r8", "rs4 cabriolet", "rs4/rs4 avant", "rs5", "rs6 avant", "rs7", "s3/s3 sportback", "s4 cabriolet", "s4/s4 avant", "s5/s5 cabriolet", "s6/rs6", "s7", "s8", "sq5", "tt coupé", "tt roadster", "tts"],
        "kia": ["avella", "besta", "carens", "carnival", "cee`d", "cee`d sw", "cerato", "k 2500", "magentis", "opirus", "optima", "picanto", "pregio", "pride", "pro cee`d", "rio", "rio combi", "rio sedan", "sephia", "shuma", "sorento", "soul", "sportage", "venga"],
        "land rover": ["109", "defender", "discovery", "discovery sport", "freelander", "range rover", "range rover evoque", "range rover sport"],
        "dodge": ["avenger", "caliber", "challenger", "charger", "grand caravan", "journey", "magnum", "nitro", "ram", "stealth", "viper"],
        "chrysler": ["300 c", "300 c touring", "300 m", "crossfire", "grand voyager", "lhs", "neon", "pacifica", "plymouth", "pt cruiser", "sebring", "sebring convertible", "stratus", "stratus cabrio", "town & country", "voyager"],
        "ford": ["aerostar", "b-max", "c-max", "cortina", "cougar", "edge", "escort", "escort cabrio", "escort kombi", "explorer", "f-150", "f-250", "fiesta", "focus", "focus c-max", "focus cc", "focus kombi", "fusion", "galaxy", "grand c-max", "ka", "kuga", "maverick", "mondeo", "mondeo combi", "mustang", "orion", "puma", "ranger", "s-max", "sierra", "street ka", "tourneo connect", "tourneo custom", "transit", "transit", "transit bus", "transit connect lwb", "transit courier", "transit custom", "transit kombi", "transit tourneo", "transit valnik", "transit van", "transit van 350", "windstar"],
        "hummer": ["h2", "h3"],
        "hyundai": ["accent", "atos", "atos prime", "coupé", "elantra", "galloper", "genesis", "getz", "grandeur", "h 350", "h1", "h1 bus", "h1 van", "h200", "i10", "i20", "i30", "i30 cw", "i40", "i40 cw", "ix20", "ix35", "ix55", "lantra", "matrix", "santa fe", "sonata", "terracan", "trajet", "tucson", "veloster"],
        "infiniti": ["ex", "fx", "g", "g coupé", "m", "q", "qx"],
        "jaguar": ["daimler", "f-pace", "f-type", "s-type", "sovereign", "x-type", "x-type estate", "xe", "xf", "xj", "xj12", "xj6", "xj8", "xj8", "xjr", "xk", "xk8 convertible", "xkr", "xkr convertible"],
        "jeep": ["cherokee", "commander", "compass", "grand cherokee", "patriot", "renegade", "wrangler"],
        "nissan": ["100 nx", "200 sx", "350 z", "350 z roadster", "370 z", "almera", "almera tino", "cabstar e - t", "cabstar tl2 valnik", "e-nv200", "gt-r", "insterstar", "juke", "king cab", "leaf", "maxima", "maxima qx", "micra", "murano", "navara", "note", "np300 pickup", "nv200", "nv400", "pathfinder", "patrol", "patrol gr", "pickup", "pixo", "primastar", "primastar combi", "primera", "primera combi", "pulsar", "qashqai", "serena", "sunny", "terrano", "tiida", "trade", "vanette cargo", "x-trail"],
        "volvo": ["240", "340", "360", "460", "850", "850 kombi", "c30", "c70", "c70 cabrio", "c70 coupé", "s40", "s60", "s70", "s80", "s90", "v40", "v50", "v60", "v70", "v90", "xc60", "xc70", "xc90"],
        "daewoo": ["espero", "kalos", "lacetti", "lanos", "leganza", "lublin", "matiz", "nexia", "nubira", "nubira kombi", "racer", "tacuma", "tico"],
        "fiat": ["1100", "126", "500", "500l", "500x", "850", "barchetta", "brava", "cinquecento", "coupé", "croma", "doblo", "doblo cargo", "doblo cargo combi", "ducato", "ducato van", "ducato kombi", "ducato podvozok", "florino", "florino combi", "freemont", "grande punto", "idea", "linea", "marea", "marea weekend", "multipla", "palio weekend", "panda", "panda van", "punto", "punto cabriolet", "punto evo", "punto van", "qubo", "scudo", "scudo van", "scudo kombi", "sedici", "seicento", "stilo", "stilo multiwagon", "strada", "talento", "tipo", "ulysse", "uno", "x1/9"],
        "mini": ["cooper", "cooper cabrio", "cooper clubman", "cooper d", "cooper d clubman", "cooper s", "cooper s cabrio", "cooper s clubman", "countryman", "mini one", "one d"],
        "rover": ["200", "214", "218", "25", "400", "414", "416", "620", "75"],
        "smart": ["cabrio", "city-coupé", "compact pulse", "forfour", "fortwo cabrio", "fortwo coupé", "roadster"]
    },
    Insurances = [
        "allianz morocco", "atlanta", "AXA insurance morocco", "MCMA", "RMA", "saham insurance", "sanad", "wafa insurance", "MAMDA", "CAT", "MATU", "moroccan life", "mutual attamine chaabi", "AXA assistance morocco", "chaabi assistance", "morocco international assistance", "saham assistance", "wafa IMA assistance", "RMA assistance", "euler hermes acmar", "coface", "SMAEX", "SCR", "MAMDA RE"
    ],
    Taxes = {
        gasoline: {
            "less than 8 cv": 300,
            "between 8 and 10 cv": 650,
            "between 11 and 14 cv": 3000,
            "grather than or equals to 15 cv": 8000
        },
        diesel: {
            "less than 8 cv": 700,
            "between 8 and 10 cv": 1500,
            "between 11 and 14 cv": 6000,
            "grather than or equals to 15 cv": 20000
        }
    };

function calculateTax() {
    if (!fueltype.value || !horsepower.value) return;
    const group = Taxes[fueltype.value];
    horsepower_tax.value = (group ? group[horsepower.value] : 0) || 0;
}

fueltype.addEventListener("change", calculateTax);
horsepower.addEventListener("change", calculateTax);

function search(query, list) {
    const value = new Set(query.toUpperCase().trim().split(/[-_.\\\/\s]/g));
    return list.reduce((found, item) => {
        const query_en = item.toUpperCase().trim(),
            query_tr = $trans(item).toUpperCase().trim(),
            score = [];
        for (const niddle of value) {
            if (query_en.includes(niddle) || query_tr.includes(niddle)) score.push(1);
            else score.push(0);
        }

        if (score.includes(1)) found.push(item);
        return found;
    }, []);
}

brand.addEventListener("input", e => {
    brand.loading = true;
    brand.data = search(e.target.query, Object.keys(Brands));
    brand.loading = false;
});

model.addEventListener("input", e => {
    const str = brand.query;
    if (str.trim() && Brands[str]) {
        model.loading = true;
        model.data = search(e.target.query, Brands[str]);
        model.loading = false;
    }
});

insurance.addEventListener("input", e => {
    insurance.loading = true;
    insurance.data = search(e.target.query, Insurances);
    insurance.loading = false;
});

[brand, model, insurance].map(auto => {
    auto.addEventListener("change:query", e => {
        auto.query = $trans(e.detail.data);
    });
    auto.item = (result) => {
        return $trans(result);
    }
});

loan.addEventListener("change", e => {
    const value = e.target.value.trim();
    if (!value) {
        labels.forEach(label => label.innerText = label.innerText.replace(" (*)", ""));
        inputs.forEach(input => {
            input.placeholder = input.placeholder.replace(" (*)", "");
            input.classList.remove("outline", "outline-2", "-outline-offset-2", "outline-red-400");
        });
        return;
    }

    labels.forEach(label => !label.innerText.includes(" (*)") && (label.innerText = label.innerText + " (*)"));
    inputs.forEach(input => !input.placeholder.includes(" (*)") && (input.placeholder = input.placeholder + " (*)"));
})