/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        "zenkaku": "Zen Kaku Gothic Antique",
        "inter": "Inter"
      }
    },
  },
  plugins: [],
}