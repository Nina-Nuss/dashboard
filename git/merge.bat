cd ..

@echo off
set /p BRANCH=Bitte Branch-Namen zum Mergen eingeben: 

git merge %BRANCH%

pause