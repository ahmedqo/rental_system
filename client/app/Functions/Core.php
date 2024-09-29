<?php

namespace App\Functions;

use App\Models\Reminder;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Core
{
    public static function getDates($period = null)
    {
        switch ($period ?? Core::setting('report_frequency')) {
            case "week":
                return [
                    Carbon::now()->startOfWeek(Carbon::MONDAY),
                    Carbon::now()->endOfWeek(Carbon::SUNDAY),
                    [
                        __('Monday') => 0,
                        __('Tuesday') => 0,
                        __('Wednesday') => 0,
                        __('Thursday') => 0,
                        __('Friday') => 0,
                        __('Saturday') => 0,
                        __('Sunday') => 0,
                    ]
                ];
            case "month":
                $month = Carbon::now()->format('m');
                $year = Carbon::now()->format('Y');
                $firstDay = mktime(0, 0, 0, $month, 1, $year);
                $daysInMonth = (int) date('t', $firstDay);
                $dayOfWeek = (int) date('w', $firstDay);
                $weekOffset = ($dayOfWeek === 0) ? 6 : $dayOfWeek - 1;
                $count = (int) ceil(($daysInMonth + $weekOffset) / 7);
                $weeks = [];
                for ($i = 1; $i <= $count; $i++) {
                    $weeks[__('Week') . ' ' . $i] = 0;
                }
                return [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                    $weeks
                ];
            case "year":
                return [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                    [
                        __('January') => 0,
                        __('February') => 0,
                        __('March') => 0,
                        __('April') => 0,
                        __('May') => 0,
                        __('June') => 0,
                        __('July') => 0,
                        __('August') => 0,
                        __('September') => 0,
                        __('October') => 0,
                        __('November') => 0,
                        __('December') => 0
                    ]
                ];
        }
    }

    public static function groupKey($model, $period = null)
    {
        switch ($period ?? Core::setting('report_frequency')) {
            case 'week':
                return __($model->created_at->format('l'));
            case 'month':
                return __('Week') . ' ' . Core::formatWeek($model->created_at->format('Y-m-d'));
            case 'year':
                return __($model->created_at->format('F'));
        }
    }

    public static function formatWeek($datestr)
    {
        $date = Carbon::parse($datestr);
        $date->startOfWeek(Carbon::MONDAY);
        $date->endOfWeek(Carbon::SUNDAY);
        $dayOfWeek = $date->format('N');
        $dayOfMonth = $date->format('j');
        $startDayOfWeek = Carbon::parse($date->format('Y-m-01'));
        $startDayOfWeek->startOfWeek(Carbon::MONDAY);
        $startDayOfWeek->endOfWeek(Carbon::SUNDAY);
        $startDayOfWeek = $startDayOfWeek->format('N');
        return (int) ceil(($dayOfMonth + $startDayOfWeek - $dayOfWeek) / 7);
    }

    public static function formatNumber($num)
    {
        $formattedNumber = number_format((float) $num, 2);
        if (strpos($formattedNumber, '.') === false) {
            $formattedNumber .= '.00';
        } else {
            list($integerPart, $decimalPart) = explode('.', $formattedNumber);
            switch (strlen($decimalPart)) {
                case 1:
                    $formattedNumber .= '0';
                    break;
            }
        }
        return $formattedNumber;
    }

    public static function matchRoute($str)
    {
        return Str::contains(request()->path(), $str);
    }

    public static function subString($str, $max = 157)
    {
        if (strlen($str) > $max) {
            $output = substr($str, 0, $max);
            return $output . '...';
        } else {
            return $str;
        }
    }

    public static function lang($lang = null)
    {
        return $lang ? app()->getLocale() == $lang : app()->getLocale();
    }

    public static function company($prop = null)
    {
        $Company = Auth::user()->Owner;
        if ($prop) return $Company->{$prop};
        return $Company;
    }

    public static function setting($prop = null)
    {
        $Setting = Auth::user()->Setting;
        if ($prop) return $Setting->{$prop};
        return $Setting;
    }

    public static function reminders($limit = null)
    {
        $today = Carbon::today();
        $reminders = Reminder::with('Vehicle')->where('company', Core::company('id'))
            ->whereRaw("? BETWEEN DATE_SUB(view_issued_at, INTERVAL threshold_value HOUR) AND view_issued_at", [$today]);

        if ($limit) $reminders = $reminders->limit($limit);

        return $reminders->get();
    }

    public static function recoveries($limit = null)
    {
        $today = Carbon::today();

        $recoveries = Reservation::with(['Recovery' => function ($query) {
            $query->select('id', 'reservation');
        }])
            ->where('company', Core::company('id'))
            ->where(function ($query) use ($today) {
                $query->whereBetween('dropoff_date', [
                    Carbon::parse($today)->subDay()->startOfDay(),
                    Carbon::parse($today)->endOfDay()
                ])
                    ->orWhere(function ($sub) use ($today) {
                        $sub->where('status', '!=', 'completed')
                            ->where('dropoff_date', '<', $today);
                    });
            });

        if ($limit) {
            $recoveries->limit($limit);
        }

        return $recoveries->get();
    }

    public static function genderList()
    {
        return ['male', 'female'];
    }

    public static function statsList()
    {
        return ['active', 'inactive'];
    }

    public static function registrationList()
    {
        return ['vehicle', 'WW'];
    }

    public static function transmissionsList()
    {
        return ['manual', 'automatic'];
    }

    public static function reservationsList()
    {
        return ['individual', 'agency'];
    }

    public static function identitiesList()
    {
        return ['pasport', 'visa', 'cin'];
    }

    public static function methodsList()
    {
        return ['credit card', 'cheque', 'cash'];
    }

    public static function alphaList()
    {
        return ['ا', 'ب', 'د', 'ه', 'و', 'ط'];
    }

    public static function languagesList()
    {
        return [
            'en' => 'english',
            'fr' => 'french',
            'ar' => 'arabic',
        ];
    }

    public static function currenciesList()
    {
        return [
            'MAD' => 'moroccan dirhams',
            '$' => 'dollars',
        ];
    }

    public static function formatsList($format = null, $index = null)
    {
        $formats = [
            'YYYY-MM-DD' => ['yyyy-mm-dd', 'Y-m-d'],
            'YYYY-DD-MM' => ['yyyy-dd-mm', 'Y-d-m'],
            'MM-DD-YYYY' => ['mm-dd-yyyy', 'm-d-Y'],
            'DD-MM-YYYY' => ['dd-mm-yyyy', 'd-m-Y'],
            'YYYY/MM/DD' => ['yyyy/mm/dd', 'Y/m/d'],
            'YYYY/DD/MM' => ['yyyy/dd/mm', 'Y/d/m'],
            'MM/DD/YYYY' => ['mm/dd/yyyy', 'm/d/Y'],
            'DD/MM/YYYY' => ['dd/mm/yyyy', 'd/m/Y'],
            'DD MMM YYYY' => ['dd mmm yyyy', 'd M Y'],
            'MMM DD YYYY' => ['mmm dd yyyy', 'M d Y'],
            'DD MMMMM YYYY' => ['dd mmmm yyyy', 'd F Y'],
            'MMMMM DD YYYY' => ['mmmm dd yyyy', 'F d Y'],
            'DDD DD MMM YYYY' => ['ddd dd mmm yyyy', 'D d M Y'],
            'DDD MMM DD YYYY' => ['ddd mmm dd yyyy', 'D M d Y'],
            'DDDD DD MMMM YYYY' => ['dddd dd mmmm yyyy', 'l d F Y'],
            'DDDD MMMM DD YYYY' => ['dddd mmmm dd yyyy', 'l F d Y'],
        ];

        return $format ? $formats[$format][$index] : $formats;
    }

    public static function themesList($color = null)
    {
        $colors = [
            'ocean tide' => ['32 138 243', '110 179 247'],
            'lavender storm' =>  ['138 32 243', '179 110 247'],
            'crimson rush' =>  ['243 32 67', '247 110 133'],
            'amber sunset' =>  ['243 103 32', '247 156 110'],
            'golden ray' =>  ['243 208 32', '247 224 110'],
            'forest haze' =>  ['32 243 173', '110 247 201'],
        ];

        return $color ? $colors[$color] : $colors;
    }

    public static function timesList($time)
    {
        return ['week' => 7, 'month' => 30, 'year' => 365][$time];
    }

    public static function periodsList()
    {
        return ['week', 'month', 'year'];
    }

    public static function unitsList()
    {
        return ['week', 'month', 'year', 'mileage'];
    }

    public static function damagesList()
    {
        return ['detachment', 'scratches', 'cracks', 'broken', 'dents', 'rust'];
    }

    public static function insurancesList()
    {
        return ['company 1', 'company 2'];
    }

    public static function fuelsList()
    {
        return ['gasoline', 'diesel', 'gasoline hybrid', 'diesel hybrid'];
    }

    public static function horsepowersList()
    {
        return ['less than 8 cv', 'between 8 and 10 cv', 'between 11 and 14 cv', 'grather than or equals to 15 cv'];
    }

    public static function statuesList()
    {
        return ['open', 'closed', 'in progress'];
    }

    public static function categoriesList()
    {
        return   [
            'technical support',
            'account issues',
            'general inquiry',
            'feature request',
            'bug report',
            'security concern',
            'feedback / suggestions',
            'login issues',
            'password reset',
            'subscription issues',
            'printer issues'
        ];
    }

    public static function citiesList()
    {
        return ["casablanca", "rabat", "fez", "marrakesh", "agadir", "tangier", "meknes", "oujda", "kenitra", "tetouan", "safi", "mohammedia", "khouribga", "el jadida", "nador", "beni mellal", "khemisset", "larache", "ksar el kebir", "settat", "sidi kacem", "temara", "berrechid", "oued zem", "fquih ben salah", "taroudant", "ouarzazate", "dakhla", "guelmim", "laayoune"];
    }

    public static function nationsList()
    {
        return
            ["afghan", "albanian", "algerian", "american", "andorran", "angolan", "anguillan", "citizen of antigua and barbuda", "argentine", "armenian", "australian", "austrian", "azerbaijani", "bahamian", "bahraini", "bangladeshi", "barbadian", "belarusian", "belgian", "belizean", "beninese", "bermudian", "bhutanese", "bolivian", "citizen of bosnia and herzegovina", "botswanan", "brazilian", "british", "british virgin islander", "bruneian", "bulgarian", "burkinan", "burmese", "burundian", "cambodian", "cameroonian", "canadian", "cape verdean", "cayman islander", "central african", "chadian", "chilean", "chinese", "colombian", "comoran", "congolese (congo)", "congolese (drc)", "cook islander", "costa rican", "croatian", "cuban", "cymraes", "cymro", "cypriot", "czech", "danish", "djiboutian", "dominican", "citizen of the dominican republic", "dutch", "east timorese", "ecuadorean", "egyptian", "emirati", "english", "equatorial guinean", "eritrean", "estonian", "ethiopian", "faroese", "fijian", "filipino", "finnish", "french", "gabonese", "gambian", "georgian", "german", "ghanaian", "gibraltarian", "greek", "greenlandic", "grenadian", "guamanian", "guatemalan", "citizen of guinea-bissau", "guinean", "guyanese", "haitian", "honduran", "hong konger", "hungarian", "icelandic", "indian", "indonesian", "iranian", "iraqi", "irish", "israeli", "italian", "ivorian", "jamaican", "japanese", "jordanian", "kazakh", "kenyan", "kittitian", "citizen of kiribati", "kosovan", "kuwaiti", "kyrgyz", "lao", "latvian", "lebanese", "liberian", "libyan", "liechtenstein citizen", "lithuanian", "luxembourger", "macanese", "macedonian", "malagasy", "malawian", "malaysian", "maldivian", "malian", "maltese", "marshallese", "martiniquais", "mauritanian", "mauritian", "mexican", "micronesian", "moldovan", "monegasque", "mongolian", "montenegrin", "montserratian", "moroccan", "mosotho", "mozambican", "namibian", "nauruan", "nepalese", "new zealander", "nicaraguan", "nigerian", "nigerien", "niuean", "north korean", "northern irish", "norwegian", "omani", "pakistani", "palauan", "palestinian", "panamanian", "papua new guinean", "paraguayan", "peruvian", "pitcairn islander", "polish", "portuguese", "prydeinig", "puerto rican", "qatari", "romanian", "russian", "rwandan", "salvadorean", "sammarinese", "samoan", "sao tomean", "saudi arabian", "scottish", "senegalese", "serbian", "citizen of seychelles", "sierra leonean", "singaporean", "slovak", "slovenian", "solomon islander", "somali", "south african", "south korean", "south sudanese", "spanish", "sri lankan", "st helenian", "st lucian", "stateless", "sudanese", "surinamese", "swazi", "swedish", "swiss", "syrian", "taiwanese", "tajik", "tanzanian", "thai", "togolese", "tongan", "trinidadian", "tristanian", "tunisian", "turkish", "turkmen", "turks and caicos islander", "tuvaluan", "ugandan", "ukrainian", "uruguayan", "uzbek", "vatican citizen", "citizen of vanuatu", "venezuelan", "vietnamese", "vincentian", "wallisian", "welsh", "yemeni", "zambian", "zimbabwean"];;
    }

    public static function consumablesList()
    {
        return [
            'fluids' => [
                'engine oil',
                'transmission fluid',
                'brake fluid',
                'coolant',
                'power steering fluid',
                'differential fluid'
            ],
            'filters' => [
                'engine filter',
                'air filter',
                'cabin air filter',
                'fuel filter'
            ],
            'belts and hoses' => [
                'timing belt',
                'serpentine belt',
                'hoses',
            ],
            'tires and brakes' => [
                'tires',
                'brake pads and rotors',
                'wheel alignment'
            ],
            'battery and electrical' => [
                'battery',
                'spark plugs',
                'ignition coils'
            ],
            'additional items' => [
                'wiper blades',
                'lights',
                'exhaust system',
                'suspension components'
            ],
            'other' => [
                'insurance',
                'taxes'
            ]
        ];
    }

    public static function brandModelList()
    {
        return [
            "seat" => ["alhambra", "altea", "altea xl", "arosa", "cordoba", "cordoba vario", "exeo", "ibiza", "ibiza st", "exeo st", "leon", "leon st", "inca", "mii", "toledo"],
            "renault" => ["captur", "clio", "clio grandtour", "espace", "express", "fluence", "grand espace", "grand modus", "grand scenic", "kadjar", "kangoo", "kangoo express", "koleos", "laguna", "laguna grandtour", "latitude", "mascott", "mégane", "mégane cc", "mégane combi", "mégane grandtour", "mégane coupé", "mégane scénic", "scénic", "talisman", "talisman grandtour", "thalia", "twingo", "wind", "zoé"],
            "peugeot" => ["1007", "107", "106", "108", "2008", "205", "205 cabrio", "206", "206 cc", "206 sw", "207", "207 cc", "207 sw", "306", "307", "307 cc", "307 sw", "308", "308 cc", "308 sw", "309", "4007", "4008", "405", "406", "407", "407 sw", "5008", "508", "508 sw", "605", "806", "607", "807", "bipper", "rcz"],
            "dacia" => ["dokker", "duster", "lodgy", "logan", "logan mcv", "logan van", "sandero", "solenza"],
            "citroën" => ["berlingo", "c-crosser", "c-elissée", "c-zero", "c1", "c2", "c3", "c3 picasso", "c4", "c4 aircross", "c4 cactus", "c4 coupé", "c4 grand picasso", "c4 sedan", "c5", "c5 break", "c5 tourer", "c6", "c8", "ds3", "ds4", "ds5", "evasion", "jumper", "jumpy", "saxo", "nemo", "xantia", "xsara"],
            "opel" => ["agila", "ampera", "antara", "astra", "astra cabrio", "astra caravan", "astra coupé", "calibra", "campo", "cascada", "corsa", "frontera", "insignia", "insignia kombi", "kadett", "meriva", "mokka", "movano", "omega", "signum", "vectra", "vectra caravan", "vivaro", "vivaro kombi", "zafira"],
            "alfa romeo" => ["145", "146", "147", "155", "156", "156 sportwagon", "159", "159 sportwagon", "164", "166", "4c", "brera", "gtv", "mito", "crosswagon", "spider", "gt", "giulietta", "giulia"],
            "škoda" => ["favorit", "felicia", "citigo", "fabia", "fabia combi", "fabia sedan", "felicia combi", "octavia", "octavia combi", "roomster", "yeti", "rapid", "rapid spaceback", "superb", "superb combi"],
            "chevrolet" => ["alero", "aveo", "camaro", "captiva", "corvette", "cruze", "cruze sw", "epica", "equinox", "evanda", "hhr", "kalos", "lacetti", "lacetti sw", "lumina", "malibu", "matiz", "monte carlo", "nubira", "orlando", "spark", "suburban", "tacuma", "tahoe", "trax"],
            "porsche" => ["911 carrera", "911 carrera cabrio", "911 targa", "911 turbo", "924", "944", "997", "boxster", "cayenne", "cayman", "macan", "panamera"],
            "honda" => ["accord", "accord coupé", "accord tourer", "city", "civic", "civic aerodeck", "civic coupé", "civic tourer", "civic type r", "cr-v", "cr-x", "cr-z", "fr-v", "hr-v", "insight", "integra", "jazz", "legend", "prelude"],
            "subaru" => ["brz", "forester", "impreza", "impreza wagon", "justy", "legacy", "legacy wagon", "legacy outback", "levorg", "outback", "svx", "tribeca", "tribeca b9", "xv"],
            "mazda" => ["121", "2", "3", "323", "323 combi", "323 coupé", "323 f", "5", "6", "6 combi", "626", "626 combi", "b-fighter", "b2500", "bt", "cx-3", "cx-5", "cx-7", "cx-9", "demio", "mpv", "mx-3", "mx-5", "mx-6", "premacy", "rx-7", "rx-8", "xedox 6"],
            "mitsubishi" => ["3000 gt", "asx", "carisma", "colt", "colt cc", "eclipse", "fuso canter", "galant", "galant combi", "grandis", "l200", "l200 pick up", "l200 pick up allrad", "l300", "lancer", "lancer combi", "lancer evo", "lancer sportback", "outlander", "pajero", "pajeto pinin", "pajero pinin wagon", "pajero sport", "pajero wagon", "space star"],
            "lexus" => ["ct", "gs", "gs 300", "gx", "is", "is 200", "is 250 c", "is-f", "ls", "lx", "nx", "rc f", "rx", "rx 300", "rx 400h", "rx 450h", "sc 430"],
            "toyota" => ["4-runner", "auris", "avensis", "avensis combi", "avensis van verso", "aygo", "camry", "carina", "celica", "corolla", "corolla combi", "corolla sedan", "corolla verso", "fj cruiser", "gt86", "hiace", "hiace van", "highlander", "hilux", "land cruiser", "mr2", "paseo", "picnic", "prius", "rav4", "sequoia", "starlet", "supra", "tundra", "urban cruiser", "verso", "yaris", "yaris verso"],
            "bmw" => ["i3", "i8", "m3", "m4", "m5", "m6", "rad 1", "rad 1 cabrio", "rad 1 coupé", "rad 2", "rad 2 active tourer", "rad 2 coupé", "rad 2 gran tourer", "rad 3", "rad 3 cabrio", "rad 3 compact", "rad 3 coupé", "rad 3 gt", "rad 3 touring", "rad 4", "rad 4 cabrio", "rad 4 gran coupé", "rad 5", "rad 5 gt", "rad 5 touring", "rad 6", "rad 6 cabrio", "rad 6 coupé", "rad 6 gran coupé", "rad 7", "rad 8 coupé", "x1", "x3", "x4", "x5", "x6", "z3", "z3 coupé", "z3 roadster", "z4", "z4 roadster"],
            "volkswagen" => ["amarok", "beetle", "bora", "bora variant", "caddy", "caddy van", "life", "california", "caravelle", "cc", "crafter", "crafter van", "crafter kombi", "crosstouran", "eos", "fox", "golf", "golf cabrio", "golf plus", "golf sportvan", "golf variant", "jetta", "lt", "lupo", "multivan", "new beetle", "new beetle cabrio", "passat", "passat alltrack", "passat cc", "passat variant", "passat variant van", "phaeton", "polo", "polo van", "polo variant", "scirocco", "sharan", "t4", "t4 caravelle", "t4 multivan", "t5", "t5 caravelle", "t5 multivan", "t5 transporter shuttle", "tiguan", "touareg", "touran"],
            "suzuki" => ["alto", "baleno", "baleno kombi", "grand vitara", "grand vitara xl-7", "ignis", "jimny", "kizashi", "liana", "samurai", "splash", "swift", "sx4", "sx4 sedan", "vitara", "wagon r+"],
            "mercedes-benz" => ["100 d", "115", "124", "126", "190", "190 d", "190 e", "200 - 300", "200 d", "200 e", "210 van", "210 kombi", "310 van", "310 kombi", "230 - 300 ce coupé", "260 - 560 se", "260 - 560 sel", "500 - 600 sec coupé", "trieda a", "a", "a l", "amg gt", "trieda b", "trieda c", "c", "c sportcoupé", "c t", "citan", "cl", "cl", "cla", "clc", "clk cabrio", "clk coupé", "cls", "trieda e", "e", "e cabrio", "e coupé", "e t", "trieda g", "g cabrio", "gl", "gla", "glc", "gle", "glk", "trieda m", "mb 100", "trieda r", "trieda s", "s", "s coupé", "sl", "slc", "slk", "slr", "sprinter"],
            "saab" => ["9-3", "9-3 cabriolet", "9-3 coupé", "9-3 sportcombi", "9-5", "9-5 sportcombi", "900", "900 c", "900 c turbo", "9000"],
            "audi" => ["100", "100 avant", "80", "80 avant", "80 cabrio", "90", "a1", "a2", "a3", "a3 cabriolet", "a3 limuzina", "a3 sportback", "a4", "a4 allroad", "a4 avant", "a4 cabriolet", "a5", "a5 cabriolet", "a5 sportback", "a6", "a6 allroad", "a6 avant", "a7", "a8", "a8 long", "q3", "q5", "q7", "r8", "rs4 cabriolet", "rs4/rs4 avant", "rs5", "rs6 avant", "rs7", "s3/s3 sportback", "s4 cabriolet", "s4/s4 avant", "s5/s5 cabriolet", "s6/rs6", "s7", "s8", "sq5", "tt coupé", "tt roadster", "tts"],
            "kia" => ["avella", "besta", "carens", "carnival", "cee`d", "cee`d sw", "cerato", "k 2500", "magentis", "opirus", "optima", "picanto", "pregio", "pride", "pro cee`d", "rio", "rio combi", "rio sedan", "sephia", "shuma", "sorento", "soul", "sportage", "venga"],
            "land rover" => ["109", "defender", "discovery", "discovery sport", "freelander", "range rover", "range rover evoque", "range rover sport"],
            "dodge" => ["avenger", "caliber", "challenger", "charger", "grand caravan", "journey", "magnum", "nitro", "ram", "stealth", "viper"],
            "chrysler" => ["300 c", "300 c touring", "300 m", "crossfire", "grand voyager", "lhs", "neon", "pacifica", "plymouth", "pt cruiser", "sebring", "sebring convertible", "stratus", "stratus cabrio", "town & country", "voyager"],
            "ford" => ["aerostar", "b-max", "c-max", "cortina", "cougar", "edge", "escort", "escort cabrio", "escort kombi", "explorer", "f-150", "f-250", "fiesta", "focus", "focus c-max", "focus cc", "focus kombi", "fusion", "galaxy", "grand c-max", "ka", "kuga", "maverick", "mondeo", "mondeo combi", "mustang", "orion", "puma", "ranger", "s-max", "sierra", "street ka", "tourneo connect", "tourneo custom", "transit", "transit", "transit bus", "transit connect lwb", "transit courier", "transit custom", "transit kombi", "transit tourneo", "transit valnik", "transit van", "transit van 350", "windstar"],
            "hummer" => ["h2", "h3"],
            "hyundai" => ["accent", "atos", "atos prime", "coupé", "elantra", "galloper", "genesis", "getz", "grandeur", "h 350", "h1", "h1 bus", "h1 van", "h200", "i10", "i20", "i30", "i30 cw", "i40", "i40 cw", "ix20", "ix35", "ix55", "lantra", "matrix", "santa fe", "sonata", "terracan", "trajet", "tucson", "veloster"],
            "infiniti" => ["ex", "fx", "g", "g coupé", "m", "q", "qx"],
            "jaguar" => ["daimler", "f-pace", "f-type", "s-type", "sovereign", "x-type", "x-type estate", "xe", "xf", "xj", "xj12", "xj6", "xj8", "xj8", "xjr", "xk", "xk8 convertible", "xkr", "xkr convertible"],
            "jeep" => ["cherokee", "commander", "compass", "grand cherokee", "patriot", "renegade", "wrangler"],
            "nissan" => ["100 nx", "200 sx", "350 z", "350 z roadster", "370 z", "almera", "almera tino", "cabstar e - t", "cabstar tl2 valnik", "e-nv200", "gt-r", "insterstar", "juke", "king cab", "leaf", "maxima", "maxima qx", "micra", "murano", "navara", "note", "np300 pickup", "nv200", "nv400", "pathfinder", "patrol", "patrol gr", "pickup", "pixo", "primastar", "primastar combi", "primera", "primera combi", "pulsar", "qashqai", "serena", "sunny", "terrano", "tiida", "trade", "vanette cargo", "x-trail"],
            "volvo" => ["240", "340", "360", "460", "850", "850 kombi", "c30", "c70", "c70 cabrio", "c70 coupé", "s40", "s60", "s70", "s80", "s90", "v40", "v50", "v60", "v70", "v90", "xc60", "xc70", "xc90"],
            "daewoo" => ["espero", "kalos", "lacetti", "lanos", "leganza", "lublin", "matiz", "nexia", "nubira", "nubira kombi", "racer", "tacuma", "tico"],
            "fiat" => ["1100", "126", "500", "500l", "500x", "850", "barchetta", "brava", "cinquecento", "coupé", "croma", "doblo", "doblo cargo", "doblo cargo combi", "ducato", "ducato van", "ducato kombi", "ducato podvozok", "florino", "florino combi", "freemont", "grande punto", "idea", "linea", "marea", "marea weekend", "multipla", "palio weekend", "panda", "panda van", "punto", "punto cabriolet", "punto evo", "punto van", "qubo", "scudo", "scudo van", "scudo kombi", "sedici", "seicento", "stilo", "stilo multiwagon", "strada", "talento", "tipo", "ulysse", "uno", "x1/9"],
            "mini" => ["cooper", "cooper cabrio", "cooper clubman", "cooper d", "cooper d clubman", "cooper s", "cooper s cabrio", "cooper s clubman", "countryman", "mini one", "one d"],
            "rover" => ["200", "214", "218", "25", "400", "414", "416", "620", "75"],
            "smart" => ["cabrio", "city-coupé", "compact pulse", "forfour", "fortwo cabrio", "fortwo coupé", "roadster"]
        ];
    }

    public static function pathList()
    {
        return ["M2358 4750 c-73 -13 -153 -54 -211 -109 -68 -64 -97 -123 -99 -198 -5 -157 87 -274 255 -325 100 -30 248 -23 331 15 89 41 140 88 175 160 55 114 51 196 -15 294 -82 120 -274 192 -436 163z", "M6173 4750 c-99 -20 -212 -96 -258 -173 -71 -122 -45 -284 61 -377 53 -46 144 -86 225 -100 176 -30 387 68 446 208 25 58 22 197 -4 247 -26 50 -106 126 -163 155 -82 42 -211 59 -307 40z", "M1415 4491 c-66 -3 -125 -9 -131 -13 -6 -4 -22 -36 -34 -70 -27 -73 -41 -88 -87 -88 -39 0 -53 -21 -53 -79 0 -84 18 -102 134 -132 104 -27 108 -33 91 -149 -25 -155 -13 -140 -110 -140 -70 0 -85 -3 -85 -15 0 -49 113 -96 321 -135 250 -47 376 -89 739 -245 236 -102 318 -131 473 -170 78 -19 165 -41 192 -49 28 -7 88 -16 134 -19 l83 -5 -73 65 c-102 91 -311 305 -375 383 -71 88 -104 153 -104 204 0 61 61 123 155 159 130 50 217 137 315 313 68 124 83 164 65 183 -11 11 -17 11 -41 0 -21 -11 -35 -33 -62 -100 -65 -165 -192 -296 -330 -340 -145 -46 -334 -34 -442 28 -113 65 -235 228 -275 366 l-16 57 -182 -2 c-100 -1 -236 -4 -302 -7z m1092 -852 c17 -8 133 -102 258 -209 l225 -195 -50 -3 c-53 -3 -268 45 -410 92 -147 48 -579 245 -652 298 l-33 23 30 7 c55 13 596 2 632 -13z", "M1962 3612 c-8 -6 9 -17 50 -35 35 -14 135 -59 223 -100 181 -84 280 -121 446 -166 140 -37 209 -51 209 -41 0 9 -111 109 -276 248 l-121 102 -259 0 c-142 0 -265 -4 -272 -8z", "M3107 4448 c-41 -102 -117 -244 -161 -301 -54 -73 -118 -121 -247 -188 -55 -29 -105 -59 -111 -67 -20 -23 -11 -90 20 -155 37 -78 122 -174 304 -345 167 -156 227 -199 299 -212 28 -6 204 -13 390 -17 300 -5 339 -4 339 9 0 8 10 132 21 274 29 353 31 741 5 915 l-19 126 -300 6 c-165 4 -349 7 -409 7 l-109 0 -22 -52z m-187 -547 c15 -4 26 -15 28 -27 5 -37 -24 -49 -119 -49 -73 0 -91 3 -109 20 l-22 20 27 22 c22 20 37 23 98 22 40 -1 83 -4 97 -8z m1004 -348 c-11 -193 -23 -343 -29 -353 -4 -6 -129 -10 -340 -10 l-334 0 -47 25 c-26 14 -72 44 -101 67 -66 50 -216 207 -279 292 l-46 61 83 6 c46 3 312 6 591 7 l507 2 -5 -97z", "M2778 3883 c-48 -4 -62 -16 -32 -27 25 -10 172 -7 179 3 3 5 2 12 -2 14 -14 8 -97 14 -145 10z", "M2831 3611 c-22 -14 24 -76 164 -216 163 -164 161 -163 417 -175 286 -13 421 -13 441 3 13 9 19 40 27 152 5 77 10 164 10 193 l0 52 -522 0 c-297 0 -529 -4 -537 -9z", "M3980 4488 c0 -7 7 -44 14 -83 51 -247 54 -373 16 -775 -10 -113 -22 -254 -25 -315 -3 -60 -8 -121 -11 -134 l-5 -24 233 6 c128 4 281 13 341 21 133 19 185 40 638 263 l336 165 30 71 c55 128 58 147 57 357 -1 143 -5 215 -18 269 -18 80 -59 165 -85 177 -9 5 -355 10 -768 12 -624 3 -753 1 -753 -10z m375 -594 c42 -43 -20 -77 -124 -69 -75 7 -101 18 -101 45 0 25 44 38 137 39 54 1 76 -3 88 -15z m938 -251 c153 -6 157 -7 140 -25 -24 -26 -166 -105 -376 -209 -281 -138 -418 -192 -522 -203 -106 -11 -509 -26 -517 -18 -5 5 23 362 35 432 1 10 19 17 57 21 78 8 995 10 1183 2z", "M4192 3882 c-18 -4 -34 -11 -35 -17 -3 -14 173 -19 186 -6 6 6 9 12 6 15 -9 8 -125 14 -157 8z", "M4113 3613 c-12 -2 -24 -14 -27 -29 -6 -24 -36 -319 -36 -358 0 -18 7 -19 190 -12 240 9 354 26 477 72 185 68 643 301 643 326 0 8 -1206 9 -1247 1z", "M5588 4493 c-22 -6 -22 -7 1 -73 41 -117 56 -218 56 -385 0 -143 -3 -171 -29 -269 -15 -60 -30 -116 -34 -124 -4 -13 2 -14 39 -9 24 4 73 11 109 16 91 14 229 27 574 56 489 41 569 54 721 121 l40 17 -55 11 c-66 13 -66 17 -19 142 l31 81 161 6 c132 4 163 8 173 21 14 19 28 148 19 176 -4 12 -24 24 -59 34 -51 15 -54 18 -92 88 -53 99 -60 102 -243 93 l-148 -7 -17 -62 c-26 -92 -84 -194 -147 -257 -106 -106 -277 -167 -430 -155 -254 20 -424 160 -495 406 l-22 75 -58 2 c-33 0 -67 -1 -76 -4z m425 -610 c13 -8 8 -31 -9 -37 -52 -20 -114 5 -100 40 5 13 15 15 54 9 26 -4 50 -9 55 -12z", "M5935 3870 c-4 -6 5 -10 20 -10 15 0 24 4 20 10 -3 6 -12 10 -20 10 -8 0 -17 -4 -20 -10z", "M467 3363 c-29 -8 -51 -22 -58 -36 -18 -33 -18 -299 0 -320 11 -14 35 -17 157 -17 l144 0 11 28 c16 40 6 269 -12 286 -17 15 -114 55 -161 65 -21 5 -51 3 -81 -6z", "M227 3363 c-4 -3 -7 -451 -7 -995 l0 -988 44 0 c27 0 52 7 65 18 l22 17 -3 961 c-3 797 -5 964 -17 977 -13 17 -90 24 -104 10z", "M7868 3355 l-28 -16 5 -762 c7 -990 11 -1157 29 -1175 8 -8 34 -16 58 -19 l45 -5 6 987 c4 544 5 990 3 993 -13 13 -94 11 -118 -3z", "M82 3297 c-60 -19 -65 -38 -71 -246 -3 -102 -4 -496 -1 -875 l5 -690 45 -22 c25 -12 62 -25 84 -28 l38 -5 -5 907 c-3 514 -9 920 -14 937 -10 34 -30 39 -81 22z m38 -67 c23 -23 26 -70 9 -119 -11 -30 -14 -32 -53 -29 l-41 3 -3 62 c-2 52 1 66 18 83 25 25 45 25 70 0z m4 -1552 c23 -33 21 -113 -4 -138 -44 -44 -90 -8 -90 70 0 78 58 120 94 68z", "M55 3188 c-8 -53 8 -101 33 -96 14 3 17 14 17 68 0 59 -2 65 -22 68 -19 3 -22 -3 -28 -40z", "M64 1666 c-3 -7 -4 -38 -2 -67 3 -46 6 -54 23 -54 17 0 21 8 23 44 2 25 1 55 -3 68 -6 25 -32 31 -41 9z", "M7576 3297 c-12 -9 -17 -20 -13 -31 6 -14 21 -16 119 -14 l113 3 0 25 c0 25 -1 25 -100 28 -73 2 -105 -1 -119 -11z", "M8022 2374 l3 -939 35 3 c19 2 55 13 80 25 l45 22 3 886 2 886 -51 23 c-29 12 -67 24 -85 27 l-34 6 2 -939z m117 850 c30 -38 29 -117 -1 -138 -30 -21 -44 -20 -68 4 -32 32 -24 127 14 152 20 13 34 9 55 -18z m0 -1550 c23 -29 28 -92 11 -125 -8 -14 -21 -19 -49 -19 -44 0 -51 12 -51 88 0 29 6 48 20 62 27 27 44 25 69 -6z", "M8082 3158 c3 -55 5 -63 23 -63 17 0 21 9 26 50 7 63 3 75 -28 75 -23 0 -24 -2 -21 -62z", "M8082 1608 c2 -52 6 -63 22 -66 24 -5 36 14 36 60 0 52 -9 68 -37 68 -23 0 -24 -2 -21 -62z", "M5810 3231 c-248 -7 -236 1 -170 -111 34 -58 57 -105 131 -268 18 -40 19 -69 19 -475 l0 -432 -96 -192 c-54 -106 -94 -196 -90 -200 4 -5 352 -8 774 -8 l766 0 22 146 c13 80 35 195 50 255 28 108 28 112 29 434 0 289 -2 331 -18 383 -11 31 -34 145 -51 253 -18 107 -38 200 -43 205 -12 12 -992 19 -1323 10z", "M1136 3212 c-3 -5 -18 -78 -33 -163 l-28 -154 0 -525 0 -525 27 -125 c14 -69 31 -137 37 -152 l11 -28 239 0 c131 0 252 3 269 6 l30 6 -43 84 c-95 185 -89 142 -93 720 l-3 511 32 99 c17 54 46 131 64 171 33 71 33 71 11 77 -33 9 -514 7 -520 -2z", "M1685 3176 c-35 -60 -70 -151 -94 -248 -20 -77 -21 -109 -21 -557 0 -277 5 -495 10 -521 14 -63 76 -207 109 -255 27 -39 28 -40 85 -38 67 2 344 45 746 114 327 56 311 48 351 170 24 74 24 74 24 534 l0 460 -30 100 -30 100 -50 12 c-79 20 -1000 173 -1039 173 -31 0 -38 -5 -61 -44z m445 -61 c150 -8 286 -30 467 -75 209 -51 210 -51 223 -97 21 -71 34 -534 22 -806 -12 -279 -24 -345 -66 -365 -34 -15 -329 -80 -446 -98 -52 -8 -174 -17 -271 -21 l-176 -6 -6 24 c-9 31 -9 1387 -1 1428 l7 32 71 -5 c39 -3 118 -8 176 -11z", "M1950 3090 l-35 -5 -6 -120 c-4 -66 -7 -385 -8 -709 l-1 -588 113 6 c225 14 551 65 704 111 52 15 53 17 70 73 16 51 18 106 18 527 0 362 -3 482 -14 523 -13 51 -14 52 -65 67 -260 75 -653 133 -776 115z", "M5405 3194 c-382 -92 -485 -119 -530 -134 -58 -20 -54 13 -36 -277 13 -225 14 -688 1 -823 -5 -52 -12 -127 -16 -166 l-7 -72 54 -15 c49 -14 556 -135 637 -152 30 -6 33 -4 48 32 55 130 78 447 71 978 -4 334 -5 356 -31 474 -29 136 -48 181 -74 180 -9 0 -62 -11 -117 -25z", "M7560 3105 l0 -115 120 0 120 0 0 115 0 115 -120 0 -120 0 0 -115z", "M5635 3062 c22 -105 26 -197 31 -702 6 -544 5 -556 -15 -614 -12 -33 -19 -61 -16 -64 2 -3 33 53 67 124 l63 129 6 220 c8 255 -4 652 -21 709 -13 44 -94 205 -111 221 -8 7 -9 0 -4 -23z", "M2960 3021 c-30 -3 -55 -10 -55 -16 0 -5 7 -55 15 -110 23 -152 20 -948 -3 -1060 -12 -55 -14 -82 -6 -90 7 -7 310 -11 933 -13 l923 -3 13 48 c27 108 33 968 8 1166 l-11 87 -881 -2 c-485 -1 -906 -4 -936 -7z m1492 -239 c20 -13 47 -40 60 -60 23 -36 23 -42 23 -322 0 -210 -3 -295 -13 -322 -17 -47 -70 -94 -124 -109 -51 -14 -319 -7 -359 9 -45 18 -88 73 -100 127 -7 32 -9 148 -7 320 3 265 3 271 27 303 13 18 40 44 60 57 35 24 40 25 216 22 168 -2 182 -4 217 -25z", "M4024 2771 c-67 -49 -69 -58 -69 -396 l0 -300 33 -36 c44 -49 99 -63 242 -63 137 0 199 15 246 60 l35 32 -3 315 c-3 301 -4 317 -24 344 -39 54 -79 65 -257 69 l-162 5 -41 -30z", "M7560 2901 c0 -56 4 -74 23 -97 22 -28 22 -29 22 -429 0 -396 0 -400 -22 -440 -15 -25 -23 -56 -23 -87 l0 -48 115 0 c112 0 116 1 124 23 5 13 7 269 4 585 l-6 562 -119 0 -118 0 0 -69z", "M390 2608 c0 -194 3 -451 7 -570 l6 -218 157 0 157 0 6 368 c4 202 7 458 7 570 l0 202 -170 0 -170 0 0 -352z", "M463 1781 c-28 -4 -55 -10 -60 -15 -4 -4 -9 -83 -11 -174 l-3 -167 53 -23 c29 -12 65 -22 80 -22 15 0 64 19 110 43 l83 42 9 118 c11 141 3 188 -34 198 -31 9 -157 8 -227 0z", "M7566 1749 c-3 -17 -6 -71 -6 -120 l0 -89 125 0 125 0 0 104 c0 136 0 136 -134 136 l-103 0 -7 -31z", "M3300 1600 c-123 -10 -158 -23 -232 -84 -104 -87 -377 -355 -423 -418 -30 -40 -48 -78 -60 -128 -21 -87 -23 -85 110 -155 116 -62 161 -93 217 -149 48 -49 128 -186 184 -313 18 -43 38 -78 44 -77 5 1 189 2 408 3 l399 1 19 123 c26 169 25 527 -4 896 -12 151 -22 283 -22 293 0 17 -16 18 -277 17 -153 -1 -316 -5 -363 -9z m594 -37 c10 -33 25 -198 28 -318 l3 -120 -579 3 c-319 1 -581 4 -584 6 -24 25 299 371 385 412 54 25 144 31 455 33 265 1 287 0 292 -16z m-1018 -633 c46 0 63 -4 68 -15 9 -23 -4 -45 -27 -45 -20 0 -20 1 -2 13 34 26 8 37 -85 37 -54 0 -91 -4 -96 -11 -11 -19 18 -29 86 -30 l65 -1 -42 -10 c-23 -6 -62 -7 -88 -4 -43 7 -46 9 -43 34 2 21 10 28 33 33 17 4 39 5 50 3 11 -2 48 -4 81 -4z", "M3300 1541 c-132 -9 -168 -28 -310 -171 -117 -117 -179 -195 -166 -208 4 -4 246 -8 538 -10 l531 -3 -7 133 c-11 230 -15 255 -40 262 -26 7 -418 5 -546 -3z", "M3991 1602 c-17 -12 -11 -123 26 -522 28 -310 27 -431 -7 -620 -11 -63 -23 -132 -26 -153 l-7 -37 767 0 766 0 24 48 c39 77 56 150 66 282 13 169 0 356 -30 435 -40 106 -78 134 -427 308 -432 215 -457 225 -623 243 -175 18 -511 29 -529 16z m474 -32 c61 -5 142 -19 180 -30 182 -56 680 -302 771 -380 l31 -27 -276 -6 c-489 -12 -1111 -9 -1116 6 -2 6 -12 104 -22 216 -19 206 -18 222 17 234 18 7 265 -1 415 -13z m-125 -639 c18 -5 25 -14 25 -31 0 -30 -24 -38 -117 -39 -85 -1 -121 11 -116 41 2 14 13 25 28 29 32 9 148 9 180 0z", "M4062 1551 c-11 -7 -10 -40 3 -187 9 -98 18 -187 21 -196 5 -17 42 -18 602 -17 328 0 615 4 637 8 l40 7 -35 23 c-57 36 -487 246 -585 284 -107 42 -199 62 -355 76 -137 13 -310 14 -328 2z", "M4157 914 c-4 -4 -7 -14 -7 -21 0 -11 19 -13 93 -11 74 2 92 6 92 18 0 12 -17 16 -85 18 -47 1 -89 0 -93 -4z", "M2875 1564 c-22 -9 -93 -26 -157 -40 -155 -32 -268 -73 -576 -205 -329 -141 -391 -162 -627 -209 -226 -46 -315 -73 -351 -107 -40 -37 -27 -48 63 -51 59 -2 83 -7 87 -17 10 -26 29 -222 23 -237 -3 -9 -35 -23 -74 -32 -98 -25 -141 -52 -153 -96 -19 -71 -3 -93 99 -140 8 -3 23 -32 34 -63 29 -87 27 -87 362 -94 l284 -6 10 24 c5 13 16 44 25 69 45 129 175 284 281 338 140 70 342 68 489 -4 115 -56 218 -178 273 -323 31 -84 38 -91 80 -91 31 0 34 2 28 23 -22 72 -113 236 -182 327 -44 58 -138 123 -215 149 -86 29 -148 94 -148 154 0 95 96 221 368 484 l167 162 -75 0 c-41 0 -93 -7 -115 -15z m109 -23 c3 -5 -17 -28 -45 -52 -28 -23 -114 -98 -192 -166 -203 -177 -232 -196 -320 -205 -91 -9 -430 -10 -519 -2 -40 4 -65 11 -61 17 9 15 414 212 527 255 124 49 268 93 406 126 156 37 195 42 204 27z m-986 -588 c12 -10 24 -30 28 -45 9 -41 -41 -88 -93 -88 -36 0 -78 20 -95 44 -15 22 -7 54 18 80 21 21 36 26 74 26 31 0 55 -6 68 -17z", "M2855 1505 c-5 -2 -80 -22 -165 -45 -85 -23 -195 -57 -245 -76 -113 -44 -475 -214 -475 -224 0 -4 111 -10 248 -13 l247 -6 52 35 c28 20 76 56 105 82 30 26 96 83 147 127 115 100 144 140 86 120z", "M1871 933 c-57 -71 48 -141 112 -75 34 35 34 55 1 81 -38 30 -87 28 -113 -6z", "M7577 1504 c-14 -15 -6 -34 21 -48 34 -17 141 -30 182 -21 28 6 31 10 28 38 l-3 32 -111 3 c-60 1 -113 -1 -117 -4z", "M5580 1131 c0 -4 9 -34 20 -67 67 -194 65 -470 -5 -692 -15 -46 -25 -86 -23 -88 2 -2 36 -6 75 -10 l70 -7 26 84 c81 257 273 400 537 400 159 0 309 -59 399 -156 51 -57 109 -165 137 -257 l18 -57 168 -3 168 -3 32 58 c18 31 41 70 50 86 12 22 27 31 56 36 72 12 77 20 64 115 -6 51 -16 89 -26 99 -14 13 -45 17 -171 19 l-154 4 -31 86 c-44 122 -44 125 7 132 24 4 45 9 49 12 9 10 -41 33 -132 61 -120 38 -261 55 -794 97 -217 17 -397 36 -512 55 -16 2 -28 1 -28 -4z m436 -213 c8 -27 -18 -48 -61 -48 -52 0 -76 42 -32 60 12 5 36 9 54 9 24 1 33 -4 39 -21z", "M5940 900 c0 -5 7 -10 15 -10 8 0 15 5 15 10 0 6 -7 10 -15 10 -8 0 -15 -4 -15 -10z", "M2324 661 c-92 -23 -221 -121 -255 -196 -26 -55 -25 -185 0 -240 23 -51 112 -135 182 -171 50 -26 64 -29 187 -32 133 -4 134 -4 197 27 81 40 158 112 187 176 26 58 30 155 8 220 -28 85 -147 180 -265 211 -53 15 -189 17 -241 5z", "M6135 657 c-107 -36 -190 -101 -229 -179 -21 -42 -26 -66 -26 -127 0 -111 13 -146 78 -211 71 -70 144 -107 242 -120 196 -27 371 53 438 199 35 75 36 184 3 253 -30 62 -97 122 -178 160 -58 27 -77 31 -176 34 -76 3 -125 0 -152 -9z"];
    }
}
