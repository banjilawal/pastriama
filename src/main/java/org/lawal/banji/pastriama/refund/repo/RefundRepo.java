package org.lawal.banji.pastriama.refund.repo;

import org.lawal.banji.pastriama.refund.model.Refund;
import org.springframework.data.jpa.repository.JpaRepository;

public interface RefundRepo extends JpaRepository<Refund, Long> {
}