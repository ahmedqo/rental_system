TableVisualizer($query("neo-datavisualizer"), ({ scene, ...props }) => [{
        name: "vehicle",
        text: $trans("Vehicle"),
        bodyRender: (row) => $capitalize($trans(row.brand)) + " " + $capitalize($trans(row.model)) + " " + row.year,
        bodyPdfRender: function(row) {
            return this.bodyRender(row);
        },
        bodyCsvRender: function(row) {
            return this.bodyRender(row);
        },
    }, {
        name: "daily_rate",
        text: $trans("Daily rate"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyRender: (row) => $money(+row.daily_rate, 2) + " " + $core.currency,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    },
    {
        name: "mileage",
        text: $trans("Mileage"),
        headStyle: { textAlign: "center" },
        bodyStyle: { textAlign: "center" },
        headPdfStyle: function() {
            return this.headStyle
        },
        bodyPdfStyle: function() {
            return this.bodyStyle;
        },
        bodyRender: (row) => row.mileage + " " + $trans('Km'),
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: function(row) { return this.bodyRender(row); },
    }, {
        name: "registration",
        text: $trans("Regitration"),
        bodyRender: (row) => `<div>${$capitalize($trans("Regitration number"))}: &#x202B;${row.registration_number}&#x202C;</div><div>${$capitalize($trans("Regitration date"))}: ${$moment(row.registration_date, $core.format)}</div>`,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => `${$capitalize($trans("Regitration number"))}: ${row.registration_number}, ${$capitalize($trans("Regitration date"))}: ${$moment(row.registration_date, $core.format)}`
    }, {
        name: "types",
        text: $trans("Types"),
        bodyRender: (row) => `<div>${$capitalize($trans("Transmission"))}: ${$capitalize($trans(row.transmission_type))}</div><div>${$capitalize($trans("Fuel"))}: ${$capitalize($trans(row.fuel_type))}</div>`,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => `${$capitalize($trans("Transmission"))}: ${$capitalize($trans(row.transmission_type))}, ${$capitalize($trans("Fuel"))}: ${$capitalize($trans(row.fuel_type))}`
    }, {
        name: "horsepower",
        text: $trans("Horsepower"),
        bodyRender: (row) => `<div>${$capitalize($trans("Horsepower"))}: ${$capitalize($trans(row.horsepower))}</div><div>${$capitalize($trans("Horsepower tax"))}: ${$money(+row.horsepower_tax, 2)} ${$core.currency}</div>`,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => `${$capitalize($trans("Horsepower"))}: ${$capitalize($trans(row.horsepower))}, ${$capitalize($trans("Horsepower tax"))}: ${$money(+row.horsepower_tax, 2)} ${$core.currency}`
    }, {
        visible: false,
        name: "loan",
        text: $trans("Loan"),
        bodyRender: (row) => `<div>${$capitalize($trans("Loan amount"))}: ${+row.loan_amount ? $money(+row.loan_amount, 2) + " " + $core.currency : empty()}</div><div>${$capitalize($trans("Paid amount"))}: ${+row.paid_amount ? $money(+row.paid_amount, 2) + " " + $core.currency : empty()}</div><div>${$capitalize($trans("Due amount"))}: ${+row.due_amount ? $money(+row.due_amount, 2) + " " + $core.currency : empty()}</div>`,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => `${$capitalize($trans("Loan amount"))}: ${+row.loan_amount ? $money(+row.loan_amount, 2) + " " + $core.currency : empty()}, ${$capitalize($trans("Paid amount"))}: ${+row.paid_amount ? $money(+row.paid_amount, 2) + " " + $core.currency : empty()}, ${$capitalize($trans("Due amount"))}: ${+row.due_amount ? $money(+row.due_amount, 2) + " " + $core.currency : empty()}`
    }, {
        visible: false,
        name: "insurance",
        text: $trans("Insurance"),
        bodyRender: (row) => `<div>${$capitalize($trans("Insurance company"))}: ${$capitalize($trans(row.insurance_company))}</div><div>${$capitalize($trans("Insurance issued at"))}: ${$moment(row.insurance_issued_at, $core.format)}</div><div>${$capitalize($trans("Insurance cost"))}: ${$money(+row.insurance_cost, 2)} ${$core.currency}</div>`,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => `${$capitalize($trans("Insurance company"))}: ${$capitalize($trans(row.insurance_company))}, ${$capitalize($trans("Insurance issued at"))}: ${$moment(row.insurance_issued_at, $core.format)}, ${$capitalize($trans("Insurance cost"))}: ${$money(+row.insurance_cost, 2)} ${$core.currency}`
    }, {
        visible: false,
        name: "extra",
        text: $trans("Extra"),
        bodyRender: (row) => `<div>${$capitalize($trans("Passenger capacity"))}: ${row.passenger_capacity}</div><div>${$capitalize($trans("Cargo capacity"))}: ${row.cargo_capacity}</div><div>${$capitalize($trans("Number of doors"))}: ${row.number_of_doors}</div>`,
        bodyPdfRender: function(row) { return this.bodyRender(row); },
        bodyCsvRender: (row) => `${$capitalize($trans("Passenger capacity"))}: ${row.passenger_capacity}, ${$capitalize($trans("Cargo capacity"))}: ${row.cargo_capacity}, ${$capitalize($trans("Number of doors"))}: ${row.number_of_doors}`
    },
    actionColumn(props)
], {}, true);