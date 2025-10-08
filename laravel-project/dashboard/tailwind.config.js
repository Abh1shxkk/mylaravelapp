/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",     // Sabhi blade files
    "./resources/views/**/**/*.blade.php",  // Nested folders bhi
    "./resources/**/*.js",                   // JS files
    "./resources/**/*.vue",                  // Vue files (agar use ho)
    "./app/View/Components/**/*.php",        // Laravel components
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}