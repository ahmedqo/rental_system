const vehicle = $query("neo-autocomplete[name=vehicle]"),
    client = $query("neo-autocomplete[name=client]"),
    secondaryClient = $query("neo-autocomplete[name=secondary_client]"),
    agency = $query("neo-autocomplete[name=agency]"),
    dailyRate = $query("neo-textbox[name=daily_rate]"),
    pickupDate = $query("neo-datepicker[name=pickup_date]"),
    dropoffDate = $query("neo-datepicker[name=dropoff_date]"),
    paymentAmount = $query("neo-textbox[name=payment_amount]"),
    paymentMethod = $query("neo-select[name=payment_method]"),
    contentCondition = $query("#content-condition-table"),
    contentPayment = $query("#content-payment-table"),
    damage = $query("neo-select[name=damage]"),
    addCondition = $query("#add-condition"),
    condition = $query("[name=condition]"),
    addPayment = $query("#add-payment"),
    payment = $query("[name=payment]"),
    mileage = $query("neo-textbox[name=mileage]"),
    fuellevel = $query("neo-textbox[name=fuel_level]"),
    paths = $queryAll(".path");

var parts = [];

const paymentSegment = new Neo.Segment(contentPayment, /*html*/ `{$ forelse row into data $}<tr class="border-t border-t-x-shade"><td class="w-4 ps-6 px-4 py-2 text-x-black font-x-thin text-base">#{{ @loop.round }}</td><td class="text-start text-x-black text-base px-4 py-3">{{ @Str.moment(row.date, "${$core.format} hh:MM A") }}</td><td class="text-center text-x-black text-base px-4 py-3">{{ @Str.capitalize(@trans(row.method)) }}</td><td class="text-center text-x-black text-base px-4 py-3">{{ @Str.money(row.amount, 2) }} ${$core.currency}</td><td class="pe-6 w-20 text-center px-4 py-3 text-x-black text-base"><button type="button" class="mx-auto flex items-center justify-center py-1 px-2 outline-none rounded-sm text-x-white bg-red-400 hover:!bg-opacity-60 focus:!bg-opacity-60" @click="{{ (e) => remove(@loop.index) }}"><svg class="w-4 h-4 pointer-events-none block" fill="currentcolor" viewBox="0 -960 960 960"><path d="M253-99q-36.462 0-64.231-26.775Q161-152.55 161-190v-552h-11q-18.75 0-31.375-12.86Q106-767.719 106-787.36 106-807 118.613-820q12.612-13 31.387-13h182q0-20 13.125-33.5T378-880h204q19.625 0 33.312 13.75Q629-852.5 629-833h179.921q20.279 0 33.179 13.375 12.9 13.376 12.9 32.116 0 20.141-12.9 32.825Q829.2-742 809-742h-11v552q0 37.45-27.069 64.225Q743.863-99 706-99H253Zm104-205q0 14.1 11.051 25.05 11.051 10.95 25.3 10.95t25.949-10.95Q431-289.9 431-304v-324q0-14.525-11.843-26.262Q407.313-666 392.632-666q-14.257 0-24.944 11.738Q357-642.525 357-628v324Zm173 0q0 14.1 11.551 25.05 11.551 10.95 25.8 10.95t25.949-10.95Q605-289.9 605-304v-324q0-14.525-11.545-26.262Q581.91-666 566.93-666q-14.555 0-25.742 11.738Q530-642.525 530-628v324Z"></path></svg></button></td></tr>{$ empty $}<tr class="border-t border-t-x-shade"><td class="px-6 py-4 text-center text-x-black font-x-thin text-lg" colspan="5">{{ @trans("No payment yet") }}</td></tr>{$ endforelse $}<tr class="bg-x-light border-t border-t-x-shade"><td class="px-6 py-3 text-center text-x-black font-x-thin" colspan="3">{{ @trans("Sub total") }}</td><td class="w-32 px-4 py-3 text-center text-x-black text-base">{{ @Str.money(sum(), 2) }} ${$core.currency}</td><td></td></tr><tr class="border-t border-t-x-shade bg-x-light"><td class="px-6 py-3 text-center text-x-black font-x-thin" colspan="3">{{ @trans("Total") }}</td><td class="w-32 px-4 py-3 text-center text-x-black text-base">{{ @Str.money(ttl(), 2) }} ${$core.currency}</td><td></td></tr><tr class="border-t border-t-x-shade bg-x-light"><td class="px-6 py-3 text-center text-x-black font-x-thin" colspan="3">{{ @trans("Creance") }}</td><td class="w-32 px-4 py-3 text-center text-x-black text-base">{{ @Str.money(ttl() - sum(), 2) }} ${$core.currency}</td><td></td></tr>`, {
    data: JSON.parse(payment.value),
    ttl() {
        if (!dailyRate.value || !pickupDate.value || !dropoffDate.value) return this.sum();
        return getPeriod(pickupDate.value, dropoffDate.value) * +dailyRate.value;
    },
    sum() {
        return this.data.reduce((c, i) => c + i.amount, 0);
    },
    remove(id) {
        this.data = this.data.filter((e, i) => i !== +id);
        paymentSegment.upgrade();
    }
});

paymentSegment.setEffect(function() {
    payment.value = JSON.stringify(this.context.data);
});

searchable(vehicle, $routes.vehicle, function(data) {
    return data.map(row => {
        return {
            ...row,
            name: $capitalize($trans(row.brand)) + " " + $capitalize($trans(row.model)) + " " + row.year + " (&#x202B;" + row.registration_number + "&#x202C;)"
        }
    });
}, {
    link: $routes.storeVehicle,
    text: $trans("Add new vehicle")
});

[client, secondaryClient].forEach(el => {
    searchable(el, $routes.client, function(data) {
        return data.map(row => {
            return {
                ...row,
                name: row.last_name.toUpperCase() + " " + $capitalize(row.first_name) + (row.restriction ? " (" + $capitalize($trans('banned')) + ")" : "")
            }
        });
    }, {
        link: $routes.storeClient,
        text: $trans("Add new client")
    });
});

searchable(agency, $routes.agency, function(data) {
    return data.map(row => {
        return {
            ...row,
            name: $capitalize(row.name)
        }
    });
}, {
    link: $routes.storeAgency,
    text: $trans("Add new agency")
});

function getPeriod(pickupDate, dropoffDate) {
    const pickup = new Date(pickupDate);
    const dropoff = new Date(dropoffDate);
    const differenceInTime = dropoff.getTime() - pickup.getTime();
    const differenceInDays = differenceInTime / (1000 * 3600 * 24);
    return differenceInDays;
}


vehicle.addEventListener("select", async e => {
    dailyRate.value = $money(+e.detail.data.daily_rate).replace(",", "");
    paymentSegment.upgrade();

    const data = await getData($routes.info.replace("XXX", e.detail.data.id));
    if (data.fuel_level) fuellevel.value = data.fuel_level;
    mileage.value = data.mileage || e.detail.data.mileage;
});

addPayment.addEventListener("click", e => {
    if (!paymentAmount.value || !paymentMethod.value) return;
    const ttl = paymentSegment.context.sum() + +paymentAmount.value;

    if (ttl > paymentSegment.context.ttl()) {
        return Neo.Toaster.toast($trans("Payment exceeds the total required amount"), "error");
    }

    paymentSegment.context.data.push({
        date: (new Date).toString(),
        amount: +paymentAmount.value,
        method: paymentMethod.value
    });

    paymentAmount.reset();
    paymentMethod.reset();

    paymentSegment.upgrade();
});

[dailyRate, pickupDate, dropoffDate].forEach(el => {
    el.addEventListener("change", e => {
        paymentSegment.upgrade();
    });
});


const conditionSegment = new Neo.Segment(contentCondition, /*html*/ `{$ each row into data $}<tr class="border-t border-t-x-shade"><td class="text-start text-x-black text-base px-4 py-3"><div class="flex items-center flex-wrap gap-2"><span class="block w-4 h-4 rounded-full" style="background: {{ row.color }}"></span>{{ @Str.capitalize(@trans(row.name)) }}</div></td>{$ if @loop.index > 0 $}<td class="pe-6 w-20 text-center px-4 py-3 text-x-black text-base"><button type="button" class="mx-auto flex items-center justify-center py-1 px-2 outline-none rounded-sm text-x-white bg-red-400 hover:!bg-opacity-60 focus:!bg-opacity-60" @click="{{ (e) => remove(@loop.index) }}"><svg class="w-4 h-4 pointer-events-none block" fill="currentcolor" viewBox="0 -960 960 960"><path d="M253-99q-36.462 0-64.231-26.775Q161-152.55 161-190v-552h-11q-18.75 0-31.375-12.86Q106-767.719 106-787.36 106-807 118.613-820q12.612-13 31.387-13h182q0-20 13.125-33.5T378-880h204q19.625 0 33.312 13.75Q629-852.5 629-833h179.921q20.279 0 33.179 13.375 12.9 13.376 12.9 32.116 0 20.141-12.9 32.825Q829.2-742 809-742h-11v552q0 37.45-27.069 64.225Q743.863-99 706-99H253Zm104-205q0 14.1 11.051 25.05 11.051 10.95 25.3 10.95t25.949-10.95Q431-289.9 431-304v-324q0-14.525-11.843-26.262Q407.313-666 392.632-666q-14.257 0-24.944 11.738Q357-642.525 357-628v324Zm173 0q0 14.1 11.551 25.05 11.551 10.95 25.8 10.95t25.949-10.95Q605-289.9 605-304v-324q0-14.525-11.545-26.262Q581.91-666 566.93-666q-14.555 0-25.742 11.738Q530-642.525 530-628v324Z"></path></svg></button></td>{$ endif $}</tr>{$ endeach $}`, {
    data: JSON.parse(condition.value),
    remove(id) {
        this.data = this.data.filter((e, i) => i !== +id);
        conditionSegment.upgrade();
    }
});

conditionSegment.setEffect(function() {
    condition.value = JSON.stringify(this.context.data);
    colorize(this.context.data);
});

paths.forEach(path => {
    path.addEventListener("click", e => {
        if (parts.includes(path.id)) {
            parts = parts.filter(e => e !== path.id);
            path.style.fill = "";
        } else {
            parts.push(path.id);
            path.style.fill = "#DC262670";
        }
    });
});

addCondition.addEventListener("click", e => {
    if (!damage.value || !parts.length) return;


    const found = conditionSegment.context.data.find(e => e.name === damage.value),
        current = found || {
            color: $Colors[damage.value],
            name: damage.value,
            parts: [],
        };

    current.parts.push(...parts);
    if (!found) conditionSegment.context.data.push(current);
    parts = [];

    damage.reset();

    conditionSegment.upgrade();
});

function colorize(data) {
    const all = data.reduce((a, e) => {
        a.push(...(e.parts || []));
        return a
    }, []);

    paths.forEach(path => {
        if (!all.includes(path.id)) path.style.fill = "";
    });

    data.forEach(({ parts, color }) => {
        parts && parts.forEach(part => {
            $query("#" + part).style.fill = color;
        });
    });
}

conditionSegment.upgrade();

Neo.Validator.Rules.custom_clash = function custom_clash(value, parts, { query }) {
    const matchField = query(`[name="${parts[0]}"]`);
    return matchField && (!String(matchField.value).trim() ? true : value !== String(matchField.value).trim());
}