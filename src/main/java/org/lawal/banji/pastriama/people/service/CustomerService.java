package org.lawal.banji.pastriama.people.service;

import org.lawal.banji.pastriama.people.CustomerRepo;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class CustomerService {

    private CustomerRepo customerRepo;

    @Autowired
    public CustomerService (CustomerRepo customerRepo) {
        this.customerRepo = customerRepo;
    }
}