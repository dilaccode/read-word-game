<# NOTE: will get link http//.../*.ps1 for run install via CMD #>


<# Install Chocolatey #>
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))

<# Download download .BAT file for install all software and excute #>
Invoke-WebRequest https://raw.githubusercontent.com/dilaccode/read-word-game/master/Win10AutoInstall/Win10InstallSoftwareMain.bat -OutFile C:\Win10InstallSoftwareMain.bat
<# Execute #>
Start-Process C:\Win10InstallSoftwareMain.bat

<# Bye #>
exit