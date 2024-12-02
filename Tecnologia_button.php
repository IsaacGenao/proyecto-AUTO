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

    $codigoModulo = 'TECN';
    print_r($_POST);
// Verificar la consulta SQL:

// php
// Copiar código
echo "Consulta ejecutada: $sql";
// Mostrar errores de conexión o consulta:

// php
// Copiar código





    // Establecer el conjunto de caracteres a UTF-8
    $link_BB->set_charset("utf8mb4");

    // Inicio del Agregar de Novedades
    $agregarTECN = (isset($_POST['np_TECNfecha']) && isset($_POST['np_TECNcolaborador']) && isset($_POST['np_TECNdepartamento']) && isset($_POST['np_TECNubicacion']) 
    && isset($_POST['np_TECNdescripcion'])&& isset($_POST['np_TECNcategoria'])&& isset($_POST['np_TECNusuario'])&& isset($_POST['np_TECNestatus'])
    && isset($_POST['np_TECNprioridad'])&& isset($_POST['np_TECNcolab_asignado'])&& isset($_POST['np_TECNactivo']));

    if ($agregarTECN) {
        // Obtener la fecha y hora del input
        $fecha = $_POST['np_TECNfecha'];
        
        // Validar que la fecha no esté vacía
        if (empty($fecha)) {
            $_SESSION['resultado'] = 'danger';
            $_SESSION['mensaje'] = '<strong>ERROR!</strong> La fecha ingresada no es válida';
            die(header('Location: novedades?estatus=fail'));
        }

        // La fecha ya viene en el formato correcto para MySQL
        // Crear identificador
        $idTECN = uniqid('TECN');
        
        // Definir el array de consultas
        $query = [];
        
        // Construir la consulta para insertar los datos
        $query[] = "
            INSERT INTO Tecnologia (
            id_TECN,
            fecha_TECN,
            id_EST,
            id_CTG,
            id_CLB,
            id_DPT,
            id_LOC,
            id_Asignado_CLG,
            descripcion_TECN,
            usuario_ID,
            id_PEST,
            id_ACT  ) 
            
            
            VALUES (
                '" . $idTECN . "',
                '" . $link_BB->real_escape_string($fecha) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNestatus']) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNcategoria']) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNcolaborador']) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNdepartamento']) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNubicacion']) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNcolab_asignado']) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNdescripcion']) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNusuario']) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNprioridad']) . "',
                '" . $link_BB->real_escape_string($_POST['np_TECNactivo']) . "'
                
            )
        ";

        if (!$link_BB->query($sql)) {
            die("Error en la consulta: " . $link_BB->error);
        }
        // Ejecutar las consultas
        $result = commitQueries($query)['STATUS'];

        // Manejar la respuesta
        if ($result === 'PASS') {
            $_SESSION['resultado'] = 'success';
            $_SESSION['mensaje'] = '<strong>¡Muy bien!</strong> Se ha agregado la novedad #' . $idTECN . '';
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
                <h2>Tecnologia</h2>
                <?php
                include_once 'inc/__right-wrapper.php'
                ?>
            </header>
           
            <?php

              /*  $busqueda = false;
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

                }*/

                $link_BB->set_charset("utf8mb4");
    
                //Consulta dentro de la SQL
                $query = "
                   SELECT 
                   TECN.id_TECN ,TECN.fecha_TECN ,CLB.nombre_CLB as 'Nombre Colaborador', 
                   DPT.nombre_DPT as 'Departamento', LOC.name_LOC as 'Ubicacion',
                   TECN.descripcion_TECN as 'Descripcion', CTG.nombre_CTG as 'Categoria'
                   ,CLBB.usuario_CLB as 'Usuario',  EST.nombre_EST as 'Estatus', 
                   ESTT.nombre_EST as 'Prioridad', CLBBB.nombre_CLB as 'Colaborador Asignado',
                   CTGG.nombre_CTG as 'Activo' 
                    from Tecnologia TECN
                    INNER JOIN colaboradores_CLB CLB on TECN.id_CLB= CLB.numero_CLB
                    INNER JOIN departamento_DPT DPT on TECN.id_DPT=DPT.id_DPT
                    INNER JOIN locations LOC on TECN.id_LOC=LOC.id
                    INNER JOIN categoriasGenerales CTG on TECN.id_CTG=CTG.id_CTG
                    INNER JOIN colaboradores_CLB CLBB on TECN.user_ID=CLBB.numero_CLB
                    INNER JOIN estatusGenerales EST on TECN.id_EST=EST.id_EST
                    INNER JOIN estatusGenerales ESTT on TECN.id_PEST=ESTT.id_EST
                    INNER JOIN colaboradores_CLB CLBBB on TECN.id_Asignado_CLG=CLBBB.numero_CLB
                    INNER JOIN categoriasGenerales CTGG on TECN.id_ACT=CTGG.id_CTG;
    
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

                    <!-- Botón de filtro
                    <div class="col-lg-2 col-md-4 mb-3">
                        <div class="form-group">
                            <label class="d-block" for="">&nbsp;</label>
                            <a id="btn_filtros" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filtros</a>
                        </div>
                    </div>-->
    
                    <!--Botón de TECNagregar -->
                    <div class="col-lg-2 col-md-4 mb-3">
                        <div class="form-group">
                            <label class="d-block" for="">&nbsp;</label>
                            <a id="btn_TECNagregar" class="btn btn-success w-100"><i id="iconagre" class="fas fa-pen"></i>Agregar</a>
                        </div>
                    </div>

                    <?php
                    /*if($busqueda){
                    
                    
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="d-block" for="">&nbsp;</label>
                                <button class="btn btn-default w-50" onclick="window.location.href='novedades';" type="button"><i class="fas fa-trash" aria-hidden="true"></i>Limpiar</button>
                            </div>
                        </div>
                    
                    }*/
                    ?>
                </div>
            </div>   
            

            <!-- Formulario de Filtros 
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

                                            Filtro de categoria                                    
                                            <div class="col-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="d-block" for="f_categorias">Categoría</label>
                                                    <select id="f_categorias" name="f_categorias[]" class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "numberDisplayed": 1 }'>
                                                        <?php
                                                        /*$f_categoriasINC = $link_BB->query("SELECT CTG.id_CTG, CTG.nombre_CTG FROM categoriasGenerales CTG LEFT JOIN novedades_NOVS NOVS ON CTG.id_CTG = NOVS.id_CTG WHERE CTG.modulo_CTG = 'NOVS' GROUP BY CTG.id_CTG, CTG.nombre_CTG ORDER BY CTG.nombre_CTG ASC");
                                                        while($row = $f_categoriasINC->fetch_assoc()) {
                                                            echo '<option '.( ( $busqueda && !empty($_POST['f_categorias']) && in_array($row['id_CTG'],$_POST['f_categorias']) ) ? 'selected' : '' ).' value="' .$row['id_CTG']. '">' .$row['nombre_CTG']. '</option>';
                                                        }*/
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            Filtro de categoria                                    
                                            <div class="col-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="d-block" for="f_estado">Estado</label>
                                                    <select id="f_estado" name="f_estado[]" class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "numberDisplayed": 1 }'>
                                                        <?php
                                                       /* $f_estadoINC = $link_BB->query("SELECT EST.id_EST, EST.nombre_EST FROM estatusGenerales EST LEFT JOIN novedades_NOVS NOVS ON EST.id_EST = NOVS.id_EST WHERE EST.modulo_EST = 'NOVS' GROUP BY EST.id_EST, EST.nombre_EST ORDER BY EST.nombre_EST ASC");
                                                        while($row = $f_estadoINC->fetch_assoc()) {
                                                            echo '<option '.( ( $busqueda && !empty($_POST['f_estado']) && in_array($row['id_EST'],$_POST['f_estado']) ) ? 'selected' : '' ).' value="' .$row['id_EST']. '">' .$row['nombre_EST']. '</option>';
                                                        }*/
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            Filtro de Colaborador
                                            <div class="col-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="d-block" for="f_colaborador">Colaborador</label>
                                                    <select id="f_colaborador" name="f_colaborador[]" class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "numberDisplayed": 1 }'>
                                                        <?php/*
                                                        $f_colaboradorINC = $link_BB->query("SELECT CLB.id_CLB, CLB.nombre_CLB FROM colaboradores_CLB CLB LEFT JOIN novedades_NOVS NOVS ON CLB.id_CLB = NOVS.id_CLB GROUP BY CLB.id_CLB, CLB.nombre_CLB ORDER BY CLB.nombre_CLB ASC
                                                        ");
                                                        while($row = $f_colaboradorINC->fetch_assoc()) {
                                                            echo '<option '.( ( $busqueda && !empty($_POST['f_colaborador']) && in_array($row['id_CLB'],$_POST['f_colaborador']) ) ? 'selected' : '' ).' value="' .$row['id_CLB']. '">' .$row['nombre_CLB']. '</option>';
                                                        }*/
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            Filtro de localidad
                                            <div class="col-lg-2">
                                                <label class="d-block" for="f_localidad">Localidad</label>
                                                <select id="f_localidad" name="f_localidad[]" class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options='{ "numberDisplayed": 1 }'>
                                                    <?php/*
                                                    $f_localidadINC = $link_BB->query("SELECT LOC.id, LOC.code_LOC FROM locations LOC LEFT JOIN colaboradores_CLB CLB ON LOC.id = CLB.id_LOC WHERE CLB.is_deleted = 0 AND CLB.id_LOC = LOC.id GROUP BY LOC.id, LOC.code_LOC ORDER BY LOC.code_LOC ASC");
                                                    while ($row = $f_localidadINC->fetch_assoc()) {
                                                        echo '<option ' . ( ($busqueda && !empty($_POST['f_localidad']) && in_array($row['id'], $_POST['f_localidad'])) ? 'selected' : '' ) . ' value="' . $row['id'] . '">' . $row['code_LOC'] . '</option>';
                                                    }*/
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-2 col-md-6">
                                                <label class="form-group" for="fechanovedad">Fecha</label>
                                                <div class="input-daterange input-group" data-plugin-datepicker data-plugin-options='{"format": "yyyy-mm-dd","endDate":"<?php echo getDates('today'); ?>","orientation": "bottom right"}'>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                    <input type="text" class="form-control" name="fechanovedad[]" value="<?php/* echo ($busqueda ? htmlspecialchars($fechaInicial) : ''); */?>">
                                                    <span class="input-group-text border-start-0 border-end-0 rounded-0">a</span>
                                                    <input type="text" class="form-control" name="fechanovedad[]" value="<?php/* echo ($busqueda ? htmlspecialchars($fechaFinal) : ''); */?>">
                                                </div>
                                            </div>

                                            Boton de filtrar                                                                  
                                            <div class="col-lg-2 col-md-6">
                                                <div class="form-group">
                                                    <label class="d-block" for="">&nbsp;</label>
                                                    <button class="btn btn-primary w-100" type="submit"><i class="fas fa-filter" name="filtrar" aria-hidden="true"></i> Filtrar</button>
                                                </div>
                                            </div>

                                            <?php/*
                                            if($busqueda){*/
                                            ?>
                                            
                                                <div class="col-lg-1 col-md-6">
                                                    <div class="form-group">
                                                        <label class="d-block" for="">&nbsp;</label>
                                                        <button class="btn btn-default w-100" onclick="window.location.href='novedades';" type="button"><i class="fas fa-trash" aria-hidden="true"></i> Limpiar</button>
                                                    </div>
                                                </div>
                                            
                                            <?php/*
                                            }*/
                                            ?>
                                        </div>

                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>-->


            
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
                                    <form class="form-horizontal form-bordered" action="Tecnologia.php" method="post" autocomplete="off">
                                        <div class="row">

                                            <!-- Fecha y Hora -->
                                            <div class="col-lg-2">
                                                <label for="np_TECNfecha">Fecha y Hora</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                    <input type="datetime-local" id="np_TECNfecha" name="np_TECNfecha" class="form-control" onclick="this.showPicker();">
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
                                                    document.getElementById("np_TECNfecha").value = currentDateTime;
                                                });
                                            </script>
                                        
                                            <!-- Colaborador -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_TECNcolaborador">Colaborador</label>
                                                    <select class="form-select d-block w-100" id="np_TECNcolaborador" name="np_TECNcolaborador" required>
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

                                            <!-- Departamento -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_TECNdepartamento">Departamento</label>
                                                    <select class="form-select d-block w-100" id="np_TECNdepartamento" name="np_TECNdepartamento" required>
                                                        <option value="">Departamento</option>
                                                        <?php
                                                        $categorias = $link_BB->query("SELECT id_DPT, nombre_DPT FROM departamento_DPT ORDER BY nombre_DPT ");
                                                        while ($row = $categorias->fetch_assoc()) {
                                                            echo '<option value="' . $row['id_DPT'] . '">' . $row['nombre_DPT'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Ubicacion -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_TECNubicacion">Ubicacion</label>
                                                    <select class="form-select d-block w-100" id="np_TECNubicacion" name="np_TECNubicacion" required>
                                                        <option value="">Ubicacion</option>
                                                        <?php
                                                        $categorias = $link_BB->query("SELECT id, code_LOC FROM locations ORDER BY code_LOC ");
                                                        while ($row = $categorias->fetch_assoc()) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['code_LOC'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            

                                             

                                            <!--Descripcion-->
                                            <div class="col-lg-3">
                                                <label for="np_TECNdescripcion">Descripcion</label>
                                                <textarea id="np_TECNdescripcion" name="np_TECNdescripcion" class="form-control" rows="1" style="overflow:hidden; resize:none; width: calc(100% - 25px);" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"></textarea>
                                            </div>

        

                                            <!-- Categoria -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_TECNcategoria">Categoria</label>
                                                    <select class="form-select d-block w-100" id="np_TECNcategoria" name="np_TECNcategoria" required>
                                                        <option value="">Categoria</option>
                                                        <?php
                                                        $categorias = $link_BB->query("SELECT id_CTG, nombre_CTG, modulo_CTG FROM `categoriasGenerales` WHERE modulo_CTG = 'TECN' ORDER BY nombre_CTG");
                                                        while ($row = $categorias->fetch_assoc()) {
                                                            echo '<option value="' . $row['id_CTG'] . '">' . $row['nombre_CTG'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Estatus -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_TECNestatus">Estatus</label>
                                                    <select class="form-select d-block w-100" id="np_TECNestatus" name="np_TECNestatus" required>
                                                        <option value="">Estatus</option>
                                                        <?php
                                                        $estado = $link_BB->query("SELECT id_EST, nombre_EST, modulo_EST FROM `estatusGenerales` WHERE modulo_EST = 'TECN' ORDER BY nombre_EST");
                                                        while ($row = $estado->fetch_assoc()) {
                                                            
                                                            echo '<option value="' . $row['id_EST']. '">' . $row['nombre_EST'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Prioridad -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_TECNprioridad">Prioridad</label>
                                                    <select class="form-select d-block w-100" id="np_TECNprioridad" name="np_TECNprioridad" required>
                                                        <!-- <option value="">Prioridad</option> -->
                                                        <?php
                                                        $estado = $link_BB->query("SELECT id_EST, nombre_EST, modulo_EST FROM `estatusGenerales` WHERE modulo_EST = 'PEST' ORDER BY nombre_EST");
                                                        while ($row = $estado->fetch_assoc()) {
                                                            
                                                            echo '<option value="' . $row['id_EST']. '">' . $row['nombre_EST'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Colaborador Asignado -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_TECNcolab_asignado">Colaborador Asignado</label>
                                                    <select class="form-select d-block w-100" id="np_TECNcolab_asignado" name="np_TECNcolab_asignado" required>
                                                        <!-- <option value="">Colaborador Asignado</option> -->
                                                        <?php
                                                        $categorias = $link_BB->query("SELECT id_CLB, numero_CLB, nombre_CLB FROM `colaboradores_CLB` WHERE is_deleted = 0 AND id_POSC=35 or id_POSC=39  ORDER BY nombre_CLB ASC");
                                                        while ($row = $categorias->fetch_assoc()) {
                                                            echo '<option value="' . $row['id_CLB'] . '">' . $row['nombre_CLB'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Activo -->
                                            <div class="col-lg-2 ">
                                                <div class="form-group">
                                                    <label for="np_TECNactivo">Tipo Activo</label>
                                                    <select class="form-select d-block w-100" id="np_TECNactivo" name="np_TECNactivo" required>
                                                        <!-- <option value="">Tipo Activo</option> -->
                                                        <?php
                                                        $estado = $link_BB->query("SELECT id_CTG, nombre_CTG, modulo_CTG FROM `categoriasGenerales` WHERE modulo_CTG = 'ACT' and id_CTG=218 or id_CTG=219 ORDER BY nombre_CTG");
                                                        while ($row = $estado->fetch_assoc()) {
                                                       
                                                            echo '<option value="' . $row['id_CTG']. '">' . $row['nombre_CTG'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div> 

                                            <!-- Botón Guardar con margen superior -->
                                            <div class="row pb-2">
                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100" type="submit"  style="margin-top: 20px;">Guardar</button>
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
                                    
                                    <th>Fecha/Hora</th>
                                    <th>Colaborador</th>
                                    <th>Departamento</th>
                                    <th>Ubicacion</th>
                                    <th>Descripcion</th>
                                    <th>Categoria</th>
                                    <th>Usuario</th>
                                    <th>Estatus</th>
                                    <th>Prioridad</th>
                                    <th>Colaborador Asignado</th>
                                    <th>Activo</th>
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
                                        <span id="Fecha_TECN_<?php echo $row['fecha_TECN']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['fecha_TECN']; ?>"><?php echo $row['fecha_TECN']; ?></span>

                                    </td>
                                        <td>
                                            <span id="Nombre Colaborador<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Nombre Colaborador']; ?>"><?php echo $row['Nombre Colaborador']; ?></span>
                                        </td> 
                                        <td>
                                            <span id="Departamento<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Departamento']; ?>"><?php echo $row['Departamento']; ?></span>
                                        </td>
                                        <td>
                                            <span id="Ubicacion<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Ubicacion']; ?>"><?php echo $row['Ubicacion']; ?></span>
                                        </td>
                                        <td>
                                            <span id="Descripcion<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Descripcion']; ?>"><?php echo $row['Descripcion']; ?></span>
                                        </td>  
                                        <td>
                                            <span id="Categoria<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Categoria']; ?>"><?php echo $row['Categoria']; ?></span>
                                        </td> 
                                        <td>
                                            <span id="Usuario<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Usuario']; ?>"><?php echo $row['Usuario']; ?></span>
                                        </td> 
                                        <td>
                                            <span id="Estatus<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Estatus']; ?>"><?php echo $row['Estatus']; ?></span>
                                        </td> 
                                        <td>
                                            <span id="Prioridad<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Prioridad']; ?>"><?php echo $row['Prioridad']; ?></span>
                                        </td> 
                                        <td>
                                            <span id="Colaborador Asignado<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Colaborador Asignado']; ?>"><?php echo $row['Colaborador Asignado']; ?></span>
                                        </td> 
                                        <td>
                                            <span id="Activo<?php echo $row['ID']; ?>" class="cur-pointer searchstring" data-searchstring="<?php echo $row['Activo']; ?>"><?php echo $row['Activo']; ?></span>
                                        </td> 
                                        <!-- <td>
                                             Descripción con Tooltip 
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
                                        </td> -->
                                        <!-- <td>
                                            <div class="notifications-list">
                                                <li>
                                                    <a class="notification-list-icon modal-sizes simple-ajax-modal" href="__form_Mtto-novedades.php?id=<?php echo $row['ID']; ?>">
                                                        <i class="fas fa-edit" title="Editar"></i>
                                                    </a>
                                                </li>
                                            </div>
                                        </td> -->
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

let btn_TECNagregar=document.getElementById("btn_TECNagregar");
let icon_agre=document.getElementById("iconagre");

    
    $( '#cantidadEstatusTitulos' ).html('<?php echo $p1_estatusTitulo. ' Tecnologia ' .$p2_estatusTitulo; ?>');    
        
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
    
    $( btn_TECNagregar ).on( 'click', function() {

        if(btn_TECNagregar.innerText === "Agregar"){
            btn_TECNagregar.innerText=" Cancelar";
            let nuevo_i=document.createElement("i");
            nuevo_i.classList.add("bi","bi-x-circle");
            btn_TECNagregar.prepend(nuevo_i);
            
            
        }
        else {

            btn_TECNagregar.innerText="Agregar";
            let nuevo_i=document.createElement("i");
            btn_TECNagregar.prepend(nuevo_i);
            nuevo_i.classList.add("fas","fa-pen");
            
        };

        btn_TECNagregar.classList.toggle("btn-danger");
        $( '#div_agregarnovs' ).toggle('slow');
        
    });    
        
    var clipboard = new ClipboardJS('.clipboard');
    
</script>