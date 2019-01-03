<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */


  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class ht_theme_color {
    public $code;
    public $group;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);
      $this->title = CLICSHOPPING::getDef('module_header_tags_theme_color_title');
      $this->description = CLICSHOPPING::getDef('module_header_tags_theme_color_description');

      if ( defined('MODULE_HEADER_TAGS_THEME_COLOR_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_THEME_COLOR_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_THEME_COLOR_STATUS == 'True');
      }
    }

    public function execute() {
      $CLICSHOPPING_Template = Registry::get('Template');

      $CLICSHOPPING_Template->addBlock('<meta name="theme-color" content="' . MODULE_HEADER_TAGS_THEME_COLOR_CODE . '"/>' . "\n", $this->group);
    }


    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('MODULE_HEADER_TAGS_THEME_COLOR_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Do you want activate this module ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_THEME_COLOR_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Do you want activate this module ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Please insert the color code in hexadecimal ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_THEME_COLOR_CODE',
          'configuration_value' => '#317EFB',
          'configuration_description' => 'Insert the color code in hexadecimal  ?',
          'configuration_group_id' => '6',
          'sort_order' => '21',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );


      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Sort order',
          'configuration_key' => 'MODULE_HEADER_TAGS_THEME_COLOR_SORT_ORDER',
          'configuration_value' => '50',
          'configuration_description' => 'Sort order (the loest is diplayed in first)',
          'configuration_group_id' => '6',
          'sort_order' => '25',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );
    }

    public function remove() {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }

    public function keys() {
      return ['MODULE_HEADER_TAGS_THEME_COLOR_STATUS',
              'MODULE_HEADER_TAGS_THEME_COLOR_CODE',
              'MODULE_HEADER_TAGS_THEME_COLOR_SORT_ORDER'
            ];
    }
  }

