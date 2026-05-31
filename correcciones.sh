#!/bin/bash

echo "=========================================="
echo "🔧 Corrigiendo todos los recursos de Filament"
echo "=========================================="

# Directorio base de recursos
RESOURCES_DIR="app/Filament/Admin/Resources"

# Verificar que el directorio existe
if [ ! -d "$RESOURCES_DIR" ]; then
    echo "❌ Directorio $RESOURCES_DIR no encontrado"
    exit 1
fi

# Contadores
TOTAL=0
CORREGIDOS=0

# Recorrer todos los archivos Resource.php
find "$RESOURCES_DIR" -name "*Resource.php" -type f | while read file; do
    TOTAL=$((TOTAL + 1))
    echo ""
    echo "📝 Procesando: $file"
    
    # Crear backup
    cp "$file" "$file.bak"
    
    # 1. CORREGIR $navigationIcon
    echo "  ✓ Corrigiendo navigationIcon..."
    sed -i '' 's/protected static string|BackedEnum|null \$navigationIcon = Heroicon::[A-Za-z]*;/protected static ?string $navigationIcon = '\''heroicon-o-document-text'\'';/g' "$file"
    
    # 2. ELIMINAR imports incorrectos
    echo "  ✓ Eliminando imports incorrectos..."
    sed -i '' '/use Filament\\Schemas\\Schema;/d' "$file"
    sed -i '' '/use Filament\\Support\\Icons\\Heroicon;/d' "$file"
    sed -i '' '/use Filament\\Schemas\\Schema;/d' "$file"
    
    # 3. CORREGIR el método form
    echo "  ✓ Corrigiendo método form()..."
    
    # Reemplazar parámetro y return type incorrectos
    sed -i '' 's/public static function form(Schema \$schema): Schema/public static function form(Filament\\Forms\\Form $form): Filament\\Forms\\Form/g' "$file"
    sed -i '' 's/public static function form(Form \$form): Form/public static function form(Filament\\Forms\\Form $form): Filament\\Forms\\Form/g' "$file"
    
    # 4. CORREGIR llamadas internas
    echo "  ✓ Corrigiendo llamadas internas..."
    sed -i '' 's/return BookEventForm::configure(\$schema);/return $form->schema([]);/g' "$file"
    sed -i '' 's/return AiTaskForm::configure(\$schema);/return $form->schema([]);/g' "$file"
    sed -i '' 's/return \$schema->schema/return $form->schema/g' "$file"
    sed -i '' 's/\$schema->schema/\$form->schema/g' "$file"
    
    # 5. AÑADIR imports correctos si no existen
    if ! grep -q "use Filament\\Forms\\Form;" "$file"; then
        echo "  ✓ Añadiendo import de Form..."
        sed -i '' '/use Filament\\Resources\\Resource;/a\
use Filament\\Forms\\Form;' "$file"
    fi
    
    if ! grep -q "use Filament\\Tables\\Table;" "$file"; then
        echo "  ✓ Añadiendo import de Table..."
        sed -i '' '/use Filament\\Resources\\Resource;/a\
use Filament\\Tables\\Table;' "$file"
    fi
    
    CORREGIDOS=$((CORREGIDOS + 1))
    echo "  ✅ Corregido: $file"
done

echo ""
echo "=========================================="
echo "✅ Procesados: $CORREGIDOS archivos"
echo "=========================================="
echo ""
echo "📦 Backup creados como .bak"
echo "🔄 Ejecuta: composer dump-autoload"
echo "🔄 Ejecuta: php artisan optimize:clear"
