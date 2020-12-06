document.addEventListener("DOMContentLoaded", function () {
   document.querySelector(".searchBar").addEventListener("keydown", (e) => {
      // For reference
      // https://www.techiedelight.com/detect-enter-key-press-javascript/
      // https://css-tricks.com/snippets/javascript/javascript-keycodes/
      // keyCode 13 = enter key
      if (e.keyCode == 13) {
         alert('enter');
      }
   });

   // change class from active to not active to show which current page is active

   //function mobileMenu() {
     // document.querySelector("#menuIcon").addEventListener("click", (e) =>{
       //  console.log("click");
         // var navItems = document.querySelector(".navItems");
         // if (navItems.style.display === "none"){
         //    navItems.style.display = "block";
         // } else {
         //    navItems.style.display = "none";
         // }
         
     //    document.querySelector(".navItems").classList.toggle("hidden");
         // var navItems = document.querySelectorAll("a .navBtn");
         // for (let nav of navItems) {

         //    // if (nav.style.visibility === "hidden") {
         //    //    nav.style.float = "left";
         //    //    nav.style.visibility = "visible"
         //    // } 
         // }
     // });
      // document.querySelector("#menuIcon").addEventListener("click", (e) => {
      //    galleryColumn.classList.toggle(".navBtn");
      //    var navItems = document.querySelectorAll("a .navBtn");
      //    for (let nav of navItems) {
      //       if (nav.style.display === "none") {
      //          nav.style.display = "block";
      //          nav.style.float = "none";
      //       }
      //    }
      // });
      // } else {
      //    nav.style.display = "none";
      // }

   //}

   //mobileMenu();

});