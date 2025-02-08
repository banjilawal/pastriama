package org.lawal.banji.pastriama.wish.repo;

import org.lawal.banji.pastriama.wish.Wish;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface WishRepo extends JpaRepository<Wish, Long> {
}