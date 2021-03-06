<?php

namespace Webcomcafe\Pix;

use stdClass as object;

interface ResourceInterface
{
    /**
     * @param array $data
     * @return object
     */
    public function all(array $data = []): object;

    /**
     * @param array $data
     * @return object
     */
    public function create(array $data): object;

    /**
     * @param string $identify
     * @param array $data
     * @return object
     */
    public function find(string $identify,  array $data = []): object;

    /**
     * @param array $data
     * @return object
     */
    public function update(array $data): object;

    /**
     * @param array $data
     * @return object
     */
    public function change(array $data): object;

    /**
     * @param string $identify
     * @param array $data
     * @return object
     */
    public function delete(string $identify, array $data = []): object;
}