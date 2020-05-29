<# Install Chocolatey #>
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))

<# Install Git #>
choco install -y git.install

<# Install Xampp #>
choco install -y bitnami-xampp
	<# start xampp, mysql #>
	Start-Process C:\xampp\mysql\bin\mysqld.exe
	Start-Process C:\xampp\xampp-control.exe
	
<# Git clone source and run SQL file
	<# config git #>
	git config --global user.email "congtk1992@gmail.com"
	git config --global user.name "dilaccode"
	
	<# clone source #>
	cd c:\
	Remove-Item -LiteralPath "C:\xampp\htdocs" -Force -Recurse
	New-Item -ItemType Directory -Force -Path "C:\xampp\htdocs"
	cd C:\xampp\htdocs
	git clone https://github.com/dilaccode/read-word-game.git .

<# Open Chrome for test localhost #>
start "http://localhost"

<# go back #>
cd c:\

<# Install Netbeans (will include JDK version X) #>
choco install -y netbeans-php
Start-Process "C:\Program Files\NetBeans 8.2\bin\netbeans64.exe"

