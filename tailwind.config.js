
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
            },

            colors: {
                cblue: 'rgb(0 34 93)',
                cgr: '#f6f6f6',
                bod: "#888"
            },
            padding: {
                '13p': '13px',
                '9o': '9px'
            },

            fontFamily: {
                math: ['"Crimson Text"', 'serif'],
                st: ['math']
            }
        },
    },
    plugins: [],
};
