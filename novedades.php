<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);

    include_once 'inc/_checkLogin.php';
    include_once 'inc/_permisos.php';
    include_once 'inc/_funciones.php';

    # Verifica si el Usuario tiene permisos
    if(!in_array($username, $menu_RHH, TRUE)){
        die('Hola 🤓 ');
    }

    include_once 'inc/_cxnBB.php';

    $codigoModulo = 'NOVS';

    // Establecer el conjunto de caracteres a UTF-8
    $link_BB->set_charset("utf8mb4");

    // Inicio del Agregar de Novedades
    $agregarNOVS = (isset($_POST['np_novedades']) && isset($_POST['np_novcolaborador']) && isset($_POST['np_novsfecha']) && isset($_POST['np_novcategoria']) && isset($_POST['np_novestado']));

    if ($agregarNOVS) {
        // Obtener la fecha y hora del input
        $fecha = $_POST['np_novsfecha'];
        
        // Validar que la fecha no esté vacía
        if (empty($fecha)) {
            $_SESSION['resultado'] = 'danger';
            $_SESSION['mensaje'] = '<strong>ERROR!</strong> La fecha ingresada no es válida';
            die(header('Location: novedades?estatus=fail'));
        }

        // La fecha ya viene en el formato correcto para MySQL
        // Crear identificador
        $idNOVS = uniqid('NOVS');
        
        // Definir el array de consultas
        $query = [];
        
        // Construir la consulta para insertar los datos
        $query[] = "
            INSERT INTO novedades_NOVS (
                id_NOVS,
                descripcion_NOVS,
                id_CLB,
                fecha_NOVS,
                id_CTG,
                id_EST,
                userID_REG
            ) 
            VALUES (
                '" . $idNOVS . "',
                '" . $link_BB->real_escape_string($_POST['np_novedades']) . "',
                '" . $link_BB->real_escape_string($_POST['np_novcolaborador']) . "',
                '" . $link_BB->real_escape_string($fecha) . "',
                '" . $link_BB->real_escape_string($_POST['np_novcategoria']) . "',
                '" . $link_BB->real_escape_string($_POST['np_novestado']) . "',
                '" . $userID . "'
            )
        ";

        // Ejecutar las consultas
        $result = commitQueries($query)['STATUS'];

        // Manejar la respuesta
        if ($result === 'PASS') {
            $_SESSION['resultado'] = 'success';
            $_SESSION['mensaje'] = '<strong>¡Muy bien!</strong> Se ha agregado la novedad #' . $idNOVS . '';
            die(header('Location: novedades?estatus=pass'));
        } elseif ($result === 'FAIL') {
            $_SESSION['resultado'] = 'danger';
            $_SESSION['mensaje'] = '<strong>ERROR!</strong> Hubo un error agregando la novedad';
            die(header('Location: novedades?estatus=fail'));
        }
    }

    // Carga el Header de la pagina

    include_once 'inc/__htmlHeader.php';

?>

<section class="body">

    <?php
    include_once 'inc/__headerSearchUserBox.php';
    ?>

    <div class="inner-wrapper">

        <?php
        include_once 'inc/__sidebar.php'; 
        ?>

        <section role="main" class="content-body">

            <header class="page-header">
                <h2>Novedades | <a href="https://courier.blumbox.do/recursos-humanos.php#w2">Colaboradores</a></h2>
                <?php
                include_once 'inc/__right-wrapper.php'
                ?>
            </header>
           
            <?php

                $busqueda = false;
                $filtro = "AND MONTH(NOVS.fecha_NOVS) = MONTH(CURRENT_DATE) AND YEAR(NOVS.fecha_NOVS) = YEAR(CURRENT_DATE)";

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $busqueda = true;

                    // Limpia la consulta
                    $filtro = "";

                    if (!empty($_POST['f_categorias'])) {
                        $categorias = array_map('test_input', $_POST['f_categorias']);
                        $categorias = array_map('intval', $categorias); // Convertir a enteros
                        if (count($categorias) > 0) {
                            $filtro .= " AND NOVS.id_CTG IN (" . implode(",", $categorias) . ") ";
                        }
                    }

                    if (!empty($_POST['f_estado'])) {
                        $estado = array_map('test_input', $_POST['f_estado']);
                        $estado = array_map('intval', $estado); // Convertir a enteros
                        if (count($estado) > 0) {
                            $filtro .= " AND NOVS.id_EST IN (" . implode(",", $estado) . ") ";
                        }
                    }

                    if( !empty($_POST['f_colaborador']) ){
                        $filtro .= "AND NOVS.id_CLB IN ('".implode("','",$_POST['f_colaborador'])."') ";
                    }

                    if (!empty($_POST['f_localidad'])) {
                        $localidad = array_map('test_input', $_POST['f_localidad']);
                        $localidad = array_map('intval', $localidad); // Convertir a enteros
                        if (count($localidad) > 0) {
                            $filtro .= " AND CLB.id_LOC IN (" . implode(",", $localidad) . ") ";
                        }
                    }

                    // Filtrar por fechas
                    if (validateDateTime($_POST['fechanovedad'][0], 'Y-m-d') && validateDateTime($_POST['fechanovedad'][1], 'Y-m-d')) {

                        $fechaInicial = test_input($_POST['fechanovedad'][0]);
                        $fechaFinal = test_input($_POST['fechanovedad'][1]);

                        $filtro .= " AND DATE(NOVS.fecha_NOVS) BETWEEN '$fechaInicial' AND '$fechaFinal'";
                    }

                }

                $link_BB->set_charset("utf8mb4");
    
                //Consulta dentro de la SQL
                $query = "
                    SELECT
                        NOVS.id_NOVS AS 'ID', 
                        NOVS.fecha_NOVS AS 'fecha',
                        CLB.nombre_CLB AS 'colaborador',
                        NOVS.descripcion_NOVS AS 'descripcion',
                        CTG.nombre_CTG AS 'categoria',
                        CTG.color_CTG AS 'categoriacolor',
                        CTG.orden_CTG AS 'categoriaorden',
                        LOC.code_LOC AS 'localidad',
                        POSC.nombre_POSC AS 'posicion',
                        SUBSTRING_INDEX(AMD.nombreCompleto, ' ', 1) AS 'usuario',
                        EST.nombre_EST AS 'estado'
                    FROM 
                        novedades_NOVS NOVS
                    LEFT JOIN 
                        colaboradores_CLB CLB ON NOVS.id_CLB = CLB.id_CLB
                    LEFT JOIN 
                        categoriasGenerales CTG ON NOVS.id_CTG = CTG.id_CTG AND CTG.modulo_CTG = 'NOVS'
                    LEFT JOIN 
                        locations LOC ON CLB.id_LOC = LOC.id
                    LEFT JOIN
                        posicion_POSC POSC ON CLB.id_POSC = POSC.id_POSC
                    LEFT JOIN
                        admin AMD ON NOVS.userID_REG = AMD.id
                    LEFT JOIN 
                        estatusGenerales EST ON NOVS.id_EST = EST.id_EST AND EST.modulo_EST = 'NOVS'
                    WHERE
                        CLB.id_CLB = NOVS.id_CLB
                        AND NOVS.is_deleted = 0
                        $filtro
                ";

                $listadoPAQs = $link_BB->query($query);

                if (!$listadoPAQs) {
                    die("Error en la consulta: " . $link_BB->error);
                }
            ?>

            <!-- Leyendas -->
            <header class="card-header">
                <h2 class="card-title" id="cantidadEstatusTitulos"></h2>
            </header>

            <!--Botones-->
            <div class="card-body">
                <div class="row">

                    <!-- Botón de filtro -->
                    <div class="col-lg-2 col-md-4 mb-3">
                        <div class="form-group">
                            <label class="d-block" for="">&nbsp;</label>
                            <a id="btn_filtros" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filtros</a>
                        </div>
                    </div>
    
                    <!-- Botón de novedades -->
                    <div class="col-lg-2 col-md-4 mb-3">
                        <div class="form-group">
                            <label class="d-block" for="">&nbsp;</label>
                            <a id="btn_novedades" class="btn btn-primary w-100"><i class="fas fa-pen"></i> Agregar</a>
                        </div>
                    </div>

                    <?php
                    if($busqueda){
                    ?>
                    
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="d-block" for="">&nbsp;</label>
                                <button class="btn btn-default w-50" onclick="window.location.href='novedades';" type="button"><i class="fas fa-trash" aria-hidden="true"></i>Limpiar</button>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>   

            <!-- Formulario de Filtros -->
            <div class="row" id="div_filtros" style="display: none; margin-top: 20px;">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <section class="card">
                                <header class="card-header">
                                    <h2 class="card-title">Filtros</h2>
                                </header>

                                <div class="card-body">
                                    <form class="form-horizontal form-bordered" action="" method="post" autocomplete="off">
                                        <div class="form-group row pb-3">                                      

                                            <!--Filtro de categoria-->                                    
                                            <div class="col-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="d-block" for="f_categorias">Categoría</label>
                                                    <select id="f_categorias" name="f_categorias[]" class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "numberDisplayed": 1 }'>
                                                        <?php
                                                        $f_categoriasINC = $link_BB->query("SELECT CTG.id_CTG, CTG.nombre_CTG FROM categoriasGenerales CTG LEFT JOIN novedades_NOVS NOVS ON CTG.id_CTG = NOVS.id_CTG WHERE CTG.modulo_CTG = 'NOVS' GROUP BY CTG.id_CTG, CTG.nombre_CTG ORDER BY CTG.nombre_CTG ASC");
                                                        while($row = $f_categoriasINC->fetch_assoc()) {
                                                            echo '<option '.( ( $busqueda && !empty($_POST['f_categorias']) && in_array($row['id_CTG'],$_POST['f_categorias']) ) ? 'selected' : '' ).' value="' .$row['id_CTG']. '">' .$row['nombre_CTG']. '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!--Filtro de categoria-->                                    
                                            <div class="col-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="d-block" for="f_estado">Estado</label>
                                                    <select id="f_estado" name="f_estado[]" class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "numberDisplayed": 1 }'>
                                                        <?php
                                                        $f_estadoINC = $link_BB->query("SELECT EST.id_EST, EST.nombre_EST FROM estatusGenerales EST LEFT JOIN novedades_NOVS NOVS ON EST.id_EST = NOVS.id_EST WHERE EST.modulo_EST = 'NOVS' GROUP BY EST.id_EST, EST.nombre_EST ORDER BY EST.nombre_EST ASC");
                                                        while($row = $f_estadoINC->fetch_assoc()) {
                                                            echo '<option '.( ( $busqueda && !empty($_POST['f_estado']) && in_array($row['id_EST'],$_POST['f_estado']) ) ? 'selected' : '' ).' value="' .$row['id_EST']. '">' .$row['nombre_EST']. '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!--Filtro de Colaborador-->
                                            <div class="col-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="d-block" for="f_colaborador">Colaborador</label>
                                                    <select id="f_colaborador" name="f_colaborador[]" class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "numberDisplayed": 1 }'>
                                                        <?php
                                                        $f_colaboradorINC = $link_BB->query("SELECT CLB.id_CLB, CLB.nombre_CLB FROM colaboradores_CLB CLB LEFT JOIN novedades_NOVS NOVS ON CLB.id_CLB = NOVS.id_CLB GROUP BY CLB.id_CLB, CLB.nombre_CLB ORDER BY CLB.nombre_CLB ASC
                                                        ");
                                                        while($row = $f_colaboradorINC->fetch_assoc()) {
                                                            echo '<option '.( ( $busqueda && !empty($_POST['f_colaborador']) && in_array($row['id_CLB'],$_POST['f_colaborador']) ) ? 'selected' : '' ).' value="' .$row['id_CLB']. '">' .$row['nombre_CLB']. '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Filtro de localidad -->
                                            <div class="col-lg-2">
                                                <label class="d-block" for="f_localidad">Localidad</label>
                                                <select id="f_localidad" name="f_localidad[]" class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "numberDisplayed": 1 }'>
                                                    <?php
                                                    $f_localidadINC = $link_BB->query("SELECT LOC.id, LOC.code_LOC FROM locations LOC LEFT JOIN colaboradores_CLB CLB ON LOC.id = CLB.id_LOC WHERE CLB.is_deleted = 0 AND CLB.id_LOC = LOC.id GROUP BY LOC.id, LOC.code_LOC ORDER BY LOC.code_LOC ASC");
                                                    while ($row = $f_localidadINC->fetch_assoc()) {
                                                        echo '<option ' . ( ($busqueda && !empty($_POST['f_localidad']) && in_array($row['id'], $_POST['f_localidad'])) ? 'selected' : '' ) . ' value="' . $row['id'] . '">' . $row['code_LOC'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-2 col-md-6">
                                                <label class="form-group" for="fechanovedad">Fecha</label>
                                                <div class="input-daterange input-group" data-plugin-datepicker data-plugin-options='{"format": "yyyy-mm-dd","endDate":"<?php echo getDates('today'); ?>","orientation": "bottom right"}'>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                    <input type="text" class="form-control" name="fechanovedad[]" value="<?php echo ($busqueda ? htmlspecialchars($fechaInicial) : ''); ?>">
                                                    <span class="input-group-text border-start-0 border-end-0 rounded-0">a</span>
                                                    <input type="text" class="form-control" name="fechanovedad[]" value="<?php echo ($busqueda ? htmlspecialchars($fechaFinal) : ''); ?>">
                                                </div>
                                            </div>

                                            <!--Boton de filtrar-->                                                                   
                                            <div class="col-lg-2 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block" for="">&nbsp;</label>
                                                    <button class="btn btn-primary w-100" type="submit"><i class="fas fa-filter" name="filtrar" aria-hidden="true"></i> Filtrar</button>
                                                </div>
                                            </div>

                                            <?php
                                            if($busqueda){
                                            ?>
                                            
                                                <div class="col-lg-1 col-md-6">
                                                    <div class="form-group">
                                                        <label class="d-block" for="">&nbsp;</label>
                                                        <button class="btn btn-default w-100" onclick="window.location.href='novedades';" type="button"><i class="fas fa-trash" aria-hidden="true"></i> Limpiar</button>
                                                    </div>
                                                </div>
                                            
                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>


            
            <!--Agregar Novedades-->
            <div class="row" id="div_agregarnovs" style="display: none;">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <section class="card">
                                <header class="card-header">
                                    <h2 class="card-title">Agregar</h2>
                                </header>
                                <div class="card-body">
                                    <form class="form-horizontal form-bordered" action="" method="post" autocomplete="off">
                                        <div class="row">

                                            <!-- Fecha y Hora -->
                                            <div class="col-lg-2">
                                                <label for="np_novsfecha">Fecha y Hora</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                    <input type="datetime-local" id="np_novsfecha" name="np_novsfecha" class="form-control" onclick="this.showPicker();">
                                                </div>
                                            </div>

                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    // Obtener la fecha y hora actual
                                                    const today = new Date();

                                                    // Formato YYYY-MM-DDTHH:MM
                                                    const yyyy = today.getFullYear();
                                                    const mm = String(today.getMonth() + 1).padStart(2, '0');
                                                    const dd = String(today.getDate()).padStart(2, '0');
                                                    const hh = String(today.getHours()).padStart(2, '0');
                                                    const min = String(today.getMinutes()).padStart(2, '0');

                                                    const currentDateTime = `${yyyy}-${mm}-${dd}T${hh}:${min}`;

                                                    // Asignar la fecha y hora actual al campo de entrada
                                                    document.getElementById("np_novsfecha").value = currentDateTime;
                                                });
                                            </script>
                                        
                                            <!-- Colaborador -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_novcolaborador">Colaborador</label>
                                                    <select class="form-select d-block w-100" id="np_novcolaborador" name="np_novcolaborador" required>
                                                        <option value="">Colaborador</option>
                                                        <?php
                                                        $categorias = $link_BB->query("SELECT id_CLB, numero_CLB, nombre_CLB FROM `colaboradores_CLB` WHERE is_deleted = 0 ORDER BY nombre_CLB ASC");
                                                        while ($row = $categorias->fetch_assoc()) {
                                                            echo '<option value="' . $row['id_CLB'] . '">' . $row['nombre_CLB'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            

                                            <!-- Categoria -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_novcategoria">Categoria</label>
                                                    <select class="form-select d-block w-100" id="np_novcategoria" name="np_novcategoria" required>
                                                        <option value="">Categoria</option>
                                                        <?php
                                                        $categorias = $link_BB->query("SELECT id_CTG, nombre_CTG, modulo_CTG FROM `categoriasGenerales` WHERE modulo_CTG = 'NOVS' ORDER BY nombre_CTG");
                                                        while ($row = $categorias->fetch_assoc()) {
                                                            echo '<option value="' . $row['id_CTG'] . '">' . $row['nombre_CTG'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_novestado">Estado</label>
                                                    <select class="form-select d-block w-100" id="np_novestado" name="np_novestado" required>
                                                        <option value="">Estado</option>
                                                        <?php
                                                        $estado = $link_BB->query("SELECT id_EST, nombre_EST, modulo_EST FROM `estatusGenerales` WHERE modulo_EST = 'NOVS' ORDER BY nombre_EST");
                                                        while ($row = $estado->fetch_assoc()) {
                                                            // Comprobar si el id_EST es 40 y añadir el atributo selected si es así
                                                            $selected = ($row['id_EST'] == 40) ? 'selected' : '';
                                                            echo '<option value="' . $row['id_EST'] . '" ' . $selected . '>' . $row['nombre_EST'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!--Comentario de novedades-->
                                            <div class="col-lg-4">
                                                <label for="np_novedades">Comentario</label>
                                                <textarea id="np_novedades" name="np_novedades" class="form-control" rows="1" style="overflow:hidden; resize:none; width: calc(100% - 25px);" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"></textarea>
                                            </div>

                                            <!-- Botón Guardar con margen superior -->
                                            <div class="row pb-2">
                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100" style="margin-top: 20px;">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>


            <!--Inicio de resultado-->        
            <div class="row">
                <div class="col">
                    <section class="card">

                        <div class="card-body"> 
                        
                        <?php
                            
                            if( isset($_SESSION['resultado']) && !empty($_SESSION['resultado']) ){
                            ?>
                            
                                <div class="alert alert-<?php echo $_SESSION['resultado']; ?> alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['mensaje']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                                </div>
                            
                            <?php
                                $_SESSION['resultado'] = '';
                                $_SESSION['mensaje'] = '';
                            }
                            
                            if ($listadoPAQs && $listadoPAQs->num_rows > 0) {
                                
                                $tableOrder = "[ 0, 'desc' ]";
                                
                            ?>

                        <table class="table table-bordered align-middle table-striped mb-0 table-sm" id="datatable-tabletools">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Fecha</th>
                                    <th>Colaborador</th>
                                    <th>Localidad</th>
                                    <th>Categoria</th>
                                    <th>Usuario</th>
                                    <th style="width: 60px;">Estado</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $cantidadEstatusTitulos = [];
                                $cantEstatus = 0;

                                while ($row = $listadoPAQs->fetch_assoc()) {
                                    $r_cantidadEstatusTitulos = [
                                        'nombre' => $row['categoria'],
                                        'color' => $row['categoriacolor'],
                                        'orden' => $row['categoriaorden'],
                                        'cantidad' => $cantEstatus + 1, 
                                    ];

                                    array_push($cantidadEstatusTitulos, $r_cantidadEstatusTitulos);
                                ?>
                                    <tr>
                                        <td>
                                            <span id="fecha_<?php echo $row['ID']; ?>"><?php echo $row['fecha']; ?></span>	
                                        </td>

                                        <td>
                                        <span id="colaborador_<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['colaborador']; ?>"><?php echo $row['colaborador']; ?></span>
                                        
                                        <br> <!-- Salto de línea para separar los spans -->

                                        <span id="posicion_<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['posicion']; ?>" style="color: #6aa3b4; display: block;"><?php echo $row['posicion']; ?></span>
                                    </td>
                                        <td>
                                            <span id="localidad_<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['localidad']; ?>"><?php echo $row['localidad']; ?></span>
                                        </td> 
                                        <td>
                                            <span id="categoria_<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['categoria']; ?>"><?php echo $row['categoria']; ?></span>
                                        </td>
                                        <td>
                                            <span id="usuario_<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['usuario']; ?>"><?php echo $row['usuario']; ?></span>
                                        </td>
                                        <td>
                                            <span id="estado_<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['estado']; ?>"><?php echo $row['estado']; ?></span>
                                        </td>  
                                        <td>
                                            <!-- Descripción con Tooltip -->
                                            <?php
                                            // Dividimos la descripción en palabras
                                            $palabras = explode(' ', $row['descripcion']);
                                            
                                            // Verificamos si la cantidad de palabras es mayor a 60
                                            if (count($palabras) > 45) {
                                                // Mostrar solo las primeras 60 palabras y agregar "..."
                                                $descripcionCorta = implode(' ', array_slice($palabras, 0, 45)) . '...';
                                                $mostrarTooltip = true; // Activar el tooltip si hay más de 60 palabras
                                            } else {
                                                // Si tiene 60 palabras o menos, mostrar toda la descripción sin los "..."
                                                $descripcionCorta = $row['descripcion'];
                                                $mostrarTooltip = false; // Desactivar el tooltip si hay 60 palabras o menos
                                            }
                                            ?>
                                            <span id="descripcion_<?php echo $row['ID']; ?>" class="cur-pointer searchstring" 
                                                <?php if ($mostrarTooltip): ?>
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="<?php echo $row['descripcion']; ?>"
                                                <?php endif; ?>>
                                                <?php echo $descripcionCorta; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="notifications-list">
                                                <li>
                                                    <a class="notification-list-icon modal-sizes simple-ajax-modal" href="__form_Mtto-novedades.php?id=<?php echo $row['ID']; ?>">
                                                        <i class="fas fa-edit" title="Editar"></i>
                                                    </a>
                                                </li>
                                            </div>
                                        </td>
                                    </tr>

                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                            }
                        else{
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show mt-3 mb-3" role="alert">
                                <strong>Ups!</strong> No se han encontrado datos, si crees que es un error... por favor reportalo, gracias.
                            </div>
                            <?php
                            }
                            ?>
                                    
                        </div>

                    </section>
                </div>
            </div>   
        
        </section>
        
    </div>
</section>
		
<?php

    include_once 'inc/__footerJS.php';
    //include_once '__form_AgregarNotasCliente.php';
    include_once '__form_AgregarNotas.php';

    $p1_estatusTitulo = 0;
    $p2_estatusTitulo = '';

    foreach( agruparEstatus($cantidadEstatusTitulos) as $value ){
        $p1_estatusTitulo += $value['cantidad'];
        $p2_estatusTitulo .= '<span class="badge rounded-pill mx-1" style="background:' .$value['color']. '">' .$value['nombre']. ' (' .$value['cantidad']. ') </span>';
    }

?>

<script> 
    
    $( '#cantidadEstatusTitulos' ).html('<?php echo $p1_estatusTitulo. ' Novedades | ' .$p2_estatusTitulo; ?>');    
        
    $( '.showclipboard' ).hover(function() {
        $(this).find( 'span.clipboard' ).toggle();
    }); 
    
    $( '#btn_filtros' ).on( 'click', function() {
        $( '#div_filtros' ).toggle('slow');
        $( '#numeros_whbb' ).focus();
    });
        
    $( '#btn_agregarpaqs' ).on( 'click', function() {
        $( '#div_agregarpaqs' ).toggle('slow');
        $( '#numeros_whbb' ).focus();
    });
    
    $( '#btn_novedades' ).on( 'click', function() {
        $( '#div_agregarnovs' ).toggle('slow');
        $( '#div_novedades' ).toggle('slow');
    });    
        
    var clipboard = new ClipboardJS('.clipboard');
    
</script>