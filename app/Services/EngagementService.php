<?php

namespace App\Services;

use App\Helpers\StaticDataHelper;
use App\Models\Engagement;

class EngagementService
{
    public function generateDispatchNumber($address, $eID) {
        if ($address) {
            $subAddress = explode(' ', $address);
            $dispatchAddress = 'IAD/' . strtoupper(substr($subAddress[0], 0, 3)) . '/' . strtoupper(substr($subAddress[1], 0, 3));
            $dispatchDate = now()->format('Y-m-d');
            $dispatchID = $this->lastDispatchID($eID);
            return $dispatchAddress . '/' . $dispatchDate . '/' . (string)$dispatchID; 
        } else {
            return '';
        }
    }

    public function lastDispatchID($eID) {
        $dispatchNumberPattern = StaticDataHelper::getData()['dispatchNumberPattern'];
        if ($eID) {
            $currentDispatchNumber = Engagement::where(id, $eID)->value('dispatch_number');
            if(!empty($currentDispatchNumber) && preg_match($dispatchNumberPattern, $currentDispatchNumber)) {
                $parts = explode('/', $currentDispatchNumber);
                $lastPart = intval(end($parts));
                return $lastPart;
            } else {
                return 1;
            }
        } else {
            $lastDispatchNumber = Engagement::latest()->value('dispatch_number');
            if(!empty($lastDispatchNumber) && preg_match($dispatchNumberPattern, $lastDispatchNumber)) {
                $parts = explode('/', $lastDispatchNumber);
                $lastPart = intval(end($parts));
                return $lastPart + 1;
            } else {
                return 1;
            }
        }
    }

    public function getVertical($vertical) {
        $units = StaticDataHelper::getData()['unit'];
        if (array_key_exists($vertical, $units['Customer Experience'])) {
            return 'Customer Experience';
        } elseif (array_key_exists($vertical, $units['Banking Operation'])) {
            return 'Banking Operation';
        } elseif (array_key_exists($vertical, $units['Corporate Service'])) {
            return 'Corporate Service';
        } else {
            return 'Others';
        }
    }
}
