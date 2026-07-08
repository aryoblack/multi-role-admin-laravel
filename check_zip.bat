@echo off
echo ========================================
echo Checking PHP Zip Extension
echo ========================================
echo.

echo Current PHP Version:
php -v
echo.

echo Checking if zip extension is loaded...
php -m | findstr /i "zip"

if %errorlevel% equ 0 (
    echo.
    echo [SUCCESS] Zip extension is ENABLED!
    echo You can now use the backup feature.
) else (
    echo.
    echo [ERROR] Zip extension is NOT enabled!
    echo.
    echo To enable it:
    echo 1. Right-click Laragon icon
    echo 2. PHP -^> Extensions -^> Click "zip"
    echo 3. Laragon will restart automatically
    echo.
    echo OR manually edit php.ini:
    echo 1. Right-click Laragon -^> PHP -^> php.ini
    echo 2. Find: ;extension=zip
    echo 3. Change to: extension=zip
    echo 4. Save and restart Laragon
)

echo.
echo ========================================
echo Press any key to exit...
pause >nul
