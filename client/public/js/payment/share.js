const
    paymentAmount = $query("neo-textbox[name=payment_amount]"),
    paymentMethod = $query("neo-select[name=payment_method]"),
    contentPayment = $query("#content-payment-table"),
    addPayment = $query("#add-payment"),
    payment = $query("[name=payment]"),
    total = $query("[name=total]");


const paymentSegment = new Neo.Segment(contentPayment, /*html*/ `{$ forelse row into data $}<tr class="border-t border-t-x-shade"><td class="w-4 ps-6 px-4 py-2 text-x-black font-x-thin text-base">#{{ @loop.round }}</td><td class="text-start text-x-black text-base px-4 py-3">{{ @Str.moment(row.date, "${$core.format} hh:MM A") }}</td><td class="text-center text-x-black text-base px-4 py-3">{{ @Str.capitalize(@trans(row.method)) }}</td><td class="text-center text-x-black text-base px-4 py-3">{{ @Str.money(row.amount, 2) }} ${$core.currency}</td><td class="pe-6 w-20 text-center px-4 py-3 text-x-black text-base"><button type="button" class="mx-auto flex items-center justify-center py-1 px-2 outline-none rounded-sm text-x-white bg-red-400 hover:!bg-opacity-60 focus:!bg-opacity-60" @click="{{ (e) => remove(@loop.index) }}"><svg class="w-4 h-4 pointer-events-none block" fill="currentcolor" viewBox="0 -960 960 960"><path d="M253-99q-36.462 0-64.231-26.775Q161-152.55 161-190v-552h-11q-18.75 0-31.375-12.86Q106-767.719 106-787.36 106-807 118.613-820q12.612-13 31.387-13h182q0-20 13.125-33.5T378-880h204q19.625 0 33.312 13.75Q629-852.5 629-833h179.921q20.279 0 33.179 13.375 12.9 13.376 12.9 32.116 0 20.141-12.9 32.825Q829.2-742 809-742h-11v552q0 37.45-27.069 64.225Q743.863-99 706-99H253Zm104-205q0 14.1 11.051 25.05 11.051 10.95 25.3 10.95t25.949-10.95Q431-289.9 431-304v-324q0-14.525-11.843-26.262Q407.313-666 392.632-666q-14.257 0-24.944 11.738Q357-642.525 357-628v324Zm173 0q0 14.1 11.551 25.05 11.551 10.95 25.8 10.95t25.949-10.95Q605-289.9 605-304v-324q0-14.525-11.545-26.262Q581.91-666 566.93-666q-14.555 0-25.742 11.738Q530-642.525 530-628v324Z"></path></svg></button></td></tr>{$ empty $}<tr class="border-t border-t-x-shade"><td class="px-6 py-4 text-center text-x-black font-x-thin text-lg" colspan="5">{{ @trans("No payment yet") }}</td></tr>{$ endforelse $}<tr class="bg-x-light border-t border-t-x-shade"><td class="px-6 py-3 text-center text-x-black font-x-thin" colspan="3">{{ @trans("Sub total") }}</td><td class="w-32 px-4 py-3 text-center text-x-black text-base">{{ @Str.money(sum(), 2) }} ${$core.currency}</td><td></td></tr><tr class="border-t border-t-x-shade bg-x-light"><td class="px-6 py-3 text-center text-x-black font-x-thin" colspan="3">{{ @trans("Total") }}</td><td class="w-32 px-4 py-3 text-center text-x-black text-base">{{ @Str.money(ttl, 2) }} ${$core.currency}</td><td></td></tr><tr class="border-t border-t-x-shade bg-x-light"><td class="px-6 py-3 text-center text-x-black font-x-thin" colspan="3">{{ @trans("Creance") }}</td><td class="w-32 px-4 py-3 text-center text-x-black text-base">{{ @Str.money(ttl - sum(), 2) }} ${$core.currency}</td><td></td></tr>`, {
    data: JSON.parse(payment.value),
    ttl: +total.content,
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

addPayment.addEventListener("click", e => {
    if (!paymentAmount.value || !paymentMethod.value) return;
    const ttl = paymentSegment.context.sum() + +paymentAmount.value;

    if (ttl > paymentSegment.context.ttl) {
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

total.remove();