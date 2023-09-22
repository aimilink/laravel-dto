<?php

/*
 * This file is part of the cblink/laravel-dto.
 *
 * (c) sunny5156 <sunny5156@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Aimilink\DTO\Contracts;

use Aimilink\DTO\DTO;

/**
 * Interface ToDTOConTract.
 */
interface ToDTOContract
{
    public function toDTO(): DTO;
}
