<?php
require_once __DIR__ . '/../models/repositories/ActorsRepository.php';
require_once 'AbstractController.php';

class ActorsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct(new ActorsRepository());
    }
    public function list()
    {
        $listado = $this->repository->getAll();
        require_once __DIR__ . '/../views/actors/list.php';
    }
    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $form = $this->validateForm();

                $actor = new Actor(null, $form["name"], $form["surname"], $form["birthday"], $form["nationality"], $form["isActor"], $form["isDirector"]);
                $this->repository->create($actor);
                $_SESSION['message'] = ["type" => "success", "text" => "Actor " . $actor->getName() . " creada con éxito."];
                header('Location: /actors/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/actors/create.php';
    }
    public function read()
    {
        throw new Exception("Not implemented yet");
    }
    public function update()
    {
        try {
            //Si no se especificó el actorId:
            if (empty($_GET["actorId"])) throw new NotFoundException("Debes especificar el actor que quieres editar.");

            $actor = $this->repository->getById($_GET["actorId"]);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $form = $this->validateForm();

                $actor->setName($form["name"]);
                $actor->setSurname($form["surname"]);
                $actor->setBirthday($form["birthday"]);
                $actor->setNationality($form["nationality"]);
                $actor->setIsDirector($form["isDirector"]);
                $actor->setIsActor($form["isActor"]);

                $this->repository->update($actor);
                $_SESSION['message'] = ["type" => "success", "text" => "Actor " . $actor->getName() . " modificada con éxito."];
                header('Location: /actors/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /actors/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/actors/update.php';
    }
    public function delete()
    {
        try {
            //Si el método no es POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new MethodNotAllowedException('Para borrar debes usar el método POST, no "' . $_SERVER['REQUEST_METHOD'] . '"');
            if (empty($_POST["actorId"])) throw new NotFoundException("Debes especificar el actor que quieres Borrar.");
            $actor = $this->repository->getById($_POST["actorId"]);
            $this->repository->delete($_POST["actorId"]);
            $_SESSION['message'] = ["type" => "success", "text" => "Se borró el actor " . $actor->getName()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /actors/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (MethodNotAllowedException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /actors/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (PDOException $e) {
            $text = "Error de base de datos.";
            if ( str_contains($e->getMessage(),"serie_actors_actor_fk")) {
                $text = "No puedes eliminar este actor porque está asociado a una serie.";
            } 
            $_SESSION['message'] = ["type" => "danger","text" => $text];
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        header('Location: /actors/list');
        exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
    }
    private function validateForm()
    {
        if (empty($_POST["name"])) throw new Exception("No se recibió el nombre del actor en el formulario.");
        if (empty($_POST["surname"])) throw new Exception("No se recibió el apellido del actor en el formulario.");
        if (empty($_POST["birthday"])) throw new Exception("No se recibió la fecha de nacimiento del actor en el formulario.");
        if (empty($_POST["nationality"])) throw new Exception("No se recibió la nacionalidad del actor en el formulario.");

        $isDirector = false;
        $isActor = false;
        if (isset($_POST["isDirector"])) $isDirector = $_POST["isDirector"] === "1";
        if (isset($_POST["isActor"])) $isActor = $_POST["isActor"] === "1";
        if (!$isActor && !$isDirector) throw new Exception("La persona tiene que ser director y/o actor.");

        return [
            "name" => $_POST["name"],
            "surname" => $_POST["surname"],
            "birthday" => $_POST["birthday"],
            "nationality" => $_POST["nationality"],
            "isDirector" => $isDirector,
            "isActor" => $isActor,
        ];
    }
}
