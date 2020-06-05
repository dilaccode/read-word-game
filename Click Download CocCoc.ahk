#NoEnv  ; Recommended for performance and compatibility with future AutoHotkey releases.
; #Warn  ; Enable warnings to assist with detecting common errors.
SendMode Input  ; Recommended for new scripts due to its superior speed and reliability.
SetWorkingDir %A_ScriptDir%  ; Ensures a consistent starting directory.

F1::
CoordMode, Mouse, Screen
Click, 406, 64
Sleep, 1000
Click, 1050, 193
Sleep, 100
MouseMove, 600,500
return