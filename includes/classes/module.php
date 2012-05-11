<?php




class sn_module
{
  public $manifest = array(
    'package' => 'core',
    'name' => 'sn_module',
    'version' => '1c0',
    'copyright' => 'Project "SuperNova.WS" #34a16# copyright © 2009-2012 Gorlum',

//    'require' => null,
    'root_relative' => '',

    'installed' => true,
    'active' => true,

    // 'functions' array - this functions would be installed as hooks
    // Key: overwritable function name to replace
    // Value: which method to use. Format: [*][<object_name>][.]<method>
    // '*' means that new function would replace old one
    // If object_name is ommited but "." is present - overwritable linked to global function
    // If only "method" present - overwritable linked to appropriate method of current object
    // Function/Method should be accessible on module init
    'functions' => array(
//      'test_object_test_method' => 'test_object.test_method',
//      'test_function' => '.my_test_function',
//      'this_object_test_method' => 'test_method',
    ),

    // 'menu' array - this menu items would be merged into main game menu
    // Array element almost identical to $sn_menu with additional param 'LOCATION'.
    // 'LOCATION' => '-news', // Special atrtribute for modules
    // [-|+][<menu_item_id>]
    // <menu_item_id> identifies menu item aginst new menu item would be placed. When ommited new item placed against whole menu
    // -/+ indicates that new item should be placed before/after identified menu item (or whole menu). If ommited and menu item exists - new item will replace previous one
    // Empty or non-existent LOCATION equivalent to '+' - place item at end of menu
    // Non-existent menu_item_id treated as ommited
    'menu' => array(
    ),
  );

  protected $config = array();

  function sn_module($filename = __FILE__)
  {
    // Getting module PHP class name
    $class_module_name = get_class($this);

    // Getting module root relative to SN
    $this->manifest['root_relative'] = $module_root_relative = str_replace(array(SN_ROOT_PHYSICAL, basename($filename)), '', str_replace('\\', '/', $filename));

    // TODO: Load configuration from DB. Manifest setting
    // Trying to load configuration from file
    if(file_exists($config_filename = dirname($filename) . '/config.php'))
    {
      include($config_filename);
      $module_config_array = $class_module_name . '_config';
      $this->config = $$module_config_array;
    }

    // Registering module
    global $sn_module;
    $sn_module[$class_module_name] = $this;

    // Checking module status - is it installed and active
    $this->check_status();
    if(!$this->manifest['active'])
    {
      return;
    }

    // Overriding function if any
    if(isset($this->manifest['functions']))
    {
      global $functions;

      foreach($this->manifest['functions'] as $function_name => $override_with)
      {
        $overwrite = $override_with[0] == '*';
        if($overwrite)
        {
          $override_with = substr($override_with, 1);
        }

        if(($point_position = strpos($override_with, '.')) === false)
        {
          $override_with = array($class_module_name, $override_with);
        }
        elseif($point_position == 0)
        {
          $override_with = substr($override_with, 1);
        }
        else
        {
          $override_with = array(substr($override_with, 0, $point_position), substr($override_with, $point_position + 1));
        }

        if(!isset($functions[$function_name]))
        {
          $functions[$function_name] = array();
        }

        if($overwrite)
        {
          $functions[$function_name] = array();
        }

        $functions[$function_name][] = $override_with;
      }
    }

    // Pathcing game menu - if any
    if(isset($this->manifest['menu']))
    {
      global $sn_menu_extra;

      foreach($this->manifest['menu'] as $menu_item_name => $menu_item_data)
      {
        $sn_menu_extra[$menu_item_name] = $menu_item_data;
      }
    }
  }

  function check_status()
  {
  }
}

abstract class sn_module_payment extends sn_module
{
  static $bonus_table = array(
    100000 => 0.1,
    200000 => 0.2,
    300000 => 0.3,
    400000 => 0.4,
    500000 => 0.5,
  );

  // Function converts money values between currencies
  function currency_convert($value, $currency_from = '', $currency_to = '')
  {
    return $value;
  }

  // Function calculates bonused DM amount for bulk purchase and ($direct = false) vice versa
  static function bonus_calculate($dark_matter, $direct = true)
  {
    $bonus = 0;
    $dark_matter_new = $dark_matter;
    if(!empty(self::$bonus_table) && $dark_matter >= $bonus_table[0])
    {
      if($direct)
      {
        foreach(self::$bonus_table as $dm_for_bonus => $multiplyer)
        {
          if($dm_for_bonus <= $dark_matter)
          {
            $dark_matter_new = $dark_matter * (1 + $multiplyer);
          }
          else
          {
            break;
          }
        }
      }
      else
      {

        foreach(self::$bonus_table as $dm_for_bonus => $multiplyer)
        {
          $temp = $dm_for_bonus * (1 + $multiplyer);
          if($dark_matter >= $temp)
          {
            $dark_matter_new = round($dark_matter / (1 + $multiplyer));
          }
          else
          {
            break;
          }
        }
      }
    }

    return $dark_matter_new;
  }

  // Function calculates amount of dark_matter for entered money and vice versa
  static function exchange($dark_matter = 0, $money = 0, $currency = '')
  {
    global $config;

    if(!$dark_matter && !$money)
    {
      return 0;
    }

    $currency = $currency ? $currency : $config->payment_currency_default;
    if($money)
    {
      $dark_matter = $money * $config->payment_lot_size / $config->payment_lot_price;
/*
      $bonus = ($dark_matter - ($dark_matter % 100000)) / 100000 / 10;
      $bonus = min(0.5, $bonus);
      $dark_matter *= 1 + $bonus;
*/
      return floor($dark_matter);
    }
    elseif($dark_matter)
    {
      $money = $dark_matter * $config->payment_lot_price / $config->payment_lot_size;

      return round($money, 2);
    }
  }
}

/*
  // Function calculates amount of dark_matter for entered money and vice versa
  static function exchange($dark_matter = 0, $money = 0, $currency = '')
  {
    if(!$dark_matter && !$money)
    {
      return 0;
    }

    global $config;
    $currency = $currency ? $currency : $config->payment_currency_default;
    if($money)
    {
      $dark_matter = $money  * $config->payment_lot_size / $config->payment_lot_price;
      $bonus = ($dark_matter - ($dark_matter % 100000)) / 100000 / 10;
      $bonus = min(0.5, $bonus);
      $dark_matter *= 1 + $bonus;

      return floor($dark_matter);
    }
    elseif($dark_matter)
    {
      $money = round($dark_matter / $config->payment_lot_size * $config->payment_lot_price, 2);

      return $money;
    }
  }
}
*/
?>