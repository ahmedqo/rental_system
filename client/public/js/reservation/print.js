// const condition = $query("[name=condition]"),
//     printer1 = $query("#printer-1"),
//     printer2 = $query("#printer-2"),
//     paths = $queryAll(".path"),
//     print = $query("#print");

// JSON.parse(condition.content).forEach(({ parts, color }) => {
//     parts && parts.forEach(part => {
//         $queryAll("#" + part).forEach(path => {
//             path.style.fill = color;
//         });
//     });
// });

// condition.remove();

// print.addEventListener("click", e => {
//     printer1.print();
// });

// Neo.load(() => {
//     setTimeout(() => {
//         printer1.print();
//     }, 1000);
// });

// printer1.addEventListener("close", e => {
//     printer2.print();
// });


const condition = document.querySelector("[name=condition]"),
    paths = document.querySelectorAll(".path");

JSON.parse(condition.content).forEach(({ parts, color }) => {
    parts && parts.forEach(part => {
        document.querySelector("#" + part).style.fill = color;
    });
});

condition.remove();

document.addEventListener("DOMContentLoaded", e => {
    window.print();
    setTimeout(() => {
        window.close();
    }, 5000);
});