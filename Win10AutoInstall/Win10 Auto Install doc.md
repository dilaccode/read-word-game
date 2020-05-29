work:

    - work of PowerShell and Chocolatey hero, but via Cmd ok, he stable
     /work of **Win10InstallSoftwareStart.ps1**
        - install Chocolatey (download via PowerShell)
        - download .BAT file for install all software, setup code, database
            - download .BAT file via PowerShell > save to temp file C:\Win10InstallSoftware.bat
            - Run temp file C:\Win10InstallSoftwareMain.bat
    - work of \**Win10InstallSoftwareMain.bat**
        - install all software
        - clone code
        - clone db
        - notify test site
        - notify DONE