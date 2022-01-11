<x-admin.layout>
    <x-admin.breadcrumb 
        title='Dashboard'
        :links="[
            ['text' => 'Dashboard' ],
        ]" />


    <div class="row">
        @can('blog_categories_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-secondary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-left mini-stat-img mr-4 font-white font-20">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Categories</h5>
                        <h4 class="font-weight-medium font-size-24">
                            22
                            <i class="fas fa-arrow-up text-success ml-2"></i>
                        </h4>
                    </div>
                    <div class="pt-2">
                        <div class="float-right">
                            <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">Till Today</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('blog_posts_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-secondary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-left mini-stat-img mr-4 font-white font-20">
                            <i class="fas fa-blog"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Blog Posts</h5>
                        <h4 class="font-weight-medium font-size-24">
                            22
                            <i class="fas fa-arrow-up text-success ml-2"></i>
                        </h4>
                    </div>
                    <div class="pt-2">
                        <div class="float-right">
                            <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">Till Today</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('blog_comments_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-secondary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-left mini-stat-img mr-4 font-white font-20">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Comments</h5>
                        <h4 class="font-weight-medium font-size-24">
                            22
                            <i class="fas fa-arrow-up text-success ml-2"></i>
                        </h4>
                    </div>
                    <div class="pt-2">
                        <div class="float-right">
                            <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">Till Today</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    
        @can('faqs_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-left mini-stat-img mr-4 font-white font-20">
                            <i class="fas fa-question"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">FAQs</h5>
                        <h4 class="font-weight-medium font-size-24">
                            22
                            <i class="fas fa-arrow-up text-success ml-2"></i>
                        </h4>
                    </div>
                    <div class="pt-2">
                        <div class="float-right">
                            <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">Till Today</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('pages_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-left mini-stat-img mr-4 font-white font-20">
                            <i class="fas fa-file"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Pages</h5>
                        <h4 class="font-weight-medium font-size-24">
                            22
                            <i class="fas fa-arrow-up text-success ml-2"></i>
                        </h4>
                    </div>
                    <div class="pt-2">
                        <div class="float-right">
                            <a href="{{ route('admin.dashboard') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">Till Today</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('users_access')
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-left mini-stat-img mr-4 font-white font-20">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Users</h5>
                        <h4 class="font-weight-medium font-size-24">
                            {{ $users_count }}
                            <i class="fas fa-arrow-up text-success ml-2"></i>
                        </h4>
                    </div>
                    <div class="pt-2">
                        <div class="float-right">
                            <a href="{{ route('admin.users.index') }}" class="text-white-50 stretched-link"><i class="fas fa-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">Till Today</p>
                    </div>
                </div>
            </div>
        </div>
        @endcan

    </div>

</x-admin.layout>
