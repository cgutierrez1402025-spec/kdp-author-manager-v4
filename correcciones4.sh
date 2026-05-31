#!/bin/bash

echo "🔧 Corrigiendo rutas completas de Form y Table en todos los recursos..."

find app/Filament/Admin/Resources -name "*Resource.php" -type f | while read file; do
    echo "Procesando: $file"
    
    # Crear backup
    cp "$file" "$file.fix.bak"
    
    # 1. Reemplazar Filament\Forms\Form por Form (cuando está en parámetros)
    sed -i '' 's/public static function form(Filament\\Forms\\Form \$form): Filament\\Forms\\Form/public static function form(Form $form): Form/g' "$file"
    
    # 2. Reemplazar Filament\Tables\Table por Table (cuando está en parámetros)
    sed -i '' 's/public static function table(Filament\\Tables\\Table \$table): Filament\\Tables\\Table/public static function table(Table $table): Table/g' "$file"
    
    # 3. Asegurar que los imports existen
    if ! grep -q "use Filament\\Forms\\Form;" "$file"; then
        sed -i '' '/use Filament\\Resources\\Resource;/a\
use Filament\\Forms\\Form;' "$file"
    fi
    
    if ! grep -q "use Filament\\Tables\\Table;" "$file"; then
        sed -i '' '/use Filament\\Resources\\Resource;/a\
use Filament\\Tables\\Table;' "$file"
    fi
    
    echo "  ✅ Corregido"
done

echo ""
echo "✅ Corrección completada"
echo "Ejecuta: composer dump-autoload && php artisan optimize:clear"
