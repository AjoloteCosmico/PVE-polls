<style>
/* Aqui puedes poner codigo css que sobre escribira los estilos predeterminados */
*{
    font-family: "Montserrat", sans-serif;
}

body{
    display: block;
    /*background-image: url('img/fondo-biblioteca.png')*/
    background-color: #050a30;
    
}

/*estilos de texto*/

/*titulo*/
h1{
    font-weight: bolder;
    font-size: 30px;
    color: white;
    text-align: center;
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
    color: white;
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
    color: white;
    padding: 8px;
    font-weight: 600;
}

/*cuadro de búsqueda*/

.dataTables_filter input {
    width: 1vw;
	max-height:2vw;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 3px #ccc, 0 10px 15px #ebebeb inset;
    text-indent: 10px;
    color: #002b7a;
    font-size: 1.3vw;
	margin-left: 10px;
  }
   
.dataTables_filter {
    align-items: center;
    size: 40px;
	color: white;
  
  }

#myTable_info {
  color: white;
}

/*prueba de next y previous*/

.paginate_button.previous {
  background-color: #000b1b;
  color: white !important;
  padding: 8px 12px;
  border-radius: 6px;
  margin: 2px;
  font-weight: bold;
}

/* Botón "Next" */
.paginate_button.next {
  background-color: #000b1b;
  color: white !important;
  padding: 8px 12px;
  border-radius: 6px;
  margin: 2px;
  font-weight: bold;
}
/* Hover efecto */
.paginate_button.previous:hover,
.paginate_button.next:hover {
  background-color: #002b7a;
  cursor: pointer;
}


/*estilos de botones de navegacion*/
.boton-volver {
  background-color: #ba800d;
  color: white;
  padding: 10px 16px;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  font-size: 20px;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
  margin-bottom: 15px;
}

.boton-volver:hover {
  background-color: #002b7a;
}

div.dataTables_length select {
  color: #002b7a; 
    background-color: white; 
    font-weight: 600;
}

div.dataTables_length label {
  color: white; 
}



/*estilos de letras en buscar*/
.label-cuenta {
  color: white;
  font-size: 2rem; 
}

.label-nombrecompleto {
  color: white;
  font-size: 2rem;  
}

.label-correo {
  color: white;
  font-size: 2rem;  
}


/*boton de buscar*/

.boton-buscar {
  background-color: #ba800d;  /* Fondo azul oscuro */
  color: white;               /* Color del texto */
  border: none;
}

.boton-buscar:hover {
  background-color: #002b7a;  /* Color al pasar el mouse */
}

/*alternativa para borrar*/

.boton-borrar {
  background-color: #002b7a; 
  color: white;               
  border: none;
}
.boton-borrar:hover {
  background-color: #ba800d;  
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
    padding: 20px 50px;
    justify-content: center;
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

.boton-muestras img.icono-boton {
  width: 90px;       /* ajusta al tamaño que desees */
  height: auto;
  margin-bottom: auto;
}
    
/*estilo de contenedores*/
div{
    background-color: #050a30;
}
.tel-contorno{
    background-color: rgba(255, 255, 255, 0.06);
    border: 2px solid white;
    border-radius: 10px;
    padding: 20px;
}
.tel-contorno-div{
    background-color: transparent !important;
}
.recado-form-div{
    background-color: #002b7a;
    border-radius: 10px;
    padding: 20px;
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
    justify-content: center;
    gap: 1rem;
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
.content-wrapper{
    /*background-image: url('img/fondo-biblioteca.png')*/
    background-color: #050a30;
}
.cuadro-azul{
    background-color: #002b7a;
    border-radius: 10px;
    width: 70%;
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
    display: block;
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
    font-weight: 200;
    color: #002b7a;
    margin: 10px;
    background-color: white;
    display: block;
    margin: auto;
}

footer{
    background:#002b7a;
    border-top: 1px solid #ba800d;
    color: white;
    padding: 1rem;
    margin-left: 250px;
}
/* Estilos de botones de formulario */
.mi-popup {
    background-color: #050a30;
    color: #fff;
}
.mi-titulo {
    color: #ba800d;
}
.mi-boton {
    background-color: #f44336;
    color: #fff;
}



</style>
