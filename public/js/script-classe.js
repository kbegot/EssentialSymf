let togg3 = document.querySelectorAll('#togg3');
let togg4 = document.querySelectorAll('#togg4');

let d3 = document.getElementById("d3");
let d4 = document.getElementById("d4");

togg4.forEach(togg => {
  
    togg.addEventListener("click", () => {
      
      
      if(getComputedStyle(d3).display != "none"){
        d3.style.display = "none";
        if(getComputedStyle(d4).display != "none"){
          d4.style.display = "none";
        }
      } else {
        d3.style.display = "block";
        d4.style.display = "none";
      }
    })
});


togg3.forEach(togg => {

    togg.addEventListener("click", () => {
      

    if(getComputedStyle(d4).display != "none"){
        d4.style.display = "none";
        if(getComputedStyle(d3).display != "none"){
        d3.style.display = "none";
        }
    }
    else {
      d4.style.display = "block";
      d3.style.display = "none";
    }
    
    })
});