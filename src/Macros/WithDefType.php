<?php

namespace Maize\CeliSearch\Macros;

use Closure;
use Maize\CeliSearch\CeliSearchEngine;

class WithDefType
{
    const KEY_NAME = 'defType';

    public function __invoke(): Closure
    {
        return function (?string $defType = null) {
            /**  @phpstan-ignore-next-line */
            if ($this->engine() instanceof CeliSearchEngine) {
                /**  @phpstan-ignore-next-line */
                $this->engine()->withParameter(WithDefType::KEY_NAME, $defType);
            }

            return $this;
        };
    }
}
