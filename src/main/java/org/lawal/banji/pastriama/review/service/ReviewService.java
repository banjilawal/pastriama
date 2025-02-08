package org.lawal.banji.pastriama.review.service;

import org.lawal.banji.pastriama.review.repo.ReviewRepo;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class ReviewService {

    @Autowired
    private final ReviewRepo reviewRepo;

    @Autowired
    private ReviewService(ReviewRepo reviewRepo) {
        this.reviewRepo = reviewRepo;
    }
}