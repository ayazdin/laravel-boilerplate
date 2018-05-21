<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">

		@if(!empty($posts))
		<div class="row">
	    	<div class="col-xs-12">
		      	<div class="box">
		      		<div class="box-header">
		      			<h3 class="box-title">Posts</h3>
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
						    <tr>
							    <th>Title</th>
		          		<th>Excerpt</th>
							    <th>Published</th>
							    <th></th>
						    </tr>
                <!--inject('post', 'App\Http\Controllers\Posts\PostsController')-->
							@foreach ($posts as $post)
							<tr>
              	<td>{{ $post->title }}</td>
                <td>{{ $post->excerpt }}</td>
                <td>{!! $post->created_at!!}</td>
              	<td>
									<a href="/admin/page/edit/{{$post->id}}">Edit</a> |
									<a href="/admin/post/delete/{{$post->id}}">Delete</a>
								</td>
              </tr>
							@endforeach
						</table>
			        </div>
				</div>
			</div>
		</div>
		<div class="row">
	    	<div class="col-xs-12">
		      	<div class="box box-default box-solid">
		      		<div class="box-body">
		              {{ $posts->links('admin.partials.paginators') }}
		            </div>
			    </div>
			</div>
		</div>
		@endif
	</section>
</div>
