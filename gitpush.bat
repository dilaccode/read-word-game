@echo off
set /p Message="Commit message: "
git add -A
git commit -m "%Message%"
git push