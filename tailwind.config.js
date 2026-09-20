/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');
export default {
  content: [
    "./*.php",
    "./inc/**/*.php",
    "./template-parts/**/*.php",
    "./woocommerce/**/*.php",
    "./assets/src/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Vazirmatn', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [],
}
