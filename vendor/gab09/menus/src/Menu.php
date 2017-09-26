<?php
namespace Menus;

// use \Illuminate\Database\Eloquent\Model;
use Baum\Node;


/**
* Menu
*/
class Menu extends Node {

  /**
   * Table name.
   *
   * @var string
   */
  protected $table = 'menus';

  protected $unguard = true;


  /* —————————  RELATIONS  —————————————————*/

  public function role()
  {
    return $this->belongsTo('Menus\Role');
  }


  /**
   * Construit un tableau destiné à la liste de sélection pour un input de type select :
   *
   * @return Response
   */
  public static function listForInputSelect() {
    $menus = Menu::roots()->orderBy('id')->get();

    $menuslist[0] = 'Faire de cet item une racine';

    foreach ($menus as $menu)
    {
      $menuslist[$menu->etiquette][$menu->id] = 'Placer juste sous “'.$menu->etiquette.'”';
      foreach($menu->getImmediateDescendants() as $item)
      {
        $menuslist[$menu->etiquette][$item->id] = '• Enfant de '.$item->etiquette;
        foreach($item->getImmediateDescendants() as $item2)
        {
          $menuslist[$menu->etiquette][$item2->id] = '•• Enfant de '.$item2->etiquette;
        }
      }
    }
    return $menuslist;
  }

  /**
   * Trie les collections des descendants d'un node par "rang"
   *
   * @return collection
   */
  public static function immediateDescSortByRang($menu) {
    $collection = $menu->getImmediateDescendants();
//    var_dump($collection); // CTRL

    $collection = $collection->sortBy(function($collection)
    {
      return $collection->rang;
    });

    return $collection;
  }

}
  /* —————————  MUTATORS  —————————————————*/