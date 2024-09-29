TableVisualizer($query("neo-datavisualizer"), ({
    csrf,
    patch,
    scene,
    clear
}) => [{
    name: "restriction",
    text: $trans("Restriction"),
    headStyle: {
        fontSize: "0px",
        paddingInlineEnd: "0px"
    },
    bodyStyle: {
        paddingInlineEnd: "0px"
    },
    headPdfStyle: function() {
        return this.headStyle;
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyRender: (row) => `<span style="width:1rem;height:1rem;display:block;background:${row.restriction ? "#ff674d" : "#71ea76"};border-radius:9999px;margin:auto;"></spam>`,
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: (row) => $capitalize(row.restriction ? $trans('true') : $trans('false')),
}, {
    name: "full_name",
    text: $trans("Full name"),
    bodyRender: (row) => row.last_name.toUpperCase() + " " + $capitalize(row.first_name),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    name: "email",
    text: $trans("Email"),
}, {
    name: "phone",
    text: $trans("Phone"),
}, {
    name: "identity",
    text: $trans("Identity"),
    bodyRender: (row) => $capitalize($trans(row.identity_type)) + ": " + row.identity_number.toUpperCase() + ", " + $trans("in") + " " + $capitalize(row.identity_issued_in) + " " + $trans("at") + " " + $moment(row.identity_issued_at, $core.format),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    name: "license",
    text: $trans("License"),
    bodyRender: (row) => row.license_number.toUpperCase() + ", " + $trans("in") + " " + $capitalize(row.license_issued_in) + " " + $trans("at") + " " + $moment(row.license_issued_at, $core.format),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    visible: false,
    name: "birth_date",
    text: $trans("Birth date"),
    headStyle: { textAlign: "center" },
    bodyStyle: { textAlign: "center" },
    headPdfStyle: function() {
        return this.headStyle
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyRender: (row) => row.birth_date ? $moment(row.birth_date, $core.format) : empty(),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    visible: false,
    name: "gender",
    text: $trans("Gender"),
    headStyle: { width: 20, textAlign: "center" },
    bodyStyle: { width: 20, textAlign: "center" },
    headPdfStyle: function() {
        return this.headStyle
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyRender: (row) => row.gender ? $capitalize($trans(row.gender)) : empty(),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    visible: false,
    name: "address",
    text: $trans("Address"),
    bodyRender: (row) => $capitalize(row.address) + ", " + $capitalize(row.city) + ", " + row.zipcode,
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, {
    name: "action",
    text: $trans("Actions"),
    headStyle: { width: 20, textAlign: "center" },
    bodyStyle: { width: 20, textAlign: "center" },
    bodyRender: (row) => `<action-tools target="${row.id}"csrf="${csrf}"patch="${patch}"scene="${scene}"clear="${clear}"></action-tools>`,
    headPdfStyle: function() {
        return this.headStyle
    },
    bodyPdfStyle: function() {
        return this.bodyStyle;
    },
    bodyPdfRender: () => empty(),
    bodyCsvRender: () => empty(),
}]);