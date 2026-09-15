// Busca las opciones del menú
const opcionesMenu = document.querySelectorAll(".opcion-menu");
// Busca las secciones
const secciones = document.querySelectorAll(".seccion");
// Recorre las opciones del menú
opcionesMenu.forEach(function(opcion) {
    opcion.addEventListener("click", function() {
        // Quita la selección de todas las opciones
        opcionesMenu.forEach(function(elemento) {
            elemento.classList.remove("seleccionada");
        });
        // Selecciona la opción que se presionó
        opcion.classList.add("seleccionada");
        // Oculta todas las secciones
        secciones.forEach(function(seccion) {
            seccion.classList.remove("visible");
        });
        // Obtiene el nombre de la sección
        const nombreSeccion = opcion.dataset.seccion;
        // Busca la sección correspondiente
        const seccionSeleccionada = document.getElementById(nombreSeccion);
        // Muestra la sección
        seccionSeleccionada.classList.add("visible");
    });
});