package org.lawal.banji.pastriama.item.repo;

import org.lawal.banji.pastriama.item.model.StoreItem;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface StoreItemRepo extends JpaRepository<StoreItem, Long> {

}