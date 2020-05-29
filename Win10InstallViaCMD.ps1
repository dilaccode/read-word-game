:: Install Chocolatey via PowerShell
@"%SystemRoot%\System32\WindowsPowerShell\v1.0\powershell.exe" -NoProfile -InputFormat None -ExecutionPolicy Bypass -Command " [System.Net.ServicePointManager]::SecurityProtocol = 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))" && SET "PATH=%PATH%;%ALLUSERSPROFILE%\chocolatey\bin"

:: Install Git
choco install -y git.install

:: Install Xampp
choco install -y bitnami-xampp
	<# start apache, mysql #>
	Start-Process C:\xampp\mysql\bin\mysqld.exe
	Start-Process C:\xampp\apache\bin\httpd.exe
  
:: Install Netbeans (will include JDK version X)
choco install -y netbeans-php

:: Notify Done
start "https://www.google.com/search?q=INSTALL+DONE"
