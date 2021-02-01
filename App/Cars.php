<?php

declare(strict_types=1);

namespace App;

use App\Request;
use App\Response;
use App\CarFile;

class Cars
{
    private Request $request;

    private Response $response;

    private CarFile $file;

    public function __construct()
    {
        $this->file     = new CarFile();
        $this->request  = new Request();
        $this->response = new Response();
    }
    
    public function index(): void
    {
        include DIR_ROOT . 'View/index.html';
    }

    public function all(): void
    {
        $this->response->json($this->file->getData());
    }

    public function get(int $id): void
    {
        $this->response->json($this->findCar($id));
    }

    public function add(): void
    {
        $file_name = $this->request->files['file']['name'] ?? '';
        $file_temp = $this->request->files['file']['tmp_name'] ?? '';

        if (false === $this->validate($this->request->post)) {
            return;
        }

        if (!move_uploaded_file($file_temp, DIR_ROOT . 'statics/images/' . $file_name)) {
            $this->response->json(['error' => 'Invalid Data'], 400  );

            return;
        }

        $car  = $this->request->post;
        $cars = $this->file->getData();

        $id = count($cars) + 1;
        $car['id'] = (int)$id;
        $car['image'] = '/statics/images/' . $file_name;

        array_push($cars, $car);

        $this->file->update($cars);

        $this->response->json($this->filterCarByBrand($cars, $car['brand']));
    }

    public function update(int $id): void
    {
        if (empty($this->findCar($id))) {
            $this->response->json(['error' => 'Car not found'], 404);

            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (false === $this->validate($data, $id)) {
            return;
        }

        $data = array_merge(['id' => $id], $data);
        $cars = $this->file->getData();

        foreach ($cars as &$car) {
            if ((int)$car['id'] === $id) {
                $data['image'] = $car['image'];

                $car = $data;

                break;
            }
        }

        $this->file->update($cars);

        $this->response->json($this->filterCarByBrand($cars, $car['brand']));
    }

    public function delete(int $id): void
    {
        if (empty($this->findCar($id))) {
            $this->response->json(['error' => 'Car not found'], 404);

            return;
        }

        $cars = $this->file->getData();

        foreach ($cars as $key => $car) {
            if ((int)$car['id'] === $id) {
                unset($cars[$key]);
            }
        }

        $this->file->update($cars);

        $this->response->json($cars);
    }

    /**
     * Ao criar/editar um carro, o campo "marca" deverá ser um SELECT
     *
     */
    private function filterCarByBrand(array $data, string $brand): array
    {
        $results = [];

        foreach ($data as $car) {
            if ($car['brand'] === $brand) {
                $results[] = $car;
            }
        }

        return $results;
    }

    private function findCar(int $id): array
    {
        $cars = $this->file->getData();
        $data = [];

        foreach ($cars as $car) {
            if ((int)$car['id'] === $id) {
                $data = $car;

                break;
            }
        }

        return $data;
    }

    private function validate(array $data, $id = null): bool
    {
        $validate   = true;
        $fields     = ['brand', 'model', 'year', 'description'];

        if (!is_array($data)) {
            $validate = false;
        } else {
            foreach ($data as $key => $field) {
                if ($key !== 'id' && !in_array($key, $fields)) {
                    $validate = false;

                    break;
                }

                if ($key !== 'id' && empty($field)) {
                    $validate = false;

                    break;
                }
            }
        }

        if (empty($id) && empty($this->request->files['file']['name'])) {
            $validate = false;
        }

        if (false === $validate) {
            $this->response->json(['error' => 'Invalid Data'], 400);
        }

        return $validate;
    }
}
