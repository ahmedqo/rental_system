TableVisualizer($query("neo-datavisualizer"), (props) => [{
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
    bodyRender: (row) => row.address ? $capitalize(row.address) : empty(),
    bodyPdfRender: function(row) {
        return this.bodyRender(row);
    },
    bodyCsvRender: function(row) {
        return this.bodyRender(row);
    },
}, actionColumn(props)]);