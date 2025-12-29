const btns = document.querySelectorAll(".btn");
const available = document.querySelector("#avail");
const Booked = document.querySelector("#Booked");

available.classList.add("active");

btns.forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();
    btns.forEach((btn) => {
      btn.classList.remove("active");
    });
    this.classList.add("active");
  });
});
