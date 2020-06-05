@echo off
cd C:\xampp\htdocs\
C:\xampp\mysql\bin\mysqldump.exe --user=root --password= --host=localhost --port=3306 --result-file="C:\xampp\htdocs\database\word_database.sql" --databases "word"
set /p Message="more message (optional): "
git add -A
git commit -m "work backup: code, db. %Message%"
git push