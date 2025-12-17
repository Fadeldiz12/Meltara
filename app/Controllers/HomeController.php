<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReviewModel;

class HomeController extends BaseController
{
    public function index()
    {
        $reviewModel = new ReviewModel();

        $reviews = $reviewModel
            ->select('reviews.*, users.username')
            ->join('users', 'users.id = reviews.user_id')
            ->where('reviews.is_approved', 1)
            ->orderBy('reviews.created_at', 'DESC')
            ->limit(6)
            ->findAll();

        return view('home', array(
            'title' => 'Home',
            'reviews' => $reviews
        ));
    }
}
