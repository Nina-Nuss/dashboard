cd ..

@echo off

set /p BRANCH=Bitte Branch-Namen eingeben: 
git branch
echo Du hast eingegeben: '%BRANCH%'
git stash
git checkout %BRANCH%
pause