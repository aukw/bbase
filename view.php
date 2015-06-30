<?php
class View
{
  	function __construct()
    {

    }

    public static function load($viewFileName, $parmValue)
    {
      foreach ($parmValue as $key => $value) {
        $$key = $value;
      }
      $template = './views/'.$viewFileName.'.html';
      if(file_exists($template))
      {
        return include_once './views/'.$viewFileName.'.html';
      }else{
        return 'Template File Not Found!';
      }
    }

    public static function blade($bladeFileName)
    {
      return include_once './views/blade/'.'$bladeFileName.'.html';
    }

}


 ?>
