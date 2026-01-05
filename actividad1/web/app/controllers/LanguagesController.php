<?php
require_once __DIR__ . '/../models/repositories/LanguageRepository.php';
require_once 'AbstractController.php';

class LanguagesController extends AbstractController
{

    public function __construct()
    {
        parent::__construct(new LanguageRepository());
    }
    public function list()
    {
        $listado = $this->repository->getAll();
        require_once __DIR__ . '/../views/languages/list.php';
    }
    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (empty($_POST["name"])) throw new Exception("No se recibió el nombre del idioma en el formulario.");
                if (empty($_POST["isoCode"])) throw new Exception("No se recibió el código iso del idioma en el formulario.");

                $language = new Language(null, $_POST["name"], $_POST["isoCode"]);
                $this->repository->create($language);
                $_SESSION['message'] = ["type" => "success", "text" => "Idioma " . $language->getName() . " creado con éxito."];
                header('Location: /languages/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/languages/create.php';
    }
    public function read()
    {
        throw new Exception("Not implemented yet");
    }
    public function update()
    {
        try {
            //Si no se especificó el languageId:
            if (!isset($_GET["languageId"])) throw new NotFoundException("Debes especificar el idioma que quieres editar.");

            $language = $this->repository->getById($_GET["languageId"]);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (empty($_POST["name"])) throw new Exception("No se recibió el nombre del idioma en el formulario.");
                if (empty($_POST["isoCode"])) throw new Exception("No se recibió el código iso del idioma en el formulario.");

                $language->setName($_POST["name"]);                     //Cambio el nombre.
                $language->setIsoCode($_POST["isoCode"]);               //Cambio el isoCode
                $this->repository->update($language);
                $_SESSION['message'] = ["type" => "success", "text" => "Idioma " . $language->getName() . " modificado con éxito."];
                header('Location: /languages/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /languages/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/languages/update.php';
    }
    public function delete()
    {
        try {
            //Si el método no es POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new MethodNotAllowedException('Para borrar debes usar el método POST, no "' . $_SERVER['REQUEST_METHOD'] . '"');
            if (!isset($_POST["languageId"])) throw new NotFoundException("Debes especificar la idioma que quieres Borrar.");
            $language = $this->repository->getById($_POST["languageId"]);
            $this->repository->delete($_POST["languageId"]);
            $_SESSION['message'] = ["type" => "success", "text" => "Se borró el idioma " . $language->getName()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /languages/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (MethodNotAllowedException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /languages/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        header('Location: /languages/list');
        exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
    }
}
