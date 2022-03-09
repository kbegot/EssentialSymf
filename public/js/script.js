//let togg1 = document.querySelector('#togg1');
//let togg2 = document.querySelector('#togg2');
let togg1 = document.querySelectorAll('#togg1');
let togg2 = document.querySelectorAll('#togg2');

let active1 = document.getElementById("active1");

let eleveClasse = document.getElementById("eleve-classe");
let profMatiere = document.getElementById("prof-matière");

let valider = document.getElementById("valider");

let d1 = document.getElementById("d1");
let d2 = document.getElementById("d2");

let displayUserId = document.getElementById("display-userId");
let userId = document.getElementById("userId");

let displayUserEmail = document.getElementById("display-userEmail");
let userEmail = document.getElementById("userEmail");



togg1.forEach(togg => {
  
  togg.addEventListener("click", () => {
    
    console.log(togg.parentNode.parentNode.parentNode.querySelector('#userId').textContent);
    displayUserId.textContent = "ID: " + togg.parentNode.parentNode.parentNode.querySelector('#userId').textContent;
    displayUserEmail.textContent = "Email: " + togg.parentNode.parentNode.parentNode.querySelector('#userEmail').textContent;
    
    if(getComputedStyle(d1).display != "none"){
      d1.style.display = "none";
      if(getComputedStyle(d2).display != "none"){
        d2.style.display = "none";
      }
    } else {
      d1.style.display = "block";
      d2.style.display = "none";
    }
  })
});

togg2.forEach(togg => {

    togg.addEventListener("click", () => {
      console.log(togg.parentNode.parentNode.parentNode.querySelector('#userId').textContent);
      displayUserId.textContent = "ID: " + togg.parentNode.parentNode.parentNode.querySelector('#userId').textContent;
      displayUserEmail.textContent = "Email: " + togg.parentNode.parentNode.parentNode.querySelector('#userEmail').textContent;

    if(getComputedStyle(d2).display != "none"){
        d2.style.display = "none";
        if(getComputedStyle(d1).display != "none"){
        d1.style.display = "none";
        }
    }
    else {
      d2.style.display = "block";
      d1.style.display = "none";
    }
    
    })
});
/*active1.addEventListener("click", () => {
  if(getComputedStyle(form1).display != "none"){
    form1.style.display = "none";
  }
  else {
    form1.style.display = "flex";
  }
 
})*/

const btn = document.querySelector('#active1');
btn.addEventListener('click', (event) => {
    let checkboxes = document.querySelectorAll('input[name="color"]:checked');
    let values = [];
    checkboxes.forEach((checkbox) => {
        values.push(checkbox.value);
    });
    if(values == "eleve"){
      valider.style.display = "inline-block";
      eleveClasse.style.display = "flex";
      profMatiere.style.display = "none";
    }
});    

btn.addEventListener('click', (event) => {
    let checkboxes = document.querySelectorAll('input[name="color"]:checked');
    let values = [];
    checkboxes.forEach((checkbox) => {
        values.push(checkbox.value);
    });
    if(values == "prof"){
      valider.style.display = "inline-block";
      profMatiere.style.display = "flex";
      eleveClasse.style.display = "none";
    }
});    

btn.addEventListener('click', (event) => {
  let checkboxes = document.querySelectorAll('input[name="color"]:checked');
  let values = [];
  checkboxes.forEach((checkbox) => {
      values.push(checkbox.value);
  });
  if(values == "admin"){
    valider.style.display = "inline-block";
    profMatiere.style.display = "none";
    eleveClasse.style.display = "none";
  }
}); 



