document.addEventListener("DOMContentLoaded", function(){
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("modalImg");
    var images = document.querySelectorAll(".thumbnail img");
    var span = document.getElementsByClassName("close")[0];
    
    images.forEach(function(img) {
      img.addEventListener("click", function() {
        modal.style.display = "block";
        modalImg.src = this.src;
      });
    });
    
    span.addEventListener("click", function() {
      modal.style.display = "none";
    });
    
    window.addEventListener("click", function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    });
})