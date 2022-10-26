<?php

namespace Maize\CeliSearch\Macros;

use Closure;
use Maize\CeliSearch\CeliSearchEngine;

class WithMinimumShouldMatch
{
    const KEY_NAME = 'mm';

    public function __invoke(): Closure
    {
        return function (?string $mm = null) {
            /**  @phpstan-ignore-next-line */
            if ($this->engine() instanceof CeliSearchEngine) {
                /**  @phpstan-ignore-next-line */
                $this->engine()->withParameter(WithMinimumShouldMatch::KEY_NAME, $mm);
            }

            return $this;
        };
    }
}
