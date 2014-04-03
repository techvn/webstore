<?php
namespace MDS\Session\SaveHandler;
use Zend\Session\SaveHandler\DbTableGateway as ZendDbTableGateway;
/**
 * DB Table Gateway session save handler
 *
 * @category   Gc
 * @package    Library
 * @subpackage Session\SaveHandler
 */
class DbTableGateway extends ZendDbTableGateway
{
    /**
     * Read session data
     *
     * @param string $id Id
     *
     * @return string
     */
    public function read($id)
    {
        $rows = $this->tableGateway->select(
            array(
                $this->options->getIdColumn()   => $id,
                $this->options->getNameColumn() => $this->sessionName,
            )
        );

        if ($row = $rows->current()) {
            if ($row->{$this->options->getModifiedColumn()} + $row->{$this->options->getLifetimeColumn()} > time()) {
                return base64_decode($row->{$this->options->getDataColumn()});
            }

            $this->destroy($id);
        }

        return '';
    }

    /**
     * Write session data
     *
     * @param string $id   Id
     * @param string $data Data
     *
     * @return boolean
     */
    public function write($id, $data)
    {
        $data = array(
            $this->options->getModifiedColumn() => time(),
            $this->options->getDataColumn()     => base64_encode((string) $data),
        );
        $rows = $this->tableGateway->select(
            array(
                $this->options->getIdColumn()   => $id,
                $this->options->getNameColumn() => $this->sessionName,
            )
        );
        if ($row = $rows->current()) {
            return (bool) $this->tableGateway->update(
                $data,
                array(
                    $this->options->getIdColumn()   => $id,
                    $this->options->getNameColumn() => $this->sessionName,
                )
            );
        }
        $data[$this->options->getLifetimeColumn()] = (int) $this->lifetime;
        $data[$this->options->getIdColumn()]       = $id;
        $data[$this->options->getNameColumn()]     = $this->sessionName;

        return (bool) $this->tableGateway->insert($data);
    }
}
