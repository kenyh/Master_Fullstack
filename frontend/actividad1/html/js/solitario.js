/***** INICIO DECLARACIÓN DE VARIABLES GLOBALES *****/

const mazoInicial = document.getElementById("mazo-inicial"); //Mazo inicial se usa en varios lados.
const mazoSobrantes = document.getElementById("mazo-sobrantes"); //Mazo sobrantes se usa en varios lados.
const contMovimientos = document.getElementById("contador_movimientos"); //Acá porque se usa en 2 lugares.
const contTiempo = document.getElementById("contador_tiempo"); // Aquí porque se usa en varios lados.
let temporizador = null; // Lo dejamo global para poderle hacer el clear.
//const NUMERO_INICIAL = 10; //Numero entre 1 y 12 para variar la cantidad de cartas. Siempre termina en 12.

let numeroInicial = 9; // Por defecto: Fácil (9-12)

const DIFICULTADES = {
  facil: { nombre: "Fácil", inicio: 9, cartas: "16 cartas" },
  medio: { nombre: "Medio", inicio: 4, cartas: "36 cartas" },
  dificil: { nombre: "Difícil", inicio: 1, cartas: "48 cartas" },
};

const PALO_COLOR = {
  viu: "orange",
  cua: "orange",
  hex: "grey",
  cir: "grey",
}; //FIXME: Hacer readonly? Mover dentro del método?

/***** FIN DECLARACIÓN DE VARIABLES GLOBALES *****/

/**
Cambia la dificultad del juego
 */
function cambiarDificultad(botonActual, dificultad) {
  console.log({ botonActual });
  if (!DIFICULTADES[dificultad]) {
    return;
  }
  numeroInicial = DIFICULTADES[dificultad].inicio;
  document.querySelectorAll(".btn-dificultad.active").forEach((btn) => {
    btn.classList.remove("active");
    const icono = btn.querySelector("i.active");
    if (icono) icono.remove();
  });

  if (!botonActual) throw new Error("Se perdión el botón.");
  botonActual.classList.add("active");
  const icono = document.createElement("i");
  icono.classList.add("bi", "bi-check-lg", "active");
  botonActual.appendChild(icono);
  comenzarJuego(); // Reiniciar juego con nueva dificultad
}

function vaciarMazos() {
  //Vaciamos todo los elementos html que son un mazo (tienen clase mazo)
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
  console.info("Comenzando juego...");
  vaciarMazos();
  const mazo = generarMazo(); //Generamos el mazo
  barajar(mazo); //Desordenamos el mazo
  cargarMazoInicial(mazo); //Cargamos todos los elementos img en el dom
  calcularContadorDeMazos(); //Calculamos el contador para TODOS los mazos.
  setContador(contMovimientos, 0); //Contador de movimientos queda en cero.
  arrancarTiempo(); //Arranca el conteo de tiempo
}

function generarMazo() {
  const mazo = [];
  for (let palo of Object.keys(PALO_COLOR)) {
    for (let numero = numeroInicial; numero <= 12; numero++) {
      let img = document.createElement("img");
      img.src = `imagenes/baraja/${numero}-${palo}.png`;
      img.alt = `${numero} de ${palo}`;
      img.classList.add("carta");
      img.id = `carta-${numero}-${palo}`; //Por si lo necesitamos.
      img.draggable = false; //Solo la última será draggable.
      img.dataset.numero = numero; //Guardamos el número en un data-attribute.
      img.dataset.palo = palo; //Guardamos el palo en un data-attribute.
      img.dataset.color = PALO_COLOR[palo];
      img.addEventListener("dragstart", iniciaDrag); // Por ahora es suficiente solo con dragstart en la imagen.
      mazo.push(img);
    }
  }
  return mazo;
}

function arrancarTiempo() {
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
  if (!mazo || mazo.length === 0)
    throw new Error("El mazo está vacío. No se puede barajar.");
  //FIXME: Optimizar el desordenamiento?.
  mazo.sort(() => Math.random() - Math.random());
  mazo.sort(() => Math.random() - Math.random());
  mazo.sort(() => Math.random() - Math.random());
  mazo[mazo.length - 1].draggable = true; //a la de más "arriba" le ponemos draggable.
} // barajar

function cargarMazoInicial(mazo) {
  for (let i = mazo.length - 1; i >= 0; i--) {
    mazoInicial.prepend(mazo[i]);
  }
}

function setContador(contador, valor) {
  if (!contador) throw new Error("No especificaste el contador.");
  contador.textContent = valor;
}

function permitirDrop(event) {
  event.preventDefault();
}

function iniciaDrag(event) {
  const carta = event.target; //Lo unico que se puede arrastrar son las cartas.
  event.dataTransfer.setData("idCarta", carta.id); //Guardamos el id de la carta que se está arrastrando.
  event.dataTransfer.setData("idMazoOrigen", carta.parentElement.id); //También guardamos el mazo al que pertenece la carta. mazo es el padre de carta.
}

function cartaSoltada(event) {
  event.preventDefault();
  //Obtenemos los datos de la imágen arrastrada.
  const idCarta = event.dataTransfer.getData("idCarta");
  const idMazoOrigen = event.dataTransfer.getData("idMazoOrigen");
  if (!idCarta || !idMazoOrigen) {
    return console.error("No se ha obtenido id de carta o idMazoOrigen.");
  }

  const mazoDestino = event.target.closest(".mazo"); //Obtenemos el mazo destino
  const mazoOrigen = document.getElementById(idMazoOrigen); //Obtenemos el mazo origen
  if (mazoDestino === mazoOrigen) return; //Para que no cuente ni haga nada.
  //Obtenemos la carta arrastrada
  const cartaArrastrada = document.getElementById(idCarta);
  if (!cartaArrastrada) {
    console.error("No se ha obtenido elemento carta.");
    return;
  }
  if (!mazoAceptaCarta(mazoDestino, cartaArrastrada)) return;

  //En este punto ya sabemos que es válido mover la carta desde origen a destino.
  if (mazoDestino.children.length !== 0)
    mazoDestino.lastElementChild.draggable = false; //Hago no draggable la última carta del mazo destino

  mazoDestino.appendChild(cartaArrastrada); //Añadimos la carta al mazoDestino. Automaticamente se borra del origen.

  if (mazoOrigen.childElementCount !== 0)
    mazoOrigen.lastElementChild.draggable = true; //Hago draggable la última carta del mazo origen

  //Si el mazoInicial quedó vacío y sobrantes tiene elementos.
  if (
    mazoInicial.childElementCount === 0 &&
    mazoSobrantes.childElementCount !== 0
  ) {
    const mazo = [...mazoSobrantes.children]; //barajar acepta un array normal.
    mazoSobrantes.innerHTML = "";
    barajar(mazo);
    cargarMazoInicial(mazo);
    calcularContadorDeMazos([mazoSobrantes]);
  }

  calcularContadorDeMazos([mazoDestino, mazoOrigen]); //Actualizamos contadores, origen, destino y movimientos. Se opta por recalcular siempre el largo de los mazos involucrados. Ya que nos parece más seguro.
  setContador(contMovimientos, parseInt(contMovimientos.textContent || 0) + 1); //Incrementamos el contador de movimientos

  //Después que se actualizó todos los contadores y demás,
  verificarJuegoTerminado();
}

function mazoAceptaCarta(mazoDiv, cartaImg) {
  //Precondiciones
  if (!mazoDiv?.id) throw new Error("No hay mazoDestino.");
  if (!cartaImg?.id) throw new Error("No hay carta moviéndose.");
  const { numero, palo, color } = cartaImg?.dataset || {};
  if (!numero || !palo || !color)
    throw new Error("Falta número, palo y/o color de la carta.");
  if (mazoDiv.id === "mazo-inicial")
    throw new Error("Mazo inicial no permite recibir cartas.");

  if (mazoDiv.id === "mazo-sobrantes") return true; //Acepta cualquier carta.
  if (!mazoDiv.id.includes("receptor"))
    throw new Error("No se reconoce el mazo.");

  //En este punto tiene que ser un mazo receptor. Verificar si el mazo receptor acepta la carta.
  if (mazoDiv.children.length === 0) return numero === "12"; //Si el mazo es vacío solo acepta un 12.

  const ultimaCarta = mazoDiv.lastElementChild;
  const valActual = parseInt(ultimaCarta.dataset.numero);
  const valNuevo = parseInt(numero);

  //Si el mazo no es vacío, acepta una carta de distinto color y un número menor unicamente.
  return ultimaCarta.dataset.color !== color && valActual - 1 === valNuevo;
}

function verificarJuegoTerminado() {
  //Si los mazos inicial y sobrantes están vacíos: Ganaste.
  if (
    mazoInicial.childElementCount === 0 &&
    mazoSobrantes.childElementCount === 0
  ) {
    if (temporizador) clearInterval(temporizador);
    const tiempo = contTiempo.textContent;
    const movimientos = contMovimientos.textContent;
    const miModal = document.getElementById("miModal");
    miModal.querySelector("span#tiempo-final").innerHTML = movimientos;
    miModal.querySelector("span#movimientos-final").innerHTML = tiempo;
    miModal.showModal();
  }
}
