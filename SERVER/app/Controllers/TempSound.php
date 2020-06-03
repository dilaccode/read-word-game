<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class TempSound extends BaseController {

    public function index() {

       echo "temp";
        
    }

    public function CurrentWord() {
        echo '<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';
        // current word for work
        $SM = new SimpleModel();
        $WordObj = $SM->Query("select * from wordtemp where IsSound=0")
                ->GetRow(0);

        $Link = "https://dictionary.cambridge.org/dictionary/english/$WordObj->Word";
        echo "current: <a class='w3-text-indigo' style='font-size: 50px;font-weight:bold;  text-transform: uppercase;' target='_blank' href='$Link'>$WordObj->Word</a><br>";

        //
        return $WordObj;
    }
    
    public function PlaySound(){
        $path = 'C:\xampp\htdocs\SERVER\TEMP\Work';
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));
        if (!empty($files[2])) {
            $AudioName = $files[2];
            echo "<audio controls autoplay>
                <source src='/TEMP/Work/$AudioName' type='audio/mpeg'>
        </audio>";
        }
    }

    public function AutoRefresh() {
        /// auto refresh
        $TimeBeat = 1500;
        echo "<script>"
        . "setTimeout(function(){ location.reload(); }, $TimeBeat);"
        . "</script>";
    }
    public function OpenSoundPage(){
        echo "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>";
        echo "<script src=\"/TEMP/SoundTemp.js\"></script>";
    }

    public function Panel() {
        // is file
        $path = 'C:\xampp\htdocs\SERVER\TEMP\Work';
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));
        $IsFileExist = !empty($files[2]);
        //
        $WordObj = $this->CurrentWord();        
        $this->PlaySound();
        $this->AutoRefresh();
        
        echo "<hr>";
        /// buttons
        if ($IsFileExist) {
            echo "<div style='margin: 25px;'>";
            echo "<a class='w3-btn w3-red' href='/TempSound/DeleteAllSound' target='_blank'>Delete All</a>";
            echo "<div style='margin-top: 50px'></div>";
            
            echo ucfirst($WordObj->Word)." arrived.<br><br>"; 
            echo "<a class='w3-btn w3-green' href='/TempSound/AddSound/$WordObj->Id' target='_blank'>Approve</a>";
            echo "<br><br>You are welcome!";
            echo "</div>";
        }else{
            echo "<span class='w3-xxlarge' style='margin: 10px;'>I waiting MP3 file... (sound file)</span>";
        }
    }

    public function DeleteAllSound() {
        //
        $path = 'C:\xampp\htdocs\SERVER\TEMP\Work';
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));
        foreach ($files as $file) { // iterate files          
            $FilePath = $path . "\\" . $file;
            if (is_file($FilePath)) {
                unlink($FilePath); // delete file
            }
        }
        //
        echo "deleted";
        // auto close tab
        echo "<script>"
        . "window.close();"
        . "</script>";
    }

    public function AddSound($WordId) {
        $SM = new SimpleModel();
        //
        $WordObj = $SM->Find("wordtemp", $WordId);
        //
        $path = 'C:\xampp\htdocs\SERVER\TEMP\Work';
        $pathResult = 'C:\xampp\htdocs\SERVER\TEMP\Result';
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));
        foreach ($files as $file) { // iterate files          
            $FilePath = $path . "\\" . $file;
            $FilePathNew = $pathResult . "\\" . $WordObj->Word . ".mp3";
            if (is_file($FilePath)) {
                copy($FilePath, $FilePathNew);
                $WordObj->IsSound = 1;
                $SM->Update('wordtemp', $WordObj);
                $this->DeleteAllSound(); // tab will close here
            }
        }
    }
    
    /// AJAX ===============
    public function AjaxGetWord(){
        $SM = new SimpleModel();
        $WordObj = $SM->Query("select * from wordtemp where IsSound=0")
                ->GetRow(0);
        echo json_encode($WordObj);
        
    }

}
