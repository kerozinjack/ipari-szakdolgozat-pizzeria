document.addEventListener("DOMContentLoaded", function () {
    const kartyak = document.querySelectorAll(".hidden-card");

    function checkScroll() {
        for (var i = 0; i < kartyak.length; i++) {
            var card = kartyak[i];
            if (isElementInViewport(card)) {
                card.classList.add("card-reveal");
            } else {
                card.classList.remove("card-reveal");
            }
        }
    }
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.bottom >= 0 &&
            rect.right >= 0 &&
            rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.left <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    window.addEventListener("scroll", checkScroll);
    checkScroll(); 
});