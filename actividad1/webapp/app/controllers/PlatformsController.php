<?php
require_once __DIR__ . '/../models/PlatformsRepository.php';
require_once 'AbstractController.php';
require_once __DIR__ . "/../models/errors/ValidationException.php";
require_once __DIR__ . "/../models/errors/NotFoundException.php";
require_once __DIR__ . "/../models/errors/MethodNotAllowedException.php";

class PlatformsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct(new PlatformsRepository());
    }
    public function list()
    {
        $listado = $this->repository->getAll();
        require_once __DIR__ . '/../views/platforms/list.php';
    }
    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $platform = new Platform(null, $_POST["name"]);
                $this->repository->create($platform);
                $_SESSION['message'] = ["type" => "success", "text" => "Plataforma " . $platform->getName() . " creada con éxito."];
                header('Location: /platforms/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/platforms/create.php';
    }
    public function read()
    {
        throw new Exception("Not implemented yet");
    }
    public function update()
    {

        try {
            //Si no se especificó el platformId:
            if (!isset($_GET["platformId"])) throw new NotFoundException("Debes especificar la plataforma que quieres editar.");
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST["name"])) throw new Exception("No se recibió el nombre de la plataforma en el formulario.");

            $platform = $this->repository->getById($_GET["platformId"]);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $platform->setName($_POST["name"]);                     //Cambio el nombre.
                $this->repository->update($platform);
                $_SESSION['message'] = ["type" => "success", "text" => "Plataforma " . $platform->getName() . " modificada con éxito."];
                header('Location: /platforms/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /platforms/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/platforms/create.php';
    }
    public function delete()
    {
        try {
            //Si el método no es POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new MethodNotAllowedException('Para borrar debes usar el método POST, no "' . $_SERVER['REQUEST_METHOD'] . '"');
            if (!isset($_POST["platformId"])) throw new NotFoundException("Debes especificar la plataforma que quieres Borrar.");
            $platform = $this->repository->getById($_POST["platformId"]);
            $this->repository->delete($_POST["platformId"]);
            $_SESSION['message'] = ["type" => "success", "text" => "Se borró la plataforma " . $platform->getName()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /platforms/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (MethodNotAllowedException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /platforms/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        header('Location: /platforms/list');
        exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
    }
}
