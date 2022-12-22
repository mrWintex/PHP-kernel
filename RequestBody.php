<?php
namespace App\Src\Core;

class RequestBody
{
    #[Inject]
    private Request $request;

    private array $body = [];

    private function load()
    {
        $data = $this->request->method === "get" ? $_GET : $_POST;
        $filter = $this->request->method === "get" ? INPUT_GET : INPUT_POST;

        foreach ($data as $key => $value) {
            $this->body[$key] = filter_input($filter, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }

    public function getbody() : array
    {
        $this->load();
        return $this->body;
    }
}