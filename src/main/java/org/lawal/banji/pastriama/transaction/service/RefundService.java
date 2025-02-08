package org.lawal.banji.pastriama.transaction.service;

import org.lawal.banji.pastriama.transaction.repo.ChargeRepo;
import org.lawal.banji.pastriama.transaction.repo.RefundRepo;
import org.springframework.stereotype.Service;

@Service
public class RefundService {

    private RefundRepo refundRepo;

    public RefundService (RefundRepo refundRepo) {
        this.refundRepo = refundRepo;
    }
}