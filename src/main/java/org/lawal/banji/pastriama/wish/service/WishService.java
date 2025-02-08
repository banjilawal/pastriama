package org.lawal.banji.pastriama.wish.service;

import org.lawal.banji.pastriama.wish.repo.WishRepo;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class WishService {

    private WishRepo wishRepo;

    @Autowired
    public WishService(WishRepo wishRepo) {
        this.wishRepo = wishRepo;
    }
}