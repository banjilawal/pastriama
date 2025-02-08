package org.lawal.banji.pastriama.phone.service;

import org.lawal.banji.pastriama.phone.repo.PhoneRepo;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class PhoneService {

    private final PhoneRepo phoneRepo;

    @Autowired
    public PhoneService(PhoneRepo phoneRepo) {
        this.phoneRepo = phoneRepo;
    }
}