/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/src/Views/**/**/**/*.view.php",
    "./html/src/Views/**/**/**/*.view.php",
  ],
  theme: {
    extend: {
      colors: {
        "bg-color": "#111124",
        "secondary-bg-color": "#1a3749",
        "accent-color": "#45b3a9",
        "secondary-accent-color": "#c0572a",
        "font-color": "#fafaf2",
        "secondary-font-color": "#111124",
      },
    },
  },
  plugins: [],
};
