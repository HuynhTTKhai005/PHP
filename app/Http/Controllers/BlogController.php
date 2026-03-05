<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogController extends Controller
{
    private function getMockPosts()
    {        
        return [
            [
                'id' => 1,
                'title' => 'Bí Quyết Nấu Nước Dùng Mỳ Cay Chuẩn Vị Hàn',
                'slug' => 'bi-quyet-nau-nuoc-dung',
                'image' => 'assets/images/blog-05.jpg',
                'date' => '2023-12-28',
                'author' => 'Bếp Trưởng',
                'category' => 'Công Thức',
                'content' => 'Nước dùng là linh hồn của món mỳ cay Sincay...',
                'comments' => 12
            ],
            [
                'id' => 2,
                'title' => 'Review Mỳ Cay Cấp Độ 7 - Thử Thách Cực Đại',
                'slug' => 'review-7-cap-do-cay',
                'image' => 'assets/images/blog-06.jpg',
                'date' => '2023-12-20',
                'author' => 'Admin',
                'category' => 'Thử Thách',
                'content' => 'Cấp độ 1 dành cho người mới, nhưng cấp độ 7 là thử thách...',
                'comments' => 35
            ],
            [
                'id' => 3,
                'title' => 'Top 5 Topping Được Yêu Thích Nhất',
                'slug' => 'top-topping-yeu-thich',
                'image' => 'assets/images/blog-04.jpg',
                'date' => '2023-11-15',
                'author' => 'Admin',
                'category' => 'Menu',
                'content' => 'Bò Mỹ, Hải sản hay Xúc xích phô mai? Đâu là lựa chọn...',
                'comments' => 8
            ],
            [
                'id' => 4,
                'title' => 'Khuyến Mãi Mùa Đông: Đi 4 Tặng 1',
                'slug' => 'khuyen-mai-mua-dong',
                'image' => 'assets/images/blog-07.jpg',
                'date' => '2023-11-10',
                'author' => 'Marketing',
                'category' => 'Sự Kiện',
                'content' => 'Chương trình tri ân khách hàng nhân dịp cuối năm...',
                'comments' => 20
            ],
            [
                'id' => 5,
                'title' => 'Ăn Cay Có Tốt Cho Sức Khỏe Không?',
                'slug' => 'loi-ich-an-cay',
                'image' => 'assets/images/blog-10.jpg',
                'date' => '2023-10-05',
                'author' => 'Chuyên Gia',
                'category' => 'Sức Khỏe',
                'content' => 'Capsaicin trong ớt giúp tăng cường trao đổi chất...',
                'comments' => 3
            ],            
            [
                'id' => 6,
                'title' => 'Lẩu Uyên Ương - Vị Ngon Gắn Kết',
                'slug' => 'lau-uyen-uong',
                'image' => 'assets/images/blog-11.jpg',
                'date' => '2023-09-20',
                'author' => 'Admin',
                'category' => 'Menu',
                'content' => 'Sự kết hợp hoàn hảo giữa 2 vị nước lẩu chua cay và thanh ngọt...',
                'comments' => 15
            ],
            [
                'id' => 7,
                'title' => 'Cách Làm Kim Chi Cải Thảo Tại Nhà',
                'slug' => 'cach-lam-kim-chi',
                'image' => 'assets/images/blog-12.jpg',
                'date' => '2023-09-15',
                'author' => 'Bếp Trưởng',
                'category' => 'Công Thức',
                'content' => 'Món ăn kèm không thể thiếu cho bữa tiệc mỳ cay thêm tròn vị...',
                'comments' => 42
            ],
            [
                'id' => 8,
                'title' => 'Mỳ Cay Cho Người Không Ăn Cay - Cấp Độ 0',
                'slug' => 'my-cay-cap-do-0',
                'image' => 'assets/images/blog-13.jpg',
                'date' => '2023-08-30',
                'author' => 'Admin',
                'category' => 'Menu',
                'content' => 'Bạn muốn tụ tập cùng bạn bè nhưng không ăn được cay? Đừng lo...',
                'comments' => 9
            ],
            [
                'id' => 9,
                'title' => 'Tổ Chức Sinh Nhật Tại Sincay Có Gì Vui?',
                'slug' => 'sinh-nhat-tai-sincay',
                'image' => 'assets/images/blog-14.jpg',
                'date' => '2023-08-10',
                'author' => 'Marketing',
                'category' => 'Sự Kiện',
                'content' => 'Không gian trang trí miễn phí, tặng bánh kem và giảm giá 15%...',
                'comments' => 5
            ],
            [
                'id' => 10,
                'title' => 'Rau Củ Tươi - Bí Mật Của Sự Cân Bằng',
                'slug' => 'rau-cu-tuoi',
                'image' => 'assets/images/blog-15.jpg',
                'date' => '2023-07-25',
                'author' => 'Chuyên Gia',
                'category' => 'Sức Khỏe',
                'content' => 'Bổ sung chất xơ từ bông cải xanh, nấm kim châm giúp giải nhiệt...',
                'comments' => 2
            ]
        ];
    }

    public function index(Request $request)
    {
        $allPosts = collect($this->getMockPosts());

        if ($request->has('search') && !empty($request->search)) {
            $keyword = strtolower($request->search);
            $allPosts = $allPosts->filter(function ($item) use ($keyword) {
                return str_contains(strtolower($item['title']), $keyword) || 
                       str_contains(strtolower($item['content']), $keyword);
            });
        }

        if ($request->has('category')) {
            $allPosts = $allPosts->where('category', $request->category);
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 4;
        $currentItems = $allPosts->slice(($currentPage - 1) * $perPage, $perPage)->all();        
        $posts = new LengthAwarePaginator($currentItems, count($allPosts), $perPage);
        $posts->setPath($request->url());
        $categories = collect($this->getMockPosts())->pluck('category')->unique();        
        $savedPostIds = session()->get('saved_posts', []); 
        $savedPostsList = collect($this->getMockPosts())->whereIn('id', $savedPostIds);
        
        return view('frontend.blog', compact('posts', 'categories', 'savedPostsList'));
    }

    public function show($slug)
    {
        $post = collect($this->getMockPosts())->firstWhere('slug', $slug);
        if (!$post) abort(404);

        $categories = collect($this->getMockPosts())->pluck('category')->unique();
        $popularPosts = collect($this->getMockPosts())->take(3);       
        $savedPostIds = session()->get('saved_posts', []);
        $isSaved = in_array($post['id'], $savedPostIds);

        return view('frontend.blog-detail', compact('post', 'categories', 'popularPosts', 'isSaved'));
    }   
    // TODO: Logic Đăng nhập (Auth)
    // if (!auth()->check()) { return response()->json(['status' => 'login_required']); }
    public function savePost(Request $request)
    {
        $postId = $request->id;
        $savedPosts = session()->get('saved_posts', []);

        if (in_array($postId, $savedPosts)) {
            $savedPosts = array_diff($savedPosts, [$postId]);
            $action = 'removed';
            $message = 'Đã bỏ lưu bài viết!';
        } else {
            $savedPosts[] = $postId;
            $action = 'added';
            $message = 'Đã lưu bài viết vào mục Lưu trữ!';
        }

        session()->put('saved_posts', $savedPosts);
        
        $allMockPosts = collect($this->getMockPosts());
        $currentSavedPosts = $allMockPosts->whereIn('id', $savedPosts);
        
        $archiveHtml = '';
        if ($currentSavedPosts->count() > 0) {
            foreach($currentSavedPosts as $savedPost) {
                $url = route('blog.detail', $savedPost['slug']);
                $date = Carbon::parse($savedPost['date'])->format('d/m/Y');                
                $archiveHtml .= '
                <li class="spicy-archive-item mb-2 pb-2 border-bottom d-flex justify-content-between align-items-center">
                    <div style="width: 85%;">
                        <a href="'.$url.'" class="text-dark font-weight-bold" style="text-decoration: none; font-size: 14px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            '.$savedPost['title'].'
                        </a>
                        <span class="text-muted" style="font-size: 12px;">'.$date.'</span>
                    </div>
                    <span class="btn-remove-saved" onclick="savePost('.$savedPost['id'].', this)" title="Bỏ lưu">
                        <i class="fas fa-times"></i>
                    </span>
                </li>';
            }
        } else {
            $archiveHtml = '<p class="text-muted font-italic small">Bạn chưa lưu bài viết nào.</p>';
        }

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'message' => $message,
            'archiveHtml' => $archiveHtml
        ]);
    }
}
