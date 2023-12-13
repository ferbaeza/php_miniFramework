<?php

namespace Src\Core\Http\Request;

use Src\Core\Routing\Route;
use Src\Core\Http\Server\Server;
use Src\Core\Validation\Validator;
use Src\Core\Http\Constants\HttpMetodos;

/**
 * Request Class
 */
class Request
{
    /**
     * Request URI
     * @var string
     */
    protected string $uri;

    /**
     * Request Route
     * @var Route
     */
    protected Route $route;

    /**
     * Request Method
     * @var HttpMetodos
     */
    protected HttpMetodos $metodo;

    /**
     * Request Query
     * @var array
     */
    protected array $query;

    /**
     * Request Data
     * @var array
     */
    protected array $data;

    /**
     * Request Cookies
     * @var array
     */
    protected array $cookies;

    /**
     * Request Files
     * @var array
     */
    protected array $files;

    /**
     * Request Server
     * @var array
     */
    protected array $server;

    /**
     * Request Headers
     * @var array
     */
    protected array $headers;



    /**
     * Get the value of uri
     * @return string
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * Set the value of uri
     * @param  string $uri
     * @return self
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Get the value of route
     * @return Route
     */
    public function route(Route $route): Route
    {
        return $this->route;
    }

    /**
     * Set the value of route
     * @param  Route $route
     * @return self
     */
    public function setRoute(Route $route): self
    {
        $this->route = $route;
        return $this;
    }

    /**
     * Get the request HTTP method
     * @return HttpMetodos
     */
    public function metodo(): HttpMetodos
    {
        return $this->metodo;
    }

    /**
     * Set the request HTTP method
     * @param  HttpMetodos $metodo
     * @return self
     */
    public function setMetodo(HttpMetodos $metodo): self
    {
        $this->metodo = $metodo;
        return $this;
    }

    /**
     * Get the request queryData
     * @param  string|null $key
     * @return string|array|null
     */
    public function query(?string $key = null): string|array|null
    {
        if (is_null($key)) {
            return $this->query;
        }
        return $this->query[$key] ?? null;
    }

    /**
     * Set the request queryData
     * @param  array $queryData
     * @return self
     */
    public function setQuery(array $queryData): self
    {
        $this->query = $queryData;
        return $this;
    }

    /**
     * Get the request postData
     * @param  string|null $key
     * @return string|array|null
     */
    public function data(?string $key = null): string|array|null
    {
        if (is_null($key)) {
            return $this->data;
        }
        return $this->data[$key] ?? null;
    }

    /**
     * Set the request postData
     * @param  array $postData
     * @return self
     */
    public function setData(array $postData): self
    {
        $this->data = $postData;
        return $this;
    }

    /**
     * Get the request cookies
     * @return array
     */
    public function cookies(): array
    {
        return $this->cookies;
    }

    /**
     * Set the Request Cookies
     * @param  array $cookies
     * @return self
     */
    public function setCookies(array $cookies): self
    {
        $this->cookies = $cookies;
        return $this;
    }

    /**
     * Get the request files
     * @return array
     */
    public function files(): array
    {
        return $this->files;
    }

    /**
     * Set the request files
     * @param  array $files
     * @return self
     */
    public function setFiles(array $files): self
    {
        $this->files = $files;
        return $this;
    }

    /**
     * Get the request server
     * @return array
     */
    public function server(): array
    {
        return $this->server;
    }

    /**
     * Set the request server
     * @param  array $server
     * @return self
     */
    public function setServer(array $server): self
    {
        $this->server = $server;
        return $this;
    }

    /**
     * Get the request headers
     * @param  string|null $key
     * @return string|array|null
     */
    public function headers($key = null): string|array|null
    {
        if (is_null($key)) {
            return $this->headers;
        }
        return $this->headers[strtolower($key)] ?? null;
    }

    /**
     * Set the request headers
     * @param  array $headers
     * @return self
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Get the parametres in a Route
     * @return array
     */
    public function params(): array
    {
        return $this->route->parseaParametros($this->uri);
    }

    /**
     * Get all the request data
     * @return array
     */
    public function all(): array
    {
        return [
            'params' => $this->params(),
            'query' => $this->query(),
            'data' => $this->data(),
            'cookies' => $this->cookies(),
            'files' => $this->files(),
        ];
    }

    public function validate(array $rules, array $messages = []): array
    {
        $validator = new Validator($this->data);
        return $validator->validate($rules, $messages);
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }
}
