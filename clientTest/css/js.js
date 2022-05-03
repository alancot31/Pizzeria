window.onload =( function funLoad() { 
    let body = document.querySelector('body');
  
    let contenantall = document.createElement("div");
    body.appendChild(contenantall);
    contenantall.classList.add("test")
    let contenant = document.createElement("div");
    contenant.classList.add("container");
    contenant.classList.add("pt-4");
    contenantall.appendChild(contenant);

    let consign=document.createElement("h4");
    contenant.appendChild(consign);
    consign.textContent="LES TABLES: ";
    let titlePizzeria=document.getElementById("titlePizzeria");
    let bienvenue = document.createElement('h1');
    titlePizzeria.appendChild(bienvenue);
    let lettreB=document.createElement('span');
    lettreB.textContent="B";
    bienvenue.appendChild(lettreB);
    let lettreI=document.createElement('span');
    lettreI.textContent="I";
    bienvenue.appendChild(lettreI);
    let lettreE=document.createElement('span');
    lettreE.textContent="E";
    bienvenue.appendChild(lettreE);
    let lettreN=document.createElement('span');
    lettreN.textContent="N";
    bienvenue.appendChild(lettreN);
    let lettreV=document.createElement('span');
    lettreV.textContent="V";
    bienvenue.appendChild(lettreV);
    let lettreE1=document.createElement('span');
    lettreE1.textContent="E";
    bienvenue.appendChild(lettreE1);
    let lettreN1=document.createElement('span');
    lettreN1.textContent="N";
    bienvenue.appendChild(lettreN1);
    let lettreU=document.createElement('span');
    lettreU.textContent="U";
    bienvenue.appendChild(lettreU);
    let lettreE2=document.createElement('span');
    lettreE2.textContent="E";
    bienvenue.appendChild(lettreE2);
    bienvenue.addEventListener('mouseover', handleletters);
    bienvenue.addEventListener('mouseleave', handleletters);
    let isAnimatingIn = false;
    let calledOut = false ;
    let animOpened = false ;
    function handleletters(){
        if(animOpened){
            animOut();
            animOpened=false;
            return;
        }
        if (isAnimatingIn){
            calledOut = true;
            return;
        }
        isAnimatingIn = true ;
        const animpromise = new Promise((resolve) => {
            animIn()
            setTimeout(()=>{
                resolve()
            },750)
        })
        animpromise.then(()=>{
            isAnimatingIn = false;
            if(calledOut){
                animOut()
                calledOut = false;
            }
            else if (!calledOut){
                animOpened= true;
            }
        })
    }
    function animIn(){
        anime({
            targets : "h1 span",
            translateX: function(){
                return anime.random(-500,500)
            },
            translateY: function(){
                return anime.random(-135,135)
            },
            translateZ: function(){
                return anime.random(-1500,650)
            },
            rotate: function(){
                return anime.random(-135,135)
            },
            easing:"easeOutCirc",
            duration : 750
        })
    }
    function animOut(){
        anime({
            targets : "h1 span",
            translateX: 0,
            translateY: 0,
            translateZ: 0,
            rotate: 0,
            easing:"easeInQuad",
            duration : 750
        })
    }
    let list = document.createElement('div');
    contenant.appendChild(list);
    list.classList.add('row');
    list.classList.add('d-flex');
    list.classList.add('text-center');
    list.classList.add('pt-4');
    let ulsansstymle = document.querySelectorAll('ul');
    ulsansstymle.forEach(element => {
        element.classList.add("ulsansstyle");
        element.classList.add("col-12");
        element.classList.add("col-md-6");
        list.appendChild(element);
    });
    let lastul = document.getElementById("option");
    if (lastul != null){
        lastul.classList.remove("col-md-6");
    }
    let leslink = document.querySelectorAll('a');
    leslink.forEach(element => {
        element.classList.add('awithoutemphasize');
    });
    let separatorFormules = document.createElement("div");
    separatorFormules.classList.add("separator");
    contenant.appendChild(separatorFormules);
    let formules = document.createElement('div');
    formules.classList.add('formules');
    formules.classList.add('row');
    formules.classList.add('d-flex');
    formules.classList.add('text-center');
    contenant.appendChild(formules);
    let forms = document.querySelector('form');
    if(forms !=  null){
        formules.appendChild(forms);
    }
    let option = document.getElementsByClassName('option');
    for(let element of option){
        if (element !=null) {
            formules.appendChild(element);
            element.classList.remove('col-6');
            element.classList.add('col-12');
        }
    }
    let separator = document.createElement("div");
    contenantall.appendChild(separator);
    separator.classList.add("separator");
    let contenusducommande = document.createElement("div");
    contenantall.appendChild(contenusducommande);
    contenusducommande.classList.add('contenusducommande');
    let contenucommande = document.getElementById("contenucommande");
    contenusducommande.appendChild(contenucommande);
    
});