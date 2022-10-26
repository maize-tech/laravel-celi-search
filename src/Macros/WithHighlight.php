<?php

namespace Maize\CeliSearch\Macros;

use Closure;
use Maize\CeliSearch\CeliSearchEngine;

class WithHighlight
{
    const KEY_NAME = 'hl';

    public function __invoke(): Closure
    {
        return function (bool $highlight = true) {
            /**  @phpstan-ignore-next-line */
            if ($this->engine() instanceof CeliSearchEngine) {
                $value = $highlight ? 'true' : 'false';
                /**  @phpstan-ignore-next-line */
                $this->engine()->withParameter(WithHighlight::KEY_NAME, $value);
            }

            return $this;
        };
    }
}
