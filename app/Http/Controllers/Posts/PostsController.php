<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use DB;
use App\Http\Controllers\Posts\PostCatController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPosts()
    {
      $posts = Posts::where('ctype', '=', 'posts')
                          ->orderBy('updated_at', 'DESC')->paginate(25);
      return view('admin.posts.posts')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new Products.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPosts()
    {
        $catCtrl = new PostCatController();
        $ddlCat = $catCtrl->getCategoryList('li');
        $proType = Postcat::where('type','=', 'posts')->orderBy('catorder', 'ASC')->get();
        $typeLi = $catCtrl->getCategoryLi($proType);

        return view('admin.posts.add-posts')->with('ddlCat', $ddlCat)
                                                    ->with('proType', $typeLi);
                                                  //->with('sliders', $sliders);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProductCategory($id='')
    {
        $postcat = Postcat::where('type', '=', 'category')
                            ->where('parent', '=', '0')
                            ->orderBy('catorder', 'ASC')
                            ->paginate(25);
        if($id!="")
        {
          $editcat = Postcat::where('id', $id)->first();
          return view('yala-admin.posts.add-category')->with('postcat', $postcat)
                                                      ->with('editcat', $editcat)
                                                      ->with('categoryType', 'category');
        }
        return view('yala-admin.posts.add-category')->with('postcat', $postcat)
                                                    ->with('categoryType', 'category');
    }

    /**
     * Show the form for creating a new Category for home page sliders.
     *
     * @return \Illuminate\Http\Response
     */
    public function createHomeCategory($id='')
    {
        $hSlider = Posts::where('ctype', '=', 'home')
                            ->orderBy('menu_order', 'ASC')
                            ->paginate(25);

        if($id!="")
        {
          $editSlider = Posts::where('id', $id)->first();
          return view('yala-admin.posts.add-home-slider')->with('slider', $hSlider)
                                                      ->with('editslider', $editSlider)
                                                      ->with('cType', 'home');
        }
        return view('yala-admin.posts.add-home-slider')->with('slider', $hSlider)
                                                    ->with('cType', 'home');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //$pc = new PostsController();
      try{
          if(Auth::check())
              $user = Auth::user();
          if($request['postid']!="")
            $posts = Posts::where('id', $request['postid'])->first();
          else
            $posts = new Posts();

          $posts->title = $request['prodTitle'];

          if($request['description']!="")
            $posts->content = $request['description'];
          if($request['excerpt']!="")
            $posts->excerpt = $request['excerpt'];

          $posts->status = $request['rdoPublish'];
          $posts->ctype = $request['ctype'];
          $posts->userid = $user->id;

          if($request['postid']!="")
            $posts->update();
          else
            $posts->save();

          $this->addAttributes('author_post', $request['author_post'], $posts->id);
          $this->addAttributes('enterby', $request['enterby'], $posts->id);
      }
      catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
          $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
      }
      if($request['postid']!="")
        $request->session()->flash('succ', 'One item updated successfully!!!');
      else
        $request->session()->flash('succ', 'One item added successfully!!!');
      return back();
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCategory(Request $request)
    {
      try {
        //$cmn = new CommonController();
        if($request['catid']!="")
          $postcat = Postcat::where('id', $request['catid'])->first();
        else
          $postcat = new Postcat();

        $postcat->name = $request['catName'];
        if(empty($request['slug']))
          $slug = $this->generateSeoURL($request['catName']);
        else
          $slug = $request['slug'];
        if(!empty($request['categoryType']))
          $postcat->type = $request['categoryType'];
        else
          $postcat->type = 'category';
        $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
        $postcat->parent = $request['subCat'];
        $postcat->image = $request['filepath'];
        //echo $postcat->slug;exit;
        if($request['catid']!="")
        {
            $postcat->update();
    				$request->session()->flash('succ', 'One item updated successfully!!!');
    		}
    		else
    		{
    				$postcat->save();
    				$request->session()->flash('succ', 'One item added successfully!!!');
    		}

      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
          $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
      }
      return redirect('/admin/product/category/add');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPost($id)
    {
      try {
          Postmeta::where('postid', $id)->delete();
          Posts::destroy($id);
      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
      }
      return back()->with('succ', 'One item deleted');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCategory($id)
    {
      try {
          Postcat::destroy($id);
      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
      }
      return back()->with('succ', 'One item deleted');
    }


    /* --------------------------- Page controller --------------------------*/
    public function generateSeoURL($string, $wordLimit = 0)
		{
		    $separator = '-';

		    if($wordLimit != 0){
		        $wordArr = explode(' ', $string);
		        $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
		    }

		    $quoteSeparator = preg_quote($separator, '#');

		    $trans = array(
		        '&.+?;'                    => '',
		        '[^\w\d _-]'            => '',
		        '\s+'                    => $separator,
		        '('.$quoteSeparator.')+'=> $separator
		    );

		    $string = strip_tags($string);
		    foreach ($trans as $key => $val){
		        //$string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
						$string = preg_replace('#'.$key.'#i', $val, $string);
		    }

		    $string = strtolower($string);

		    return trim(trim($string, $separator));
		}

    public function getUniqueSlug($s, $catid="")
    {
      if($catid!="")
        $postcat = Postcat::where('slug', $s)
                            ->where('id', '<>', $catid)
                            ->first();
      else
        $postcat = Postcat::where('slug', $s)->first();
      if(!empty($postcat))
        return $postcat->slug."-".date('md');
      else
        return $s;
    }

    public function addAttributes($metaKey, $metaValue, $postid)
    {
      if($metaValue=="")
        $metaValue="";
      //{
        $hasAtt = Postmeta::where('postid', $postid)
                              ->where('meta_key', '=', $metaKey)->first();
        if(!empty($hasAtt))
          $postMeta = Postmeta::where('postid', $postid)
                              ->where('meta_key', '=', $metaKey)->first();
        else
          $postMeta = new Postmeta();
        $postMeta->postid = $postid;
        $postMeta->meta_key = $metaKey;
        $postMeta->meta_value = $metaValue;
        if(!empty($hasAtt))
          $postMeta->update();
        else
          $postMeta->save();

      //}
    }

    public function getMetaValue($metakey, $postid)
    {
      if($metakey!="" and $postid!="")
      {
        $metavalue = Postmeta::where('postid', '=', $postid)
                                ->where('meta_key', '=', $metakey)->first();
        if(!empty($metavalue))
          return $metavalue->meta_value;
      }
        return "";
    }

    public function getCategoryName($slug="", $id="")
    {
      if($slug!="")
      {
        $catName = Postcat::where('slug', '=', $slug)->first();
        return $catName->name;
      }
      elseif($id!="")
      {
        $catName = Postcat::where('id', '=', $id)->first();
        return $catName->name;
      }
      else
        return "";
    }

    public function getSubCategory($id, $isa)
    {
      $cats = Postcat::where('parent', '=', $id)->get();
      if($isa==true)
        return response()->json(['response' => 'This is post method']);
      else
        return $cats;
    }

    public function addCategoryRelation($categories, $postid)
    {
      //print_r($categories);exit;
      if(!empty($categories))
      {
        $cr = new Cat_relation();
        $cr->where('postid', $postid)->delete();

        foreach($categories as $c)
        {
          $crs = new Cat_relation();
          $crs->postid = $postid;
          $crs->catid = $c;
          $crs->save();
        }
      }
    }

    public function getPostsByType($type="product", $paging=false)
    {
      if($paging==true)
        $posts = Posts::where('ctype', '=', $type)->paginate(25);
      else
        $posts = Posts::where('ctype', '=', $type)->get();
      return $posts;
    }

    public function getPostByField($fieldName, $fieldValue, $operator='=')
    {
      $post = Posts::where($fieldName, $operator, $fieldValue)->get();
      return $post;
    }

    public function getThumbnail($image)
    {
      return substr_replace($image, '/thumbs/', strrpos($image, "/"), 0);
    }



}
