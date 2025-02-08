package org.lawal.banji.pastriama.billing.service;

import org.lawal.banji.pastriama.billing.repo.BillingRepo;
import org.springframework.stereotype.Service;

@Service
public class BillService {

    private BillingRepo billingRepo;

    public BillService (BillingRepo billingRepo) {
        this.billingRepo = billingRepo;
    }
}