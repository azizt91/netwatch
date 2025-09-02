<?php

namespace App\Services;

use App\Models\RouterosAPI;

class RouterosService
{
    private RouterosAPI $api;

    public function __construct()
    {
        $this->api = new RouterosAPI();
        $this->api->debug = false;
    }

    /**
     * Attempt connection and return boolean result.
     */
    public function connect(string $host, string $username, string $password): bool
    {
        return $this->api->connect($host, $username, $password);
    }

    /**
     * Disconnect gracefully.
     */
    public function disconnect(): void
    {
        $this->api->disconnect();
    }

    /**
     * Collect dashboard/netwatch related data after connection established.
     * Throws \RuntimeException when not connected.
     */
    public function fetchDashboardData(): array
    {
        if (!$this->api) {
            throw new \RuntimeException('API instance not initialised');
        }
        // Ensure socket/connection still alive. No clear method; we rely on caller ensuring connect() success.

        $netwatch      = $this->api->comm('/tool/netwatch/print');
        $hotspotActive = $this->api->comm('/ip/hotspot/active/print');
        $resource      = $this->api->comm('/system/resource/print');
        $secret        = $this->api->comm('/ppp/secret/print');
        $secretActive  = $this->api->comm('/ppp/active/print');
        $interface     = $this->api->comm('/interface/ethernet/print');
        $routerboard   = $this->api->comm('/system/routerboard/print');
        $identity      = $this->api->comm('/system/identity/print');

        // Count statuses
        $statusUpCount   = 0;
        $statusDownCount = 0;
        foreach ($netwatch as $row) {
            if (($row['status'] ?? '') === 'up') {
                $statusUpCount++;
            } elseif (($row['status'] ?? '') === 'down') {
                $statusDownCount++;
            }
        }

        return [
            'netwatchData'   => $netwatch,
            'totalsecret'    => count($secret),
            'totalhotspot'   => count($hotspotActive),
            'hotspotactive'  => count($hotspotActive),
            'secretactive'   => count($secretActive),
            'cpu'            => $resource[0]['cpu-load'] ?? null,
            'uptime'         => $resource[0]['uptime'] ?? null,
            'version'        => $resource[0]['version'] ?? null,
            'interface'      => $interface,
            'boardname'      => $resource[0]['board-name'] ?? null,
            'freememory'     => $resource[0]['free-memory'] ?? null,
            'freehdd'        => $resource[0]['free-hdd-space'] ?? null,
            'model'          => $routerboard[0]['model'] ?? null,
            'identity'       => $identity[0]['name'] ?? null,
            'statusUpCount'  => $statusUpCount,
            'statusDownCount'=> $statusDownCount,
        ];
    }
}
