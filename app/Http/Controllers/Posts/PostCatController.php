<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostCatController extends Controller
{
  public function getCategoryList($list="", $sel="")
  {
    $parents = $this->getParent();
    foreach($parents as $p)
    {//echo $p->id;exit;
      $subCat = $this->hasChild($p->id);
      if($subCat!==false)
        $categories[] = array('id' => $p->id, 'name' => $p->name, 'subcategory' => $subCat);
      else
        $categories[] = array('id' => $p->id, 'name' => $p->name);
    }

    if($list=="li")
    {
      $output="";
      if(!empty($categories))
      {//print_r($categories);exit;
        $output .= '<ul>';
        $output .= $this->getCategoryLi($categories, $sel);
        $output .= '</ul>';
      }
      //echo $output;exit;
      return $output;
    }
    else
      return $categories;
  }

  public function getParent()
  {
    return Postcat::where('type', '=', 'category')
                        ->where('parent', '=', '0')
                        ->get();
  }

  public function hasChild($id)
  {
    $categories = Postcat::where('parent', '=', $id)->get();
    if($categories->isNotEmpty())
    {//print_r($categories);exit;
      foreach($categories as $category)
      {
        $subCat = $this->hasChild($category->id);
        if($subCat!==false)
          $cat[] = array('id' => $category->id, 'name' => $category->name, 'subcategory' => $subCat);
        else
          $cat[] = array('id' => $category->id, 'name' => $category->name);
      }
      return $cat;
    }
    else
      return false;
  }

  public function getCategoryLi($categories, $sel="")
  {
    $output = "";
    if(!empty($categories))
    {//echo "herer ";print_r($categories);exit;
      //echo "ksdjhfksjdf";print_r($sel);exit;
      foreach($categories as $cat)
      {
        if($sel!="")
        {
          if(in_array($cat['id'], $sel))
            $output .='<li><label><input type="checkbox" name="category[]" checked value="'.$cat['id'].'"></label> '.$cat['name'];
          else
            $output .='<li><label><input type="checkbox" name="category[]" value="'.$cat['id'].'"></label> '.$cat['name'];
        }
        else
          $output .='<li><label><input type="checkbox" name="category[]" value="'.$cat['id'].'"></label> '.$cat['name'];
        if(!empty($cat['subcategory']))
        { //print_r($cat['subcategory']);exit;
          $output .='<ul>';
          $output .=$this->getCategoryLi($cat['subcategory'], $sel);
          $output .='</ul></li>';
        }
        else
          $output .= '</li>';
      }
    }
    //echo $output;exit;
    return $output;
  }

  /* gets the categories of the post
   * Parameter: post id whose categories to be returned
   * Returns array of categories
   */
  public function getPostCategories($postid)
  {
      $cat="";
      $categories = Cat_relation::where('postid', '=', $postid)->get();
      foreach($categories as $category)
      {
        $cat[]=$category->catid;
      }
      return $cat;
  }

  /* gets the products id list of the categories
   * Parameter: Category id array
   * Returns array of products id
   */
  public function getRelationProduct($cats)
  {
    $products="";
    //$products = Cat_relation::where('postid', '=', $postid)->get();
    $results = Cat_relation::where(function ($q) use ($cats) {
        foreach ($cats as $c) {
            $q->orWhere('catid', '=', $c);
        }
    })->get();
    //print_r($results);
    //echo "Search index: ".$results->search($postid);

          //->where('postid', '!=', $postid);
    $products = Posts::where(function ($q) use ($results) {
        foreach ($results as $result) {
            $q->orWhere('id', '=', $result->postid);
        }
    })->get();
    return $products;

  }

}
