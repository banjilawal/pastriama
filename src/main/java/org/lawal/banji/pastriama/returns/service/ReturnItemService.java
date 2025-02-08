package org.lawal.banji.pastriama.returns.service;

import org.lawal.banji.pastriama.returns.repo.ReturnItemRepo;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class ReturnItemService {

    private ReturnItemRepo returnItemRepo;

    @Autowired
    public ReturnItemService (ReturnItemRepo returnItemRepo) {
        this.returnItemRepo = returnItemRepo;
    }
}