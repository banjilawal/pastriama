<?php
    $nextPastryId = 0;
    
    function nextPastryId(): int {
        global $nextPastryId;
        return $nextPastryId += 1;
    }