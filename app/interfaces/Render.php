<?php

namespace app\interfaces;

use app\models\concretes\User;

interface Render {

    public function body (): string;
    public function page (): string;
    public function mainSection (): string;
    public function dashboard (): string;
//    public function getBodyHeading (): string;
//
//    public function getMainSectionHeading (): string;
//    public function setBodyHeading (string $bodyHeading): void;
//
//    public function setMainSectionHeading (string $mainSectionHeading): void;
}