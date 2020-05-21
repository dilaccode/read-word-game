#NoEnv  ; Recommended for performance and compatibility with future AutoHotkey releases.
; #Warn  ; Enable warnings to assist with detecting common errors.
SendMode Input  ; Recommended for new scripts due to its superior speed and reliability.
SetWorkingDir %A_ScriptDir%  ; Ensures a consistent starting directory.




IsClick := false
while(true){
    if(Isclick){
        TrayTip, Running, F1=on/off
        ;word
        MouseClick, left, 381, 205
        Sleep, 1500 ; ms
        ;bookmark
        MouseClick, left, 343, 92
        Sleep, 200 ; ms
        ; click other place for anti wrong click
        MouseMove, 375, 145
        Sleep, 250 ; ms // for review test
    }else{
        ; waiting...
    }
}

F1::
   IsClick := !IsClick
return