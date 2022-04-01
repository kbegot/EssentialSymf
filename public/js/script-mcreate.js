let classeBox = document.querySelector('#creation_matiere_classe');
let textBox = document.querySelector('#creation_matiere_nom')
console.log(textBox.value);

function refresh_value(){
  let classeName= classeBox[classeBox.value].textContent;

  textBox.value += " " + classeName;

}