package org.lawal.banji.pastriama.phone.repo;

import org.lawal.banji.pastriama.phone.model.Phone;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface PhoneRepo extends JpaRepository<Phone, Long> {
}