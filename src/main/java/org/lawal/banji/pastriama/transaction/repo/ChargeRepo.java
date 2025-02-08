package org.lawal.banji.pastriama.transaction.repo;

import org.lawal.banji.pastriama.transaction.model.Charge;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface ChargeRepo extends JpaRepository<Charge, Long> {
}