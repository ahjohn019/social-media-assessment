$(document).ready(function() {
    let dc = document.cookie;
    let prefix = "authorization=";
    let checkAuth = dc.split(prefix).length;
    let comments;
    const authCookie = checkAuth <=1 ? null : dc.split('; ').find(row => row.startsWith(prefix)).split('=')[1];

    //Hide The Comment Section
    $('.commentContainer').hide();
    $('.toogleCommentSection').hide();

    //Post the posts content
    $('.postBtn').click(function(event){
        event.preventDefault();
        let postTitle = $("input[name=postTitle]").val();
        let postArea = $("textarea[name=postArea]").val();
    
        $.ajax({
            url:'/api/get_user',
            type:'GET',
            data: {
                token: authCookie
            },
            success:function (response){
                $.ajax({
                    url:'/api/posts', 
                    type: "POST", 
                    data:{
                        "name":postTitle,
                        "description":postArea,
                        "user_id": response.user ? response.user.id : null
                    },
                    headers:{"Authorization": "Bearer "+ authCookie},
                    success:function(response){
                        window.location.reload();
                    }
                })
            }
        })
    });

    //View All Comment
    $('.viewAllComment').click(function(event){
        let getViewAll = $(this).attr("id")
        let getViewAllContainer = document.getElementById("viewComment-"+getViewAll)

        if (getViewAllContainer.style.display === "none") {
            getViewAllContainer.style.display = "block";
        } else {
            getViewAllContainer.style.display = "none";
        }
    })

    //Toogle Comment Button
    $('.commentBtn').click(function(event) {
        let toggleCommentId = $(this).attr("id")
        let toggleCommentSection = document.getElementById("toogleCommentSection-"+toggleCommentId)

        if (toggleCommentSection.style.display === "none") {
            toggleCommentSection.style.display = "block";
        } else {
            toggleCommentSection.style.display = "none";
        }
    });


    //register User
    $('.regBtn').click(function(event) {
        event.preventDefault();
        let email = $("input[name=email]").val();
        let fname = $("input[name=fname]").val();
        let pwd = $("input[name=pwd]").val();

        $.ajax({
            url:"/api/register",
            type:"POST",
            data:{
                email:email,
                name:fname,
                password:pwd
            },
            success:function(response){
                console.log(response);
            }
        })
    });

    $('.loginBtn').click(function(event) {
        event.preventDefault();

        let email = $("input[name=email]").val();
        let pwd = $("input[name=pwd]").val();
        
        $.ajax({
            url:"/api/login",
            type:"POST",
            data:{
                email:email,
                password:pwd
            },
            success:function(response){
                console.log(response);
                document.cookie = "authorization="+ response.token;
                if(response.error){
                    return null;
                }
                $.ajax({
                    url:'/api/get_user',
                    type:'GET',
                    data: {
                        token: response.token
                    },
                    success:function(response){
                        document.cookie = "userId="+ response.user.id;
                        window.location = "/";
                    }
                })
            }
        })
    });

    $('.logoutBtn').click(function(event) {
        const logoutCookie = document.cookie.split('; ').find(row => row.startsWith('authorization=')).split('=')[1];
        console.log(logoutCookie);
        $.ajax({
            url:"/api/logout",
            type:"GET",
            data:{
                token: logoutCookie
            },
            success: function(response){
                console.log(response);
                document.cookie = 'authorization' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                document.cookie = 'userId' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                window.location.reload();
            }
        })
    });

    $('input[type="text"]').change(function(){comments = this.value}).val();
        
    $('.postComment').click(function(event) {
        event.preventDefault();
        let getposts = $(this).attr("id");

        $.ajax({
            url:'/api/get_user',
            type:'GET',
            data: {
                token: authCookie
            },
            success:function(response){
                //if user id same with comment id, append else no
                $.ajax({
                    url:'/api/comments',
                    type:'POST',
                    data:{
                        name:comments,
                        posts_id:getposts,
                        user_id:response.user.id
                    },
                    success:function(response){
                        window.location.reload();
                    }
            })
        }})
    })

    $('.likeBtn').on('click', function(){
        
        let getLikesId = $(this).attr("id");
        let postName = document.getElementById(getLikesId).getElementsByClassName("postName")[0].innerHTML;
        let postDesc = document.getElementById(getLikesId).getElementsByClassName("postDescription")[0].innerHTML;

        $.ajax({
            url:'/api/get_user',
            type:'GET',
            data: {
                token: authCookie
            },
            success:function(response){
               $.ajax({
                    url:'/api/posts/'+getLikesId, 
                    type: "GET", 
                    data: {
                        token: authCookie
                    },
                    success:function(response){
                        var getLikesCount = response.likes + 1;
                        $.ajax({
                            url:'/api/posts/'+getLikesId, 
                            type: "PUT", 
                            data:{
                                "name":postName,
                                "description":postDesc,
                                "likes":getLikesCount,
                                "user_id": response.user ? response.user.id : null
                            },
                            headers:{"Authorization": "Bearer "+ authCookie},
                            success:function(response){
                                document.getElementById("likes-"+getLikesId).getElementsByClassName("postLikesValue")[0].innerHTML = getLikesCount;
                            }
                        })
                    }, error:function(response){
                        alert("Please Login Your Account");
                    }
            })
        }
    })
    })

    $('.editBtn').on('click', function(){
        let getEditBtnId = $(this).attr("id");
        let getEditBtnInt = getEditBtnId.match(/(\d+)/);
        let editTitle = document.getElementById("editContent-"+getEditBtnInt[0]).getElementsByClassName("editTitle")[0].innerHTML;
        let editDesc = document.getElementById("editContent-"+getEditBtnInt[0]).getElementsByClassName("editDescription")[0].value;

        $.ajax({
            url:'/api/get_user',
            type:'GET',
            data: {
                token: authCookie
            },
            success:function(response){
                $.ajax({
                    url:'/api/posts/'+getEditBtnInt[0], 
                    type:'GET',
                    data: {
                        "token": authCookie
                    },
                    success:function(response){
                        let getExistLikes = response.likes;
                        $.ajax({
                            url:'/api/posts/'+getEditBtnInt[0], 
                            type:'PUT',
                            data:{
                                "name":editTitle,
                                "description":editDesc,
                                "likes":getExistLikes,
                                "user_id": response.user ? response.user.id : null
                            },
                            headers:{"Authorization": "Bearer "+ authCookie},
                            success:function(response){
                                window.location.reload();
                            }
                        })
                    }
                })
            }
        })
    })

    $('.delPostBtn').on('click',function(){
        let getDelBtnId = $(this).attr("id");
        let getDelBtnInt = getDelBtnId.match(/(\d+)/);
        function delPosts(){
            $.ajax({
                url:'/api/posts/'+ getDelBtnInt[0],
                type:'DELETE',
                headers:{"Authorization": "Bearer "+ authCookie},
                success:function(response){
                    console.log(response);
                    window.location.reload();
                }
            })
        }
         $.ajax({
            url:'/api/comments',
            type:'GET',
            success:function(response){
                var commentList = response.data;
                if(commentList.length == 0){
                    delPosts();
                } else {
                    commentList.forEach(function(comment){
                        if(getDelBtnInt[0] == comment.posts_id){
                            $.ajax({
                                url:'/api/comments/'+ comment.id,
                                type:'DELETE',
                                success:function(response){
                                    console.log(response);
                                }
                            })
                        }
                    })
                    delPosts();
                }
            }
        })
            
    })
});