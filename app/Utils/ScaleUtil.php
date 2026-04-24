<?php

namespace App\Utils;

use App\Business;
use App\ScaleDevice;
use App\ScaleReadLog;

class ScaleUtil extends Util
{
    public function isEnabled($business_id)
    {
        $business = Business::find($business_id);
        $settings = ! empty($business->common_settings) ? $business->common_settings : [];

        return ! empty($settings['enable_scale_live_read']);
    }

    public function readWeight($business_id, $user_id = null)
    {
        $business = Business::find($business_id);
        $common_settings = ! empty($business->common_settings) ? $business->common_settings : [];
        $device = ScaleDevice::where('business_id', $business_id)
            ->where('is_active', 1)
            ->orderByDesc('is_default')
            ->first();

        if (empty($device)) {
            if (! empty($common_settings['scale_api_url'])) {
                $result = $this->readFromApiUrl($common_settings['scale_api_url'], $common_settings['scale_api_key'] ?? null);
                $scale_device_id = null;
            } elseif (! empty($common_settings['scale_tcp_host']) && ! empty($common_settings['scale_tcp_port'])) {
                $result = $this->readFromTcpHostPort($common_settings['scale_tcp_host'], (int) $common_settings['scale_tcp_port']);
                $scale_device_id = null;
            } else {
                return ['success' => false, 'message' => 'No active scale device configured.'];
            }
        } else {
            if ($device->connection_type === 'api' && ! empty($device->api_url)) {
                $result = $this->readFromApi($device);
            } else {
                $result = $this->readFromTcp($device);
            }
            $scale_device_id = $device->id;
        }

        ScaleReadLog::create([
            'business_id' => $business_id,
            'scale_device_id' => $scale_device_id,
            'weight' => $result['weight'] ?? null,
            'unit' => $result['unit'] ?? null,
            'barcode' => $result['barcode'] ?? null,
            'status' => ! empty($result['success']) ? 'success' : 'failed',
            'response_body' => $result['raw'] ?? null,
            'error_message' => $result['message'] ?? null,
            'created_by' => $user_id ?: auth()->id(),
        ]);

        return $result;
    }

    protected function readFromApi(ScaleDevice $device)
    {
        return $this->readFromApiUrl($device->api_url, $device->api_key);
    }

    protected function readFromApiUrl($api_url, $api_key = null)
    {
        $ch = curl_init($api_url);
        $headers = ['Accept: application/json'];
        if (! empty($api_key)) {
            $headers[] = 'Authorization: Bearer '.$api_key;
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (! empty($error)) {
            return ['success' => false, 'message' => $error, 'raw' => $response];
        }
        if ($http < 200 || $http >= 300) {
            return ['success' => false, 'message' => 'Scale API HTTP '.$http, 'raw' => $response];
        }

        $json = json_decode($response, true);
        if (empty($json)) {
            return ['success' => false, 'message' => 'Invalid JSON from scale API', 'raw' => $response];
        }

        return [
            'success' => true,
            'weight' => isset($json['weight']) ? (float) $json['weight'] : null,
            'unit' => $json['unit'] ?? 'kg',
            'barcode' => $json['barcode'] ?? null,
            'raw' => $response,
        ];
    }

    protected function readFromTcp(ScaleDevice $device)
    {
        return $this->readFromTcpHostPort($device->host, (int) $device->port);
    }

    protected function readFromTcpHostPort($host, $port)
    {
        if (empty($host) || empty($port)) {
            return ['success' => false, 'message' => 'Scale TCP host/port missing.'];
        }

        $socket = @fsockopen($host, (int) $port, $errno, $errstr, 3);
        if (! $socket) {
            return ['success' => false, 'message' => "Scale socket error: {$errstr} ({$errno})"];
        }

        stream_set_timeout($socket, 2);
        fwrite($socket, "READ\r\n");
        $raw = fgets($socket, 1024);
        fclose($socket);

        if (empty($raw)) {
            return ['success' => false, 'message' => 'No response from scale device'];
        }

        $weight = null;
        if (preg_match('/([0-9]+(?:\.[0-9]+)?)/', $raw, $matches)) {
            $weight = (float) $matches[1];
        }
        if (is_null($weight)) {
            return ['success' => false, 'message' => 'Could not parse weight value', 'raw' => $raw];
        }

        return [
            'success' => true,
            'weight' => $weight,
            'unit' => 'kg',
            'barcode' => null,
            'raw' => $raw,
        ];
    }
}
