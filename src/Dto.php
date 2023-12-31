<?php

/*
 * This file is part of the aimilink/laravel-dto.
 *
 * (c) sunny5156 <sunny5156@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Aimilink\Dto;

use ArrayAccess;
use Hyperf\Utils\Arr;
use Hyperf\Utils\Contracts\Arrayable;
use Serializable;

/**
 * Class DTO.
 */
class Dto implements Arrayable,Serializable, ArrayAccess
{
    use PayloadTrait;

    /**
     * @var array
     */
    protected array $origin = [];

    /**
     * @var array
     */
    protected array $payload = [];

    /**
     * @var array
     */
    protected array $fillable = [];

    /**
     * DTO constructor.
     */
    public function __construct(array $data = [])
    {
        $this->setOriginData($data)->setPayload();
    }

    /**
     * @return $this
     */
    protected function setOriginData(array $data = []): DTO
    {
        $this->origin = $data;

        return $this;
    }

    /**
     * @return $this
     */
    protected function setPayload(array $payload = []): DTO
    {
        $payload = $payload ?: $this->getOrigin();

        $fillable = $this->fillable();

        $this->payload = in_array('*', $fillable) ?
            $payload :
            Arr::only($payload, $fillable);

        return $this;
    }

    /**
     * @return array|string[]
     */
    protected function fillable(): array
    {
        if (empty($this->fillable)) {
            $this->fillable = ['*'];
        }

        return $this->fillable;
    }

    /**
     * 获取参数，不经过.
     *
     * @param $key
     * @param null $default
     *
     * @return array|\ArrayAccess|mixed
     */
    public function getItem($key, $default = null)
    {
        return Arr::get($this->payload, $key, $default);
    }
}
