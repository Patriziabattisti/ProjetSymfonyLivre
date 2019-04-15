document.addEventListener("DOMContentLoaded",function(){ 
    
    var nomprenom=document.querySelector("#fichedetail h5");
    var detailphys=document.querySelector("#fichedetail h6");
    var detailpsy=document.querySelector("#fichedetail p");
    var mesperso=document.querySelectorAll("li");
    
    for(let i=0; i<mesperso.length;i++){
        mesperso[i].addEventListener("click", function(){
            nomprenom.innerHTML=mesperso[i].innerHTML;
            detailphys.innerHTML=mesperso[i].dataset.physique;
            detailpsy.innerHTML=mesperso[i].dataset.psy;
        });
    }
    

});
