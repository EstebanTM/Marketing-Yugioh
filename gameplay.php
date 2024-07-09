<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="recursos/logo.png" type="image/x-icon">
    <title>Como jugar</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/gameplay.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="recursos/Yu-Gi-Oh!.png" alt="" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="php/eventos.php">Eventos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="php/perfil.php">Perfil</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="gameplay.php">Como jugar YuGiOh!</a>
                        </li>
                    </ul>
                </div>
                <div class="ms-auto">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</a>
                    <?php else: ?>
                    <a href="php/logout.php" class="nav-link">Cerrar Sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <!-- Contenido principal -->
    <div id="gameplay-content" class="container content-section">
    <h1>Cómo Jugar Yu-Gi-Oh!</h1>

    <div id="objetivo">
        <h2>Objetivo del Juego</h2>
        <p>El objetivo del juego es reducir los puntos de vida (LP) de tu oponente a 0 antes de que ellos reduzcan los tuyos. Cada jugador comienza con 8000 puntos de vida.</p>
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
                <video class="d-block w-100" autoplay loop muted>
                    <source src="recursos/v1.mp4" type="video/mp4">
                </video>  
            </div>
            </div>
            </div>
          <div class="clearfix"></div> <!-- Limpieza de flotantes -->
          <br> <!-- Salto de línea -->   
    </div>

    <div id="componentes">
         <h2>Componentes del Juego</h2>
        <h3>Cartas</h3>
        <ul>
        <li><b>Cartas de Monstruo:</b> Estas cartas se usan para atacar y defender.</li>
        </ul>
        <img src="recursos/k2.png" alt="Carta de Monstruo" class="left-image" style="width: 700px; height: auto; margin-right: 20px;">
        <div class="clearfix"></div> <!-- Limpieza de flotantes -->
        <br> <!-- Salto de línea -->
        <ul><li><b>Cartas de Magia:</b> Estas cartas tienen efectos especiales que pueden influir en el juego de diversas maneras.</li></ul>
        <img src="recursos/c4.jpg" alt="Carta de Magica" class="left-image" style="width: 150px; height: auto; margin-right: 20px;">
        <div class="clearfix"></div> <!-- Limpieza de flotantes -->
        <br> <!-- Salto de línea -->
        <ul><li><b>Cartas de Trampa:</b> Estas cartas se colocan boca abajo y se activan en respuesta a ciertas acciones del oponente.</li></ul>
        <img src="recursos/c3.png" alt="Carta de Trampa" class="left-image" style="width: 150px; height: auto; margin-right: 20px;">
        <div class="clearfix"></div> <!-- Limpieza de flotantes -->
        <br> <!-- Salto de línea -->
        <ul><li><b>DATO IMPORTANTE:</b> Tu deck solo puede contener mínimo 40 y máximo 60 cartas.</li></ul>
        <img src="recursos/d1.jpg" alt="Carta de Trampa" class="left-image" style="width: 400px; height: auto; margin-right: 20px;">
        <div class="clearfix"></div> <!-- Limpieza de flotantes -->
        <br> <!-- Salto de línea -->
        


        <h3>Campo de Juego</h3>
        <ul>
            <li><b>Zonas de Monstruo:</b> Hasta 5 monstruos pueden estar en el campo a la vez.</li>
            <li><b>Zonas de Magia y Trampa:</b> Hasta 5 cartas de Magia o Trampa pueden estar en el campo a la vez.</li>
            <li><b>Zona de Cementerio:</b> Aquí van las cartas destruidas.</li>
            <li><b>Zona de Deck Principal:</b> Aquí está tu mazo principal de cartas.</li>
            <li><b>Zona de Deck Extra:</b> Aquí están cartas especiales como los Monstruos de Fusión, Sincronía y XYZ.</li>
        </ul>
        <img src="recursos/t1.jpg" alt="Carta de Trampa" class="left-image" style="width: 800px; height: auto; margin-right: 20px;">
        <div class="clearfix"></div> <!-- Limpieza de flotantes -->
        
    </div>

    <div id="fases">
        <h2>Fases del Juego</h2>
        <ul>
            <li><b>Draw Phase (Fase de Robo):</b> El jugador roba una carta.</li>
            <li><b>Standby Phase (Fase de Espera):</b> Se resuelven efectos que ocurren durante esta fase.</li>
            <li><b>Main Phase 1 (Fase Principal 1):</b> El jugador puede invocar monstruos, activar cartas de Magia/Trampa, y colocar cartas de Magia/Trampa.</li>
            <li><b>Battle Phase (Fase de Batalla):</b> El jugador puede atacar con sus monstruos.</li>
            <li><b>Main Phase 2 (Fase Principal 2):</b> Similar a la Main Phase 1, pero ocurre después de la Battle Phase.</li>
            <li><b>End Phase (Fase Final):</b> El jugador termina su turno y se resuelven efectos que ocurren al final del turno.</li>
        </ul>
    </div>

    <div id="invocaciones">
        <h2>Invocaciones</h2>
        <ul>
            <li><b>Invocación Normal:</b> Puedes invocar un monstruo de nivel 4 o menor una vez por turno.</li>
            <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
                <video class="d-block w-100" autoplay loop muted>
                    <source src="recursos/pr2.mp4" type="video/mp4">
                </video>  
            </div>
            </div>
            </div>
            <div class="clearfix"></div> <!-- Limpieza de flotantes -->
            <br> <!-- Salto de línea -->
            <li><b>Invocación por Sacrificio:</b> Para invocar monstruos de nivel 5 o 6, debes sacrificar un monstruo. Para monstruos de nivel 7 o mayor, necesitas sacrificar dos monstruos.</li>
            <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
                <video class="d-block w-100" autoplay loop muted>
                    <source src="recursos/pr1.mp4" type="video/mp4">
                </video>  
            </div>
            </div>
            </div>
          <div class="clearfix"></div> <!-- Limpieza de flotantes -->
          <br> <!-- Salto de línea -->
          <li><b>Invocación Especial:</b> Algunos monstruos pueden ser invocados mediante efectos especiales.</li>
          <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
                <video class="d-block w-100" autoplay loop muted>
                    <source src="recursos/pr3.mp4" type="video/mp4">
                </video>  
            </div>
            </div>
            </div>
          <div class="clearfix"></div> <!-- Limpieza de flotantes -->
          <br> <!-- Salto de línea -->
          
        </ul>
    </div>

    <div id="batalla">
        <h2>Batalla</h2>
        <p><b>Ataque de Monstruo:</b> Cada monstruo tiene puntos de ataque (ATK) y puntos de defensa (DEF). Si un monstruo en ataque ataca a otro en ataque y su ATK es mayor, el monstruo oponente es destruido y la diferencia en puntos de ataque se resta de los puntos de vida del oponente. Si un monstruo ataca a un monstruo en defensa y su ATK es mayor que la DEF del monstruo defensor, el monstruo defensor es destruido pero no se inflige daño al oponente. Si la DEF es mayor que el ATK, el atacante recibe el daño de diferencia.</p>
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
                <video class="d-block w-100" autoplay loop muted>
                    <source src="recursos/b1.mp4" type="video/mp4">
                </video>  
            </div>
            </div>
            </div>
          <div class="clearfix"></div> <!-- Limpieza de flotantes -->
          <br> <!-- Salto de línea -->
        <p><b>Cartas de Magia y Trampa:</b> Pueden ser activadas para influir en la batalla de diversas maneras.</p>
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
                <video class="d-block w-100" autoplay loop muted>
                    <source src="recursos/b2.mp4" type="video/mp4">
                </video>  
            </div>
            </div>
            </div>
          <div class="clearfix"></div> <!-- Limpieza de flotantes -->
          <br> <!-- Salto de línea -->
    </div>

    <div id="estrategia">
        <h2>Estrategia</h2>
        <p>La estrategia en Yu-Gi-Oh! implica construir un mazo equilibrado, planificar tus movimientos, y anticipar las acciones del oponente. Cada carta tiene efectos únicos que pueden cambiar el curso del juego, así que conocer bien tu mazo y cómo interactúan las cartas entre sí es crucial.</p>
        <p>Esto es solo una introducción básica; el juego tiene muchas más reglas y estrategias avanzadas.</p>
        <p>Para más información consulta el libro de reglas oficial: <a href="https://img.yugioh-card.com/eu/wp-content/uploads/2022/07/Rulebook_v9_es.pdf" target="_blank">LIBRO DE REGLAS OFICIAL</a></p>
            <div class="gifs-container">
        <img src="recursos/g1.gif" alt="Animación" class="resize-gif">
        
             </div>
    </div>
</div>
    <!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2024 Yu-Gi-Oh! Todos los derechos reservados.</p>
    </div>
</footer>




<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm" action="php/login.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div id="error-message" class="text-danger mb-3" style="display:none;"></div>
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </form>
                <div class="mt-3">
                    <p>¿No tienes una cuenta? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Regístrate aquí</a></p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Registrar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" action="php/registrarUsuario.php" method="post">
                    <div class="mb-3">
                        <label for="registerName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="registerName" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="registerEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="registerPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                    </div>
                    <div id="register-error-message" class="text-danger mb-3" style="display:none;"></div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/login.js"></script>
    <script src="js/registrarUsuario.js"></script>
</body>
</html>