<?php
namespace zerist\behavir\command;

//command interface
use function MongoDB\BSON\toJSON;

interface Command{
    public function execute() : void ;
    public function getId() : int;
    public function getStatus() : int ;
}

//abstract command class
abstract class WebScrapingCommand implements Command
{
    public $id;
    public $status = 0;
    public $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getId() : int {
        return $this->id;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function getUrl() : string {
        return $this->url;
    }

    public function execute(): void
    {
        // TODO: Implement execute() method.
        $html = $this->download();
        $this->parse($html);
        $this->complete();
    }

    public function download() : string {
        $html = file_get_contents($this->getUrl());
        echo "WebScrapingCommans: Download {$this->url}\n";
        return $html;
    }

    abstract public function parse(string $html);

    public function complete() : void {
        $this->status = 1;
    }
}


//invoker class
//stacks the command in a Queue
class Queue{
    private $db;

    public function __construct()
    {
        $this->db = new \SQLite3(__DIR__ . '/commands.sqlite',
        SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        $this->db->query('CREATE TABLE IF NOT EXISTS "commands" (
            "id" INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL ,
            "command" TEXT,
            "status" INTEGER 
        )');

    }

    public function isEmpty() : bool {
        $query = 'SELECT COUNT ("ID") FROM "commands" WHERE status = 0';
        return $this->db->querySingle($query) === 0;
    }

    public function add(Command $command) : void {
        $query = 'INSERT INTO commands (command, status) VALUES (:command, :status)';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':command', base64_encode(serialize($command)));
        $statement->bindValue(':status', $command->getStatus());
        $statement->execute();
    }

    public function getCommand() : Command{
        $query = 'SELECT * FROM "commands" WHERE "status" = 0 LIMIT 1';
        $record = $this->db->querySingle($query, true);
        $command = unserialize(base64_decode($record["command"]));
        $command->id = $record['id'];
        return $command;
    }

    public function completeCommand(Command $command) : void
    {
        $query = 'UPDATE commands SET status = :status WHERE id = :id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':status', $command->getStatus());
        $statement->bindValue(':id', $command->getId());
        $statement->execute();
    }

    public function work() : void {
        while (!$this->isEmpty()){
            $command = $this->getCommand();
            $command->execute();
        }
    }

    //singleton mode
    public function get() : Queue{
        static $instance;
        if(!$instance){
            $instance = new Queue();
        }
        return $instance;
    }
}