/*import hamburguesa from "./xmenu.js";*/

const d=document;
let x=0,y=0;
function hamburguesa(boton,panel,menu){
    
    d.addEventListener("click",e=>{
        if (e.target.matches(boton)|| e.target.matches(`${boton} *`)){
            d.querySelector(panel).classList.toggle("panel_activado")
            d.querySelector(boton).classList.toggle("is-active")
        }

        if (e.target.matches(menu)){
            d.querySelector(panel).classList.remove("panel_activado")
            d.querySelector(boton).classList.remove("is-active")
        }
        
    })
};
function Reloj (clock,botoninicio,botondetener,activar,pausar){

    let tiempo,$seccion=d.getElementById("botonesR"),$hijo,
    $alarma=d.createElement("audio"),$alarmatime;
        
    function AperecerIniciar(){
        $hijo=d.createElement("button");
        $hijo.textContent="Iniciar";
        $hijo.classList.add("botonesRE","botonA")
        $seccion.appendChild($hijo);  
    }
    function DesaparecerIniciar () {
        $hijo=d.querySelector(botoninicio);
        $seccion.removeChild($hijo);
    }
    function AparecerDetener (){
      $hijo =d.createElement("button");
      $hijo.textContent="Detener";
      $hijo.classList.add("botonesRE","botonD","botonD1");
      $seccion.appendChild($hijo);
      
    }
    function DesaparecerDetener (){
        $hijo=d.querySelector(botondetener);
      $seccion.removeChild($hijo);
    }
    function AparecerActivar (){
        $hijo=d.createElement("button");
        $hijo.textContent="Activar";
        $hijo.classList.add("botonesRE","activar");
        $seccion.appendChild($hijo);
    }
    function DesaparecerActivar (){
        $hijo=d.querySelector(activar);
        $seccion.removeChild($hijo);
    }
    function AparecerPausar() {
        $hijo=d.createElement("button");
        $hijo.textContent="Pausar";
        $hijo.classList.add("botonesRE","pausar");
        $seccion.appendChild($hijo);
    }
    function DesaparecerPausar (){
        $hijo=d.querySelector(pausar);
        $seccion.removeChild($hijo);
    }

    d.addEventListener("click",e=>{
        
        if (e.target.matches(botoninicio)){
            d.getElementById("contreloj").classList.remove("degradado1");
            d.getElementById("contreloj").classList.add("degradado2")
            tiempo=setInterval(() => {
                let relojdigital=new Date().toLocaleTimeString();
                d.querySelector(clock).innerHTML=`<h1>${relojdigital}</h1>`;
            }, 1000);
            DesaparecerIniciar();
            AparecerDetener();
            AparecerActivar();
        }
        
        if (e.target.matches(botondetener)){
            d.getElementById("contreloj").classList.remove("degradado2");
            d.getElementById("contreloj").classList.add("degradado1")
            clearInterval(tiempo);
            DesaparecerDetener();
            DesaparecerActivar();
            AperecerIniciar();
        }
        
        if (e.target.matches(activar)){
            $alarma.setAttribute("src","/pagina de autos/alarma/iPhone-alert.mp3");
            $alarmatime= setInterval(() => {
                $alarma.play();
            },0);
            DesaparecerActivar();
            AparecerPausar();
            d.querySelector(botondetener).disabled=true;
            d.querySelector(botondetener).classList.remove("botonD1");
        }

        if(e.target.matches(pausar)){
            $alarma.pause();
            $alarma.currentTime=0;
            clearInterval($alarmatime);
            AparecerActivar();
            DesaparecerPausar();
            d.querySelector(botondetener).disabled=false;
            d.querySelector(botondetener).classList.add("botonD1");
        }
       
        
    })
    
};

function movimiento(e,pelota,fondo) {
    const $pelota=d.querySelector(pelota),
    $fondo=d.querySelector(fondo);
    let limitepelota=$pelota.getBoundingClientRect(),
    limitefondo=$fondo.getBoundingClientRect();
    
    console.log(limitepelota,limitefondo);
    
    switch (e.keyCode) {
    //izquierda
        case 37:
            
            if (limitepelota.left>limitefondo.left)
            x--;
            break;
    //arriba
        case 38:
            e.preventDefault();
            if (limitepelota.top>limitefondo.top)
            y--;
            break;
    //derecha      
        case 39:
            if (limitepelota.right<limitefondo.right)
            x++;
            break;
    //abajo
         case 40:
            e.preventDefault();
            if (limitepelota.bottom<limitefondo.bottom)
            y++;
            break;
            
        }
        $pelota.style.transform= `translate(${x*10}px,${y*10}px)`;
}
 

document.addEventListener("DOMContentLoaded",e=>{
    hamburguesa(".boton-panel","aside",".menu a");
    Reloj(".reloj",".botonA",".botonD",".activar",".pausar");
    
});

d.addEventListener("keydown",(e)=>{
    movimiento (e,".pelota",".fondo")
});


