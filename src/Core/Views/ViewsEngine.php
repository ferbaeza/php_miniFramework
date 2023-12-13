<?php

namespace Src\Core\Views;

use Src\Core\Shared\Utils\App\EnvUtils;
use Src\Core\Views\Interfaces\ViewInterface;

class ViewsEngine implements ViewInterface
{
    public const LAYOUTSFOLDER = "layouts/";
    public const MAINLAYOUT = "main.php";
    protected string $content = "@content";


    public function __construct(
        public readonly string $viewsPath,
    ) {
    }
    public function render(string $string, array $params = [], string $layout = null): string
    {
        $view = $this->renderView($string, $params);
        $layout = $this->renderLayout($layout);
        return str_replace($this->content, $view, $layout);
    }

    public function renderView(string $string, array $params = []): string
    {
        $file = $this->viewsPath . $string . ".php";
        return $this->phpFileOutput($file, $params);
    }

    public function renderLayout(string|null $layout): string
    {
        if(is_null($layout)) {
            return $this->phpFileOutput($this->viewsPath . self::LAYOUTSFOLDER . self::MAINLAYOUT);
        }
        return $this->phpFileOutput($this->viewsPath . self::LAYOUTSFOLDER . $layout . ".php");
    }

    protected function phpFileOutput(string $file, array $params = []): string
    {
        foreach ($params  as $param => $value) {
            $$param = $value;
        }
        ob_start();
        include_once $file;
        return ob_get_clean();
    }
}
