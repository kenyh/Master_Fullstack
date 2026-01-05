<?php
require_once __DIR__ . '/../models/repositories/DirectorsRepository.php';
require_once 'AbstractController.php';

class DirectorsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct(new DirectorsRepository());
    }
    public function list()
    {
        $listado = $this->repository->getAll();
        require_once __DIR__ . '/../views/directors/list.php';
    }
    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $form = $this->validateForm();

                $director = new Director(null, $form["name"], $form["surname"], $form["birthday"], $form["nationality"], $form["isActor"], $form["isDirector"]);
                $this->repository->create($director);
                $_SESSION['message'] = ["type" => "success", "text" => "Director " . $director->getName() . " creada con éxito."];
                header('Location: /directors/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/directors/create.php';
    }
    public function read()
    {
        throw new Exception("Not implemented yet");
    }
    public function update()
    {
        try {
            //Si no se especificó el directorId:
            if (empty($_GET["directorId"])) throw new NotFoundException("Debes especificar el director que quieres editar.");

            $director = $this->repository->getById($_GET["directorId"]);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $form = $this->validateForm();

                $director->setName($form["name"]);
                $director->setSurname($form["surname"]);
                $director->setBirthday($form["birthday"]);
                $director->setNationality($form["nationality"]);
                $director->setIsActor($form["isActor"]);
                $director->setIsDirector($form["isDirector"]);

                $this->repository->update($director);
                $_SESSION['message'] = ["type" => "success", "text" => "Director " . $director->getName() . " modificada con éxito."];
                header('Location: /directors/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /directors/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/directors/update.php';
    }
    public function delete()
    {
        try {
            //Si el método no es POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new MethodNotAllowedException('Para borrar debes usar el método POST, no "' . $_SERVER['REQUEST_METHOD'] . '"');
            if (empty($_POST["directorId"])) throw new NotFoundException("Debes especificar el director que quieres Borrar.");
            $director = $this->repository->getById($_POST["directorId"]);
            $this->repository->delete($_POST["directorId"]);
            $_SESSION['message'] = ["type" => "success", "text" => "Se borró el director " . $director->getName()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /directors/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (MethodNotAllowedException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /directors/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        header('Location: /directors/list');
        exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
    }
    private function validateForm()
    {
        if (empty($_POST["name"])) throw new Exception("No se recibió el nombre del director en el formulario.");
        if (empty($_POST["surname"])) throw new Exception("No se recibió el apellido del director en el formulario.");
        if (empty($_POST["birthday"])) throw new Exception("No se recibió la fecha de nacimiento del director en el formulario.");
        if (empty($_POST["nationality"])) throw new Exception("No se recibió la nacionalidad del director en el formulario.");

        $isActor = false;
        $isDirector = false;
        if (isset($_POST["isActor"])) $isActor = $_POST["isActor"] === "1";
        if (isset($_POST["isDirector"])) $isDirector = $_POST["isDirector"] === "1";
        if (!$isActor && !$isDirector) throw new Exception("La persona tiene que ser director y/o actor.");

        return [
            "name" => $_POST["name"],
            "surname" => $_POST["surname"],
            "birthday" => $_POST["birthday"],
            "nationality" => $_POST["nationality"],
            "isActor" => $isActor,
            "isDirector" => $isDirector,
        ];
    }
}
