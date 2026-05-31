# Busca archivos con el método form mal definido
grep -l "public static function form(Form \$form): Form" app/Filament/Admin/Resources/*/*Resource.php | while read file; do
    echo "⚠️ Revisar: $file"
    # Verifica si tiene el import correcto
    if ! grep -q "use Filament\\Forms\\Form;" "$file"; then
        echo "  ❌ Falta import de Filament\\Forms\\Form"
    fi
done
