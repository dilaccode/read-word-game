:: Install Git
choco install -y git.install

:: Install Xampp
choco install -y bitnami-xampp
::	start apache, mysql
start C:\xampp\mysql\bin\mysqld.exe
::	start xampp for start apache
start C:\xampp\xampp-control.exe


:: CLONE CODE AND DB ===

@echo off
:: 	config git
git config --global user.email "congtk1992@gmail.com"
git config --global user.name "dilaccode"

:: 	clone source
cd c:\
RMDIR "C:\xampp\htdocs" /S /Q
MKDIR C:\xampp\htdocs
cd C:\xampp\htdocs
git clone https://github.com/dilaccode/read-word-game.git .

:: 	execute databse
C:\xampp\mysql\bin\mysql.exe --user=root --password= --host=localhost --port=3306 < "C:\xampp\htdocs\database\word_database.sql"

:: 	open test site
explorer "https://localhost"

:: END CLONE CODE AND DB ===

  
:: Install Netbeans (will include JDK version X)
choco install -y netbeans-php

:: Notify Done
explorer "https://www.google.com/search?q=INSTALL+DONE"
