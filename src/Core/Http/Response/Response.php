<?php

namespace Src\Core\Http\Response;

use Src\Core\Helpers\Helper;
use Src\Core\Http\Response\ApiResponse;

class Response
{
    /**
     * Response Http status code
     * @var int
     */
    protected int $status = 200;

    /**
     * Response content
     * @var string|null
     */
    protected ?string $content = null;

    /**
     * Response headers
     * @var array
     */
    protected array $headers = [];

    /**
     *Response 404 Not Found Code
     * @var int
     * @return int 404
     */
    public const ESTADO_404 = 404;
    public const ESTADO_OK = 200;
    protected const TEXT = 'application/text';
    protected const HTML = 'text/html';
    protected const JSON = 'application/json';



    public const CONTENT_LENGTH = 'Content-Length';
    public const CONTENT_TYPE = 'Content-Type';


    /**
     * Get the value of status
     * @return int
     */
    public function status(): int
    {
        return $this->status;
    }

    /**
     * Get the value of content
     * @return string|null
     */
    public function content(): ?string
    {
        return $this->content;
    }

    /**
     * Get the value of headers
     * @return array|string|null
     */
    public function headers(string $key = null): array|string|null
    {
        if(is_null($key)) {
            return $this->headers;
        }
        return $this->headers[strtolower($key)] ?? null;
    }

    /**
     * Set Response Status Code
     * @param  int  $status example: 200
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Set Response Content
     * @param  string|null $content
     * @return self
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set Response Headers
     * @param  string $header
     * @param  string $value
     * @return self
     */
    public function setHeader(string $header, string $value): self
    {
        $this->headers[strtolower($header)] = $value;
        return $this;
    }

    /**
     * Remove Response Header
     * @param  string $header
     * @return void
     */
    public function setContentType(string $header): void
    {
        $this->setHeader(self::CONTENT_TYPE, $header);
    }

    public function removeHeader(string $header): void
    {
        unset($this->headers[strtolower($header)]);
    }

    /**
     *Response with json
     * @param  array $data
     * @param  ?int  $status
     * @param  ?string $header
     * @return self
     */
    public static function jsonResponse(array $data, ?int $status = null, ?string $header = null): self
    {
        $data = [
            'data' => $data,
            'status' => $status,
        ];

        $header = $header === null ? self::JSON : $header;
        $code = $status ?? self::ESTADO_OK;
        $response = new self();
        $response->setStatus($code)
            ->setHeader(self::CONTENT_TYPE, $header)
            ->setContent(json_encode($data));

        return $response;
    }

    /**
     * Response with plain text
     * @param  string      $data
     * @param  int         $status
     * @param  string|null $header
     * @return self
     */
    public static function text(string $data, int $status, ?string $header = null): self
    {
        $response = new self();
        $response->setStatus($status)
            ->setContent($data);

        return $response;
    }

    /**
     * Prepare Response
     * @return void
     */
    public function prepare()
    {
        if (is_null($this->content)) {
            $this->removeHeader(ApiResponse::CONTENT_LENGTH);
            $this->removeHeader(self::CONTENT_TYPE);
        } else {
            $this->setHeader(ApiResponse::CONTENT_LENGTH, strval(strlen($this->content)));
        }
    }


    /**
     * Response with redirect
     * @param  string $uri
     * @return self
     */
    public static function redirect(string $uri): self
    {
        return (new self())->setStatus(302)->setHeader('Location', $uri);
    }


    /**
     * Response with html
     * @param  string $view
     * @param  array $params
     * @param  string $layout
     * pasandole un layout personalizado renderizara la vista sobre ese layout previmente creado
     * @return self
     */
    public static function view(string $view, array $params = null, string $layout = null): self
    {
        $content = app()->viewsEngine->render($view, $params, $layout);
        $response = new self();
        $response->setStatus(self::ESTADO_OK)
            ->setContent($content)
            ->setContentType(self::HTML);

        return $response;
    }
}
