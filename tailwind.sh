#!/bin/bash
TAILWIND_CSS="/var/www/tailwindcss-linux-x64"
INPUT_CSS="/var/www/html/main.css"
OUTPUT_CSS="/var/www/public/style.css"
if [[ ! -f "$TAILWIND_CSS" ]]; then
    echo "Ошибка: Файл $TAILWIND_CSS не найден!"
    exit 1
fi
if [[ ! -f "$INPUT_CSS" ]]; then
    echo "Ошибка: Входной файл $INPUT_CSS не найден!"
    exit 1
fi
mkdir -p "$(dirname "$OUTPUT_CSS")"
$TAILWIND_CSS -i "$INPUT_CSS" -o "$OUTPUT_CSS" --minify
if [[ $? -eq 0 ]]; then
    echo "CSS успешно скомпилирован и сохранен в $OUTPUT_CSS"
else
    echo "Произошла ошибка при компиляции CSS."
    exit 1
fi