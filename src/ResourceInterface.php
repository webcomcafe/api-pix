<?php

namespace Webcomcafe\Pix;

use stdClass as object;

interface ResourceInterface
{
    /**
     * @param array $options
     * @return object
     */
    public function all(array $query = [], array $options = []): object;

    /**
     * @param array $data
     * @param array $options
     * @return object
     */
    public function create(array $data, array $options = []): object;

    /**
     * @param string $identify
     * @param array $query
     * @param array $options
     * @return object
     */
    public function find(string $identify,  array $query = [], array $options = []): object;

    /**
     * @param string $identify
     * @param array $data
     * @param array $options
     * @return object
     */
    public function update(string $identify, array $data, array $options = []): object;

    /**
     * @param string $identify
     * @param array $data
     * @param array $options
     * @return object
     */
    public function change(string $identify, array $data, array $options = []): object;

    /**
     * @param string $identify
     * @param array $options
     * @return object
     */
    public function delete(string $identify, array $options = []): object;
}