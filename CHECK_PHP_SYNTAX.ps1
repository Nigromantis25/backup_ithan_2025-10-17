# Ejecuta esta script en PowerShell para verificar sintaxis PHP de todos los archivos .php
$path = "c:\xampp\htdocs\backup_ithan_2025-10-17"
Get-ChildItem -Path $path -Filter *.php -Recurse | ForEach-Object {
    $file = $_.FullName
    Write-Host "Checking $file"
    php -l $file
}
