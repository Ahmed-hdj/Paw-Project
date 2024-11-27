
module.exports = {
    content: [
        './*.{html,js}',
    ],
    theme: {
        extend: {
            height: {
                '90vh': '90vh',
                '28%': '28%',

            },
            spacing: {
                '6p': '6%',
                '4p': '4%',
                '7p': '7%',
                '9p': '9%',
                '0p': '6px'
            },
            margin: {
                '6p': '6%',
                '4p': '4%',
                '7p': '7%',
                '9p': '9%',
                '5p': '5%',
                '34p': '34%'
            },

            colors: {
                cblue: 'rgb(0 34 93)',
                cgr: '#f6f6f6',
                bod: "#888",
                sp: "#1a4185"
            },
            padding: {
                '13p': '13px',
                '9o': '9px'
            },

            fontFamily: {
                math: ['"Crimson Text"', 'serif'],
                st: ['math']
            },
            boxShadow: {
                'lightsh': "0px 0px 20px 0px #00000026"
            },
            content: {
                '': '',
            },
            inset: {
                '40p': '40%',
            },
            width: {
                "60p": "60%",
                "40k": "40%",
            },
            borderWidth: {
                '0.5': '0.5px', // Add fractional border width
            },
            screens: {
                'max-sm': { max: '639px' }, // Applies below 640px
                'max-md': { max: '940px' }, // Applies below 768px
                'max-lg': { max: '1000px' }, // Applies below 1024px
            },
        },
    },
    plugins: [require('tailwind-scrollbar')],
};
