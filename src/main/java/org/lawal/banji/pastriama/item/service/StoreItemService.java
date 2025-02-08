package org.lawal.banji.pastriama.item.service;

import org.lawal.banji.pastriama.item.model.StoreItem;
import org.lawal.banji.pastriama.item.repo.StoreItemRepo;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class StoreItemService {

    @Autowired
    private final StoreItemRepo storeItemRepo;

    @Autowired
    public StoreItemService (StoreItemRepo storeItemRepo) {
        this.storeItemRepo = storeItemRepo;
    }


    public StoreItem findById(Long id) {
        return storeItemRepo.findById(id).orElse(null);
    }

}