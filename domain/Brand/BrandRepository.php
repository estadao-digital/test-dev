<?php

namespace Domain\Brand;


class BrandRepository
{

    public function listBrands()
    {
        return
            [
              'Chevrolet'  => 'Chevrolet',
              'Volkswagen' => 'Volkswagen',
              'Fiat'       => 'Fiat',
              'Renault'    => 'Renault',
              'Ford'       => 'Ford',
              'Toyota'     => 'Toyota',
              'Hyundai'    => 'Hyundai'
            ];
    }



}
