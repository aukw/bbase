<?php
class View
{
  public static $parm;
  	function __construct()
    {

    }

    public static function load($viewFileName, $parmValue)
    {
      self::$parm = array_merge(self::$parm, $parmValue);
      foreach ($parmValue as $key => $value) {
        $$key = $value;
      }
      $template = './views/'.$viewFileName.'.html';
      if(file_exists($template))
      {
         include_once './views/'.$viewFileName.'.html';
      }else{
        echo  'Template File Not Found!';
      }
    }

    public static function blade($bladeFileName)
    {
      foreach (self::$parm as $key => $value) {
        $$key = $value;
      }
       include_once './views/blades/'.$bladeFileName.'.blade.html';
    }
	

}


 ?>
