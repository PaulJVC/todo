/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js}",
  ],
  theme: {
    extend: {
      maxWidth: {
        '3/4': '75%',
      }
    },
  },
  plugins: [],
}

