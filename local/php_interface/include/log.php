<?
class Log
{
    private $path = '';

    const DEBUG = true;

    function __construct($folder = '')
    {
        if($folder == '')
            $folder = 'all';

        $this->path = $_SERVER['DOCUMENT_ROOT']."/local/log/".$folder.'';
        CheckDirPath($this->path.'/');
    }

    public function Add ()
    {
        if(!DEBUG)
            return;

        $arArgs = func_get_args();

        $arArgs = func_get_args();
        $trace = debug_backtrace();
        $trace = $trace[1];

        $sResult = array_key_exists('class',$trace) ? $trace['class'].'::' : '' ;//class
        $sResult .= $trace['function'].' '; //function

        foreach($arArgs as $arArg)
            $sResult .= print_r($arArg, true).' / ';

        $sResult = date('H:i:s ').$sResult.chr(13)."---------".chr(13);
        $hfile = fopen($this->path.'/log_'.date('Y-m-d').".log","a");
        fwrite($hfile, $sResult);
        fclose($hfile);
    }
}