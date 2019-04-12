document.addEventListener("DOMContentLoaded",function(){ 
    
    var meschapitres=document.querySelectorAll(".chapitreLivre");
    var btnnvchap=document.querySelector("#nouveauChap");
    var monform=document.querySelector("form");
    var monplantravail=document.querySelector("#plantravail");
    
    function affichageChapitre(){
        
        monform.style.display='flex';
        monform.children[0].placeholder="Nom de Chapitre";
        monform.children[1].innerHTML="Contenu (...)";
        
    }
    for(var i=0; i<meschapitres.length;i++){

        meschapitres[i].addEventListener('click',function(){
            
            monform.children[0].placeholder=this.innerHTML;
            monform.children[0].value=this.innerHTML;
            monform.children[1].innerHTML=this.dataset.contenu;
            monform.children[2].value=this.dataset.id;
            monform.style.display='flex';
            
        })
    }

    console.log(meschapitres);
    
                        //event d'enregistrement ou affichage
                        
    btnnvchap.addEventListener('click', function(){ //affiche un nouveau chapitre
        affichageChapitre();
    });



});
