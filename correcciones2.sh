#!/bin/bash

echo "🔧 Limpiando todos los recursos de Filament..."

find app/Filament/Admin/Resources -name "*Resource.php" -type f | while read file; do
    echo "Procesando: $file"
    
    # Crear backup
    cp "$file" "$file.clean.bak"
    
    # 1. Eliminar todos los imports existentes de Form y Table
    sed -i '' '/use Filament\\Forms\\Form/d' "$file"
    sed -i '' '/use Filament\\Tables\\Table/d' "$file"
    
    # 2. Añadir imports correctos después de Resource
    sed -i '' '/use Filament\\Resources\\Resource;/a\
use Filament\\Forms\\Form;\
use Filament\\Tables\\Table;' "$file"
    
    # 3. Eliminar líneas con "use ... as Form"
    sed -i '' '/use.*as Form/d' "$file"
    
    # 4. Limpiar líneas con múltiples puntos y coma
    sed -i '' 's/;use/;\
use/g' "$file"
    
    echo "  ✅ Completado"
done

echo ""
echo "✅ Limpieza finalizada"
echo "Ejecuta: composer dump-autoload && php artisan optimize:clear"
