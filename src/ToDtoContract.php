<?php

/*
 * This file is part of the cblink/laravel-dto.
 *
 * (c) sunny5156 <sunny5156@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Aimilink\Dto\Contracts;

use Aimilink\Dto\Dto;

/**
 * Interface ToDTOConTract.
 */
interface ToDtoContract
{
    public function toDto(): Dto;
}
