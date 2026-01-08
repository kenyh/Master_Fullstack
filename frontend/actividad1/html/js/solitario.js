/***** INICIO DECLARACIÓN DE VARIABLES GLOBALES *****/

let contMovimientos = document.getElementById("contador_movimientos"); //Acceso global a contador movimientos

let temporizador = null; // Lo dejamo global para poderle hacer el clear.

/***** FIN DECLARACIÓN DE VARIABLES GLOBALES *****/

function vaciarMazos() {
  for (const mazo of document.getElementsByClassName("mazo"))
    mazo.innerHTML = "";
}

function calcularContadorDeMazos(mazos) {
  if (!mazos) mazos = document.getElementsByClassName("mazo");
  for (const mazo of mazos) {
    //Busco el contador asociado a el mazo y le pongo el largo del mazo
    setContador(
      mazo.parentElement.querySelector(".contador"),
      mazo.children.length
    );
  }
}

function comenzarJuego() {
  console.log("Comenzando juego...");
  vaciarMazos(); //Vaciamos todo los elementos html que son un mazo
  const mazo = generarMazo(); //Generamos el mazo
  barajar(mazo); //Desordenamos el mazo
  cargarMazoInicial(mazo); //Cargamos todos los elementos img en el dom
  calcularContadorDeMazos(); //Calculamos el contador para TODOS los mazos.
  setContador(contMovimientos, 0); //Contador de movimientos queda en cero.
  arrancarTiempo(); //Arranca el conteo de tiempo
}

function generarMazo() {
  const mazo = [];
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
      mazo.push(img);
    }
  }
  return mazo;
}

function arrancarTiempo() {
  let contTiempo = document.getElementById("contador_tiempo"); // span cuenta tiempo
  let segundos = 0; // cuenta de segundos
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
  const mazoInicial = document.getElementById("mazo-inicial");
  for (let i = mazo.length - 1; i >= 0; i--) {
    mazoInicial.prepend(mazo[i]);
  }
}

function setContador(contador, valor) {
  contador.textContent = valor;
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

  //Actualizamos contadores, origen, destino y movimientos. Se opta por recalcular siempre el largo de los mazos involucrados. Ya que nos parece más seguro.
  calcularContadorDeMazos([mazoDestino, mazoOrigen]);
  setContador(contMovimientos, parseInt(contMovimientos.textContent || 0) + 1);
}
