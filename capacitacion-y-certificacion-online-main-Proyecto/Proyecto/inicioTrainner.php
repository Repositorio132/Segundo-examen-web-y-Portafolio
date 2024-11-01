<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Capacitador</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section>
        <h2>Bienvenido, Capacitador</h2>
        <h3>Panel de Administración de Tareas y Cuestionarios</h3>
    </section>

    <!-- Sección para crear apartados y tareas -->
    <section>
        <h2>Crear Apartado de Tareas</h2>
        <form id="create-section-form" onsubmit="crearApartado(event)">
            <input type="text" id="sectionName" placeholder="Nombre del Apartado" required>
            <button type="submit">Crear Apartado</button>
        </form>
        
        <h2>Crear Nueva Tarea</h2>
        <form id="create-task-form" onsubmit="crearTarea(event)">
            <input type="text" id="taskName" placeholder="Nombre de la Tarea" required>
            <select id="taskSection" required>
                <option value="">Seleccione un apartado</option>
            </select>
            <textarea id="taskInstructions" placeholder="Instrucciones para la tarea" rows="4"></textarea>
            <button type="submit">Crear Tarea</button>
        </form>
    </section>

    <!-- Sección para crear cuestionarios -->
    <section>
        <h2>Crear Cuestionario</h2>
        <form id="create-quiz-form" onsubmit="crearCuestionario(event)">
            <input type="text" id="quizTitle" placeholder="Título del Cuestionario" required>
            <button type="button" onclick="agregarPregunta()">Agregar Pregunta</button>
            <button type="submit">Crear Cuestionario</button>
        </form>
        <div id="quiz-questions-container"></div>
    </section>

    <!-- Sección de cuestionarios y tareas asignables -->
    <section>
        <h2>Apartados, Tareas y Cuestionarios del Curso</h2>
        <div id="sections-container"></div>
        <div id="quizzes-container">
            <h3>Cuestionarios Disponibles</h3>
        </div>
    </section>

    <script>
        const sections = {};
        const quizzes = [];

        // Función para crear un nuevo apartado
        function crearApartado(event) {
            event.preventDefault();
            const sectionName = document.getElementById("sectionName").value;
            
            if (sectionName && !sections[sectionName]) {
                sections[sectionName] = [];
                actualizarApartados();
                document.getElementById("sectionName").value = "";
                alert(`Apartado "${sectionName}" creado exitosamente.`);
            } else {
                alert("El nombre del apartado es inválido o ya existe.");
            }
        }

        function actualizarApartados() {
            const taskSection = document.getElementById("taskSection");
            const sectionsContainer = document.getElementById("sections-container");

            taskSection.innerHTML = '<option value="">Seleccione un apartado</option>';
            sectionsContainer.innerHTML = '';

            for (const section in sections) {
                const option = document.createElement("option");
                option.value = section;
                option.textContent = section;
                taskSection.appendChild(option);

                const sectionDiv = document.createElement("div");
                sectionDiv.classList.add("section");

                const sectionTitle = document.createElement("h3");
                sectionTitle.textContent = section;
                sectionDiv.appendChild(sectionTitle);

                const taskList = document.createElement("ul");
                taskList.classList.add("tasks-list");
                
                sections[section].forEach(task => {
                    const taskItem = crearElementoTarea(task);
                    taskList.appendChild(taskItem);
                });

                sectionDiv.appendChild(taskList);
                sectionsContainer.appendChild(sectionDiv);
            }
        }

        function crearTarea(event) {
            event.preventDefault();
            const taskName = document.getElementById("taskName").value;
            const taskSection = document.getElementById("taskSection").value;
            const taskInstructions = document.getElementById("taskInstructions").value;

            if (taskName && taskSection && sections[taskSection]) {
                const taskId = new Date().getTime();
                const newTask = { id: taskId, name: taskName, instructions: taskInstructions, available: false };
                sections[taskSection].push(newTask);
                
                actualizarApartados();
                document.getElementById("taskName").value = "";
                document.getElementById("taskInstructions").value = "";
                alert(`Tarea "${taskName}" creada en el apartado "${taskSection}".`);
            } else {
                alert("Debe ingresar un nombre de tarea y seleccionar un apartado.");
            }
        }

        function crearElementoTarea(task) {
            const taskItem = document.createElement("li");
            taskItem.classList.add("task");
            if (task.available) taskItem.classList.add("available");

            const taskTitle = document.createElement("h4");
            taskTitle.textContent = task.name;
            taskItem.appendChild(taskTitle);

            const instructions = document.createElement("p");
            instructions.textContent = `Instrucciones: ${task.instructions || "No se han especificado instrucciones."}`;
            taskItem.appendChild(instructions);

            const toggleLabel = document.createElement("label");
            toggleLabel.innerHTML = `<input type="checkbox" ${task.available ? "checked" : ""} onchange="toggleAvailability('${task.section}', ${task.id})"> Disponible`;
            taskItem.appendChild(toggleLabel);

            const assignButton = document.createElement("button");
            assignButton.textContent = "Asignar Tarea";
            assignButton.onclick = () => asignarTarea(task.section, task.id);
            taskItem.appendChild(assignButton);

            return taskItem;
        }

        function toggleAvailability(section, taskId) {
            const task = sections[section].find(t => t.id === taskId);
            task.available = !task.available;
            actualizarApartados();
            alert(`La tarea "${task.name}" en "${section}" ahora está ${task.available ? "disponible" : "no disponible"}.`);
        }

        function asignarTarea(section, taskId) {
            const task = sections[section].find(t => t.id === taskId);
            if (task.available) {
                alert(`La tarea "${task.name}" en "${section}" ha sido asignada.`);
            } else {
                alert("Esta tarea no está disponible para asignar.");
            }
        }

        // Crear un nuevo cuestionario
        function crearCuestionario(event) {
            event.preventDefault();
            const quizTitle = document.getElementById("quizTitle").value;
            const questions = Array.from(document.querySelectorAll(".question-container")).map(q => ({
                questionText: q.querySelector(".question-text").value,
                options: Array.from(q.querySelectorAll(".option")).map(opt => opt.value),
                correctAnswer: Array.from(q.querySelectorAll(".option-radio")).find(r => r.checked).value
            }));

            if (quizTitle && questions.length > 0) {
                const newQuiz = { id: new Date().getTime(), title: quizTitle, questions, available: false };
                quizzes.push(newQuiz);
                document.getElementById("quizTitle").value = "";
                document.getElementById("quiz-questions-container").innerHTML = "";
                actualizarCuestionarios();
                alert(`Cuestionario "${quizTitle}" creado exitosamente.`);
            } else {
                alert("Debe ingresar un título y al menos una pregunta para el cuestionario.");
            }
        }

        function actualizarCuestionarios() {
            const quizzesContainer = document.getElementById("quizzes-container");
            quizzesContainer.innerHTML = `<h3>Cuestionarios Disponibles</h3>`;

            quizzes.forEach(quiz => {
                const quizItem = document.createElement("div");
                quizItem.classList.add("quiz-item");

                const quizTitle = document.createElement("h4");
                quizTitle.textContent = quiz.title;
                quizItem.appendChild(quizTitle);

                const toggleLabel = document.createElement("label");
                toggleLabel.innerHTML = `<input type="checkbox" ${quiz.available ? "checked" : ""} onchange="toggleQuizAvailability(${quiz.id})"> Disponible`;
                quizItem.appendChild(toggleLabel);

                const assignButton = document.createElement("button");
                assignButton.textContent = "Asignar Cuestionario";
                assignButton.onclick = () => asignarCuestionario(quiz.id);
                quizItem.appendChild(assignButton);

                quizzesContainer.appendChild(quizItem);
            });
        }

        function toggleQuizAvailability(quizId) {
            const quiz = quizzes.find(q => q.id === quizId);
            quiz.available = !quiz.available;
            actualizarCuestionarios();
            alert(`El cuestionario "${quiz.title}" ahora está ${quiz.available ? "disponible" : "no disponible"}.`);
        }

        function asignarCuestionario(quizId) {
            const quiz = quizzes.find(q => q.id === quizId);
            if (quiz.available) {
                alert(`El cuestionario "${quiz.title}" ha sido asignado.`);
            } else {
                alert("Este cuestionario no está disponible para asignar.");
            }
        }

        function agregarPregunta() {
            const questionContainer = document.createElement("div");
            questionContainer.classList.add("question-container");

            questionContainer.innerHTML = `
                <input type="text" class="question-text" placeholder="Texto de la Pregunta" required>
                <label for="optionCount">Número de opciones:</label>
                <select class="option-count" onchange="generarOpciones(this)">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4" selected>4</option>
                </select>
                <div class="options-container">
                    ${generarOpcionesHTML(4)}
                </div>
            `;
            document.getElementById("quiz-questions-container").appendChild(questionContainer);
        }

        function generarOpciones(selectElement) {
            const optionsContainer = selectElement.closest('.question-container').querySelector('.options-container');
            const optionCount = parseInt(selectElement.value);
            optionsContainer.innerHTML = generarOpcionesHTML(optionCount);
        }

        function generarOpcionesHTML(count) {
            return Array.from({ length: count }, (_, index) => `
                <div class="option-group">
                    <input type="radio" name="correctOption${Date.now()}" class="option-radio" value="Opción ${index + 1}" ${index === 0 ? "checked" : ""}>
                    <input type="text" class="option" placeholder="Opción ${index + 1}" required>
                </div>
            `).join('');
        }
    </script>
</body>
</html>
