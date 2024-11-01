CREATE DATABASE CursosDB;
USE CursosDB;

-- Tabla Estado
CREATE TABLE Estado (
    Id_Estado INT PRIMARY KEY,
    Estado_curso VARCHAR(50) NOT NULL
);

-- Tabla Progreso
CREATE TABLE Progreso (
    Id_Progreso INT PRIMARY KEY,
    Porcentaje_Tareas DECIMAL(5,2)
);

-- Tabla Cursante
CREATE TABLE Cursante (
    Matricula INT PRIMARY KEY,
    Nombre VARCHAR(50),
    NombrePila VARCHAR(50),
    Apellido_Paterno VARCHAR(50),
    Apellido_Materno VARCHAR(50),
    Numero_Celular VARCHAR(15),
    Correo VARCHAR(50),
    Fecha_registro DATE,
    Cursos_Cursante INT,
    Calificaciones DECIMAL(5,2)
);

-- Tabla Capacitor
CREATE TABLE Capacitor (
    CodCapacitador INT PRIMARY KEY,
    Nombre VARCHAR(50),
    NombrePila VARCHAR(50),
    Apellido_Paterno VARCHAR(50),
    Apellido_Materno VARCHAR(50),
    Numero_Celular VARCHAR(15),
    Correo VARCHAR(50)
);

-- Tabla Curso
CREATE TABLE Curso (
    Codigo_Curso INT PRIMARY KEY,
    Nombre_Curso VARCHAR(100),
    Descripcion_Curso TEXT,
    Duracion INT,
    Fecha_Inicio DATE,
    Fecha_Fin DATE,
    Estado INT,
    FOREIGN KEY (Estado) REFERENCES Estado(Id_Estado)
);

-- Tabla Inscripción 
CREATE TABLE Inscripcion (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Curso INT,
    Cursante INT,
    Fecha_inscripcion DATE,
    FOREIGN KEY (Curso) REFERENCES Curso(Codigo_Curso),
    FOREIGN KEY (Cursante) REFERENCES Cursante(Matricula)
);

-- Tabla Tarea
CREATE TABLE Tarea (
    Num_Tarea INT PRIMARY KEY,
    Titulo VARCHAR(100),
    Descripcion TEXT,
    Fecha_Creacion DATE,
    Fecha_Entrega DATE,
    Puntaje_Tarea DECIMAL(5,2)
);

-- Tabla Estado de Tarea 
CREATE TABLE Tarea_Progreso (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Tarea INT,
    Progreso INT,
    FOREIGN KEY (Tarea) REFERENCES Tarea(Num_Tarea),
    FOREIGN KEY (Progreso) REFERENCES Progreso(Id_Progreso)
);

-- Tabla Material de Apoyo
CREATE TABLE Material_Apoyo (
    Codigo_Material INT PRIMARY KEY,
    Nombre_Material VARCHAR(100),
    Descripcion TEXT
);

-- Relación entre Curso y Material de Apoyo 
CREATE TABLE Curso_Material (
    Curso INT,
    Material INT,
    PRIMARY KEY (Curso, Material),
    FOREIGN KEY (Curso) REFERENCES Curso(Codigo_Curso),
    FOREIGN KEY (Material) REFERENCES Material_Apoyo(Codigo_Material)
);

-- Tabla Tema
CREATE TABLE Tema (
    Codigo_Tema INT PRIMARY KEY,
    Nombre_tema VARCHAR(100),
    Descripcion_Tema TEXT
);

-- Relación entre Curso y Tema 
CREATE TABLE Curso_Tema (
    Curso INT,
    Tema INT,
    PRIMARY KEY (Curso, Tema),
    FOREIGN KEY (Curso) REFERENCES Curso(Codigo_Curso),
    FOREIGN KEY (Tema) REFERENCES Tema(Codigo_Tema)
);

-- Tabla Examen
CREATE TABLE Examen (
    Codigo_Examen INT PRIMARY KEY,
    Codigo_Curso INT,
    TipoExamen VARCHAR(50),
    Hora_Inicio TIME,
    Hora_fin TIME,
    Puntaje DECIMAL(5,2),
    FOREIGN KEY (Codigo_Curso) REFERENCES Curso(Codigo_Curso)
);

-- Tabla Pregunta
CREATE TABLE Pregunta (
    num_Pregunta INT PRIMARY KEY,
    Texto_Pregunta TEXT
);

-- Relación entre Examen y Pregunta (Examen contiene Pregunta)
CREATE TABLE Examen_Pregunta (
    Examen INT,
    Pregunta INT,
    PRIMARY KEY (Examen, Pregunta),
    FOREIGN KEY (Examen) REFERENCES Examen(Codigo_Examen),
    FOREIGN KEY (Pregunta) REFERENCES Pregunta(num_Pregunta)
);

-- Tabla Respuesta
CREATE TABLE Respuesta (
    num_Respuesta INT PRIMARY KEY,
    Descripcion TEXT,
    Puntaje_Respuesta DECIMAL(5,2)
);

-- Relación entre Pregunta y Respuesta (Pregunta tiene Respuesta)
CREATE TABLE Pregunta_Respuesta (
    Pregunta INT,
    Respuesta INT,
    PRIMARY KEY (Pregunta, Respuesta),
    FOREIGN KEY (Pregunta) REFERENCES Pregunta(num_Pregunta),
    FOREIGN KEY (Respuesta) REFERENCES Respuesta(num_Respuesta)
);

-- Tabla Certificación
CREATE TABLE Certificacion (
    Folio_Certificacion INT PRIMARY KEY,
    Nombre_Certificacion VARCHAR(100),
    Titulo_Certificado VARCHAR(100),
    Fecha_Expedicion DATE
);

-- Relación entre Examen y Certificación
CREATE TABLE Examen_Certificacion (
    Examen INT,
    Certificacion INT,
    PRIMARY KEY (Examen, Certificacion),
    FOREIGN KEY (Examen) REFERENCES Examen(Codigo_Examen),
    FOREIGN KEY (Certificacion) REFERENCES Certificacion(Folio_Certificacion)
);

-- Relación entre Curso y Capacitor
CREATE TABLE Curso_Capacitor (
    Curso INT,
    Capacitor INT,
    PRIMARY KEY (Curso, Capacitor),
    FOREIGN KEY (Curso) REFERENCES Curso(Codigo_Curso),
    FOREIGN KEY (Capacitor) REFERENCES Capacitor(CodCapacitador)
);
