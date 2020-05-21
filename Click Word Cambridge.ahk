#NoEnv  ; Recommended for performance and compatibility with future AutoHotkey releases.
; #Warn  ; Enable warnings to assist with detecting common errors.
SendMode Input  ; Recommended for new scripts due to its superior speed and reliability.
SetWorkingDir %A_ScriptDir%  ; Ensures a consistent starting directory.




IsClick := false
while(true){
    if(Isclick){
        ;word
        MouseClick, left, 381, 205
        Sleep, 3000 ; ms
        ;bookmark
        MouseClick, left, 343, 92
        Sleep, 200 ; ms
        ; click other place for anti wrong click
        MouseClick, left, 90, 180
        Sleep, 2000 ; ms // for review test
    }else{
        ; waiting...
    }
}

F1::
   IsClick := !IsClick
return