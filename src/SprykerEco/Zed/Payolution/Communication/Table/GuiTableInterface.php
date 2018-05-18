<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Payolution\Communication\Table;

use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

interface GuiTableInterface
{
    /**
     * @return \Generated\Shared\Transfer\DataTablesTransfer
     */
    public function getDataTablesTransfer();

    /**
     * @param \Generated\Shared\Transfer\DataTablesTransfer $dataTablesTransfer
     *
     * @return void
     */
    public function setDataTablesTransfer($dataTablesTransfer);

    /**
     * @return void
     */
    public function disableSearch();

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return void
     */
    public function setConfiguration(TableConfiguration $config);

    /**
     * @param array $data
     *
     * @return void
     */
    public function loadData(array $data);

    /**
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data);

    /**
     * @return array
     */
    public function getData();

    /**
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    public function getConfiguration();

    /**
     * @return string
     */
    public function getTableIdentifier();

    /**
     * @param string|null $tableIdentifier
     *
     * @return void
     */
    public function setTableIdentifier($tableIdentifier);

    /**
     * @return mixed
     */
    public function getOffset();

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    public function getOrders(TableConfiguration $config);

    /**
     * @return mixed
     */
    public function getSearchTerm();

    /**
     * @return int
     */
    public function getLimit();

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit($limit);

    /**
     * @return string
     */
    public function render();

    /**
     * @return array
     */
    public function prepareConfig();

    /**
     * @return array
     */
    public function fetchData();

    /**
     * Drop table name from key
     *
     * @param string $key
     *
     * @return string
     */
    public function cutTablePrefix($key);

    /**
     * @param string $str
     *
     * @return string
     */
    public function camelize($str);
}
