<# Install Chocolatey #>
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))

<# Install Git #>
choco install -y git.install

<# Install Xampp #>
choco install -y bitnami-xampp
	<# start apache, mysql #>
	Start-Process C:\xampp\mysql\bin\mysqld.exe
	Start-Process C:\xampp\apache\bin\httpd.exe
	
<# Git clone source and run SQL file, run cmd bat beacause mysql error on Powershell #>
	<# Download GitClone.bat file #>
	Invoke-WebRequest https://raw.githubusercontent.com/dilaccode/read-word-game/master/GitClone.bat -OutFile C:\GitClone.bat
	<# Execute #>
	Start-Process C:\GitClone.bat
	<# Open Chrome for test localhost #>
	start "http://localhost"

<# Install Netbeans (will include JDK version X) #>
choco install -y netbeans-php

<# Notify Done #>
start "https://www.google.com/search?q=INSTALL+DONE"
