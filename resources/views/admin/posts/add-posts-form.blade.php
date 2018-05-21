<?php
$author_post="";$enteredby="";$keywords="";$metadesc="";
if(!empty($postmeta))
{
  foreach($postmeta as $pm)
  {
    if($pm->meta_key=='author_post')
      $author_post = $pm->meta_value;
    if($pm->meta_key=='enterby')
      $enterby = $pm->meta_value;
    if($pm->meta_key=='keywords')
        $keywords = $pm->meta_value;
    if($pm->meta_key=='metadesc')
        $metadesc = $pm->meta_value;
  }
}
?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
  <form class="form-horizontal" name="frmAddPost" action="/admin/page/store" method="post">
	<section class="content-header">
		<div class="row">
			<div class="col-xs-8">
				<div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"> Add Page</h3>
          </div>

            <input type="hidden" name="ctype" value="page">
            <input type="hidden" name="postid" value="<?php  echo (!empty($post->id ))? $post->id : '' ?>">
    		    <div class="box-body">
              <?php //print_r($options);?>
                <div class="form-group">
                  <label for="prodTitle" class="col-sm-12 control-label lft-align">Page Title</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" name="prodTitle" id="prodTitle" placeholder="Product Title"
                    			value="<?php  echo (!empty($post->title ))? $post->title : ''; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="prodSlug" class="col-sm-12 control-label lft-align">Url</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" name="prodSlug" id="prodSlug" placeholder="Product Url"
                    			value="<?php  echo (!empty($post->clean_url ))? $post->clean_url : ''; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="description" class="col-sm-12 control-label lft-align">Description</label>
                  <div class="col-sm-12">
                    <textarea class="form-control tinymce" rows="2" name="description" id="description"><?php echo (!empty($post->content))? $post->content : ''; ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="excerpt" class="col-sm-12 control-label lft-align">Excerpt</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="excerpt" id="excerpt"><?php echo (!empty($post->excerpt))? $post->excerpt : ''; ?></textarea>
                  </div>
                </div>

            </div>
        </div>
			</div>





      <div class="col-xs-4">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Publish</h3>
            </div>
            <div class="box-body">
              <?php
                if(!empty($post->status))
                    $status=$post->status;
                else
                    $status='publish';
                //echo $status;
              ?>
              <div class="radio">
                  <label>
                    <input type="radio" name="rdoPublish" id="rdoPublish" value="publish"
                    <?php echo ($status=='publish') ? 'checked="checked"' : ''; ?>>
                    Publish
                  </label>
              </div>
              <div class="radio">
                  <label>
                    <input type="radio" name="rdoPublish" id="rdoUnpublish" value="unpublish"
                    <?php echo ($status=='unpublish') ? 'checked="checked"' : ''; ?>>
                    Pending Review
                  </label>
              </div>
              <div class="radio">
                  <label>
                    <input type="radio" name="rdoPublish" id="rdoDraft" value="draft"
                    <?php echo ($status=='draft') ? 'checked="checked"' : ''; ?>>
                    Draft
                  </label>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Category</h3>
            </div>
            <div class="box-body">
                <div class="form-group no-mar">
                  <div class="col-sm-12">
                    <div class="category-list">
                      {!! $ddlCat !!}
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Featured Image</h3>
            </div>
            <div class="box-body">
                <div class="input-group">
                 <span class="input-group-btn">
                   <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                     <i class="fa fa-picture-o"></i> Choose
                   </a>
                 </span>
                 <input id="thumbnail" class="form-control" type="text" name="featuredimage" value="<?php  echo (!empty($post->image ))? $post->image : ''; ?>">
               </div>
               <img <?php  echo (!empty($post->image ))? 'src="'.$post->image.'"' : ''; ?> id="holder" style="margin-top:15px;max-height:100px;">
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Seo</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="keywords" class="col-sm-12 control-label lft-align">Keywords</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Comma seperated Keywords"
                        value="<?php echo $keywords;?>">
                </div>
              </div>
              <div class="form-group">
                <label for="metadesc" class="col-sm-12 control-label lft-align">Meta Desc</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="metadesc" id="metadesc" placeholder="Meta Description"
                        value="<?php echo $metadesc;?>">
                </div>
              </div>
            </div>
        </div>

      </div>

		</div>
    {!! csrf_field() !!}
    </form>
	</section>
</div>
