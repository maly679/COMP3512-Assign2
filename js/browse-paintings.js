document.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".ui_form").addEventListener("click", (e) => {
    //event deligation
    // row5 row6 row7 id for radiobuttons
    // boxrow4 5 6 7
    if (e.target && e.target.matches("#radioBefore")) {
      console.log("clicked on before");
      document.querySelector("#inputBefore").removeAttribute("disabled");
      document.querySelector("#inputAfter").disabled = true;
      document.querySelector("#inputBetween1").disabled = true;
      document.querySelector("#inputBetween2").disabled = true;
    } else if (e.target && e.target.matches("#radioAfter")) {
      console.log("clicked on after");
      document.querySelector("#inputBefore").disabled = true;
      document.querySelector("#inputAfter").removeAttribute("disabled");
      document.querySelector("#inputBetween1").disabled = true;
      document.querySelector("#inputBetween2").disabled = true;
    } else if (e.target && e.target.matches("#radioBetween")) {
      console.log("clicked on between");
      document.querySelector("#inputBefore").disabled = true;
      document.querySelector("#inputAfter").disabled = true;
      document.querySelector("#inputBetween1").removeAttribute("disabled");
      document.querySelector("#inputBetween2").removeAttribute("disabled");
    }
  });
});
