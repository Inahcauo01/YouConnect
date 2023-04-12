
function updatePost(postID,postDesc,postImg,userName,userImg){
    console.log(postID+" | postdesc:"+postDesc+" | imgpost:"+postImg+" | username:"+userName+" | userimg:"+userImg)
    document.querySelector(".user-img").innerHTML  = `<img src="${userImg}" alt="User Avatar">`;
    document.querySelector(".name-user").innerHTML = userName;
    document.querySelector("#postId_up").value     = postID;
    document.querySelector("#post_desc_up").value  = postDesc;
    document.querySelector(".img-post").innerHTML  = `<img src="/images/${postImg}" alt="post image">`;

}

function modifier(postId, postDesc){
    $.ajax({
        url: "/feed",
        type: "POST",
        data: { postId: postId, postDesc: postDesc },
        success: function(response) {
            console.log("la modification a bien été effectuée !");
            
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
        }
    });
}

function liking(postId){
    // document.querySelector("#click-like-"+postId).click();
}