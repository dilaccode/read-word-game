; GUI
Gui, Add, Text,, >>>
Gui, Add, Button, Default w200 , F1 = Approved
Gui, Add, Button, Default w200 , F5 = Start/Stop
Gui, Add, Text, vTalk, >>> >>> >>> >>> >>> >>> >>>
Gui, Show

; program
IsApproved := false
IsStart := false
while(true){
	if(IsStart){
		if(IsApproved){
			IsApproved := false
			GuiControl,, Talk, I approved - You are welcome
			; approved work
			Send {F10}
			; sleep some for loading new sound page + approved work
			Sleep, 1500
		}else{
			GuiControl,, Talk, I downloading sound...
			; downloading work
			Send {F9}
			; sleep for work = F10 seconds
			Sleep, 2000
		}
	}else{
		GuiControl,, Talk,  I stopped
	}
	Sleep, 1000
}

return
; END

; NEW APPROVED
F1::		
	IsApproved := true
return
F5::	
	IsStart := !IsStart
return

; DOWNLOAD
F9::
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

Sleep, 100
MouseMove, 391, 78
return

; APPROVED AND MOVE TO NEW SOUND
F10::
CoordMode, Mouse, Screen
Click, 600,600
Sleep, 100
Click, 600,500
Sleep, 200


MouseMove, 391, 78

return

