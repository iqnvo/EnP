<?php

include_once("color.php");

$command = $argv;

function exitTool($result = ""){
    echo $result;
    echo "\n\n";
    exit();
}

class extension{
    protected array $textEnc = array(
        "LpIaO3", "0r#0Jy", "X8IwBp", "bFb#C6", "C2q\$oK",
        "W5AeN2", "m5tU9I", "W0cR8U", "C4V#Yj", "hD7k@w",
        "z2O#Ei", "8x#mOn", "f5JtO3", "Y4bP#n", "H8Hh\$w",
        "Y2Rj#B", "4pV#7L", "m#6T0x", "S8Qw#C", "a#9LwR",
        "D5Yv@G", "aM0o#t", "R#5kFs", "2aMx#j", "xVnE#o",
        "Q6Ii\$n", "S5N#s0", "g$3kXo", "Zz#dJ9", "4EhV#e",
        "1dY#xL", "E9Yd@J", "3RgI#f", "h#0bCo", "B5wC#m",
        "7tC#rP", "X8u@9b", "6FfR#1", "aI4p#z", "K#7mTt",
        "cH2z@E", "v#5VfK", "G#8vBr", "e#1gAi", "D5Wj#u",
        "Q#0rKv", "jN7m#Z", "1h#eAd", "7e#lHz", "M7d#xK",
        "qN9g#X", "8WnI#s", "X9K#qP", "5G#kRv", "Jz#9bS",
        "W6p#7e", "GxI#oJ", "pGd#zL", "4k#lFy", "7qW@9x",
        "yKj#eL", "w0r#sB", "3pH@4t", "fRz#oE", "R#1eNt",
        "8nQh#z", "G2x@jK", "mO0#pX", "y#5cBa", "L4P#vZ",
        "F4vA#e", "dT6g#U", "y2H#lO", "W#1z4d", "g#8wFh",
        "Z4nX#p", "mT8o#D", "9hI@7s", "k#3lNr", "bR5j#X",
        "A1P#vO", "i#7z3w", "B8a#oG", "H#2cTt", "VzR#eX",
        "dD2x#Y", "3LgP#o", "G#0dUq", "mWn#6l", "C5c#jS",
        "q#4wDm", "pXjI#7", "yN9q#L", "b#2kOz", "F5D@1y",
        "kS4a#Y", "Z#6uQh", "CnG#3b", "j#9iJp", "qV5m#E"
    );

    protected $commands = [
        "-open", //must open to be number 0
        "-enc",  // must enc to be number 1
        "-file", // must file to be number 2
        "-text", // must text to be number 3
        "-dir" //must dir to be number 4
    ];

    protected string $typeHash = "c"; //pack && unpack


    public function getO() : string{
        return $this->commands[0];
    }

    public function getE() : string{
        return $this->commands[1];
    }

    public function getF() : string{
        return $this->commands[2];
    }

    public function getT() : string{
        return $this->commands[3];
    }

    public function getD() : string{
        return $this->commands[4];
    }

    public function help() : array{
        return [
            ""
        ];
    }
}


class clearError extends extension{

    public function __construct(public &$command){
        array_shift($command);
        $this->cleanBadCommands(); // clean bad
        $this->cleanMoreOne(); // clean more than one
        $this->bombError(); // check errors
        
    }

    private function cleanBadCommands() : void{
        $textStop = False;
        $this->command = array_filter($this->command, function ($value, $key) use(&$textStop){
            if ((isset($this->command[$key]) && !in_array($this->command[$key], $this->commands) && !file_exists($this->command[$key]) && !$textStop)) {
                $textStop = True;
                return TRUE;
            }
            return in_array($value, $this->commands) || (file_exists($value));
        }, ARRAY_FILTER_USE_BOTH);

    }

    private function cleanMoreOne() : void{
        $new = [];
        foreach($this->command as $command){
            in_array($command, $new) ? Null : $new[] = $command;
        }
        $this->command = $new;
    }

    private function bombError() : void{



        $twoOption = function () {
            $files = function (){
                $files = array_filter($this->command, fn($value) => is_file($value) && file_exists($value));
                return $files;
            };

            if (in_array($this->getO(), $this->command) && in_array($this->getE(), $this->command)){
                exitTool(syntax("cannot use option -open, -enc two gather", 0));
            }

            if (in_array($this->getT(), $this->command) && in_array($this->getF(), $this->command)){
                exitTool(syntax("cannot use option -text, -file two gather", 0));
            }

            if (in_array($this->getF(), $this->command) && empty($files())){
                exitTool(syntax("file does not exists", 0));
            }
        };

        $twoOption();
    }




}




class tool extends extension{

    //const ENC_FILE = 12;

    public function __construct(public &$command){
        //$this->encryptionText();
        
        $mode = function (){
            $option = $this->getOption();

            if (isset($option["file"])) return $option["file"];
            if (isset($option["text"])) return $option["text"];
        };

        switch ($this->getOption()["option"]) :

            case $this->getE():
                echo "\n";
                if (isset($this->getOption()["file"])) :
                    echo syntax("Encryption File -> " . $this->getOption()["file"] . " :\n\n", 2);
                    echo $this->encryptionFile();
                elseif ($mode() == $this->getT()):
                    echo syntax("Encryption :\n\n", 2);
                    echo $this->encryptionText();
                endif;

            break;


            case $this->getO():
                echo "\n";

                if (isset($this->getOption()["file"])) :
                    echo $this->openFile();
                else:
                    echo $this->openEncryption();
                endif;

            break;
            
            default:
                //echo $this->syntax(implode($this->help()), 2);
                null;
        endswitch;

        echo "\n";
    }



    public function encryptionText(string $text = ""){
        $text ? null : $text = $this->getText();

        $convertToBytes = function () use(&$text){
            $bytes = unpack("c*", $text);
            $bytes = array_map(fn($value) => $value * 5, $bytes);

            return $bytes;
        };
    
        $base64 = function($bytes){
            $text = base64_encode(implode("\n", $bytes));
            return $text;
        };
    
        $enc = function (string $base){
            $textEnc = $this->textEnc;
            $textEnc = array_combine(str_split("qazwsxedcrfvtgbyhnujmikolp1234567890QAZWSXEDCRFVTGBYHNUJMIKOLP@!="), array_slice($textEnc, 0, count(str_split("qazwsxedcrfvtgbyhnujmikolp1234567890QAZWSXEDCRFVTGBYHNUJMIKOLP@!="))));
    
            $t = implode(array_map(function ($value) use ($textEnc){
                return $textEnc[$value] ?? $value;
            }, str_split($base)));
    
            return $t;
        };


        return $enc($base64($convertToBytes()));
    }


    public function openEncryption($text = "") : string{
        if (empty($text ? $text : $this->getText())) exitTool(syntax("no text for open encryption", 2));

        $enc = function (string $enc){
            $textEnc = $this->textEnc;
            $textOpen = array_combine(array_slice($textEnc, 0, count(str_split("qazwsxedcrfvtgbyhnujmikolp1234567890QAZWSXEDCRFVTGBYHNUJMIKOLP@!="))), str_split("qazwsxedcrfvtgbyhnujmikolp1234567890QAZWSXEDCRFVTGBYHNUJMIKOLP@!="));

            $val = "";
            $key = "";
            foreach(str_split($enc) as $word){
                strlen($key) < 6 ? $key .= $word : null;

                if (strlen($key) == 6){
                    $val .= $textOpen[$key] ?? exitTool(syntax("hash is bad", 0));
                    $key = "";
                };
            }
            if ($key == "\n") $key = "";

            if (strlen($key) !== 0) exitTool(syntax("--hash is bad", 0));

            return $val;
        };

        $base64 = function($bytes){
            $text = base64_decode($bytes);
            return $text;
        };


        
        $BytesToString = function ($bytesAsString){
            $bytes = explode("\n", $bytesAsString);
            $bytes = array_map(fn($value) => $value / 5, $bytes);

            $val = "";
            foreach ($bytes as $byte){
                $val .= pack("c", $byte);
            }

            return $val;
        };

        return $BytesToString($base64($enc($text ? $text : $this->getText())));
    }

    public function encryptionFile(){

        $value = [];

        echo syntax("Save Encryption At Memory :\n", 2);
        foreach (file($this->getFile()) as $key => $line){
            $value[] = $this->encryptionText($line);
            echo "[" . $key++ . "] " . ((strlen($line) < 60) ? $line : removeLettersAfterCustomByte($line, 30) . "... {Hased At Memory}\n");
        }
        
        $handle = fopen($this->getFile(), "w");
        fclose($handle);

        $handle = fopen($this->getFile(), "a");
        foreach($value as $key => $line){
            fwrite($handle, $line . "\n");
        }
        fclose($handle);

        echo syntax("\nSaved Data At File.", 1);
        exitTool(syntax("\nDone.", 1));
    }


    public function openFile(){

        $value = [];
        foreach(file($this->getFile()) as $key => $line){
            $result = $this->openEncryption($line);
            $value[] = $result;
            echo "[" . $key++ . "] " . ((strlen($line) < 60) ? $line : removeLettersAfterCustomByte($line, 30) . "... {opened At Memory}\n");
        }


        $handle = fopen($this->getFile(), "w");
        fclose($handle);

        $handle = fopen($this->getFile(), "a");

        foreach ($value as $line){
            fwrite($handle, $line);
        }

        fclose($handle);

        exitTool(syntax("Done.", 1));
    }


    private function getText() : string{
        foreach($this->command as $cmd){
            if (!file_exists($cmd) && !in_array($cmd, $this->commands)) return (string) $cmd;
        }

        return "";
    }

    private function getFile() : string{
        return $this->getOption()["file"] ?? "";
    }

    private function getOption() : array{
        $file = "";
        $option = "";

        foreach($this->command as $cmd){
            if (in_array($this->getF(), $this->command)){
                file_exists($cmd) ? $file = $cmd : null;
            }
            
            if ($cmd !== $this->getF() && in_array($cmd, $this->commands)){
                $option = $cmd;
            }
        }

        if ($option == $this->getT()) $option = NULL;

        if (empty($file)){
            return ["option" => $option, "text" => in_array($this->getT(), $this->command) ? $this->getT(): Null];
        }else return ["option" => $option, "file" => $file];
    }



}

$clear = new clearError($command);
$tool = new tool($command);
