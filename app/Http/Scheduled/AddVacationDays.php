<?php

namespace App\Http\Scheduled;

use App\Http\Repositories\Users\UserRepositoryInterface;

class AddVacationDays {

    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function __invoke() {
        $this->userRepository->addVacationDays(20); //dodaj 20 dana svim korisnicima
    }

}