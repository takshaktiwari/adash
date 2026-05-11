<x-admin.layout>
    <x-admin.breadcrumb
        title='Dashboard'
        :links="[
            ['text' => 'Dashboard' ],
        ]" />


    <div class="row g-3">
        @can('blog_categories_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-secondary text-white mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mini-stat-img me-3">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div>
                            <h5 class="font-size-14 text-uppercase mb-1 text-white-50">Categories</h5>
                            <h4 class="font-weight-medium font-size-24 mb-0">
                                22
                                <i class="fas fa-arrow-up text-success ms-1 font-size-14"></i>
                            </h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1 border-top border-white border-opacity-10">
                        <p class="text-white-50 mb-0 font-size-12">Till Today</p>
                        <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('blog_posts_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-secondary text-white mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mini-stat-img me-3">
                            <i class="fas fa-blog"></i>
                        </div>
                        <div>
                            <h5 class="font-size-14 text-uppercase mb-1 text-white-50">Blog Posts</h5>
                            <h4 class="font-weight-medium font-size-24 mb-0">
                                22
                                <i class="fas fa-arrow-up text-success ms-1 font-size-14"></i>
                            </h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1 border-top border-white border-opacity-10">
                        <p class="text-white-50 mb-0 font-size-12">Till Today</p>
                        <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('blog_comments_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-secondary text-white mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mini-stat-img me-3">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <h5 class="font-size-14 text-uppercase mb-1 text-white-50">Comments</h5>
                            <h4 class="font-weight-medium font-size-24 mb-0">
                                22
                                <i class="fas fa-arrow-up text-success ms-1 font-size-14"></i>
                            </h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1 border-top border-white border-opacity-10">
                        <p class="text-white-50 mb-0 font-size-12">Till Today</p>
                        <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('faqs_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mini-stat-img me-3">
                            <i class="fas fa-question"></i>
                        </div>
                        <div>
                            <h5 class="font-size-14 text-uppercase mb-1 text-white-50">FAQs</h5>
                            <h4 class="font-weight-medium font-size-24 mb-0">
                                22
                                <i class="fas fa-arrow-up text-success ms-1 font-size-14"></i>
                            </h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1 border-top border-white border-opacity-10">
                        <p class="text-white-50 mb-0 font-size-12">Till Today</p>
                        <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('pages_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mini-stat-img me-3">
                            <i class="fas fa-file"></i>
                        </div>
                        <div>
                            <h5 class="font-size-14 text-uppercase mb-1 text-white-50">Pages</h5>
                            <h4 class="font-weight-medium font-size-24 mb-0">
                                22
                                <i class="fas fa-arrow-up text-success ms-1 font-size-14"></i>
                            </h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1 border-top border-white border-opacity-10">
                        <p class="text-white-50 mb-0 font-size-12">Till Today</p>
                        <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('users_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mini-stat-img me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h5 class="font-size-14 text-uppercase mb-1 text-white-50">Users</h5>
                            <h4 class="font-weight-medium font-size-24 mb-0">
                                {{ $users_count }}
                                <i class="fas fa-arrow-up text-success ms-1 font-size-14"></i>
                            </h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1 border-top border-white border-opacity-10">
                        <p class="text-white-50 mb-0 font-size-12">Till Today</p>
                        <a href="{{ route('admin.users.index') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endcan

    </div>

</x-admin.layout>
