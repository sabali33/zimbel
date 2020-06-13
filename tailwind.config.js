module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
      colors: {
        blue: {500 : '#01cfff'},
        gray: {
          100: '#f5f8f8',
          200: '#f4f4f4',
          400: '#f4f4f4',
          600: '#707070',
          500: '#707070',
          800: '#707070',
          900: '#545d5f'
        }
      }
    },
    transformOrigin:{
      '1/2': '50%'
    },
    screens: {
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1200px',
    },
    inset:{
      '0': 0,
      '1': '1rem',
      '2': '2rem',
      '1-p': '1px',
      '2-p': '2px',
      '3-p': '3px',
      '5-p': '5px',
      '1/2' : '50%',
      '3/5' : '60%'
    },
    
    fontFamily: {
      display: ['.AppleSystemUIFont', 'sans-serif'],
      body: ['Helvetica', 'sans-serif'],
    }
  },
  variants: {},
  plugins: [
    require('@tailwindcss/custom-forms')
  ]
}
