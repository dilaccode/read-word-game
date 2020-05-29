@echo off
:: config 2 site apache
del "C:\xampp\apache\conf\extra\httpd-vhosts.conf"
del "C:\xampp\apache\conf\httpd.conf"

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

:: open test site
explorer "https://localhost"

