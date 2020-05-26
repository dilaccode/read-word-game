@echo off
cd C:\xampp\htdocs\
set /p Message="Commit message: "
git add -A
git commit -m "%Message%"
git push