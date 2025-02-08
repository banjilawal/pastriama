package org.lawal.banji.pastriama.transaction.service;

import org.lawal.banji.pastriama.transaction.repo.ChargeRepo;
import org.springframework.stereotype.Service;

@Service
public class ChargeService {

    private ChargeRepo chargeRepo;

    public ChargeService(ChargeRepo chargeRepo) {
        this.chargeRepo = chargeRepo;
    }
}