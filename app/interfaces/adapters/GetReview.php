<?php

namespace app\interfaces\adapters;

use app\models\concretes\review;

interface GetReview {
    public function getReview (): Review;
}