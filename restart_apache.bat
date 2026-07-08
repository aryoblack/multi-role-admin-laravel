@echo off
echo ========================================
echo Restarting Apache Web Server
echo ========================================
echo.

echo Stopping Apache...
net stop Apache2.4 2>nul
if %errorlevel% equ 0 (
    echo Apache stopped successfully
) else (
    echo Apache was not running or requires admin rights
)

echo.
echo Starting Apache...
net start Apache2.4 2>nul
if %errorlevel% equ 0 (
    echo Apache started successfully
) else (
    echo Could not start Apache - use Laragon menu instead
)

echo.
echo ========================================
echo Alternative: Use Laragon Menu
echo ========================================
echo 1. Right-click Laragon icon
echo 2. Click "Restart All"
echo 3. Wait for services to restart
echo.
echo Press any key to exit...
pause >nul
