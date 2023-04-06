// document.querySelector(".comment-actions").addEventListener("mouseout",()=>{
//     setTimeout(()=>{
//         document.querySelector(".delet-btn-cmt").classList.add("hide")
//     },1500)
// })

// function changeComment(commentId){
//     document.querySelector("#edit-comment-in-"+commentId).value = document.querySelector("#coment-content-out-"+commentId).value
// }

document.querySelector("#edit-comment-in-19").addEventListener("keyup",()=>{
    console.log(document.querySelector("#edit-comment-in-19").value)
})
document.querySelector(".edit-btn-cmt").addEventListener("click", ()=>{
    console.log("clicked   : "+document.querySelector("#edit-comment-in-19").value)
})