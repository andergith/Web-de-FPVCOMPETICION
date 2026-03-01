/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./index.html",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#dc2626',
                'dark-bg': '#0f172a',
                'dark-card': '#1e293b',
                'dark-border': '#334155',
                telegram: '#229ED9'
            },
            fontFamily: {
                teko: ['Teko', 'system-ui', 'sans-serif'],
                inter: ['Inter', 'system-ui', 'sans-serif'],
            }
        }
    },
    plugins: [],
}
