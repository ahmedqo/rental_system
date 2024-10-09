const condition = $query("[name=condition]"),
    printer = $query("neo-printer"),
    paths = $queryAll(".path"),
    print = $query("#print");

JSON.parse(condition.content).forEach(({ parts, color }) => {
    parts && parts.forEach(part => {
        $queryAll("#" + part).forEach(path => {
            path.style.fill = color;
        });
    });
});

condition.remove();

print.addEventListener("click", e => {
    printer.print();
});

Neo.load(() => {
    setTimeout(() => {
        printer.print();
    }, 1000);
});