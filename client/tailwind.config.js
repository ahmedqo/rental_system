/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./public/js/**/*.js",
    ],
    theme: {
        extend: {
            borderRadius: {
                "x-thin": "var(--r-thin)",
                "x-huge": "var(--r-huge)",
            },
            fontWeight: {
                "x-thin": "var(--w-thin)",
                "x-huge": "var(--w-huge)",
            },
            boxShadow: {
                "x-core": "var(--shadow)",
            },
            colors: {
                "x-prime": "rgb(var(--prime) / <alpha-value>)",
                "x-acent": "rgb(var(--acent) / <alpha-value>)",
                /** */
                "x-black": "rgb(var(--black) / <alpha-value>)",
                "x-white": "rgb(var(--white) / <alpha-value>)",
                "x-light": "rgb(var(--light) / <alpha-value>)",
                "x-shade": "rgb(var(--shade) / <alpha-value>)",
            },
        },
    },
    plugins: [],
};