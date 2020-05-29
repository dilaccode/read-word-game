@echo off
:: config git
git config --global user.email "congtk1992@gmail.com"
git config --global user.name "dilaccode"

:: clone source
cd c:\
RMDIR "C:\xampp\htdocs" /S /Q
MKDIR C:\xampp\htdocs
cd C:\xampp\htdocs
git clone https://github.com/dilaccode/read-word-game.git .

:: execute databse
C:\xampp\mysql\bin\mysql.exe --user=root --password= --host=localhost --port=3306 < "C:\xampp\htdocs\database\word_database.sql"

:: add domain to end file hosts
echo 127.0.0.1 readword.com >> C:\Windows\System32\drivers\etc\hosts
echo 127.0.0.1 api.readword.com >> C:\Windows\System32\drivers\etc\hosts

:: open test site
explorer "https://readword.com"

