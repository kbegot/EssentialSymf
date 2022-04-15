//Script de modification des utilisateurs 

let togg1 = document.querySelectorAll('#togg1');
let togg2 = document.querySelectorAll('#togg2');

let eleveClasse = document.getElementById("eleve-classe");
let profMatiere = document.getElementById("prof-matière");

let valider = document.getElementById("valider");
let supprimer = document.getElementById("supprimer")

let d1 = document.getElementById("d1");
let d2 = document.getElementById("d2");

let displayUserId1 = document.getElementById("display-userId-1");
let displayUserId2 = document.getElementById("display-userId-2");
let displayUserEmail1 = document.getElementById("display-userEmail-1");
let displayUserEmail2 = document.getElementById("display-userEmail-2");

let userId = document.getElementById("userId");
let userEmail = document.getElementById("userEmail");


togg1.forEach(togg => {
  
  togg.addEventListener("click", () => {
    
    displayUserId1.textContent = "ID: [" + togg.parentNode.parentNode.parentNode.querySelector('#userId').textContent + "]";
    displayUserEmail1.textContent = "Email: " + togg.parentNode.parentNode.parentNode.querySelector('#userEmail').textContent;
    
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
      displayUserId2.textContent = "ID: [" + togg.parentNode.parentNode.parentNode.querySelector('#userId').textContent + "]";
      displayUserEmail2.textContent = "Email: " + togg.parentNode.parentNode.parentNode.querySelector('#userEmail').textContent;

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



let listebtn = document.querySelectorAll('#active1');

listebtn.forEach(btn => {
  btn.checked = false;
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
    
    if(values == "prof"){
      valider.style.display = "inline-block";
      profMatiere.style.display = "flex";
      eleveClasse.style.display = "none";
    }

    if(values == "admin"){
      valider.style.display = "inline-block";
      profMatiere.style.display = "none";
      eleveClasse.style.display = "none";
    }


  });    

  
});

// action bouton editer

valider.addEventListener('click',(event) => {
  let checkboxes = document.querySelectorAll('input[name="color"]:checked');
  let values = [];
  checkboxes.forEach((checkbox) => {
      values.push(checkbox.value);
  });

  //variable pour la route
  let role;
  let ValueId
  if(values == "admin")
  {
    role = "ROLE_ADMIN";
  }
  if(values == "prof")
  {
    ValueId = document.getElementById("classe-matiere").value;
    //alert(ValueMatiere);
    role = "ROLE_TEACHER";
  }
  if(values == "eleve")
  {
    ValueId = document.getElementById("classe-select").value;
    //alert(ValueClasse);
    role = "ROLE_ELEVE"
    
    
  }

  else
  {

  }

  var regularExpression= /(?<=\[).*?(?=\])/g;

  let id = valider.parentNode.parentNode.parentNode.querySelector('#display-userId-1').textContent.match(regularExpression)[0];

  if (window.confirm(`Vous vous apprêtez à modifier le rôle de l'utilisateur sur ${role}`))
  {
    location.href =`userlist/edit/${id}/${role}/${ValueId}`;
  };



});



// action bouton supprimer

supprimer.addEventListener('click',(event)=>{
  console.log('action');
  console.log(supprimer.parentNode.parentNode.parentNode);
  var regularExpression= /(?<=\[).*?(?=\])/g;
  let id = supprimer.parentNode.parentNode.parentNode.querySelector('#display-userId-2').textContent.match(regularExpression)[0];


  if (window.confirm(`Vous vous apprêtez à supprimer cet utilisateur`))
  {
    location.href= `userlist/delete/${id}`;
  };


});


