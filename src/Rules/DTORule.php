<?php

/*
 * This file is part of the cblink/laravel-dto.
 *
 * (c) sunny5156 <sunny5156@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Aimilink\DTO\Rules;

use Aimilink\DTO\DTO;
use Illuminate\Contracts\Validation\Rule;

class DTORule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value instanceof DTO;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be DTO.';
    }
}
