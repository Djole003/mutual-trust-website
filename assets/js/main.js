AOS.init({
    duration: 1000,
    once: true
});



document.addEventListener("DOMContentLoaded", function () {

    const counters = document.querySelectorAll('.counter');

    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        let count = 0;
        const speed = 20;
        const increment = target / 100;

        const update = () => {
            count += increment;

            if (count < target) {
                counter.innerText = Math.ceil(count);
                setTimeout(update, speed);
            } else {
                counter.innerText = target;
            }
        };

        update();
    });

});



document.querySelectorAll(".faq-question").forEach(question => {
    question.addEventListener("click", () => {
        const item = question.parentElement;

        document.querySelectorAll(".faq-item").forEach(i => {
            if (i !== item) i.classList.remove("active");
        });

        item.classList.toggle("active");
    });
});


const hamburger = document.getElementById("hamburger");
const navMenu = document.getElementById("nav-menu");
const navLinks = document.querySelectorAll("#nav-menu a");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
});

/* Zatvaranje menija kad klikneš link */

navLinks.forEach(link => {
    link.addEventListener("click", () => {
        hamburger.classList.remove("active");
        navMenu.classList.remove("active");
    });
});


document.querySelectorAll(".service-card").forEach(card => {

card.addEventListener("mouseenter", () => {

card.style.transform = "translateY(-10px) scale(1.02)";

});

card.addEventListener("mouseleave", () => {

card.style.transform = "translateY(0) scale(1)";

});

});

document.querySelectorAll(".service-card").forEach(card => {

card.addEventListener("click", () => {

card.classList.toggle("active");

});

});

function closePopup(){

document.getElementById("success-popup").classList.remove("show");

}

document.addEventListener("DOMContentLoaded", function(){

const popup = document.getElementById("success-popup");

if(popup && popup.dataset.show === "true"){

popup.classList.add("show");

}

});

const form = document.querySelector(".contact-form form");

if(form){

form.addEventListener("submit",function(){

const btn = form.querySelector(".submit-btn");

btn.classList.add("loading");

});

}