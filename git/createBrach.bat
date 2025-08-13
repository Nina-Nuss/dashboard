@echo off
set /p branchname=Bitte Branch-Namen eingeben: 
git checkout -b %branchname%
pause