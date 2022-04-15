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

//supprimer matières

let supprimer2 = document.getElementById("supprimer");

supprimer2.addEventListener('click',(event)=>{

  var regularExpression= /(?<=\[).*?(?=\])/g;
  let id = supprimer2.parentNode.parentNode.parentNode.querySelector('#matiere-id').textContent.match(regularExpression)[0];

console.log(id);
  if (window.confirm(`Vous vous apprêtez à supprimer cet utilisateur`))
  {
    location.href= `matieredelete/${id}`; 
  };


});