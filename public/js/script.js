
function updatePost(postID,postDesc,postImg,userName,userImg){
    console.log(postID+" | postdesc:"+postDesc+" | imgpost:"+postImg+" | username:"+userName+" | userimg:"+userImg)
    document.querySelector(".user-img").innerHTML  = `<img src="${userImg}" alt="User Avatar">`;
    document.querySelector(".name-user").innerHTML = userName;
    document.querySelector("#postId_up").value     = postID;
    document.querySelector("#post_desc_up").value  = postDesc;
    document.querySelector(".img-post").innerHTML  = `<img src="/images/${postImg}" >`;

}


function liking(postId){
    document.querySelector("#click-like-"+postId).click();
}


    var postDescription = document.getElementById('post-description');
    var tags = [];

    postDescription.addEventListener('input', function() {
        var description = postDescription.value;
        var words = description.split(' ');

        tags = words.filter(word => word.startsWith('#') && word.indexOf(' ') === -1);
    
        // Update the hidden input field for tags
        document.getElementById('tags').value = tags.join(',');
    });


// $(document).ready(function(){
//     var down = false;
//     $('#bell').click(function(e){
//         var color = $(this).text();
//         if(down){
            
//             $('#box').css('height','0px');
//             $('#box').css('opacity','0');
//             down = false;
//         }else{
            
//             $('#box').css('height','auto');
//             $('#box').css('opacity','1');
//             down = true;
            
//         }
//     });
            
// });

    