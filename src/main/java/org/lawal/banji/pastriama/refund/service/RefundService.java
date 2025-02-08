package org.lawal.banji.pastriama.refund.service;

import org.lawal.banji.pastriama.refund.repo.RefundRepo;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class RefundService {

    private RefundRepo refundRepo;

    @Autowired
    public RefundService(RefundRepo refundRepo) {
        this.refundRepo = refundRepo;
    }
}