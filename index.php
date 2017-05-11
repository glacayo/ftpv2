<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FTPv2</title>
<!-- JQUERY 1.12 LOCAL -->
<script type="text/javascript" src="js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP 3.3 CSS CDN -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- FONT AWESOME 4.7 CSS CDN -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
 <!-- BOOTSTRAP 3.3 JS CDN -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- FANCYWEBSOCKET JS LOCAL -->
<script src="js/fancywebsocket.js"></script>
<script type="text/javascript">
function actualiza_mensaje(message)
{
	var JSONdata    = JSON.parse(message); //parseo la informacion
				var usuario = JSONdata[0].usuario
				var urlPeticion = JSONdata[0].urlPeticion
				var accionPeticion = JSONdata[0].accionPeticion
				var motivoPeticion = JSONdata[0].motivoPeticion
				var mensajePeticion = JSONdata[0].mensajePeticion
				var estadoPeticion = JSONdata[0].estadoPeticion
				var gestorPeticion = JSONdata[0].gestorPeticion
				var timestamp = JSONdata[0].timestamp

				var tipo = JSONdata[0].tipo;
				var mensaje = JSONdata[0].mensaje;
				var fecha = JSONdata[0].fecha;

				if (estadoPeticion==1) {
					estadoPeticion = "HECHA";
				}else if (estadoPeticion==2){
					estadoPeticion = "PROCESANDO";
				}else if (estadoPeticion==0){
					estadoPeticion = "PENDIENTE";
				};
				
				var contenidoDiv  = $("#respuestaPeticion").html();
				var mensajehtml   = timestamp+' : '+urlPeticion;
		          if(window.Notification && Notification.permission !== "denied") {
		            Notification.requestPermission(function(status) {  // si estatus es granted es por que el suario acepto 
		              var n = new Notification('NOTIFICACION FTP', { 
		                body: usuario+' envio una peticion para '+accionPeticion+' el sitio de '+urlPeticion,
		                icon: 'http://192.168.1.62/ftp/alert-icon.png'
		              }); 
		            });
		          }
				$("#respuestaPeticion").html('<div><div class="well"><strong id="name_ftp_user">'+usuario+'</strong> dice: Por favor <strong id="accion_peticion" class="bajar">'+accionPeticion+'</strong> la pagina <strong id="neme_ftp_url" class="url">'+urlPeticion+'</strong> <br> por motivos de '+motivoPeticion+' | Peticion enviada a las: '+timestamp+' | Estado de la peticion: <strong class="pendiente"><i class="fa fa-exclamation-triangle"></i> '+estadoPeticion+' </strong><br> Atendido por: <strong class="bajar">'+gestorPeticion+'</strong><div>NOTAS ADICIONALES: <p style="word-wrap: break-word !important;">'+mensajePeticion+'</p></div></div>');
}

</script>
<!-- CUSTOM CLASS AND ID'S -->
<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<body>
<!-- EMPIEZA LA APLICACION -->
<?php

/**
 * Class OneFileLoginApplication
 *
 * An entire php application with user registration, login and logout in one file.
 * Uses very modern password hashing via the PHP 5.5 password hashing functions.
 * This project includes a compatibility file to make these functions available in PHP 5.3.7+ and PHP 5.4+.
 *
 * @author Panique
 * @link https://github.com/panique/php-login-one-file/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class OneFileLoginApplication
{
    /**
     * @var string Type of used database (currently only SQLite, but feel free to expand this with mysql etc)
     */
    private $db_type = "sqlite"; //

    /**
     * @var string Path of the database file (create this with _install.php)
     */
    private $db_sqlite_path = "./users.db";

    /**
     * @var object Database connection
     */
    private $db_connection = null;

    /**
     * @var bool Login status of user
     */
    private $user_is_logged_in = false;

    /**
     * @var string System messages, likes errors, notices, etc.
     */
    public $feedback = "";


    /**
     * Does necessary checks for PHP version and PHP password compatibility library and runs the application
     */
    public function __construct()
    {
        if ($this->performMinimumRequirementsCheck()) {
            $this->runApplication();
        }
    }

    /**
     * Performs a check for minimum requirements to run this application.
     * Does not run the further application when PHP version is lower than 5.3.7
     * Does include the PHP password compatibility library when PHP version lower than 5.5.0
     * (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
     * @return bool Success status of minimum requirements check, default is false
     */
    private function performMinimumRequirementsCheck()
    {
        if (version_compare(PHP_VERSION, '5.3.7', '<')) {
            echo "Sorry, Simple PHP Login does not run on a PHP version older than 5.3.7 !";
        } elseif (version_compare(PHP_VERSION, '5.5.0', '<')) {
            require_once("libraries/password_compatibility_library.php");
            return true;
        } elseif (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            return true;
        }
        // default return
        return false;
    }

    /**
     * This is basically the controller that handles the entire flow of the application.
     */
    public function runApplication()
    {
        // check is user wants to see register page (etc.)
        if (isset($_GET["action"]) && $_GET["action"] == "register") {
            $this->doRegistration();
            $this->showPageRegistration();
        } else {
            // start the session, always needed!
            $this->doStartSession();
            // check for possible user interactions (login with session/post data or logout)
            $this->performUserLoginAction();
            // show "page", according to user's login status
            if ($this->getUserLoginStatus()) {
                $this->showPageLoggedIn();
            } else {
                $this->showPageLoginForm();
            }
        }
    }

    /**
     * Creates a PDO database connection (in this case to a SQLite flat-file database)
     * @return bool Database creation success status, false by default
     */
    private function createDatabaseConnection()
    {
        try {
            $this->db_connection = new PDO($this->db_type . ':' . $this->db_sqlite_path);
            return true;
        } catch (PDOException $e) {
            $this->feedback = "PDO database connection problem: " . $e->getMessage();
        } catch (Exception $e) {
            $this->feedback = "General problem: " . $e->getMessage();
        }
        return false;
    }

    /**
     * Handles the flow of the login/logout process. According to the circumstances, a logout, a login with session
     * data or a login with post data will be performed
     */
    private function performUserLoginAction()
    {
        if (isset($_GET["action"]) && $_GET["action"] == "logout") {
            $this->doLogout();
        } elseif (!empty($_SESSION['user_name']) && ($_SESSION['user_is_logged_in'])) {
            $this->doLoginWithSessionData();
        } elseif (isset($_POST["login"])) {
            $this->doLoginWithPostData();
        }
    }

    /**
     * Simply starts the session.
     * It's cleaner to put this into a method than writing it directly into runApplication()
     */
    private function doStartSession()
    {
        if(session_status() == PHP_SESSION_NONE) session_start();
    }

    /**
     * Set a marker (NOTE: is this method necessary ?)
     */
    private function doLoginWithSessionData()
    {
        $this->user_is_logged_in = true; // ?
    }

    /**
     * Process flow of login with POST data
     */
    private function doLoginWithPostData()
    {
        if ($this->checkLoginFormDataNotEmpty()) {
            if ($this->createDatabaseConnection()) {
                $this->checkPasswordCorrectnessAndLogin();
            }
        }
    }

    /**
     * Logs the user out
     */
    private function doLogout()
    {
        $_SESSION = array();
        session_destroy();
        $this->user_is_logged_in = false;
        $this->feedback = "<div class='alert alert-info'><strong><i class='fa fa-info'></i></strong> Se ha cerrado su sesion de FTP</div>";
    }

    /**
     * The registration flow
     * @return bool
     */
    private function doRegistration()
    {
        if ($this->checkRegistrationData()) {
            if ($this->createDatabaseConnection()) {
                $this->createNewUser();
            }
        }
        // default return
        return false;
    }

    /**
     * Validates the login form data, checks if username and password are provided
     * @return bool Login form data check success state
     */
    private function checkLoginFormDataNotEmpty()
    {
        if (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {
            return true;
        } elseif (empty($_POST['user_name'])) {
            $this->feedback = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->feedback = "Password field was empty.";
        }
        // default return
        return false;
    }

    /**
     * Checks if user exits, if so: check if provided password matches the one in the database
     * @return bool User login success status
     */
    private function checkPasswordCorrectnessAndLogin()
    {
        // remember: the user can log in with username or email address
        $sql = 'SELECT user_name, user_email, user_password_hash
                FROM users
                WHERE user_name = :user_name OR user_email = :user_name
                LIMIT 1';
        $query = $this->db_connection->prepare($sql);
        $query->bindValue(':user_name', $_POST['user_name']);
        $query->execute();

        // Btw that's the weird way to get num_rows in PDO with SQLite:
        // if (count($query->fetchAll(PDO::FETCH_NUM)) == 1) {
        // Holy! But that's how it is. $result->numRows() works with SQLite pure, but not with SQLite PDO.
        // This is so crappy, but that's how PDO works.
        // As there is no numRows() in SQLite/PDO (!!) we have to do it this way:
        // If you meet the inventor of PDO, punch him. Seriously.
        $result_row = $query->fetchObject();
        if ($result_row) {
            // using PHP 5.5's password_verify() function to check password
            if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {
                // write user data into PHP SESSION [a file on your server]
                $_SESSION['user_name'] = $result_row->user_name;
                $_SESSION['user_email'] = $result_row->user_email;
                $_SESSION['user_is_logged_in'] = true;
                $this->user_is_logged_in = true;
                return true;
            } else {
                $this->feedback = "<div class='alert alert-warning'><strong><i class='fa fa-exclamation-triangle'></i></strong> Password Incorrecto.</div>";
            }
        } else {
            $this->feedback = "<div class='alert alert-warning'><strong><i class='fa fa-exclamation-triangle'></i></strong> Este Usuario no existe</div>";
        }
        // default return
        return false;
    }

    /**
     * Validates the user's registration input
     * @return bool Success status of user's registration data validation
     */
    private function checkRegistrationData()
    {
        // if no registration form submitted: exit the method
        if (!isset($_POST["register"])) {
            return false;
        }

        // validating the input
        if (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && strlen($_POST['user_password_new']) >= 6
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            // only this case return true, only this case is valid
            return true;
        } elseif (empty($_POST['user_name'])) {
            $this->feedback = "Empty Username";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->feedback = "Empty Password";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->feedback = "Password and password repeat are not the same";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->feedback = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->feedback = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->feedback = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (empty($_POST['user_email'])) {
            $this->feedback = "Email cannot be empty";
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->feedback = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->feedback = "Your email address is not in a valid email format";
        } else {
            $this->feedback = "An unknown error occurred.";
        }

        // default return
        return false;
    }

    /**
     * Creates a new user.
     * @return bool Success status of user registration
     */
    private function createNewUser()
    {
        // remove html code etc. from username and email
        $user_name = htmlentities($_POST['user_name'], ENT_QUOTES);
        $user_email = htmlentities($_POST['user_email'], ENT_QUOTES);
        $user_password = $_POST['user_password_new'];
        // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 char hash string.
        // the constant PASSWORD_DEFAULT comes from PHP 5.5 or the password_compatibility_library
        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

        $sql = 'SELECT * FROM users WHERE user_name = :user_name OR user_email = :user_email';
        $query = $this->db_connection->prepare($sql);
        $query->bindValue(':user_name', $user_name);
        $query->bindValue(':user_email', $user_email);
        $query->execute();

        // As there is no numRows() in SQLite/PDO (!!) we have to do it this way:
        // If you meet the inventor of PDO, punch him. Seriously.
        $result_row = $query->fetchObject();
        if ($result_row) {
            $this->feedback = "Sorry, that username / email is already taken. Please choose another one.";
        } else {
            $sql = 'INSERT INTO users (user_name, user_password_hash, user_email)
                    VALUES(:user_name, :user_password_hash, :user_email)';
            $query = $this->db_connection->prepare($sql);
            $query->bindValue(':user_name', $user_name);
            $query->bindValue(':user_password_hash', $user_password_hash);
            $query->bindValue(':user_email', $user_email);
            // PDO's execute() gives back TRUE when successful, FALSE when not
            // @link http://stackoverflow.com/q/1661863/1114320
            $registration_success_state = $query->execute();

            if ($registration_success_state) {
                $this->feedback = "Your account has been created successfully. You can now log in.";
                return true;
            } else {
                $this->feedback = "Sorry, your registration failed. Please go back and try again.";
            }
        }
        // default return
        return false;
    }

    /**
     * Simply returns the current status of the user's login
     * @return bool User's login status
     */
    public function getUserLoginStatus()
    {
        return $this->user_is_logged_in;
    }

    /**
     * Simple demo-"page" that will be shown when the user is logged in.
     * In a real application you would probably include an html-template here, but for this extremely simple
     * demo the "echo" statements are totally okay.
     */
    private function showPageLoggedIn()
    {
        if ($this->feedback) {
            echo $this->feedback . "<br/><br/>";
    }
    
?>
<?php	include('clases/conect.php'); 
		include('funciones/hostingName.php');
        include('changedStatus.php');
		$peticionesQuery = $dataBase->query("SELECT * FROM ftp_peticiones ORDER BY timestamp DESC");
		$db = new SQLite3('users.db');
		$userName = $_SESSION['user_name'];
		$queryPermisos = $db->query("SELECT user_permiso FROM users WHERE user_name = '$userName'");
		$user_permiso = $queryPermisos->fetchArray();
		
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="./">FTP</a>
    </div><!-- 
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
    </ul> -->
    <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><i class="fa fa-server"></i> <span id="message_box"></span></a>
      <li><a href="#"><i class="fa fa-user"></i> <?php echo $_SESSION['user_name'];?> is <?php echo $user_permiso['user_permiso'];?></a></li>
      <li><?php  echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?action=logout"><span class="glyphicon glyphicon-log-in"></span> Log out</a>'; ?></li>
    </ul>
  </div>
</nav>
    <div class="container">
        <div class="row">
            
			<div id="div" class="col-md-9">
                <?php
                echo "<h3><strong>Peticiones recientes</strong>  <br><span>Por favor tenga paciencia, tambien nosotros estamos trabajando en paginas web!!</span></h3>";

                echo "<div id='respuestaPeticion'></div>";
                while ($peticionesResultados = $peticionesQuery->fetchArray(SQLITE3_ASSOC)) {
                    echo "<div>";
                        echo "<div class='well'>";
                            $url = $peticionesResultados['urlPeticion'];
                            echo "<strong id='name_ftp_user'>" . $peticionesResultados['usuario'] . "</strong>" . " dice: Por favor <strong id='accion_peticion' class='" . $peticionesResultados['accionPeticion'] . "'>" . $peticionesResultados['accionPeticion'] . "</strong> la pagina <strong id='neme_ftp_url' class='url'>" . $peticionesResultados['urlPeticion'] . "</strong> <br> por motivos de ". $peticionesResultados['motivoPeticion'];
                            echo "| Peticion enviada a las: (" . $peticionesResultados['timestamp'] . ")";
                            if ($peticionesResultados['estadoPeticion'] == 0){
                                echo " | Estado de la peticion: <strong class='pendiente'><i class='fa fa-exclamation-triangle'></i> PENDIENTE</strong>";
                            }elseif($peticionesResultados['estadoPeticion'] == 1){
                                echo " | Estado de la peticion: <strong class='hecha'><i class='fa fa-check-circle'></i> HECHA</strong>";
                            }elseif($peticionesResultados['estadoPeticion'] == 2) {
                                echo " | Estado de la peticion: <strong class='procesando'><i class='fa fa-cog fa-spin fa-fw'></i> PROCESANDO</strong>";
                            }
                            $urlCatch = $peticionesResultados['urlPeticion'];
                            hostingName($urlCatch);
                            echo "<br> Atendido por: <strong class='bajar'>" . $peticionesResultados['gestorPeticion'] . "</strong>";
                            echo "<div>";
                                echo "NOTAS ADICIONALES: <p style='word-wrap: break-word !important;'>" . strip_tags( $peticionesResultados['mensajePeticion'] ) . "</p>";
                            echo "</div>";

                            // ROW Button Control
                             echo "<div class='row'>";
                                if ( $_SESSION['user_name'] == $peticionesResultados['usuario'] ) {

                                    if ( $peticionesResultados['estadoPeticion'] == 0 ) {
                                        echo "<form id='CancelarPeticion' class='col-md-2' action='' method='POST'>";
                                            echo "<input type='hidden' name='IDUpdate' value='".$peticionesResultados['id']."'>";
                                            echo "<input type='hidden' name='newStatus' value='3'>";
                                            echo "<input type='hidden' name='gestorPeticion' value='".$_SESSION['user_name']."'>";
                                            echo "<button type='submit' class='btn btn-sm btn-danger'><i class='fa fa-times'></i> Cancelar Peticion</button>";
                                        echo "</form>";
                                    }
                                }

                                if ( $user_permiso['user_permiso']=="admin" ) {
                                    if($peticionesResultados['estadoPeticion'] == 1){
                                        // Si la peticion esta hecha no mostra nada
                                    }else{
                                        if ( $_SESSION['user_name'] == "Geovanny" ) {
                                            if ( $peticionesResultados['estadoPeticion'] == 2 ) {
                                                if ( $peticionesResultados['gestorPeticion'] == "Geovanny" ) {
                                                    echo "<form id='PeticionHecha' class='col-md-2' action='' method='POST'>";
                                                        echo "<input type='hidden' name='IDUpdate' value='".$peticionesResultados['id']."'>";
                                                        echo "<input type='hidden' name='newStatus' value='1'>";
                                                        echo "<input type='hidden' name='gestorPeticion' value='".$_SESSION['user_name']."'>";
                                                        echo "<button type='submit' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Peticion Hecha</button>";
                                                    echo "</form>";
                                                    echo "<form id='ProcesarPeticion' class='col-md-3' action='' method='POST'>";
                                                        echo "<input type='hidden' name='IDUpdate' value='".$peticionesResultados['id']."'>";
                                                        echo "<input type='hidden' name='newStatus' value='0'>";
                                                        echo "<input type='hidden' name='gestorPeticion' value='".$_SESSION['user_name']."'>";
                                                        echo "<button type='submit' class='btn btn-sm btn-primary'><i class='fa fa-chain-broken'></i> Interrumpir Proceso</button>";
                                                    echo "</form>";
                                                    echo "<form id='CancelarPeticion' class='col-md-2 pull-left' action='' method='POST'>";
                                                        echo "<input type='hidden' name='IDUpdate' value='".$peticionesResultados['id']."'>";
                                                        echo "<input type='hidden' name='newStatus' value='3'>";
                                                        echo "<input type='hidden' name='gestorPeticion' value='".$_SESSION['user_name']."'>";
                                                        echo "<button type='submit' class='btn btn-sm btn-danger'><i class='fa fa-times'></i> Eliminar esta Peticion</button>";
                                                    echo "</form>";
                                                }
                                            }
                                        }elseif ( $_SESSION['user_name'] == "asyi") {
                                            if ( $peticionesResultados['estadoPeticion'] == 2 ) {
                                                if ( $peticionesResultados['gestorPeticion'] == "asyi" ) {
                                                    echo "<form id='PeticionHecha' class='col-md-2' action='' method='POST'>";
                                                        echo "<input type='hidden' name='IDUpdate' value='".$peticionesResultados['id']."'>";
                                                        echo "<input type='hidden' name='newStatus' value='1'>";
                                                        echo "<input type='hidden' name='gestorPeticion' value='".$_SESSION['user_name']."'>";
                                                        echo "<button type='submit' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Peticion Hecha</button>";
                                                    echo "</form>";
                                                    echo "<form id='ProcesarPeticion' class='col-md-3' action='' method='POST'>";
                                                        echo "<input type='hidden' name='IDUpdate' value='".$peticionesResultados['id']."'>";
                                                        echo "<input type='hidden' name='newStatus' value='0'>";
                                                        echo "<input type='hidden' name='gestorPeticion' value='".$_SESSION['user_name']."'>";
                                                        echo "<button type='submit' class='btn btn-sm btn-primary'><i class='fa fa-chain-broken'></i> Interrumpir Proceso</button>";
                                                    echo "</form>";
                                                    echo "<form id='CancelarPeticion' class='col-md-2 pull-left' action='' method='POST'>";
                                                        echo "<input type='hidden' name='IDUpdate' value='".$peticionesResultados['id']."'>";
                                                        echo "<input type='hidden' name='newStatus' value='3'>";
                                                        echo "<input type='hidden' name='gestorPeticion' value='".$_SESSION['user_name']."'>";
                                                        echo "<button type='submit' class='btn btn-sm btn-danger'><i class='fa fa-times'></i> Eliminar esta Peticion</button>";
                                                    echo "</form>";
                                                }
                                            }
                                        }
                                    }
                                    if ( $peticionesResultados['estadoPeticion'] == 0 ) {
                                        echo "<form id='PeticionHecha' class='col-md-2' action='' method='POST'>";
                                        echo "<input type='hidden' name='IDUpdate' value='".$peticionesResultados['id']."'>";
                                        echo "<input type='hidden' name='newStatus' value='2'>";
                                        echo "<input type='hidden' name='gestorPeticion' value='".$_SESSION['user_name']."'>";
                                         echo "<button type='submit' class='btn btn-sm btn-warning'><i class='fa fa-eye'></i> Procesar Peticion</button>";
                                        echo "</form>";
                                    }
                                }
                                echo "</div>";
                                ?>
                                <script type="text/javascript">
                                    $('#procesar<?php echo $peticionesResultados["id"];?>').click(function(){
                                        var id = document.getElementById('IDUpdate<?php echo $peticionesResultados["id"];?>').value;
                                        var newStatus = document.getElementById('newStatus<?php echo $peticionesResultados["id"];?>').value;
                                        var gestorPeticion = document.getElementById('gestorPeticion<?php echo $peticionesResultados["id"];?>').value;
                                        alert(id);
                                          $.ajax({
                                              url: 'changedStatus.php',
                                              type: 'POST',
                                              data: "IDUpdate="+id+"&urlPeticion="+newStatus+"&gestorPeticion="+gestorPeticion,
                                                    dataType: 'html'
                                          })
                                          .done(function(data){
                                              var $html = $( data );
                                              //$html.filter('#respuestaPositiva').fadeIn('slow').appendTo("#respuestaForm").fadeOut(10000);
                                             // $html.filter('#respuestaNegativa').fadeIn('slow').appendTo("#respuestaForm").fadeOut(10000);
                                          })
                                          .fail(function(data){
                                              alert('Ajax Error');
                                          });
                                    })
                                </script>
                                <?php
                            //END Button Control
                        echo "</div>";
                    echo "</div>";
                }
                $dataBase->close(); 
                unset($dataBase); 
                ?>
			</div>
            <div class="form-send col-md-3">
	          <div class="fija">
                <div><a href="" id="recargar"><i class="fa fa-refresh fa-spin fa-fw"></i> Recargar</a> <span id="timer"></span></div>
                <h3 style="">Crear Peticion </h3>
                <form id="EnviarPeticion" action="insertar.php" method="POST" class="well">
    	            <div class="form-group">
                        <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['user_name']?>">
                        <input type="url" class="form-control" name="urlPeticion" id="urlPeticion" placeholder="Escriba la url aqui" required><br>
                        <label style="">Accion de la peticion</label>
	                    <select class="form-control" name="accionPeticion" id="accionPeticion">
    	                    <option value="bajar">Bajar Pagina</option>
        	                <option value="subir">Subir Pagina</option>
                        </select><br>
                        <label style="">Motivo de la peticion</label>
                        <select class="form-control" name="motivoPeticion" id="motivoPeticion">
                            <option value="Nueva Pagina">Nueva Pagina</option>
                            <option value="Cambios">Cambios</option>
                        </select><br>
                        <textarea name="mensajePeticion" id="mensajePeticion" class="form-control" cols="40" rows="5" maxlength="250" placeholder="Escriba aqui un mensaje adicional"></textarea><br>
                        <button id="send-btn" class="btn btn-primary" type="submit">Enviar Peticion</button>
                    </div>
                    <div class="clock" style="margin:2em;"></div>
                    <div id="respuestaForm"></div>
                    <div class="result"></div>
                </form>
          	</div>
        </div>
    </div>


<script type="text/javascript">

$( document ).ready(function(){


	$('#EnviarPeticion').on('submit', function (e) {
		e.preventDefault();
			var usuario			= document.getElementById('usuario').value;
			var urlPeticion		= document.getElementById('urlPeticion').value;
			var accionPeticion	= document.getElementById('accionPeticion').value;
			var motivoPeticion	= document.getElementById('motivoPeticion').value;
			var mensajePeticion = document.getElementById('mensajePeticion').value;
			$.ajax({
					type: 'POST',
					url: 'insertar.php',
					data: "usuario="+usuario+"&urlPeticion="+urlPeticion+"&accionPeticion="+accionPeticion+"&motivoPeticion="+motivoPeticion+"&mensajePeticion="+mensajePeticion,
					dataType: 'html',
					success: function(data) 
					{
						send(data);
						//$html.filter('#respuestaPositiva').fadeIn('slow').appendTo("#respuestaForm").fadeOut(10000);
						//$html.filter('#respuestaNegativa').fadeIn('slow').appendTo("#respuestaForm").fadeOut(10000);
					}//END DONE
				})//END AJAX
				.fail(function(data){
					console.log('Ajax Error');
				});//END FAIL
	});// END GUARDAR
        var count=90;
        var counter=setInterval(timer, 1000); //1000 will  run it every 1 second
        function timer()
        {
          count=count-1;
          if (count <= 0)
          {
            location.reload();
             clearInterval(counter);
             return;
          }

         document.getElementById("timer").innerHTML=count + " Seg"; // watch for spelling
        }
        $('#recargar').click(function(){
            location.reload();
        })
});

</script>
<!-- FINALIZA LA APLICACION -->
<?php
       
    }

    /**
     * Simple demo-"page" with the login form.
     * In a real application you would probably include an html-template here, but for this extremely simple
     * demo the "echo" statements are totally okay.
     */
    private function showPageLoginForm()
    {
        if ($this->feedback) {
            echo $this->feedback . "<br/><br/>";
        }
        echo '<div class="container"><div class="row"><div class="col-md-6 col-md-offset-3 text-center">';

        echo '<h2><b>Login FTP </b></h2>';

        echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '" name="loginform" class="form-custom">';
        echo '<div class="form-group">';
        echo '<label for="login_input_username">username o email</label> ';
        echo '<input id="login_input_username" class="form-control" type="text" name="user_name" required /> ';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="login_input_password">password</label> ';
        echo '<input id="login_input_password" class="form-control" type="password" name="user_password" required /> ';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<input type="submit"  name="login" class="btn btn-danger" value="Log in" />';
        echo '</div>';
        echo '</form>';

        //echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?action=register">Registrate</a>';

        echo '</div></div></div>';
    }

    /**
     * Simple demo-"page" with the registration form.
     * In a real application you would probably include an html-template here, but for this extremely simple
     * demo the "echo" statements are totally okay.
     */
    private function showPageRegistration()
    {
        if ($this->feedback) {
            echo $this->feedback . "<br/><br/>";
        }
        echo '<div class="container"><div class="row"><div class="col-md-6 col-md-offset-3 text-center">';

        echo '<h2>Registrar usuario</h2>';

        echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '?action=register" name="registerform" class="form-custom2">';
        echo '<div class="form-group">';
        echo '<label for="login_input_username">Username (solo letras y numeros, de 2 a 64 caracteres)</label>';
        echo '<input id="login_input_username" type="text" class="form-control" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="login_input_email">Correo electronico (El de la empresa xfa :))</label>';
        echo '<input id="login_input_email" type="email" class="form-control" name="user_email" required />';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="login_input_password_new">Password (min. 6 caracteres)</label>';
        echo '<input id="login_input_password_new" class="login_input form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="login_input_password_repeat">Repetir password</label>';
        echo '<input id="login_input_password_repeat" class="login_input form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<input type="submit" name="register" class="btn btn-success" value="Registrar" />';
        echo '</div>';
        echo '</form>';

        echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '"><i class="fa fa-home"></i> Home</a>';

        echo '</div></div></div>';
    }
}

// run the application
$application = new OneFileLoginApplication();
?>

</body>
</html>

</body>
</html>