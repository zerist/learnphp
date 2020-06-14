<?php
namespace zerist\struct\bridge;

//product
interface Device {
    function isEnabled() : bool ;
    function enable() : bool ;
    function disable() : bool ;
    function getVolume() : int ;
    function setVolume(int $vol) : int ;
    function getChannel() : string ;
    function setChannel(string $channel) : string ;
}

class Tv implements Device {
    private $stat = false;
    private $volume = 10;
    private $channel = 'cctv';
    public $device = 'TV';


    public function isEnabled(): bool
    {
        // TODO: Implement isEnabled() method.
        return $this->stat or false;
    }

    public function enable(): bool
    {
        // TODO: Implement enable() method.
        $this->stat = true;
        return true;
    }

    public function disable(): bool
    {
        // TODO: Implement disable() method.
        $this->stat = false;
        return true;
    }

    public function getVolume(): int
    {
        // TODO: Implement getVolume() method.
        return $this->volume;
    }

    public function setVolume(int $vol): int
    {
        // TODO: Implement setVolume() method.
        $this->volume = $vol;
        return $this->volume;
    }

    public function getChannel(): string
    {
        // TODO: Implement getChannel() method.
        return $this->channel;
    }

    public function setChannel(string $channel): string
    {
        // TODO: Implement setChannel() method.
        $this->channel = $channel;
        return $this->channel;
    }
}

class Radio implements Device{
    private $stat = false;
    private $volume = 10;
    private $channel = 'pm1.2';
    public $device = 'Radio';

    public function isEnabled(): bool
    {
        // TODO: Implement isEnabled() method.
        return $this->stat or false;
    }

    public function enable(): bool
    {
        // TODO: Implement enable() method.
        $this->stat = true;
        return true;
    }

    public function disable(): bool
    {
        // TODO: Implement disable() method.
        $this->stat = false;
        return true;
    }

    public function getVolume(): int
    {
        // TODO: Implement getVolume() method.
        return $this->volume;
    }

    public function setVolume(int $vol): int
    {
        // TODO: Implement setVolume() method.
        $this->volume = $vol;
        return $this->volume;
    }

    public function getChannel(): string
    {
        // TODO: Implement getChannel() method.
        return $this->channel;
    }

    public function setChannel(string $channel): string
    {
        // TODO: Implement setChannel() method.
        $this->channel = $channel;
        return $this->channel;
    }
}

//abstruct class
class RemoteControl {
    protected $device;

    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    public function togglePower(){
        if($this->device->isEnabled()){
            $this->device->disable();
        }else{
            $this->device->enable();
        }
    }

    public function volumeDown(){
        $this->device->setVolume($this->device->getVolume() - 10);
    }

    public function channelDown(){
        $this->device->setChannel($this->device->getChannel() - 1);
    }
}

//concrete abstruct
class AdavancedRemoteControl extends RemoteControl{
    public function mute(){
        $this->device->setVolume(0);
    }
}

//client app
$tv = new Tv();
$control = new RemoteControl($tv);
$control->togglePower();
echo $tv->device;

$radio = new Radio();
$control = new AdavancedRemoteControl($radio);
$control->mute();
echo $radio->getVolume();

