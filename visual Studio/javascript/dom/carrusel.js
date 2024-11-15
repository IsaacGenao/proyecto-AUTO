const $article= document.querySelector("article"),
$imagenes=document.querySelectorAll(".carros");

let index=0,arreglo=[1,2,3,4,5];

let interval=setInterval(()=>{
    star_carrusel()
}
, 3000);

function clear_Interval(){
    clearInterval(interval);
    interval=setInterval(()=>{
        star_carrusel()
    }
    , 3000);
}

function star_carrusel(){
    index++;
    mover_carrusel();
    
}

function mover_carrusel(){
    if (index <=arreglo.length-1) {
        $article.style.transition="transform.9s ease"
    }

    else if (index > arreglo.length-1) {
        $article.style.transition="none"
        index=0;
    }
    $article.style.transform=`translateX(-${index*550}px)`
}


moverbotones=(boton1,boton2,botontema)=>{
    document.addEventListener("click",e=>{
        if(e.target.matches(boton1)||e.target.matches(`${boton1} *`)){
            index--;
            mover_carrusel()
            clear_Interval()
        }

        if(e.target.matches(boton2)||e.target.matches(`${boton2} *`)){
            index++;
            mover_carrusel()
            clear_Interval()
        }

        if(e.target.matches(botontema)||e.target.matches(`${botontema} *`)){
           document.querySelector(botontema).classList.toggle("activado");
           let $imagen=document.querySelector(".indicador img");
           document.querySelector(".dark").classList.toggle("light");
           document.querySelector("main").classList.toggle("color");
           document.querySelector(".cont-boton-dark-light").classList.toggle("color");
          
            
                
                
            

            
        }

    })
}
document.addEventListener("DOMContentLoaded",e=>{
    moverbotones("#boton-atras","#boton-siguiente",".indicador");
})




