@echo off
REM Dieses Batch-Skript zieht automatisch den neuesten Stand vom Branch "beta"

cd /d %~dp0
git checkout beta
git pull origin beta

pause