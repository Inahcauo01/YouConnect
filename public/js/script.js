document.querySelector(".coment-content-input").addEventListener("focus",()=>{
    document.querySelector(".edit-btn-cmt").classList.remove("hide")
})

document.querySelector(".coment-content-input").addEventListener("blur",()=>{
    document.querySelector(".edit-btn-cmt").classList.add("hide")
    document.querySelector("#form-edit-comment").reset()
})

document.querySelector(".comment-actions").addEventListener("mouseover",()=>{
    document.querySelector(".delet-btn-cmt").classList.remove("hide")
})
