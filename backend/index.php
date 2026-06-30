<form action="procesar.php" method="POST">

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="curso">Curso:</label>
    <select id="curso" name="curso" required>
        <option value="4to A">4to A</option>
        <option value="5to A">5to A</option>
    </select>

    <button type="submit">Registrar</button>

</form>