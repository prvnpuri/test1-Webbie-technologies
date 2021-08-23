<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{

    public static function menuWithChildren($menus,$parent_id){
            
        $childs=array_filter( $menus,function($item)use($parent_id){
            return $item["parent_id"]==$parent_id;
        });

        array_splice($menus,0,count($childs),$childs);
      //  $menu_ids=array_column($menus,"id");
        // array_walk($childs,function($menu)use(&$menus,$menu_ids){
        //     $indx=array_search( $menu["id"], $menu_ids);
        //     unset( $menus[ $indx]);
        // });
        array_walk($childs,function(&$menu)use($menus){
            $parent_id=$menu["id"];
            $menu["children"]=self::menuWithChildren($menus,$parent_id);
        });
        return count($childs)>0?array_values($childs):[];
    }

}
