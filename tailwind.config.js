/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset],
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/filament/**/*.blade.php",
    './app/Filament/**/*.php',
    './resources/views/filament/**/*.blade.php',
    
  ],
  theme: {
    extend: {},
  },
  plugins: [
    
  ],
}

