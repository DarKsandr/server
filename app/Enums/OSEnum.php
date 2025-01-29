<?php

namespace App\Enums;

use App\Facades\SshService;

enum OSEnum
{
    case LINUX;
    case WINDOWS;

    /**
     * @param resource $connect
     * @return self
     */
    public static function checkOS($connect): self
    {
        try {
            $result = SshService::exec($connect, 'uname');
            if($result === 'Linux'){
                return self::LINUX;
            }
        } catch (\Exception $e) {}
        return self::WINDOWS;
    }

    /**
     * @param resource $connect
     * @return void
     * @throws \Exception
     */
    public function off($connect): void
    {
        match ($this){
            self::LINUX => $this->poweroff($connect),
            self::WINDOWS => $this->shutdown($connect),
        };
    }

    /**
     * @param resource $connect
     * @return void
     * @throws \Exception
     */
    private function poweroff($connect): void
    {
        SshService::exec($connect, 'echo "'.config('ssh.password').'" | sudo -S poweroff', $this);
    }

    /**
     * @param resource $connect
     * @return void
     * @throws \Exception
     */
    private function shutdown($connect): void
    {
        SshService::exec($connect, 'shutdown /s /t 0', $this);
    }
}
