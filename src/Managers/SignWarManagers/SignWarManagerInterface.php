<?php

namespace App\Managers\SignWarManagers;

interface SignWarManagerInterface
{
    public function __invoke(string $requestContent);

    /**
     * @return array
     */
    public function manage(): array;

}