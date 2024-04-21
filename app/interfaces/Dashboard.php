<?php

namespace app\interfaces;

interface Dashboard {
    public function getDashboardHeading (): string;
    public function setDashboardHeading (string $dashboardHeading): void;
    public function dashboard (): string;
}