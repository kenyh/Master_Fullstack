<?php
require_once __DIR__ . '/../models/SeriesRepository.php';
require_once __DIR__ . '/../models/DirectorsRepository.php';
require_once __DIR__ . '/../models/PlatformsRepository.php';
require_once __DIR__ . '/../models/LanguageRepository.php';
require_once __DIR__ . '/../models/ActorsRepository.php';

require_once 'AbstractController.php';

class SeriesController extends AbstractController
{

    public function __construct()
    {
        parent::__construct(new SeriesRepository());
    }
    public function list()
    {
        $listado = $this->repository->getAll();
        require_once __DIR__ . '/../views/series/list.php';
    }

    public function create()
    {
        try {

            $directorsRepo = new DirectorsRepository();
            $platfomsRepo = new PlatformsRepository();
            $languagesRepo = new LanguageRepository();
            $actorsRepo = new ActorsRepository();
            $directors = $directorsRepo->getAll();
            $platforms = $platfomsRepo->getAll();
            $languages = $languagesRepo->getAll();
            $actors = $actorsRepo->getAll();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $form = $this->validateForm();
                $serie = new Serie(null, $form["title"], $form["synopsis"], $form["platformId"], $form["directorId"], $form["audioLanguageIds"], $form["subtitleLanguageIds"], $form["actorIds"]);

                $this->repository->create($serie);

                $_SESSION['message'] = ["type" => "success", "text" => "Serie " . $serie->getTitle() . " creado con éxito."];
                header('Location: /series/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/series/create.php';
    }
    public function read()
    {
        throw new Exception("Not implemented yet");
    }
    public function update()
    {
        try {
            //Si no se especificó el serieId:
            if (!isset($_GET["serieId"])) throw new NotFoundException("Debes especificar el serie que quieres editar.");

            $serie = $this->repository->getById($_GET["serieId"]);
            $directorsRepo = new DirectorsRepository();
            $platfomsRepo = new PlatformsRepository();
            $languagesRepo = new LanguageRepository();
            $actorsRepo = new ActorsRepository();
            $directors = $directorsRepo->getAll();
            $platforms = $platfomsRepo->getAll();
            $languages = $languagesRepo->getAll();
            $actors = $actorsRepo->getAll();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $form = $this->validateForm();

                $serie->setTitle($form["title"]);
                $serie->setSynopsis($form["synopsis"]);
                $serie->setPlatformId($form["platformId"]);
                $serie->setDirectorId($form["directorId"]);
                $serie->setAudioLanguageIds($form["audioLanguageIds"]);
                $serie->setSubtitleLanguageIds($form["subtitleLanguageIds"]);
                $serie->setActorIds($form["actorIds"]);

                $this->repository->update($serie);
                $_SESSION['message'] = ["type" => "success", "text" => "Serie " . $serie->getTitle() . " modificada con éxito."];
                header('Location: /series/list');
                exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
            }
        } catch (ValidationException $e) {
            $_SESSION['message'] = ["type" => "warning", "text" => $e->getMessage()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /series/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        require_once __DIR__ . '/../views/series/update.php';
    }
    public function delete()
    {
        try {
            //Si el método no es POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new MethodNotAllowedException('Para borrar debes usar el método POST, no "' . $_SERVER['REQUEST_METHOD'] . '"');
            if (!isset($_POST["serieId"])) throw new NotFoundException("Debes especificar la serie que quieres Borrar.");
            $serie = $this->repository->getById($_POST["serieId"]);
            $this->repository->delete($_POST["serieId"]);
            $_SESSION['message'] = ["type" => "success", "text" => "Se borró el serie " . $serie->getTitle()];
        } catch (NotFoundException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /series/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (MethodNotAllowedException $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => $e->getMessage()];
            header('Location: /series/list');
            exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
        } catch (Exception $e) {
            $_SESSION['message'] = ["type" => "danger", "text" => "ERROR: " . $e->getMessage()];
        }
        //Si llega aquí no es post o no salió bien..
        header('Location: /series/list');
        exit;   //Esto hace que no llegue a terminar de ejecutar index.php donde se borra el mensaje de la sesión.
    }

    private function validateForm()
    {
        if (empty($_POST["title"])) throw new Exception("No se recibió el nombre de la serie en el formulario.");
        if (empty($_POST["synopsis"])) throw new Exception("No se recibió la sinopsis de la serie en el formulario.");
        if (empty($_POST["platformId"])) throw new Exception("No se recibió la plataforma de la serie en el formulario.");
        if (empty($_POST["directorId"])) throw new Exception("No se recibió el director de la serie en el formulario.");
        if (empty($_POST["audioLanguageIds"])) throw new Exception("No se recibieron los idiomas de audio de la serie en el formulario.");
        if (empty($_POST["subtitleLanguageIds"])) throw new Exception("No se recibieron los idiomas de subtítulos de la serie en el formulario.");
        if (empty($_POST["actorIds"])) throw new Exception("No se recibieron los actores de la serie en el formulario.");

        return [
            "title" => $_POST["title"],
            "synopsis" => $_POST["synopsis"],
            "platformId" => $_POST["platformId"],
            "directorId" => $_POST["directorId"],
            "audioLanguageIds" => array_values($_POST["audioLanguageIds"]),
            "subtitleLanguageIds" => array_values($_POST["subtitleLanguageIds"]),
            "actorIds" => array_values($_POST["actorIds"])
        ];
    }
}
