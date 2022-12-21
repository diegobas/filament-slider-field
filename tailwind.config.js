const colors = require('tailwindcss/colors')

function toRgb (hex) {
    if (hex.length === 4) {
        hex = '#' + hex[1] + hex[1] + hex[2] + hex[2] + hex[3] + hex[3]
    }
    const red = parseInt(hex[1] + hex[2], 16)
    const green = parseInt(hex[3] + hex[4], 16)
    const blue = parseInt(hex[5] + hex[6], 16)
    return `${red} ${green} ${blue}`
}

const tailwindColorToRgb = (name) => {
    const parts = name.split('-')
    let current = colors
    parts.forEach(part => {
        current = current[part]
    })
    if (current) {
        return toRgb(current)
    }
}

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./resources/views/**/*.blade.php', './src/**/*.php'],
    darkMode: 'class',
    important: '#filament-ui-slider-field',
    corePlugins: {
        preflight: false,
    },
    tailwindColorToRgb,
}
