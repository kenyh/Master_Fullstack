/***** INICIO DECLARACIÓN DE VARIABLES GLOBALES *****/

// Contadores de cartas
let contInicial = document.getElementById("contador_inicial");
let contMovimientos = document.getElementById("contador_movimientos");

// Tiempo
let contTiempo = document.getElementById("contador_tiempo"); // span cuenta tiempo
let segundos = 0; // cuenta de segundos
let temporizador = null; // manejador del temporizador

const mazoInicial = document.getElementById("mazo-inicial");

/***** FIN DECLARACIÓN DE VARIABLES GLOBALES *****/
function vaciarMazos() {
  for (const mazo of document.getElementsByClassName("mazo"))
    mazo.innerHTML = "";
}
function reiniciarContadores() {
  for (const contador of document.getElementsByClassName("contador"))
    contador.innerHTML = "0";
}
// Desarrollo del comienzo de juego
function comenzarJuego() {
  vaciarMazos();
  console.log("Comenzando juego...");

  const mazoInicial = [];
  for (let palo of ["viu", "cua", "hex", "cir"]) {
    for (let numero = 1; numero <= 12; numero++) {
      let img = document.createElement("img");
      img.src = `imagenes/baraja/${numero}-${palo}.png`;
      img.alt = `${numero} de ${palo}`;
      img.classList.add("carta");
      img.id = `carta-${numero}-${palo}`; //Por si lo necesitamos.
      img.draggable = false; //Solo la última será draggable.
      img.dataset.numero = numero; //Guardamos el número en un data-attribute.
      img.dataset.palo = palo; //Guardamos el palo en un data-attribute.
      img.addEventListener("dragstart", iniciaDrag); // Por ahora es suficiente solo con dragstart en la imagen.
      mazoInicial.push(img);
    }
  }

  // Barajar y dejar mazoInicial en tapete inicial
  /*** !!!!!!!!!!!!!!!!!!! CODIGO !!!!!!!!!!!!!!!!!!!! **/
  barajar(mazoInicial);
  cargarMazoInicial(mazoInicial);

  // Puesta a cero de contadores de mazos
  /*** !!!!!!!!!!!!!!!!!!! CODIGO !!!!!!!!!!!!!!!!!!!! **/
  reiniciarContadores();
  setContador(contInicial, mazoInicial.length);

  // Arrancar el conteo de tiempo
  /*** !!!!!!!!!!!!!!!!!!! CODIGO !!!!!!!!!!!!!!!!!!!! **/
  arrancarTiempo();
} // comenzarJuego

function arrancarTiempo() {
  if (temporizador) clearInterval(temporizador);
  let hms = function () {
    let seg = Math.trunc(segundos % 60);
    let min = Math.trunc((segundos % 3600) / 60);
    let hor = Math.trunc((segundos % 86400) / 3600);
    let tiempo =
      (hor < 10 ? "0" + hor : "" + hor) +
      ":" +
      (min < 10 ? "0" + min : "" + min) +
      ":" +
      (seg < 10 ? "0" + seg : "" + seg);
    setContador(contTiempo, tiempo);
    segundos++;
  };
  segundos = 0;
  hms(); // Primera visualización 00:00:00
  temporizador = setInterval(hms, 1000);
}

function barajar(mazo) {
  //FIXME: Optimizar el desordenamiento.
  mazo.sort(() => Math.random() - Math.random());
  mazo.sort(() => Math.random() - Math.random());
  mazo.sort(() => Math.random() - Math.random());
  mazo[mazo.length - 1].draggable = true;
} // barajar

function cargarMazoInicial(mazo) {
  for (let i = mazo.length - 1; i >= 0; i--) {
    mazoInicial.prepend(mazo[i]);
  }
}

function setContador(contador, valor) {
  contador.textContent = valor;
}

function eliminarCartas(cartasElement) {
  cartasElement.innerHTML = "";
}

function permitirDrop(event) {
  event.preventDefault();
}

function iniciaDrag(event) {
  //Lo unico que se puede arrastrar son las cartas.
  const carta = event.target;
  //Guardamos el id de la carta que se está arrastrando.
  event.dataTransfer.setData("idCarta", carta.id);
  event.dataTransfer.setData("palo", carta.dataset.palo);
  event.dataTransfer.setData("numero", carta.dataset.numero);
  event.dataTransfer.setData("idMazoOrigen", carta.parentElement.id);
}

function cartaSoltada(event) {
  event.preventDefault();
  //Obtenemos los datos del drag.
  const idCarta = event.dataTransfer.getData("idCarta");
  const idMazoOrigen = event.dataTransfer.getData("idMazoOrigen");
  if (!idCarta || !idMazoOrigen) {
    console.error("No se ha obtenido id de carta o idMazoOrigen.");
    return;
  }
  //Obtenemos el cartas destino
  const mazoDestino = event.target.closest(".mazo");
  //Obtenemos el cartas origen
  const mazoOrigen = document.getElementById(idMazoOrigen); //El tapete donde estaba la carta.
  //Obtenemos la carta arrastrada
  const cartaArrastrada = document.getElementById(idCarta);
  if (!cartaArrastrada) {
    console.error("No se ha obtenido elemento carta.");
    return;
  }

  if (mazoDestino.children.length !== 0)
    mazoDestino.lastElementChild.draggable = false; //Hago no draggablela última carta del mazo destino
  mazoDestino.appendChild(cartaArrastrada); //Añadimos la carta al nuevo cartas. Automaticamente se borra del origen.
  if (mazoOrigen.children.length !== 0)
    mazoOrigen.lastElementChild.draggable = true; //Hago draggable la última carta del mazo origen
  //Actualizamos contadores, origen, destino y movimientos.
  //Se opta por recalcular siempre el largo de los mazos involucrados. Ya que nos parece más seguro.
  const contador = mazoDestino.parentElement.querySelector(".contador");
  setContador(contador, mazoDestino.children.length);
  const contadorOrigen = mazoOrigen.parentElement.querySelector(".contador");
  setContador(contadorOrigen, mazoOrigen.children.length);
  const movimientosActuales = parseInt(contMovimientos.textContent || 0);
  setContador(contMovimientos, movimientosActuales + 1);
}
