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
Click, 164, 793
Click, 180, 793
Click, 196, 793
Click, 212, 793
Click, 228, 793
Click, 244, 793
Click, 260, 793

; download
Click, 406, 191
Sleep, 1000
Click, 1050, 331

;wait server read word
Sleep, 1000
; go Approved button
MouseMove, 385, 65
SoundPlay, C:\xampp\htdocs\tempzzz\CheckingApproved.mp3
return

; APPROVED AND MOVE TO NEW SOUND
F2::
CoordMode, Mouse, Screen
Click, 600,600
Click, 600,500

;wait new page load
SoundPlay, C:\xampp\htdocs\tempzzz\PLeaseWaitPageLoading.mp3
Sleep, 6000
; go Download button
MouseMove, 385, 92
SoundPlay, C:\xampp\htdocs\tempzzz\DownloadMe.mp3

return

