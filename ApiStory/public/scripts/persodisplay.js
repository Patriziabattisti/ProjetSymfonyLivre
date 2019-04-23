document.addEventListener("DOMContentLoaded",function(){ 
    
    var nomprenom=document.querySelector("#fichedetail h5");
    var detailphys=document.querySelector("#fichedetail h6");
    var detailpsy=document.querySelector("#fichedetail p");
    var mesperso=document.querySelectorAll("li");
    var monformmodif=document.querySelector("#persomodif");
    var btnmodifopen=document.querySelector("#btnmodifopen");
    var btnmodifclose=document.querySelector("#btnmodifclose");
    
    
    
    for(let i=0; i<mesperso.length;i++){
        mesperso[i].addEventListener("click", function(){
            nomprenom.innerHTML=mesperso[i].innerHTML;
            detailphys.innerHTML=mesperso[i].dataset.physique;
            detailpsy.innerHTML=mesperso[i].dataset.psy;
        });
    }
    
    
    function open(){
        monformmodif.classList.remove('close');
    }
    
    function close(){
        monformmodif.classList.add('close');
    }
    
    btnmodifopen.addEventListener("click", function(){
        open();
    });
    
    btnmodifclose.addEventListener("click",function(){
        close();
    });
});
