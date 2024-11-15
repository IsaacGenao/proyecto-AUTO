
function actividad (boton,opcion,sobremi,cerrar,botontema){
    d=document;
    d.addEventListener("click",e=>{
        if((e.target.matches(boton))||(e.target.matches(`${boton} *`))||
        (e.target.matches(opcion))||(e.target.matches(`${opcion} *`))){
            d.querySelector(sobremi).classList.add("sobremi2");
            d.querySelector("body").classList.add("scroll");
        }

        if(e.target.matches(cerrar)|| (e.target.matches(`${cerrar} *`))){
            d.querySelector(sobremi).classList.remove("sobremi2");
            d.querySelector("body").classList.remove("scroll");
        }

        if(e.target.matches(botontema)|| (e.target.matches(`${botontema} *`))){
            d.querySelector(botontema).classList.toggle("activado");
            d.querySelector(".botontemacolor").classList.toggle("colorboton");
            d.querySelector(".fotoinicio-noche").classList.toggle("inicionoche");
            d.querySelector(".nav1").classList.toggle("linkcolor");
            d.querySelector(".nav2").classList.toggle("linkcolor");
            d.querySelector(".seccion2").classList.toggle("fondonegro");
        }
})};

    function carrusel_letras(){
        let index=0,$letras=document.querySelector(".contletras"),
        arreglo=document.querySelectorAll(".letras").length-1;

        setInterval(() => {
            star_carrusel()
        }, 3000);

        function star_carrusel() {
            index++;
            mover_carrusel();
        }
        
        function mover_carrusel(){
            if (index < arreglo) {
                $letras.style.transition="transform.9s ease";
            }
            else if (index > arreglo) {
                index=0;
                $letras.style.transition="none";
            }
           $letras.style.transform=`translateX(-${index*200}%)`;
        }
    };

    function carrusel_carros(boton1,boton2){
        let index=0,$contenedor=document.querySelector(".cont-carrusel-carros"),
        tiempo,tiempo2,arreglo=document.querySelectorAll(".imgcont").length-1,
        $h2=document.querySelectorAll(".cont-texto h2"),
        $h3=document.querySelectorAll(".cont-texto h3"),
        $p=document.querySelectorAll(".cont-texto p");
        detenerinterval();

        
    function textohidden (){
        $h2.forEach(e => {
            e.style.transform="translateY(-100px)";
            e.style.visibility="hidden";
            e.style.transition="none";
        });
        $h3.forEach(e => {
            e.style.transform="translateY(-100px)";
            e.style.visibility="hidden";
            e.style.transition="none";
        });
        $p.forEach(e => {
            e.style.transform="translateY(-100px)";
            e.style.visibility="hidden";
            e.style.transition="none";
        });
    }

        function detenerinterval(){
            
            if(index==0){
                document.querySelector(boton2).style.visibility="visible";
                document.querySelector(boton1).style.visibility="hidden";
            }
            else if(index==arreglo){
                document.querySelector(boton2).style.visibility="hidden";
            }
            else if(index>0){
                document.querySelector(boton1).style.visibility="visible";
                document.querySelector(boton2).style.visibility="visible";
            } 
            
            textohidden();
            tiempo=setInterval(() => {
                    $h2[index].style.transform="translateY(0)";
                    $h2[index].style.visibility="visible";
                    $h2[index].style.transition="all 2s";
                    $h3[index].style.transform="translateY(0)";
                    $h3[index].style.visibility="visible";
                    $h3[index].style.transition="all 1s";
                    $p[index].style.transform="translateY(0)";
                    $p[index].style.visibility="visible";
                    $p[index].style.transition="all 0s";
                    clearInterval(tiempo);
                    iniciarinterval();   
        },1000);
        };
        
        function iniciarinterval(){
            tiempo2=setTimeout(() => {
                star_carrusel();
                    setTimeout(() => {
                        detenerinterval();
                    }, 0);
                }, 9000); 
        };

        function parar(){
            clearTimeout(tiempo2);
            clearInterval(tiempo);
        };

        function star_carrusel(){
            index++;
            mover_carrusel();
        };

        function mover_carrusel(){
            if (index < arreglo) {
                $contenedor.style.transition="transform.9s ease";
            }
            else if (index > arreglo) {
                index=0;
                $h2.forEach(e => {
                    e.style.transform="translateY(-100px)";
                    e.style.visibility="hidden";
                    e.style.transition="none";
                });
                $h3.forEach(e => {
                    e.style.transform="translateY(-100px)";
                    e.style.visibility="hidden";
                    e.style.transition="none";
                });
                $p.forEach(e => {
                    e.style.transform="translateY(-100px)";
                    e.style.visibility="hidden";
                    e.style.transition="none";
                });
                $contenedor.style.transition="none";
            }
           $contenedor.style.transform=`translateX(-${index*100}%)`;
        };
        
        document.addEventListener("click",e=>{    
            
                if(e.target.matches(boton1)||e.target.matches(`${boton1} *`)){
                    index--;
                    $h2[index].style.transform="translateY(-100px)";
                    $h2[index].style.visibility="hidden";
                    $h2[index].style.transition="none";
                    $h3[index].style.transform="translateY(-100px)";
                    $h3[index].style.visibility="hidden";
                    $h3[index].style.transition="none";
                    $p[index].style.transform="translateY(-100px)";
                    $p[index].style.visibility="hidden";
                    $p[index].style.transition="none";               
                    mover_carrusel();
                    parar();
                    setTimeout(() => {
                        detenerinterval();
                    }, 0);
                }  
                
            if(e.target.matches(boton2)||e.target.matches(`${boton2} *`)){
                index++;
                $h2[index].style.transform="translateY(-100px)";
                $h2[index].style.visibility="hidden";
                $h2[index].style.transition="none";
                $h3[index].style.transform="translateY(-100px)";
                $h3[index].style.visibility="hidden";
                $h3[index].style.transition="none";
                $p[index].style.transform="translateY(-100px)";
                $p[index].style.visibility="hidden";
                $p[index].style.transition="none";               
                mover_carrusel();
                parar();
                setTimeout(() => {
                    detenerinterval();
                }, 0);
                
            }

        })
    }

    function hamburguesa(botonmenu,panel,menu){
    
        d.addEventListener("click",e=>{
            if (e.target.matches(botonmenu)|| e.target.matches(`${botonmenu} *`)){
                d.querySelector(panel).classList.toggle("panel_activado")
                d.querySelector(botonmenu).classList.toggle("is-active")
            }
    
            if (e.target.matches(menu)){
                d.querySelector(panel).classList.remove("panel_activado")
                d.querySelector(botonmenu).classList.remove("is-active")
            }
            
        })
    };

document.addEventListener("DOMContentLoaded",e=>{
    actividad(".btnsobremi",".nav3",".sobremi",".cerrar",".indicador");
    carrusel_letras ();
    carrusel_carros(".bton-left",".bton-right");
    hamburguesa(".boton-panel",".menu-nav",".opcionesmenu a");
    console.log(navigator.userAgent);
});

