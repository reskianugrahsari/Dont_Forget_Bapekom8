@echo off
taskkill /F /IM ngrok.exe >nul 2>&1
timeout /t 2 /nobreak >nul
ngrok http https://dont-forget.test --host-header=dont-forget.test
