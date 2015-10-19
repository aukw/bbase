<?php
class View
{
  public static $parm;
    function __construct()
    {
        self::$parm = [];
    }

    public static function load($viewFileName, $parmValue)
    {
      if(!is_array($parmValue)){
          $parmValue = [$parmValue];
      }
      //self::$parm = array_merge(self::$parm, $parmValue);
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

    public static function blade($bladeFileName, $parmVlaue = [])
    {
      foreach ($parmVlaue as $key => $value) {
        $$key = $value;
      }
       include_once './views/blades/'.$bladeFileName.'.blade.html';
    }
	

}


 ?>
