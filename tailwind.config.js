// tailwind.config.js
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

const plugin = require('tailwindcss/plugin')

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            /* ---------- TYPOGRAPHY SYSTEM ---------- */
            fontFamily: {
                sans: ["Inter", "Figtree", ...defaultTheme.fontFamily.sans], // Inter first
            },
            fontSize: {
                /* Headings */
                "h-1": [
                    "64px",
                    {
                        lineHeight: "74px",
                        letterSpacing: "0px",
                        fontWeight: "700",
                    },
                ],
                "h-2": [
                    "48px",
                    {
                        lineHeight: "72px",
                        letterSpacing: "0px",
                        fontWeight: "700",
                    },
                ],
                "h-3": [
                    "40px",
                    {
                        lineHeight: "60px",
                        letterSpacing: "0px",
                        fontWeight: "700",
                    },
                ],
                "h-4": [
                    "34px",
                    {
                        lineHeight: "51px",
                        letterSpacing: "0px",
                        fontWeight: "700",
                    },
                ],
                "h-5": [
                    "28px",
                    {
                        lineHeight: "42px",
                        letterSpacing: "0px",
                        fontWeight: "700",
                    },
                ],
                "h-6": [
                    "24px",
                    {
                        lineHeight: "36px",
                        letterSpacing: "0px",
                        fontWeight: "700",
                    },
                ],
                "h-7": [
                    "20px",
                    {
                        lineHeight: "30px",
                        letterSpacing: "0px",
                        fontWeight: "500",
                    },
                ],

                /* Body */
                "b-1": [
                    "16px",
                    {
                        lineHeight: "24px",
                        letterSpacing: "0px",
                        fontWeight: "400",
                    },
                ],
                "b-2": [
                    "14px",
                    {
                        lineHeight: "21px",
                        letterSpacing: "0px",
                        fontWeight: "400",
                    },
                ],
                "b-3": [
                    "12px",
                    {
                        lineHeight: "18px",
                        letterSpacing: "0px",
                        fontWeight: "400",
                    },
                ],
                "b-4": [
                    "10px",
                    {
                        lineHeight: "15px",
                        letterSpacing: "0px",
                        fontWeight: "400",
                    },
                ],
                "b-5": [
                    "8px",
                    {
                        lineHeight: "12px",
                        letterSpacing: "0px",
                        fontWeight: "400",
                    },
                ],
            },

            /* -------------------------------------------------- */
            /* COLOR SYSTEM from your palette */
            /* -------------------------------------------------- */
            colors: {
                /* Primary scale (green) */
                primary: {
                    100: "#e6f5e6",
                    200: "#c2e6c2",
                    300: "#99d699",
                    400: "#66c266",
                    500: "#108a00", // brand
                    600: "#0d6e00",
                    700: "#0a5300",
                    800: "#083b00",
                    900: "#052700",
                    1000: "#031a00",
                },

                /* Secondary / accent (coral) */
                secondary: {
                    100: "#fce8e1",
                    200: "#f9d0c0",
                    300: "#f4b196",
                    400: "#ec8c6c",
                    500: "#ecac5c", // brand
                    600: "#d9944a",
                    700: "#b87938",
                    800: "#97602a",
                    900: "#7a4c20",
                    1000: "#5c3a18",
                },

                /* Neutral (grays) */
                neutral: {
                    0: "#ffffff",
                    10: "#f6f6f6",
                    100: "#e6e6e6",
                    200: "#d9d9d9",
                    300: "#b3b2b2",
                    400: "#9a9999",
                    500: "#656565",
                    600: "#4b4b4b",
                    700: "#353535",
                    800: "#181818",
                    900: "#0f0f0f",
                    1000: "#000000",
                },

                /* Feedback semantic colors */
                red: {
                    100: "#ffe9e9",
                    200: "#ffc7c7",
                    300: "#ff9f9f",
                    400: "#ff6b6b",
                    500: "#dc2626", // pick closest 500
                },
                yellow: {
                    100: "#fff9e6",
                    200: "#fff0b3",
                    300: "#ffe680",
                    400: "#ffdc4d",
                    500: "#ffc107", // match PDF
                },
                green: {
                    100: "#e6f9ed",
                    200: "#c2f2d6",
                    300: "#8ce5b0",
                    400: "#4dd18a",
                    500: "#108a00", // same as primary-500
                },
                blue: {
                    100: "#e6f2ff",
                    200: "#b3d9ff",
                    300: "#80c6ff",
                    400: "#4db3ff",
                    500: "#0d6ef0", // match PDF
                },
            },
            backgroundImage: {
                "radial-green-to-white":
                    "radial-gradient(ellipse at center, #fce8e1 0%, white 840px, white 100%)",
            },
        },
    },

    plugins: [
        plugin(function ({ addUtilities }) {
            addUtilities({
                ".shadow-inset": {
                    boxShadow: "inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)",
                },
                ".shadow-inset-lg": {
                    boxShadow: "inset 0 4px 8px 0 rgba(0, 0, 0, 0.08)",
                },
                ".shadow-inset-xl": {
                    boxShadow: "inset 0 8px 16px 0 rgba(0, 0, 0, 0.12)",
                },
            });
        }),
    ],
};
