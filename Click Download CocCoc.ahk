; GUI
Gui, Add, Text,, >>>
Gui, Add, Button, Default w200 , Approved_or_Play_Sound
Gui, Add, Button, Default w200 , Download_Sound
Gui, Add, Text,, >>>
Gui, Show

ButtonApproved_or_Play_Sound:
 {
   Send {F2}
 }
return
ButtonDownload_Sound:
 {
   Send {F1}
 }
return

; DOWNLOAD
F1::
CoordMode, Mouse, Screen
Click, 406, 191
Sleep, 1000
Click, 1050, 331

Sleep, 100
MouseMove, 391, 78
return

; APPROVED AND MOVE TO NEW SOUND
F2::
CoordMode, Mouse, Screen
Click, 600,500
Sleep, 200
; play sound (16x16 icon)
Click, 180, 793
Sleep, 100
Click, 196, 793
Sleep, 100
Click, 212, 793
Sleep, 100
Click, 228, 793
Sleep, 100

MouseMove, 391, 78

return

