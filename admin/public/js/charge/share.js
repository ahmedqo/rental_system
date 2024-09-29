searchable($query("neo-autocomplete[name=vehicle]"), $routes.search, function(data) {
    return data.map(row => {
        return {
            ...row,
            name: $capitalize($trans(row.brand)) + " " + $capitalize($trans(row.model)) + " " + row.year + " (" + row.registration_number + ")"
        }
    });
});