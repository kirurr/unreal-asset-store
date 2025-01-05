#!/bin/bash

# Путь к исполнимому файлу Tailwind CSS
TAILWIND_CSS="/var/www/tailwindcss-linux-x64"

# Путь к входному CSS файлу
INPUT_CSS="/var/www/html/main.css"

# Путь к выходному CSS файлу
OUTPUT_CSS="/var/www/public/style.css"

# Проверка, существует ли файл tailwindcss
if [[ ! -f "$TAILWIND_CSS" ]]; then
    echo "Ошибка: Файл $TAILWIND_CSS не найден!"
    exit 1
fi

# Проверка, существует ли входной файл
if [[ ! -f "$INPUT_CSS" ]]; then
    echo "Ошибка: Входной файл $INPUT_CSS не найден!"
    exit 1
fi

# Создание директории для выходного файла, если она не существует
mkdir -p "$(dirname "$OUTPUT_CSS")"

# Выполнение команды для генерации и минимизации CSS
$TAILWIND_CSS -i "$INPUT_CSS" -o "$OUTPUT_CSS" --minify

# Проверка на успешное выполнение команды
if [[ $? -eq 0 ]]; then
    echo "CSS успешно скомпилирован и сохранен в $OUTPUT_CSS"
else
    echo "Произошла ошибка при компиляции CSS."
    exit 1
fi

