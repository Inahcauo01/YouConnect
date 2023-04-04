document.querySelector(".coment-content-input").addEventListener("focus",()=>{
    document.querySelector(".edit-btn-cmt").classList.remove("hide")
})

document.querySelector(".coment-content-input").addEventListener("blur",()=>{
    document.querySelector(".edit-btn-cmt").classList.add("hide")
})

document.querySelector(".comment-actions").addEventListener("mouseover",()=>{
    document.querySelector(".delet-btn-cmt").classList.remove("hide")
})
document.querySelector(".comment-actions").addEventListener("mouseout",()=>{
    setTimeout(()=>{
        document.querySelector(".delet-btn-cmt").classList.add("hide")
    },1200)
    
})
