<?php

declare(strict_types=1);

namespace DevLnk\LaravelCodeBuilder\Services\CodePath\Core;

use DevLnk\LaravelCodeBuilder\Enums\BuildType;
use DevLnk\LaravelCodeBuilder\Services\CodePath\AbstractPath;

readonly class DTOPath extends AbstractPath
{
    public function getBuildType(): BuildType
    {
        return BuildType::DTO;
    }
}
