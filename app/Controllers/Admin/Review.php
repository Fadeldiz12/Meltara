<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReviewModel;

class Review extends BaseController
{
    protected $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new \App\Models\ReviewModel();
    }

    // daftar review (admin)
    public function index()
    {
        $reviews = $this->reviewModel->getAllWithProductUser();
        return view('admin/review_list', [
            'reviews' => $reviews
        ]);
    }

    // setujui review
    public function approve($id)
    {
        $this->reviewModel->update($id, ['is_approved' => 1]);
        return redirect()->to(base_url('admin/reviews'))->with('success', 'Review disetujui.');
    }

    // tolak review (set is_approved = 2 atau hapus)
    public function reject($id)
    {
        $this->reviewModel->update($id, ['is_approved' => 2]);
        return redirect()->to(base_url('admin/reviews'))->with('success', 'Review ditolak.');
    }

    // hapus review
    public function delete($id)
    {
        $this->reviewModel->delete($id);
        return redirect()->to(base_url('admin/reviews'))->with('success', 'Review dihapus.');
    }
}
