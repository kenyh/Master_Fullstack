<?php
require_once __DIR__ . '/../models/PlatformsRepository.php';
require_once 'AbstractController.php';
require_once __DIR__ . "/../models/errors/ValidationException.php";

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
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje.
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
        throw new Exception("Not implemented yet");
    }
    public function delete()
    {
        throw new Exception("Not implemented yet");
    }
}
