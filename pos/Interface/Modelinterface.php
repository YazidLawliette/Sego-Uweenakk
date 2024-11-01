<?php

interface ModelInterface
{
    public function create($data);
    public function all();
    public function find($id);
    public function update($data, $id);
    public function delete($id);
}