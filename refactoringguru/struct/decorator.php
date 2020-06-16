<?php
namespace zerist\struct\decorator;

//decorator interface
interface DataSource
{
    public function write($data);
    public function read();
}

//concrete componet
class FileDataSource implements DataSource{
    public $filename;
    public $data;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function write($data)
    {
        // TODO: Implement write() method.
        $this->data = $data;
    }

    public function read(){
        echo "filename: " . $this->filename . PHP_EOL;
        echo "data: " . $this->data . PHP_EOL;
    }
}

//decorator basic class for extend
class DataSourceDecorator implements DataSource
{
    protected $datasource;

    public function __construct(DataSource $datasource)
    {
        $this->datasource = $datasource;
    }

    public function write($data)
    {
        // TODO: Implement write() method.
        $this->datasource->write($data);
    }

    public function read()
    {
        // TODO: Implement read() method.
        $this->datasource->read();
    }
}

//concrete decorator class
class EncryptionDecorator extends DataSourceDecorator{
    public function write($data)
    {
        echo "encode data" . PHP_EOL;
        parent::write($data); // TODO: Change the autogenerated stub
    }

    public function read()
    {
        echo "decode data" . PHP_EOL;
        parent::read(); // TODO: Change the autogenerated stub
    }
}

class CompressionDecorator extends DataSourceDecorator{
    public function write($data)
    {
        echo "zip data" . PHP_EOL;
        parent::write($data); // TODO: Change the autogenerated stub
    }

    public function read()
    {
        echo "unzip data" . PHP_EOL;
        parent::read(); // TODO: Change the autogenerated stub
    }
}

//client
class Application {
    public function test(){
        $source = new FileDataSource('file1');
        $source->write('data1');

        $source = new CompressionDecorator($source);
        $source->write('compress');

        $source = new EncryptionDecorator($source);
        $source->write('encrypt');
    }
}

class SalaryManager{
    public $source;

    public function __construct(DataSource $dataSource)
    {
        $this->source = $dataSource;
    }

    public function load(){
        return $this->source->read();
    }

    public function save(){
        $this->source->write('salary');
    }
}

$app = new Application();
$app->test();