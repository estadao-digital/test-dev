<?php

declare(strict_types=1);

namespace App;

class CarFile
{
    public function update(array $data): void
    {
        if (empty($data)) {
            return;
        }
        
        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        file_put_contents(DIR_ROOT . 'statics/data-cars.json', $data);
    }

    public function getData(): array
    {
        return json_decode(file_get_contents(DIR_ROOT . 'statics/data-cars.json'), true);
    }
}
