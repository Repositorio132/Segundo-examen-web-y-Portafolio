<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso de Matemáticas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section>
        <div>
            <h2>Bienvenido cursante</h2>
            <h3>Al curso de Matemáticas</h3>
        </div> 
    </section>

    <section>
        <h2>Tareas del Curso</h2>
        <ul class="tasks-list">
            <li class="task available">
                <h4>Tarea 1: Introducción a Matemáticas</h4>
                <button onclick="comenzarTarea(1)">Comenzar Tarea</button>
            </li>
            <li class="task unavailable">
                <h4>Tarea 2: Ecuaciones Lineales</h4>
                <button disabled>No Disponible</button>
            </li>
            <li class="task unavailable">
                <h4>Tarea 3: Funciones y Gráficas</h4>
                <button disabled>No Disponible</button>
            </li>
        </ul>
    </section>

    <script>
        function comenzarTarea(taskId) {
            alert("Has comenzado la Tarea " + taskId + "!");
            // Aquí puedes agregar la lógica adicional para redirigir o marcar la tarea como "en progreso".
        }
    </script>
</body>
</html>
