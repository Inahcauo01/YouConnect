
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

    if(postDescription){
        postDescription.addEventListener('input', function() {
            var description = postDescription.value;
            var words = description.split(' ');

            tags = words.filter(word => word.startsWith('#') && word.indexOf(' ') === -1);
        
            // Update the hidden input field for tags
            if(tags.lenght >=1)
            document.getElementById('tags').value = tags.join(',');
        });
    }

    
    let imgPub = document.getElementById("imgshow");
    let inputImg = document.getElementById("post_image");
    
    if(inputImg){
        inputImg.onchange = (e) => {
            if (inputImg.files[0]) {
                document.querySelector('.imgshow-container').classList.remove('hide');
                imgPub.src = URL.createObjectURL(inputImg.files[0]); 
            }
        };
    }
    
    