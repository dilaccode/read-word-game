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

:: copy apache config
xcopy /R /Y "C:\xampp\htdocs\server_setup\XAMPP_httpd.conf" "C:\xampp\apache\conf\httpd.conf"
C:\Users\Administrator\Desktop\httpd.conf
:: start mysql
start C:\xampp\mysql\bin\mysqld.exe

:: open test site
explorer "https://localhost"
explorer "https://localhost:81"

