<?php


namespace Amadeus\Environment\Backend;


use Amadeus\Environment\Cgroup;
use Amadeus\Environment\Quota;
use Amadeus\IO\Logger;
use Amadeus\Process;

/**
 * Class Server
 * @package Amadeus\Environment\Backend
 */
class Server
{
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    private
        $SID,
        $key,
        $directory,
        $gameType,
        $cpu,
        $mem,
        $disk,
        $diskSpeed,
        $networkSpeed,
        $status,
        $user,
        $group,
        $PID;
    /**
     * @var Cgroup
     */
    private $Cgroup;
    /**
     * @var Quota
     */
    private $Quota;
    private $GameTypeController;

    /**
     * Server constructor.
     * @param $SID
     * @param $Key
     * @param $Directory
     * @param $GameType
     * @param $Cpu
     * @param $Mem
     * @param $Disk
     * @param $DiskSpeed
     * @param $NetworkSpeed
     * @param $Status
     */
    public function __construct($SID, $Key, $Directory, $GameType, $Cpu, $Mem, $Disk, $DiskSpeed, $NetworkSpeed, $Status)
    {
        Logger::printLine('Server ' . $SID . ' is starting', Logger::LOG_INFORM);
        $this->SID = $SID;
        $this->key = $Key;
        $this->directory = $Directory;
        $this->gameType = $GameType;
        $this->cpu = $Cpu;
        $this->mem = $Mem;
        $this->disk = $Disk;
        $this->diskSpeed = $DiskSpeed;
        $this->networkSpeed = $NetworkSpeed;
        $this->status = $Status;
        $this->user = 'server' . $SID;
        $this->group = 'server' . $SID;
        if (!@is_dir($this->directory)) {
            Logger::printLine('Server ' . $SID . ' directory does not exist ' . $this->directory, Logger::LOG_FATAL);
        }
        $this->Quota = new Quota($this->SID,$this->disk);
        if (Process::getGameControl()->getGameType($this->gameType) !== false) {
            $this->GameTypeController = Process::getGameControl()->getGameType($this->gameType);
            $this->GameTypeController->initServer($this->SID);
        } else {
            Logger::printLine('Server ' . $SID . ' failed to load ' . $this->gameType, Logger::LOG_FATAL);
        }
        $this->PID = $this->GameTypeController->onServerStart($this->SID);
        $this->Cgroup = new Cgroup($this->SID, $this->cpu, $this->mem, $this->diskSpeed, $this->networkSpeed, $this->PID);
        Logger::printLine('Server ' . $SID . ' successfully started', Logger::LOG_INFORM);
    }
    public function getLog(string $key){
        if($this->key===$key){
            return $this->GameTypeController->onClientGetLog();
        }else{
            return false;
        }
    }
}