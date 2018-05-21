<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use App\Http\Controllers\Admin\Posts\PostsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPage()
    {
      $pages = Posts::where('ctype', '=', 'pages')
                          ->orderBy('updated_at', 'DESC')->paginate(25);
        return view('admin.pages.pages')->with('pages', $pages);
    }

    /**
     * Show the form for creating a new Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPage()
    {
        return view('admin.pages.add-pages');
    }


    /**
     * Show the form for edit Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function editPage($id)
    {
        $post = Posts::where('id', $id)->first();
        //print_r($post->postmeta);
        return view('admin.pages.add-pages')->with('post', $post)
                                                              ->with('postmeta', $post->postmeta);
    }

    public function store(Request $request)
    {
      $pc = new PostsController();
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

          $pc->addAttributes('author_post', $request['author_post'], $posts->id);
          $pc->addAttributes('enterby', $request['enterby'], $posts->id);
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
      //return redirect('/admin/product/add');
    }

}
