
const $parrafo= document.querySelector(".texto1"),
$contenedor= document.querySelector(".contenedor"),
$body= document.querySelector("body");


setTimeout(() => {
    $parrafo.classList.add("animacion");
    setTimeout(() => {
        $parrafo.style.transform="translateY(300px)"
        $parrafo.style.transition="transform.9s ease-in-out";
        setTimeout(() => {
            $contenedor.removeChild($parrafo);
                setTimeout(() => {
                    $body.classList.remove("color")
                    $body.style.transition='background-color.9s ease';
                    $body.style.backgroundColor='white';
                    setTimeout(() => {
                        aparecertexto();
                    }, 0);
                }, 200);
        }, 300);
    },3000);
},900);


function aparecertexto(){
    const $nuevotexto=document.createElement("p");
    $nuevotexto.innerHTML="MI NOMBRE ES<span>ISAAC GENAO</span>😉​✌​";
    $nuevotexto.style.fontWeight='bold';
    $nuevotexto.style.color='black';
    $contenedor.appendChild($nuevotexto);
    $nuevotexto.classList.add("aparecer");
    const $span=document.querySelector("span");
    $span.style.background='linear-gradient(to right, #121FCF 0%, #CF1512 100%)';
    $span.style.webkitBackgroundClip='text';
    $span.style.webkitTextFillColor= 'transparent';
    $span.style.fontWeight='bold';
    setTimeout(() => {
        $nuevotexto.classList.add("animacion");
        setTimeout(() => {
            $nuevotexto.style.transform="translateY(300px)";
            setTimeout(() => {
                $body.style.backgroundColor='black';
                $contenedor.removeChild($nuevotexto);
                
                aparecernuevo ();
            },600);
        }, 2000);
    }, 500);
}

function aparecernuevo (){
    const $nuevotexto=document.createElement("p");
    $nuevotexto.innerHTML="SOY<span>DESARROLLADOR WEB</span>​​ 💻​​🔥​​​​";
    $nuevotexto.style.fontWeight='bold';
    $nuevotexto.style.color='white';
    $contenedor.appendChild($nuevotexto);
    $nuevotexto.classList.add("aparecer");
    const $span=document.querySelector("span");
    $span.classList.add("animaciontextodecolor"); 
    setTimeout(() => {
        $nuevotexto.classList.add("animacion");
}, 500);   
    
}