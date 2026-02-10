$ErrorActionPreference = "Stop"

# Configuration
$projectRoot = Split-Path -Parent $PSScriptRoot
$backupDir = Join-Path $projectRoot "backups"
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$mysqlDumpPath = "C:\xampp\mysql\bin\mysqldump.exe"
$dbUser = "root"
$dbPass = "" # Empty password for default XAMPP
$dbName = "avante_servico"
$backupName = "backup_$timestamp"
$sqlFile = Join-Path $backupDir "$backupName.sql"
$zipFile = Join-Path $backupDir "$backupName.zip"

# Create backups directory if it doesn't exist
if (-not (Test-Path $backupDir)) {
    New-Item -ItemType Directory -Path $backupDir | Out-Null
    Write-Host "Created backups directory at $backupDir"
}

# 1. Backup Database
Write-Host "Backing up database '$dbName'..."
try {
    if (-not (Test-Path $mysqlDumpPath)) {
        throw "mysqldump.exe not found at $mysqlDumpPath. Please verify your XAMPP installation path."
    }
    
    $dumpCommand = "& '$mysqlDumpPath' --user=$dbUser --password='$dbPass' --databases $dbName --result-file='$sqlFile' 2>&1"
    Invoke-Expression $dumpCommand
    
    if (-not (Test-Path $sqlFile)) {
        throw "Database dump failed. SQL file not created."
    }
    Write-Host "Database backup created: $sqlFile" -ForegroundColor Green
}
catch {
    Write-Error "Database backup failed: $_"
    exit 1
}

# 2. Backup Files (Zip everything excluding specifics)
Write-Host "Zipping project files..."

# Define exclusions
$exclude = @(
    "backups",
    ".git",
    ".vscode",
    "node_modules",
    "vendor", # Optional: exclude vendor if you want faster backups and run composer install later, but for restore simplicity keeping it might be better. Let's keep it for now as it's a full restore.
    "*.zip",
    "*.sql",
    ".backup_temp"
)

try {
    # We want to zip the contents of projectRoot into the zip file
    # But we need to include the generated SQL file which is currently in $backupDir
    
    # Strategy: 
    # 1. Create a temp directory locally to avoid env issues
    # 2. Copy project files (minus excludes) to temp/project
    # 3. Move SQL file to temp/database/
    # 4. Zip temp directory contents
    # 5. Cleanup
    
    $tempDir = Join-Path $projectRoot ".backup_temp"
    if (Test-Path $tempDir) { Remove-Item -Path $tempDir -Recurse -Force }
    New-Item -ItemType Directory -Path $tempDir | Out-Null
    
    Write-Host "Temp directory location: $tempDir"
    
    # Capture list of files BEFORE creating temp content to avoid recursion issues if possible
    # but we just created tempDir. It's fine, we exclude it.
    
    $filesToZip = Get-ChildItem -Path $projectRoot -Exclude $exclude
    
    Write-Host "Found $($filesToZip.Count) items to backup."
    
    Write-Host "Copying files to temp directory..."
    
    foreach ($item in $filesToZip) {
        if ($item.FullName -eq $backupDir) { 
            Write-Host "Skipping backup directory"
            continue 
        }
        if ($item.FullName -eq $tempDir) {
            continue
        }
        
        Write-Host "Copying $($item.Name)..."
        Copy-Item -Path $item.FullName -Destination $tempDir -Recurse -Force -ErrorAction Stop
    }

    
    # Move the SQL dump to the temp dir to be included in the zip
    Write-Host "Moving SQL dump..."
    Move-Item -Path $sqlFile -Destination (Join-Path $tempDir "database.sql") -ErrorAction Stop
    
    # Create Zip
    Write-Host "Compressing archive (using .NET)..."
    Add-Type -AssemblyName System.IO.Compression.FileSystem
    [System.IO.Compression.ZipFile]::CreateFromDirectory($tempDir, $zipFile)
    
    # Cleanup Temp
    Write-Host "Cleaning up temp..."
    Remove-Item -Path $tempDir -Recurse -Force -ErrorAction Stop
    
    Write-Host "Backup ZIP created successfully: $zipFile" -ForegroundColor Green
}
catch {
    Write-Host "File backup failed at step: $($_.InvocationInfo.ScriptLineNumber)" -ForegroundColor Red
    Write-Host "Error Message: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "Stack Trace: $($_.ScriptStackTrace)" -ForegroundColor Red
    exit 1
}

Write-Host "Backup Process Completed Successfully!" -ForegroundColor Cyan
