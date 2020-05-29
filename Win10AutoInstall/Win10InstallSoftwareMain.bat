:: Install Git
choco install -y git.install

:: Install Xampp
choco install -y bitnami-xampp
	:: start apache, mysql
	start C:\xampp\mysql\bin\mysqld.exe
	:: start xampp for start apache
	start C:\xampp\xampp-control.exe
  
:: Install Netbeans (will include JDK version X)
choco install -y netbeans-php

:: Notify Done
start "https://www.google.com/search?q=INSTALL+DONE"
