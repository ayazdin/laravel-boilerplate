<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="row">
      <div class="col-sm-8 col-xs-12">
				<div class="box box-primary">
        		<div class="box-header with-border">
        			<h3 class="box-title">Product Category</h3>
        		</div>
            <div class="box-body table-responsive no-padding">
              @if(!empty($succ))
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> {{ $succ }}
              </div>
              @endif
              @if(!empty(session('succ')))
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> {{ session('succ') }}
              </div>
              @endif
              <table class="table table-hover">
              <tbody><tr>
                <th>Name</th>
                <th>Image</th>
                <th>Slug</th>
                <!-- <th>Order</th> -->
                <th></th>
              </tr
              @if(!empty($postcat) and $postcat->count()>0)
              @foreach ($postcat as $cat)
              <tr>
                <td>{{ $cat->name }}</td>
                <td>@if($cat->image!="") <img src="{{ $cat->image }}" width="40" alt="{{ $cat->name }}"> @endif</td>
                <td>{{ $cat->slug }}</td>
                <!-- <td></td> -->
                <td>
                  <a href="/admin/product/category/add/{{ $cat->id }}">Edit</a> |
                  <a href="/admin/product/category/delete/{{ $cat->id }}">Delete</a>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody></table>
            </div>
		      	<div class="box-footer">
		              {{ $postcat->links('yala-admin.partials.paginators') }}
			    	</div>

        </div>
      </div>
			<div class="col-sm-4 col-xs-12">
				<div class="box box-primary">
		      		<div class="box-header with-border">
		      			<h3 class="box-title">Add Category</h3>
		      		</div>

		      		<form class="form-horizontal" name="frmAddCategory" action="/admin/post/store-category" method="post">
                @if(!empty($editcat))
                  <input type="hidden" name="catid" value="{{ $editcat->id }}">
                @endif
								<input type="hidden" name="categoryType" value="{{$categoryType}}">
		      		<div class="box-body">
		                <div class="form-group">
		                  <label for="catName" class="col-sm-12 control-label lft-align">Category</label>
		                  <div class="col-sm-12">
		                    <input type="text" class="form-control" name="catName" id="catName" placeholder="Category name"
		                    			value="{{!empty($editcat) ? $editcat->name : '' }}">
		                  </div>
		                </div>
										<div class="form-group">
		                  <label for="catName" class="col-sm-12 control-label lft-align">Parent</label>
		                  <div class="col-sm-12">
		                    <select name="subCat" id="subCat" class="form-control ">
													<option value="0">Please Select</option>
													@if(!empty($postcat) and $postcat->count()>0)
							              @foreach ($postcat as $cat)
															@if($cat->parent=="0")
																@if(!empty($editcat))
																	<option value="{{$cat->id}}" @if($cat->id==$editcat->parent) selected  @endif>{{$cat->name}}</option>
																@else
																	<option value="{{$cat->id}}">{{$cat->name}}</option>
																@endif
															@endif
														@endforeach
													@endif
												</select>
		                  </div>
		                </div>
		                <div class="form-group">
		                  <label for="slug" class="col-sm-12 control-label lft-align">Slug</label>
		                  <div class="col-sm-12">
		                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug"
		                    			value="{{!empty($editcat) ? $editcat->slug : '' }}">
		                  </div>
		                </div>
                    <div class="non-pad col-sm-12">
                      <div class="input-group">
                       <span class="input-group-btn">
                         <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                           <i class="fa fa-picture-o"></i> Choose
                         </a>
                       </span>
                       <input id="thumbnail" class="form-control" type="text" name="filepath" value="{{!empty($editcat) ? $editcat->image : '' }}">
                     </div>
                     <div>
                     <img id="holder" style="margin-top:15px;max-height:100px;" src="{{!empty($editcat) ? $editcat->image : '' }}">
                   </div>
                   </div>


			        </div>

			        <div class="box-footer">
			            <button type="submit" class="btn btn-default">Save</button>
		            </div>
		            {!! csrf_field() !!}
		            </form>

		      	</div>
			</div>
		</div>

	</section>
</div>
