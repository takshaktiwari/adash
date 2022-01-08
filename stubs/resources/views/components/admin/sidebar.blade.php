<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Admin Main</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">Manage Contents</li>
                @canany(['blog_categories_access', 'blog_categories_create'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-tags"></i>
                        <span>Blog Categories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('blog_categories_create')
                        <li><a href="{{ route('admin.blog.categories.create') }}">New Category</a></li>
                        @endcan

                        @can('blog_categories_access')
                        <li><a href="{{ route('admin.blog.categories.index') }}">All Categories</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['blog_posts_access', 'blog_posts_create'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-blog"></i>
                        <span>Blog Posts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('blog_posts_access')
                        <li><a href="{{ route('admin.blog.posts.create') }}">New Post</a></li>
                        @endcan

                        @can('blog_posts_create')
                        <li><a href="{{ route('admin.blog.posts.index') }}">All Posts</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @can('blog_comments_access')
                <li>
                    <a href="{{ route('admin.blog.comments.index') }}" class="waves-effect">
                        <i class="fas fa-comments"></i>
                        <span>Blog Comments</span>
                    </a>
                </li>
                @endcan

                @canany(['pages_create', 'pages_access'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-file"></i>
                        <span>Manage Pages</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('pages_create')
                        <li><a href="{{ route('admin.pages.create') }}">New Page</a></li>
                        @endcan

                        @can('pages_access')
                        <li><a href="{{ route('admin.pages.index') }}">All Pages</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['faqs_access','faqs_create'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-question"></i>
                        <span>Manage FAQs</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('faqs_create')
                        <li><a href="{{ route('admin.faqs.create') }}">New FAQ</a></li>
                        @endcan

                        @can('faqs_access')
                        <li><a href="{{ route('admin.faqs.index') }}">All FAQs</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['testimonials_access', 'testimonials_create'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-comment-dots"></i>
                        <span>Testimonials</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @can('testimonials_create')
                        <li><a href="{{ route('admin.testimonials.create') }}">New Testimonial</a></li>
                        @endcan
                        
                        @can('testimonials_access')
                        <li><a href="{{ route('admin.testimonials.index') }}">All Testimonials</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                <li class="menu-title">Manage Users</li>
                @can('roles_access')
                <li>
                    <a href="{{ route('admin.roles.index') }}" class="waves-effect">
                        <i class="fas fa-users-cog"></i>
                        <span>All Roles</span>
                    </a>
                </li>
                @endcan

                @can('permissions_access')
                <li>
                    <a href="{{ route('admin.permissions.index') }}" class="waves-effect">
                        <i class="fas fa-user-shield"></i>
                        <span>All Permissions</span>
                    </a>
                </li>
                @endcan

                @can('users_access')
                <li>
                    <a href="{{ route('admin.users.index') }}" class="waves-effect">
                        <i class="fas fa-users"></i>
                        <span>All Users</span>
                    </a>
                </li>
                @endcan
                

                <li class="menu-title">Manage Account</li>
                <li>
                    <a href="{{ route('admin.password') }}" class=" waves-effect">
                        <i class="fas fa-key"></i>
                        <span>Change Password</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class=" waves-effect" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off"></i>
                        <span>Logout</span>
                    </a>
                </li>

                <!--Adash::Menu ends here (Do not remove this line)-->
            </ul>
        </div>
    </div>
</div>
