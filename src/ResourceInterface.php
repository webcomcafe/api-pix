<?php

namespace Webcomcafe\Pix;

use stdClass as object;

interface ResourceInterface
{
    /**
     * @param array $config
     * @return object
     */
    public function create(array $config): object;

    /**
     * @param string $identify
     * @param array $config
     * @return object
     */
    public function find(string $identify, array $config = []): object;

    /**
     * @param string $identify
     * @param array $config
     * @return object
     */
    public function update(string $identify, array $config): object;

    /**
     * @param string $identify
     * @param array $config
     * @return object
     */
    public function delete(string $identify, array $config = []): object;
}