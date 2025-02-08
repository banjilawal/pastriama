package org.lawal.banji.pastriama.billing.repo;

import org.lawal.banji.pastriama.billing.model.Bill;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface BillingRepo extends JpaRepository<Bill, Long> {
}