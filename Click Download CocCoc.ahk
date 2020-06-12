; GUI
Gui, Add, Text,, >>>
Gui, Add, Button, Default w200 , Approved
Gui, Add, Button, Default w200 , Play_Download_Sound
Gui, Add, Text,, >>>
Gui, Show

ButtonApproved:
 {
   Send {F2}
 }
return
ButtonPlay_Download_Sound:
 {
   Send {F1}
 }
return

; DOWNLOAD
F1::
CoordMode, Mouse, Screen

; play sound (16x16 icon)
Click, 180, 793
Sleep, 100
Click, 196, 793
Sleep, 100
Click, 212, 793
Sleep, 100
Click, 228, 793
Sleep, 100
Click, 244, 793
Sleep, 100
Click, 260, 793
Sleep, 100

; download
Click, 406, 191
Sleep, 1000
Click, 1050, 331

; go Approved button
Sleep, 100
MouseMove, 385, 65
return

; APPROVED AND MOVE TO NEW SOUND
F2::
CoordMode, Mouse, Screen
Click, 600,600
Sleep, 100
Click, 600,500
Sleep, 200

;wait new page load
Sleep, 6000
; go Download button
MouseMove, 385, 92

return

