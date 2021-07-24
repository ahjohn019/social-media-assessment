@extends('layouts.master')
@section('content')  
<div class="bg-light m-5 p-4 d-flex flex-col justify-content-center">
    <form method="post" >
        <div>
            <input name="postTitle" type="text" class="form-control" placeholder="Title" aria-label="Comment" aria-describedby="basic-addon2">
            <textarea rows="4" cols="50" placeholder="Whats On Your Mind ?" class="form-control mt-2" name="postArea"></textarea>
        </div>
        <div class="float-right mt-3">
            <button type="button" class="btn btn-success postBtn">Posts</button>
        </div>
    </form>
</div>

@foreach($posts_All as $post)
<div class="postTable bg-light m-5 p-4">
    <h5>{{$post->users->name}}</h5>
    <div id={{$post->id}} style="height:100px;" class="postContent border bg-white p-3">
        <h3 class="postName">{{$post->name}}</h3>
        <p class="postDescription">{{$post->description}}</p>
    </div>
    <div id="likes-{{$post->id}}" class="postLikes mt-2">
        <span class="postLikesValue">{{$post->likes}}</span>
        <label>Likes</label>
    </div>
    <div class="d-flex justify-content-around mt-4">
        <div class="d-flex">
            <button id={{$post->id}} type="button" class="btn btn-light likeBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                </svg>
            </button>
            <p class="ml-2">Likes</p>  
        </div>
        <div class="d-flex">
            <button type="button" class="btn btn-light commentBtn" id={{$post->id}}>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                </svg>
            </button>
            <p class="ml-2">Comments</p>
        </div>

        @if(isset($_COOKIE['authorization']) && isset($_COOKIE['userId']))
            @if($post->users->id == $_COOKIE['userId'])
                <div class="d-flex">
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#editContent-{{$post->id}}" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg>
                    </button>
                    <p class="ml-2">Edit</p>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-light delPostBtn" id="#deleteContent-{{$post->id}}" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </button>
                    <p class="ml-2">Delete</p>
                </div>
            @endif
        @endif
        
    </div>
    <div class="toogleCommentSection" id="toogleCommentSection-{{$post->id}}">
        <div class="input-group mb-3">
            <input type="text" name="comment" class="form-control" placeholder="Write Your Comment" aria-label="Comment" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button id={{$post->id}} class="btn btn-outline-secondary postComment" type="button">Posts</button>
            </div>
        </div>
        <button class="btn btn-primary viewAllComment" type="submit" id="{{$post->id}}">
            View All Comments 
        </button>
        <div class="commentContainer" id="viewComment-{{$post->id}}">
            @foreach($comments_All as $comments)    
                @if($post->id == $comments->posts_id)
                    <div class="bg-white p-2 border-bottom commentSection" id="comment-{{$comments->id}}">
                        <span class="commentName">{{$comments->name}}</span>
                        <label>{{$comments->created_at}}</label>
                        <p class="font-weight-bold">{{$comments->users->name}}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div> 

<!-- Edit Content Modal -->
<div class="modal fade" id="editContent-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="editContentTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title editTitle" id="editContentLongTitle">{{$post->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <input type="text" value="{{$post->description}}" class="form-control editDescription"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary editBtn" id="editBtn-{{$post->id}}">Edit</button>
      </div>
    </div>
  </div>
</div>
@endforeach
{!! $posts_All->links() !!}
@stop
