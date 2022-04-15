let bouttonAfficherMatiere = document.querySelectorAll('#togg3');
let bouttonAfficherEleve = document.querySelectorAll('#togg4');
let listeEleve = document.getElementById('listeEleve');
let listeMatiere = document.getElementById('listeMatiere');


//supprimer matières

let bouttonSupprimerMatiere = document.querySelectorAll("#supprimer_matiere");

bouttonSupprimerMatiere.forEach(button => {
  
  
  button.addEventListener('click',(event)=>{
    
    var regularExpression= /(?<=\[).*?(?=\])/g;
    let id = button.parentNode.parentNode.textContent.match(regularExpression)[0];
    
    //console.log(id);
    if (window.confirm(`Vous vous apprêtez à supprimer cet matière`))
    {
      location.href= `matieredelete/${id}`; 
    }
    
  });
});


/*let bouttonSupprimerEleve = document.querySelectorAll("#supprimer_eleve");

bouttonSupprimerEleve.forEach(button => {
  
  
  button.addEventListener('click',(event)=>{
    
    var regularExpression= /(?<=\[).*?(?=\])/g;
    let id = button.parentNode.parentNode.textContent.match(regularExpression)[0];
    
    //console.log(id);
    if (window.confirm(`Vous vous apprêtez à supprimer cet eleve`))
    {
      location.href= `userlist/edit/${id}/ `; 
    }
    
  });
});
*/










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

        // id == id classe
        matiereId = matiere.textContent.match(regularExpression)[0];
        classeId = matiere.textContent.match(regularExpression)[1];

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


bouttonAfficherEleve.forEach(button => {
  button.addEventListener("click", ()=>{
    if (getComputedStyle(listeEleve).display != "none"){
      listeEleve.style.display = "none";

      if(getComputedStyle(listeMatiere).display != "none"){
        listeMatiere.style.display = "none";
      }
    }

    else{
      // affichage selon le classe id
      var regularExpression= /(?<=\[).*?(?=\])/g;
      
      
      Eleves = listeEleve.getElementsByClassName('card-body')[0].querySelectorAll('.customer')
      Eleves.forEach(eleve => {

        // id == id classe
        eleveId = eleve.textContent.match(regularExpression)[0];
        classeId = eleve.textContent.match(regularExpression)[1];

        if (classeId == button.getAttribute('idclasse')){
          eleve.style.display = 'block';
        }

        else{
          eleve.style.display = 'none';
        }
        
      });
      
      listeEleve.style.display = "block";
      listeMatiere.style.display = "none";

    }

  })
  
});



