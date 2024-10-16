<style>
/* Aqui puedes poner codigo css que sobre escribira los estilos predeterminados */
*{
    font-family: "Montserrat", sans-serif;
}

/*estilos de texto*/

/*titulo*/
h1{
    font-weight: bolder;
    font-size: 30px;
    color: white;
}

/*subtitulo azul*/
h2{
    font-size: 24px;
    color: #002b7a;
    font-weight: bolder;
    padding-left: 10%;
}

/*subtitulo blanco*/
h3{
    font-size: 20px;
    color: white;
    font-weight: bolder; 
    margin: 0;
}


/*texto*/
h6{
    font-size: 16px;
    color: white;
    font-weight: 500;
}

a{
    font-weight: 700;
    font-size: 12pt;
    color: #00183f;
    text-align: none;
}

hr{
    background-color: #ba800d;
    width: 100px;
    height: 10px;
    border-radius: 3px;
    margin: auto;
}

/*estilo de tablas*/
table{
    table-layout: fixed;
    width: 80%;
    border-collapse: collapse;
    border: 2px solid #000b1b;
    background-color: white;
}
th{
    border: 2px solid #000b1b;
    text-align: center;
    background-color: #000b1b;
    color: white;
}
td{
    border: 2px solid #000b1b;
    text-align: center;
    background-color: white;
    padding: 8px;
    font-weight: 600;
}

/*estilos de boton*/
.boton-oscuro{
    background-color: #000b1b;
    border: none;
    border-radius: 6px;
    padding: 5px;
    color: white;
    font-weight: 800;
    font-size: 14px;
}
.boton-oscuro:hover{
    background-color: #002b7a;
}

.boton-borde{
    margin-top: 10px;;
    background-color: transparent;
    border: 1px solid white;
    border-radius: 6px;
    color: white;
}
.boton-borde:hover{
    background-color: rgba(255, 255, 255, 0.664);
    color: #000b1b;
}
.boton-borde-oscuro{
    margin-top: 10px;;
    background-color: transparent;
    border: 1px solid #000b1b;
    border-radius: 6px;
    color: #000b1b;
}
.boton-borde-oscuro:hover{
    background-color: #000b1b94;
    color: #ffffff;
}
.boton-dorado{
    background-color: #ba800d;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 14px;
    font-weight: 800;
    padding: 6px;
}
.boton-dorado:hover{
    background-color: #002b7a;
}

.boton-azul{
    background-color: #002b7a;
    color: white;
    padding: 6px;
    border-radius: 8px;
    border: none;
}
.boton-azul:hover{
    background-color: #ba800d;
}
.boton-muestras{
    background-color: #002b7a;
    color: white;
    padding: 25px;
    padding-left: 60px;
    padding-right: 60px;
    border-radius: 8px;
    border: none;
}
.boton-muestras:hover{
    background-color: #ba800d;
}
    
/*estilo de contenedores*/
div{
    background-color: #050a30;
}
.titulos{
    padding-top: 50px;
    text-align: center;
    margin-bottom: 50px;
    margin-top: 50px;
}
.subtitulo{
    padding-top: 50px;
    margin-bottom: 50px;
    margin-top: 50px;
    background-color: transparent;
}
.botones-inicio{
    margin: auto;
    width: 80%;
    display: flex;
    justify-content: space-between;
}
.aviso{
    background-color: #ba800d;
    width: 80%;
    border-radius: 10px;
    margin: auto;
    margin-top: 30px;
    display: flex;
    align-items: center;
}

.cuadro-azul{
    background-color: #002b7a;
    border-radius: 10px;
    width: 60%;
    padding-top: 20px;
    padding-bottom: 50px;
    margin-top: 30px;
    margin: auto;
}

.cuadro-amarillo{
    background-color: #ba800d;
    margin-left: 30px;
    max-width: 92%;
    border-radius: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 20px;
    margin-top: px;
    margin-bottom: 30px;
}

.muestras{
    height: 300px;
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    margin-top: 50px;
}

.tabla{
    display: grid;
    place-items: center;
    background-color: transparent;
}

.elementos-centrados{
    display: grid;
    place-items: center;
}
.degradado{
    background-image: linear-gradient(#b8b8b8 15%, #ffffff 70%, #b8b8b8 );
}
/*Form controls*/
input{
    border-radius: 6px;
    border: none;
    width: 350px;
    padding: 10px;
    text-align: center;
    font-size: 16px;
    font-weight: 800;
    color: #000b1b;
    margin: 10px;
    background-color: white;
}
</style>
