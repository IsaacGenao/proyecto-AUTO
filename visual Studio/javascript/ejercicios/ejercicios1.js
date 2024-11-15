/*1) Programa una función que cuente el número de 
caracteres de una cadena de texto, pe. miFuncion("Hola Mundo") devolverá 10.
2) Programa una función que te devuelva el texto recortado 
según el número de caracteres indicados, 
pe. miFuncion("Hola Mundo", 4) devolverá "Hola".
3) Programa una función que dada una String 
te devuelva un Array de textos separados por cierto 
caracter, pe. miFuncion('hola que tal', ' ') devolverá ['hola', 'que', 'tal'].
4) Programa una función que repita un texto X 
veces, pe. miFuncion('Hola Mundo', 3) devolverá 
Hola Mundo Hola Mundo Hola Mundo.
5) Programa una función que invierta las palabras de una cadena de texto, pe. 
miFuncion("Hola Mundo") devolverá "odnuM aloH".
6) Programa una función para contar el número de veces que 
se repite una palabra en un texto largo, pe. miFuncion
("hola mundo adios mundo", "mundo") devolverá 2.
7) Programa una función que valide si una palabra o frase dada, 
es un palíndromo (que se lee igual en un sentido que en otro), 
pe. mifuncion("Salas") devolverá true.
8) Programa una función que elimine cierto patrón de caracteres de un texto dado,
 pe. miFuncion("xyz1, xyz2, xyz3, xyz4 y xyz5", "xyz") devolverá  "1, 2, 3, 4 y 5.
 
9) Programa una función que obtenga un numero aleatorio entre 501 y 600.
10) Programa una función que reciba un número y evalúe si es 
capicúa o no (que se lee igual en un sentido que en otro), 
pe. miFuncion(2002) devolverá true.
11) Programa una función que calcule el factorial de un número 
(El factorial de un entero positivo n, se define como el producto de 
    todos los números enteros positivos desde 1 hasta n), pe. miFuncion(5) 
    devolverá 120.
12) Programa una función que determine si un número es primo
(aquel que solo es divisible por sí mismo y 1) o no, pe. miFuncion(7) devolverá true.
13) Programa una función que determine si un número es par o impar, 
pe. miFuncion(29) devolverá Impar.
14) Programa una función para convertir grados Celsius a Fahrenheit y viceversa, 
pe. miFuncion(0,"C") devolverá 32°F.
15) Programa una función para convertir números de base binaria a decimal y viceversa, pe. 
miFuncion(100,2) devolverá 4 base 10.
16) Programa una función que devuelva el monto final después 
de aplicar un descuento a una cantidad dada, pe. miFuncion(1000, 20) devolverá 800.
17) Programa una función que dada una fecha válida determine 
cuantos años han pasado hasta el día de hoy, pe. miFuncion(new Date(1984,4,23)) 
devolverá 35 años (en 2020.)
27) Programa una clase llamada Pelicula.

La clase recibirá un objeto al momento de instanciarse con los siguentes datos: 
id de la película en IMDB, titulo, director, año de estreno, país o países de origen, 
géneros y calificación en IMBD.
  - Todos los datos del objeto son obligatorios.
  - Valida que el id IMDB tenga 9 caracteres, los primeros 2 sean letras y los 
     7 restantes números.
  - Valida que el título no rebase los 100 caracteres.
  - Valida que el director no rebase los 50 caracteres.
  - Valida que el año de estreno sea un número entero de 4 dígitos.
  - Valida que el país o paises sea introducidos en forma de arreglo.
  - Valida que los géneros sean introducidos en forma de arreglo.
  - Valida que los géneros introducidos esten dentro de los géneros 
     aceptados*.
  - Crea un método estático que devuelva los géneros aceptados*.
  - Valida que la calificación sea un número entre 0 y 10 pudiendo ser 
    decimal de una posición.
  - Crea un método que devuelva toda la ficha técnica de la película.
  - Apartir de un arreglo con la información de 3 películas genera 3 
    instancias de la clase de forma automatizada e imprime la ficha técnica 
    de cada película.

* Géneros Aceptados: Action, Adult, Adventure, Animation, Biography, 
Comedy, Crime, Documentary ,Drama, Family, Fantasy, Film Noir, Game-Show, 
History, Horror, Musical, Music, Mystery, News, Reality-TV, Romance, Sci-Fi, 
Short, Sport, Talk-Show, Thriller, War, Western.
    
    200300
    */

/*

//1)

let I="HOLA MUNDO";
function contar(){
console.log(I.length);};
//contar();

//2)

let H="HOLA MUNDO";
function cortar(){
console.log(H.slice(0,4));};
//cortar();

//3


arreglo=(C="",N=undefined)=>{
    (!C)
    ?console.warn("NO INGRESASTE TEXTO")
    :(N===undefined)
        ?console.warn("NO ESCRIBISTE EL PARAMETRO")
        :console.log('SU TEXTO ES ', C.split(N));};

//arreglo("ISAAC GENAO","");

//4

const Repetir=(A="",N=undefined)=>{
    if (!A)return console.warn("NO INGRESASTE TEXTO");
    if (N===undefined) return console.warn("NO INGRESASTE LONGITUD");
    if (Math.sign(N)===-1) return console.error("NO PUEDE SER UN NUMERO NEGATIVO");
    for (let i = 1; i<=N; i++) {
    console.log(`(${i}) ${A}`);}
};
//Repetir("",5);
//Repetir("JOSE");

//5 

const invertir=(I="HOLA")=>{
    console.log(I.split("").reverse().join(""));

}
//invertir();

//7

const palindroma = (P="")=>{
    P=P.toLowerCase();
    let H= P.split("").reverse().join("");
    if (H===P){
        return console.log("Es palindroma");
    }
    else return console.log("No es palindroma");

}
//palindroma("salas");


//9
const Numero=()=>{
console.log(Math.round((Math.random()*100)+500));
}
//Numero();

//10

const capicua=(N=0)=>{
if (!N)console.error("NO ES UN NUMERO");
    N=N.toString();
    let A =N.split("").reverse().join("");
    return(A===N)
    ?console.log("ES CAPICUA")
    :console.log("NO ES CAPICUA");;
}

//capicua(9009)

//11
const Factorial= (NU=0)=>{
    let N1=1;
for (let N = NU; N > 1; N--) {
    N1*=N;
    console.log(`EL FACTORIAL DE ${NU} ES = ${N1}`);
    }

};

//Factorial(6);

//12
const PRIMO=(NUM=0)=>{
div=false;

for (i=2;i<NUM;i++){
 if ((NUM%2)===0)
    div=true;
    break;
}
return(div)
?console.log("EL NUMERO NO ES PRIMO")
:console.log("EL NUMERO ES PRIMO");

}
//PRIMO(9)

//13

const impar = (Na=0)=>{
((Na%2)===0)
?console.log("ES PAR")
:console.log("ES IMPAR");
}
//impar (2);

//14
const grados =(OP=undefined,G=undefined)=>{

if (OP===undefined || G===undefined ||typeof OP!=="number"|| typeof G !=="number") {
    console.error("No ingresaste las especificaciones correctamente")
    }

else {switch (OP) {
    case 1:
        console.log("DE CELSIUS A FAHRENHEIT");
         let F=G*1.8+32;
         console.log(`ES IGUAL A ${F}°F`);
        break;
    case 2:
            console.log("DE FAHRENHEIT A CELSIUS");
             let C=(G-32)/1.8;
             console.log(`ES IGUAL A ${C}°C`);
            break;
    default:
        break;
 }
}
}
grados(1)*/

//16
/*
const descuento =(N=undefined,D=undefined)=>{
let R=N*(D/100),R1=N-R;  
if (N===undefined||D===undefined)
console.error("NO INSERTASTE LOS DATOS CORRECTAMENTE");
else if (typeof N !=="number")
console.error("NO INSERTASTE NUMEROS");

else
console.log(`${N} MENOS EL DESCUENTO DE UN ${D}% = ${R1}`);
}
//descuento(1000,20);

//17
const tiempo = (fecha=undefined)=>{
let R= new Date().getTime()-fecha.getTime(),
A=1000*60*60*24*30,F= Math.floor(R/A) ;
console.log
(`Del ${fecha.getFullYear()} hasta el ${new Date().getFullYear()} han pasado ${F} meses `);
}

//tiempo(new Date(2003,7,6))*/
/*

class pelicula{
    constructor({id,titulo,director,estreno,pais,generos,calificacion}){
    this.id=id;
    this.titulo=titulo;
    this.director=director;
    this.estreno=estreno;
    this.pais=pais;
    this.generos=generos;
    this.calificacion=calificacion;
    this.validarID(id);
    this.validarTitulo(titulo);
    this.validarDirector(director);
    this.validarEstreno(estreno);
    this.validarPais(pais);
    this.validargenero(generos);
    this.validarcalificacion(calificacion);
    }

    validarcadena(propiedad,valor){
        if (!valor)return console.warn(`${propiedad} ESTA VACIO`);
        if (typeof valor !== "string")console.error(`${propiedad} ${valor} NO ES UNA CADENA DE TEXTO`);
        else return true;
    }
    validarlongitud (propiedad,valor,longitud){
        if (valor.length > longitud)
            return console.error(`El texto debe tener una longitud menor o igual a ${longitud}`);
        else return true;
    }
    validarNumero(propiedad,valor){
        if(!valor)return console.warn(`${propiedad} ESTA VACIO`);
        else if (typeof valor !== "number") 
            return console.error(`${propiedad} NO ES UN NUMERO`);
        else return true;
    }
    validarArreglo (propiedad,valor){
        if(!valor)return console.warn(`${propiedad} ESTA VACIO`);
        else if (!(valor instanceof Array)) 
            return console.error("NO ES UN ARREGLO");
        else if (valor.length=== 0)
            return console.warn("EL ARREGLO ESTA VACIO");
        for (let cadena of valor) {
            if (typeof cadena !== "string")
            return console.error(`El valor de pais no es una cadena`);
        }
        return true;
    }

    static get Listageneros(){
       return ["Action", "Adult", "Adventure", "Animation", "Biography", 
        "Comedy", "Crime", "Documentary" ,"Drama", "Family", "Fantasy", "Film Noir", "Game-Show", 
        "History", "Horror", "Musical", "Music", "Mystery", "News", "Reality-TV", "Romance", "Sci-Fi", 
        "Short", "Sport", "Talk-Show", "Thriller", "War", "Western"]
    }

    static generosaceptados(){
        return console.log (`${pelicula.Listageneros.join(",")}`);
    }
    
    

    validarID(id){
        if(this.validarcadena("IMDB ID",id)){
            if(!(/^([a-z]){2}([0-9]){7}$/.test(id)))
            return console.error("EL ID NO ES CORRECTO");
        }
    }

    validarTitulo(titulo){
        if(this.validarcadena("Titulo",titulo)){
            this.validarlongitud("Titulo",titulo,100)
        }
    }

    validarDirector(director){
        if(this.validarcadena(" Nombre director",director)){
            this.validarlongitud("Nombre director",director,50)
        }
    }

    validarEstreno(estreno){
        if (this.validarNumero("Estreno",estreno))
            if (!(/^([0-9]){4}$/.test(estreno))) 
            return console.error (`Tiene mas de 4 digitos`);
    }

    validarPais(pais){
        if (this.validarArreglo("Pais",pais));
    }

    validargenero (generos){
        if (this.validarArreglo("generos",generos)){
            for (let categoria of generos) {
                if (!(pelicula.Listageneros.includes(categoria)))
                console.error(` El genero "${categoria}" no ha sido encontrado`);
            };
        }
    }

    validarcalificacion (calificacion){
        if (this.validarNumero("Calificacion",calificacion))
        if (calificacion < 0 || calificacion > 10 )
            return console.log(" La calificacion es incorrecta ")
            
        }

    fichaPelicula(){
        console.log(
        `        ID: ${this.id} 
        TITULO: ${this.titulo} 
        DIRECTOR: ${this.director}
        ESTRENO: ${this.estreno} 
        PAISES ${this.pais.join("-")}
        GENEROS: ${this.generos.join(",")} 
        CALIFICACION: ${this.calificacion}`);
    }    
    }

const peli=new pelicula({
    id:"tt0923457",
    titulo:23,
    director:"JOSE ALCANTARA",
    estreno:2022,
    pais:["ESTADOS UNIDOS"],
    generos:["Action","Comedy"],
    calificacion:10    
})*/



/*
setInterval(() => {
console.log(new Date().toLocaleTimeString());
}, 6000);



/*
const porciento=(value,P)=>{
    if (typeof value !== "number" || typeof P !== "number" ){
        return Promise.reject(`ERROR EL DATO ${value} INTRODUCIDO NO ES UN NUMERO`);
    }
    else return new Promise((resolve, reject) => {
        setTimeout(() => {
            resolve({
                value,
                P,
                result:value*(P/100)
            })
        }, 2000);
    })
}

porciento(1000,30)
.then(obj=>{
    console.log(`EL ${obj.P}% DE ${obj.value} ES = ${obj.result}`);
    return porciento(2000,20);
})
.then(obj=>{
    console.log(`EL ${obj.P}% DE ${obj.value} ES = ${obj.result}`);
    return porciento(3000,30);
})
.then(obj=>{
    console.log(`EL ${obj.P}% DE ${obj.value} ES = ${obj.result}`);
    return porciento(4000,40);
})
.then(obj=>{
    console.log(`EL ${obj.P}% DE ${obj.value} ES = ${obj.result}`);
    return porciento(5000,50);
})
.then(obj=>{
    console.log(`EL ${obj.P}% DE ${obj.value} ES = ${obj.result}`);
})

.catch(err=>console.error(err));
*/
/*
class vehiculo {
    constructor({tipo,placa}){
        this.tipo=tipo;
        this.placa=placa;
        this.Validartipo(tipo);
        this.validarplaca(tipo,placa)
    }

    validarcadena(propiedad,valor){
        if (!valor)return console.warn(`NO INSERTO ${propiedad} DE VEHICULO`);
        if (typeof valor !== "string")
        console.error(`${propiedad} DE VEHICULO NO ES UNA CADENA DE TEXTO`);
        else return true;
    }

    static get listaVehiculos(){
     return ["JEEPETA","AUTOMOVIL","AMBULANCIA","CAMIONETA"];
    }

    static lista(){
       return console.log(`LISTA DE VEHICULOS: ${vehiculo.listaVehiculos.join(" - ") }`);
    }

    Validartipo(tipo){
        if (this.validarcadena("EL TIPO",tipo)){
            tipo = tipo.toUpperCase()
            if ((tipo!="JEEPETA" && tipo!="AUTOMOVIL" && tipo!="AMBULANCIA" 
            && tipo!="CAMIONETA"))
            return console.error("EL TIPO DE VEHICULO NO EXISTE EN NUESTRA LISTA DE VEHICULOS");
        }  
         }

    validarplaca(tipo,placa){
        if (this.validarcadena("LA PLACA",placa)){
            tipo = tipo.toUpperCase();
            if (tipo==="JEEPETA"){
                if (!(/^[G][0-9]{6}$/.test(placa))){
                    console.log(" ");
                    console.error("*****************************");
                    console.error("LA PLACA NO ES DE UNA JEEPETA");
                    console.error("*****************************");
                }
                else {
                    console.log(" ");
                    console.log("****************************************");
                    console.log("TODO CORRECTO LA PLACA ES DE UNA JEEPETA");
                    console.log("****************************************");
                }
            }
            if (tipo==="AUTOMOVIL"){
                if (!(/^[A][0-9]{6}$/.test(placa))){
                    console.log(" ");
                    console.error("******************************");
                    console.error("LA PLACA NO ES DE UN AUTOMOVIL");
                    console.error("******************************");
                }

                else {
                    console.log(" ");
                    console.log("*****************************************");
                    console.log("TODO CORRECTO LA PLACA ES DE UN AUTOMOVIL");
                    console.log("*****************************************");
                }
            }

            if (tipo==="AMBULANCIA"){
                if (!(/^[H][0-9]{6}$/.test(placa))){
                    console.log(" ");
                    console.error("********************************");
                    console.error("LA PLACA NO ES DE UNA AMBULANCIA");
                    console.error("********************************");
                }
                else {
                    console.log(" ");
                    console.log("*******************************************");
                    console.log("TODO CORRECTO LA PLACA ES DE UNA AMBULANCIA");
                    console.log("*******************************************");
                }
            }

            if (tipo==="CAMIONETA"){
                if (!(/^[L][0-9]{6}$/.test(placa))){
                    console.log(" ");
                    console.error("*******************************");
                    console.error("LA PLACA NO ES DE UNA CAMIONETA");
                    console.error("*******************************");
                }
                else {
                    console.log(" ");
                    console.log("******************************************");
                    console.log("TODO CORRECTO LA PLACA ES DE UNA CAMIONETA");
                    console.log("******************************************");
                }

            }

        }

    }
        
    fichavehiculos(){
        console.log("   ");
        console.log(`TIPO DE VEHICULO: ${this.tipo}`);
        console.log(`PLACA DE VEHICULO: ${this.placa}`);   
    }
        }
        
vehiculo.lista()

const vehiculo1= new vehiculo({
    tipo:"JEEPETA",
    placa:"H123456"
}) 

vehiculo1.fichavehiculos()


*/

/*const iterable = new Set([10,10,10,10]);
const iterador=iterable[Symbol.iterator]();
let next = iterador.next();

while (!(next.done)) {
    console.log(next.value);
    next = iterador.next()
}    */

const usuarios={

}

const nombres=["Isaac","Jose","John","Manuel","Fiona","Pedro"]

nombres.forEach((usuario,index)=>usuarios[`ID_${index+100}`]=usuario);
//console.log(usuarios);
    

/*const persona = {
    Nombre:"Isaac",
    Apellido:"Genao",
    Edad:18,
    Cedula:"402-1205673-9"
}*/


/*console.log(JSON.stringify(persona));



console.log(JSON.parse
    ('{"Nombre":"Isaac","Apellido":"Genao","Edad":18,"Cedula":"402-1205673-9"}'));*/

    let escuchar= new webkitSpeechRecognition();
    escuchar.lang='es.ES';
    escuchar.continuous=true;
    escuchar.interimResults=false;
   
    let responder= function(tex=undefined){
        if (tex===undefined){hablar("no me insertaste texto")}
        if (tex=="hola"){hablar("hola Isaac, como estas?")}
        if (tex=="bien"){hablar("me alegro mucho")}
        if (tex=="mal"){hablar("porque, que te sucede")}
        if (tex=="como se llama mi novia"){hablar("natalia")}
    }   
    const hablar =(texto)=> speechSynthesis.speak(new SpeechSynthesisUtterance(texto))
    
    responder("mal")

/*
 class Persona {
  constructor({Nombre,Apellido,Edad,Estatura}){
    this.Nombre=Nombre;
    this.Apellido=Apellido;
    this.Edad=Edad;
    this.Estatura=Estatura;
    this.validarnombre(Nombre);
    this.validarapellido(Apellido);
    this.validarEdad(Edad);
    this.validarEstatura(Estatura)
  }

  validarcadena(propiedad,valor){
    if (!valor) return hablar(`EL VALOR DE ${propiedad} ESTA VACÍO`);
    if(typeof valor !== "string")return hablar(`EL VALOR DE ${propiedad} NO ES CADENA DE TEXTO`);
    else return true;
  }

  validarnumero(propiedad,valor){
    if(!valor) return hablar(`EL VALOR ${propiedad} ESTA VACÍO`);
    if(typeof valor !=="number" )return hablar (`EL VALOR DE ${propiedad}INTRODUCIDO DEBE SER UN NUMERO`);
    else return true;
  }

  validarnombre(Nombre){
    if (this.validarcadena("NOMBRE:",Nombre))
        if(!(/^[A-Za-z]*\s[A-Za-z]*$/.test(Nombre)))return hablar("EL NOMBRE SOLO PUEDE CONTENER LETRAS")
            else hablar(`TU NOMBRE ES ${Nombre}`)
  }
  validarapellido(Apellido){
    if (this.validarcadena("Apellido:",Apellido))
        if(!(/^[A-Za-z]*$/.test(Apellido)) && !(/^[A-Za-z]*\s[A-Za-z]*$/.test(Apellido)) )return hablar("EL APELLIDO SOLO PUEDE CONTENER LETRAS");
             else if (Apellido=="Genao") return hablar(`TU APELLIDO ES JENAO`);
             else return hablar(`TU APELLIDO ES ${Apellido}`)
  }
  
  validarEdad(Edad){
    if(this.validarnumero("EDAD:",Edad))
        hablar(`TIENES ${Edad} AñOS de edad`)
  }

  validarEstatura(Estatura){
    if (this.validarnumero("Estatura:",Estatura))
        hablar(`Y TIENES ${Estatura} PIES DE ALTURA`)
  }
   
 }

 const Isaac = new Persona({
    Nombre:"kikinnii ",
    Apellido:40,
    Edad:"C",
    Estatura:"CX"
 })





*/











