/*const $body = document.querySelector("body")
const $contenedor=document.querySelector(".section1")
let modo="claro";

if (modo==="oscuro"){
    $body.classList.toggle("color") 
$section.classList.replace("section2","sectionnueva")
$contenedor.style.setProperty("background-color","rgb(112, 36, 43)")
}

const $img=document.createElement("img")
$img.setAttribute("src","autos/audi.png")
$img.classList.add("imgcont")
$section.appendChild($img)

const animales=["perro","gato","mono","leon","serpiente","elefante"]

const $ol=document.createElement("ul")

animales.forEach((el)=>{
    const $li=document.createElement("li")
    $li.textContent=el
    $fragmento.appendChild($li)
})

document.write("<h3 class=lista>ANIMALES</h3>")
$ol.appendChild($fragmento)
$body.appendChild($ol)
$ol.classList.add("lista")*/



const $section=document.querySelector(".section2")
const $fragmento=document.createDocumentFragment();
let $agregar=document.getElementById("agregar");
const imagenes=["autos/audi.png","autos/astonmartin.png","autos/mclaren.png"];

 

$agregar=document.addEventListener("click",(agregar)=>{
     imagenes.forEach((el)=>{
        const $img=document.createElement("img")
         $img.setAttribute("src",el)
         $img.classList.add("imgcont")
         $fragmento.appendChild($img)});
    $section.appendChild($fragmento)
       
            for (index = i; index < imagenes.length;) {
                const $img=document.createElement("img")
                $img.classList.add("imgcont")
                $fragmento.appendChild($img)
                $img.setAttribute("src",element)
                break;
            }
        
    
    
    $section.appendChild($fragmento)
})







 

