<?php

namespace App\UseCases\Car\DestroyCar;

class DestroyCar
{
    public function __construct(
        private \App\Repositories\CarRepository $repository
    ) {}

    public function execute(int $carId): void
    {
        $this->repository->delete($carId);
    }
}