
$pluginSlug = "samurai-chat-widget"
$pluginFile = "samurai_chat.php"
$sourceDir  = $PSScriptRoot
$zipPath    = "$sourceDir\..\$pluginSlug.zip"

Write-Host "Building $pluginSlug.zip ..." -ForegroundColor Cyan

if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

$tempDir = "$env:TEMP\$pluginSlug"
if (Test-Path $tempDir) { Remove-Item $tempDir -Recurse -Force }
New-Item -ItemType Directory -Path $tempDir | Out-Null
Copy-Item "$sourceDir\$pluginFile" "$tempDir\$pluginFile"

Compress-Archive -Path $tempDir -DestinationPath $zipPath -Force
Remove-Item $tempDir -Recurse -Force

$size = [math]::Round((Get-Item $zipPath).Length / 1KB, 1)
Write-Host "Done: $zipPath ($size KB)" -ForegroundColor Green
Write-Host ""
Write-Host "Upload steps:" -ForegroundColor Yellow
Write-Host "  WP Admin -> Plugins -> Add New -> Upload Plugin"
Write-Host "  Select: $zipPath"
Write-Host "  Install Now -> Activate"
Write-Host "  (If plugin already exists: Deactivate + Delete first)"
Write-Host ""

Start-Process explorer.exe (Split-Path $zipPath -Parent)
