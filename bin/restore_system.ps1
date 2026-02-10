$ErrorActionPreference = "Stop"

# Configuration
$projectRoot = Split-Path -Parent $PSScriptRoot
$backupDir = Join-Path $projectRoot "backups"
$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"
$dbUser = "root"
$dbPass = "" # Empty password for default XAMPP
$dbName = "avante_servico"

# Check dependencies
if (-not (Test-Path $mysqlPath)) {
    Write-Error "mysql.exe not found at $mysqlPath. Please verify your XAMPP installation path."
    exit 1
}

# 1. Select Backup
$backups = Get-ChildItem -Path $backupDir -Filter "*.zip" | Sort-Object LastWriteTime -Descending

if ($backups.Count -eq 0) {
    Write-Warning "No backups found in $backupDir."
    exit 1
}

Write-Host "Available Backups:" -ForegroundColor Cyan
for ($i = 0; $i -lt $backups.Count; $i++) {
    Write-Host "$($i + 1). $($backups[$i].Name) ($($backups[$i].LastWriteTime))"
}

$selection = Read-Host "Enter the number of the backup to restore (1-$($backups.Count))"
if ($selection -match "^\d+$" -and $selection -ge 1 -and $selection -le $backups.Count) {
    $selectedBackup = $backups[$selection - 1]
} else {
    Write-Error "Invalid selection."
    exit 1
}

$confirm = Read-Host "WARNING: This will OVERWRITE your current project files and database. Are you sure? (y/n)"
if ($confirm -ne 'y') {
    Write-Host "Restore cancelled."
    exit 0
}

# 2. Extract and Restore
Write-Host "Restoring from $($selectedBackup.Name)..." -ForegroundColor Yellow

$tempDir = Join-Path $projectRoot ".restore_temp"
if (Test-Path $tempDir) { Remove-Item -Path $tempDir -Recurse -Force }
New-Item -ItemType Directory -Path $tempDir | Out-Null

try {
    # Extract Zip (using .NET for reliability)
    Write-Host "Extracting archive..."
    Add-Type -AssemblyName System.IO.Compression.FileSystem
    [System.IO.Compression.ZipFile]::ExtractToDirectory($selectedBackup.FullName, $tempDir)
    
    # Restore Database
    $sqlFile = Join-Path $tempDir "database.sql"
    if (Test-Path $sqlFile) {
        Write-Host "Restoring database '$dbName'..."
        $restoreCommand = "& '$mysqlPath' --user=$dbUser --password='$dbPass' $dbName < '$sqlFile'"
        # Use cmd /c specifically for input redirection which is tricky in PS
        cmd /c "$mysqlPath --user=$dbUser --password=""$dbPass"" $dbName < ""$sqlFile"""
        Write-Host "Database restored successfully." -ForegroundColor Green
    } else {
        Write-Warning "No database.sql found in backup. Database restore skipped."
    }
    
    # Restore Files
    Write-Host "Restoring project files..."
    
    # Get all items in temp dir except the sql file and restore them to project root
    $itemsToRestore = Get-ChildItem -Path $tempDir -Exclude "database.sql"
    
    foreach ($item in $itemsToRestore) {
        if ($item.Name -eq "database.sql") { continue }
        Copy-Item -Path $item.FullName -Destination $projectRoot -Recurse -Force
    }
    
    Write-Host "Files restored successfully." -ForegroundColor Green
    
}
catch {
    Write-Error "Restore failed: $_"
}
finally {
    # Cleanup
    if (Test-Path $tempDir) {
        Remove-Item -Path $tempDir -Recurse -Force
    }
}

Write-Host "System restored successfully!" -ForegroundColor Cyan
