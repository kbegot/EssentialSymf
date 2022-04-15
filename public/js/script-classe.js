let bouttonAfficherMatiere = document.querySelectorAll('#togg3');
let bouttonAfficherEleve = document.querySelectorAll('#togg4');
let listeEleve = document.getElementById('listeEleve');
let listeMatiere = document.getElementById('listeMatiere');


console.log(listeEleve);
console.log(listeMatiere);


bouttonAfficherMatiere.forEach(button => {
  button.addEventListener("click", ()=>{
    if (getComputedStyle(listeMatiere).display != "none"){
      listeMatiere.style.display = "none";

      if(getComputedStyle(listeEleve).display != "none"){
        listeEleve.style.display = "none";
      }
    }

    else{
      // affichage selon le classe id
      var regularExpression= /(?<=\[).*?(?=\])/g;
      
      
      Matieres = listeMatiere.getElementsByClassName('card-body')[0].querySelectorAll('.customer')
      Matieres.forEach(matiere => {
        console.log(button);
        console.log(button.getAttribute('idclasse'));
        // id == id classe
        matiereId = matiere.textContent.match(regularExpression)[0];
        classeId = matiere.textContent.match(regularExpression)[1];
        console.log(matiereId);
        console.log(classeId);
        if (classeId == button.getAttribute('idclasse')){
          matiere.style.display = 'block';
        }

        else{
          matiere.style.display = 'none';
        }
        
      });
      
      listeMatiere.style.display = "block";
      listeEleve.style.display = "none";

    }

  })
  
});


/*let togg3 = document.querySelectorAll('#togg3');
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
});*/