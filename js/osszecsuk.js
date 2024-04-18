function $_(id){
    return document.getElementById(id)
}

document.addEventListener("DOMContentLoaded", function () {
    const gombok = document.querySelectorAll(".collapse-btn");
    const tabladivek = document.querySelectorAll(".adminMenu");

    for (let i = 0; i < tabladivek.length; i++) {
        tabladivek[i].classList.add("show_item");
    }

    function toggle(index) {
        if (tabladivek[index].classList.contains("show_item")) {
            // tabladivek[index].style.display = "none";
            tabladivek[index].classList.remove("show_item");
            tabladivek[index].classList.add("hide_item");
            gombok[index].querySelector("i").classList.remove("fa-angle-down");
            gombok[index].querySelector("i").classList.add("fa-angle-up");
        } else {
            // tabladivek[index].style.display = "block";
            tabladivek[index].classList.remove("hide_item");
            tabladivek[index].classList.add("show_item");
            gombok[index].querySelector("i").classList.remove("fa-angle-up");
            gombok[index].querySelector("i").classList.add("fa-angle-down");
        }
    }

    for (let i = 0; i < gombok.length; i++) {
        gombok[i].addEventListener("click", function() {
            toggle(i);
        });
    }
});

  
  
  