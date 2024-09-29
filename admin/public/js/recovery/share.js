const penaltyName = $query("neo-textbox[name=penalty-name]"),
    penaltyCost = $query("neo-textbox[name=penalty-cost]"),
    contentCondition = $query("#content-condition-table"),
    contentPenalty = $query("#content-penalties-table"),
    damage = $query("neo-select[name=damage]"),
    addCondition = $query("#add-condition"),
    condition = $query("[name=condition]"),
    penalties = $query("[name=penalties]"),
    addPenalty = $query("#add-penalty"),
    paths = $queryAll(".path");

var parts = [];

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

const penaltySegment = new Neo.Segment(contentPenalty, /*html*/ `{$ forelse row into data $}<tr class="border-t border-t-x-shade"><td class="w-4 ps-6 px-4 py-2 text-x-black font-x-thin text-base">#{{ @loop.round }}</td><td class="text-x-black text-base px-4 py-3">{{ @Str.capitalize(row.name) }}</td><td class="text-center text-x-black text-base px-4 py-3">{{ @Str.money(row.cost, 2) }} ${$core.currency}</td><td class="pe-6 w-20 text-center px-4 py-3 text-x-black text-base"><button type="button" class="mx-auto flex items-center justify-center py-1 px-2 outline-none rounded-sm text-x-white bg-red-400 hover:!bg-opacity-60 focus:!bg-opacity-60" @click="{{ (e) => remove(@loop.index) }}"><svg class="w-4 h-4 pointer-events-none block" fill="currentcolor" viewBox="0 -960 960 960"><path d="M253-99q-36.462 0-64.231-26.775Q161-152.55 161-190v-552h-11q-18.75 0-31.375-12.86Q106-767.719 106-787.36 106-807 118.613-820q12.612-13 31.387-13h182q0-20 13.125-33.5T378-880h204q19.625 0 33.312 13.75Q629-852.5 629-833h179.921q20.279 0 33.179 13.375 12.9 13.376 12.9 32.116 0 20.141-12.9 32.825Q829.2-742 809-742h-11v552q0 37.45-27.069 64.225Q743.863-99 706-99H253Zm104-205q0 14.1 11.051 25.05 11.051 10.95 25.3 10.95t25.949-10.95Q431-289.9 431-304v-324q0-14.525-11.843-26.262Q407.313-666 392.632-666q-14.257 0-24.944 11.738Q357-642.525 357-628v324Zm173 0q0 14.1 11.551 25.05 11.551 10.95 25.8 10.95t25.949-10.95Q605-289.9 605-304v-324q0-14.525-11.545-26.262Q581.91-666 566.93-666q-14.555 0-25.742 11.738Q530-642.525 530-628v324Z"></path></svg></button></td></tr>{$ empty $}<tr class="border-t border-t-x-shade"><td class="px-6 py-4 text-center text-x-black font-x-thin text-lg" colspan="5">{{ @trans("No penalty yet") }}</td></tr>{$ endforelse $}<tr class="border-t border-t-x-shade bg-x-light"><td class="px-6 py-3 text-center text-x-black font-x-thin" colspan="2">{{ @trans("Total") }}</td><td class="w-32 px-4 py-3 text-center text-x-black text-base">{{ @Str.money(sum(), 2) }} ${$core.currency}</td><td></td></tr>`, {
    data: JSON.parse(penalties.value),
    sum() {
        return this.data.reduce((c, i) => c + i.cost, 0);
    },
    remove(id) {
        this.data = this.data.filter((e, i) => i !== +id);
        penaltySegment.upgrade();
    }
});


penaltySegment.setEffect(function() {
    penalties.value = JSON.stringify(this.context.data);
});

addPenalty.addEventListener("click", e => {
    if (!penaltyName.value || !penaltyCost.value) return;


    penaltySegment.context.data.push({
        name: penaltyName.value,
        cost: +penaltyCost.value
    });

    penaltyCost.reset();
    penaltyName.reset();

    penaltySegment.upgrade();
});