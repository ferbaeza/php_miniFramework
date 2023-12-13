<?php

namespace Src\Core\Views\Interfaces;

interface ViewInterface
{
    public function render(string $view, array $params = [], string $layout = null): string;
}
