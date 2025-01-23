#!/bin/bash
TAILWIND_CSS="/var/www/tailwindcss-linux-x64"
INPUT_CSS="/var/www/html/main.css"
OUTPUT_CSS="/var/www/public/style.css"
if [[ ! -f "$TAILWIND_CSS" ]]; then
    echo "error $TAILWIND_CSS not found"
    exit 1
fi
if [[ ! -f "$INPUT_CSS" ]]; then
    echo "error $INPUT_CSS not found"
    exit 1
fi
mkdir -p "$(dirname "$OUTPUT_CSS")"
$TAILWIND_CSS -i "$INPUT_CSS" -o "$OUTPUT_CSS" --minify
if [[ $? -eq 0 ]]; then
    echo "successfuly compiled css to $OUTPUT_CSS"
else
    echo "error compiling css to $OUTPUT_CSS"
    exit 1
fi
