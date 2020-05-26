<?php

/*
 * This file is part of the cblink/laravel-dto.
 *
 * (c) Nick <i@httpd.cc>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Cblink\DTO;

use Cblink\DTO\Exceptions\DTOException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class DTO
{
    /**
     * @var array
     */
    protected $origin = [];

    /**
     * @var array
     */
    protected $payload = [];

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * DTO constructor.
     *
     * @throws \Throwable
     */
    public function __construct(array $data = [])
    {
        $this->origin = $data;
        $this->validate();
        $this->setPayload();
    }

    abstract public function rules(): array;

    /**
     * @throws \Throwable
     */
    protected function setPayload()
    {
        array_walk($this->origin, function ($val, $key) {
            // 如果key值不存在，则跳过
            if (!in_array($key, $this->fillable())) {
                return;
            }

            $method = sprintf('set%s', ucfirst(Str::snake($key)));

            // 如果存在set方法，优先使用方法赋值
            $this->payload[$key] = method_exists($this, $method) ?
                call_user_func_array([$this, $method], [$val]) : $val;
        });
    }

    /**
     * @throws \Throwable
     */
    protected function validate()
    {
        if (!$this->rules()) {
            return;
        }

        $validator = Validator::make($this->origin, $this->rules());

        throw_if($validator->fails(), DTOException::class, $validator->errors()->first());

        if (method_exists($this, 'afterValidate')) {
            call_user_func([$this, 'afterValidate'], $this->origin);
        }
    }

    /**
     * @return array
     */
    protected function fillable()
    {
        return $this->fillable ?: array_keys($this->rules());
    }

    /**
     * @param $name
     *
     * @return array|\ArrayAccess|mixed
     *
     * @throws \Throwable
     */
    public function __get($name)
    {
        if (method_exists($this, $method = sprintf('get%s', ucfirst($name)))) {
            return call_user_func([$this, $method]);
        }

        throw_if(!array_key_exists($name, $this->payload), new DTOException(sprintf('%s attribute is not defined', $name)));

        return $this->payload[$name];
    }

    /**
     * 实现__isset防止empty检测不到值
     *
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->payload[$name]);
    }
}
