# Busca todos los archivos Resource.php con el error
find app/Filament/Admin/Resources -name "*Resource.php" -type f | while read file; do
    echo "Corrigiendo: $file"
    
    # 1. Cambia Heroicon::XXX a string
    sed -i '' 's/protected static string|BackedEnum|null \$navigationIcon = Heroicon::[A-Za-z]*;/protected static ?string $navigationIcon = '\''heroicon-o-document-text'\'';/g' "$file"
    
    # 2. Elimina imports incorrectos
    sed -i '' '/use Filament\\Schemas\\Schema;/d' "$file"
    sed -i '' '/use Filament\\Support\\Icons\\Heroicon;/d' "$file"
    
    # 3. Corrige el método form si usa Schema en lugar de Form
    sed -i '' 's/public static function form(Schema \$schema): Schema/public static function form(Form $form): Form/g' "$file"
    sed -i '' 's/\$schema->schema/\/\/ \$form->schema/g' "$file"
    
    echo "✅ Corregido: $file"
done
