package org.lawal.banji.pastriama.review.repo;

import org.lawal.banji.pastriama.review.Review;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface ReviewRepo extends JpaRepository<Review, Long> {
}