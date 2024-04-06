let line = document.querySelector(".line");
const allTabs = document.querySelectorAll(".tabBtn");
const allContent = document.querySelectorAll(".content");
console.log(allTabs);
allTabs.forEach((tab, index)=>{
    tab.addEventListener("click", (e)=>{
        allTabs.forEach(tab=>{tab.classList.remove("active")});
        tab.classList.add("active");

        line.style.width = e.target.offsetWidth + "px";
        line.style.left = e.target.offsetLeft + "px";

        allContent.forEach(content=>{content.classList.remove("active")});
        allContent[index].classList.add("active");
    })
})
