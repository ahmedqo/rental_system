searchable($query("neo-autocomplete[name=vehicle]"), $routes.search, function(data) {
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