<x-app-layout>
    {{-- Hero Section --}}
    <section class="py-5 bg-light border-bottom">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-3 fw-bold mb-3">
                        Elevate Your Workflow with <span class="text-primary">Adash</span>
                    </h1>
                    <p class="lead text-secondary mb-4">
                        The ultimate starter kit for your next Laravel project. Beautifully crafted, highly customizable, and ready to scale.
                    </p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">Start Building</a>
                        <a href="https://github.com/takshaktiwari/adash" class="btn btn-outline-dark btn-lg px-5 rounded-pill">Documentation</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold h1">Why Choose Adash?</h2>
                <p class="text-secondary">Everything you need to ship your application faster.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-4 d-inline-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem;">
                            <i class="bi bi-speedometer2 fs-3"></i>
                        </div>
                        <h3 class="h4 fw-bold">Lightning Fast</h3>
                        <p class="text-secondary small">Optimized for performance with Vite and modern asset bundling, ensuring your site loads in milliseconds.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="feature-icon bg-success bg-gradient text-white rounded-3 mb-4 d-inline-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem;">
                            <i class="bi bi-shield-check fs-3"></i>
                        </div>
                        <h3 class="h4 fw-bold">Secure by Default</h3>
                        <p class="text-secondary small">Built-in authentication, authorization, and security best practices to keep your data safe and sound.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="feature-icon bg-info bg-gradient text-white rounded-3 mb-4 d-inline-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem;">
                            <i class="bi bi-palette fs-3"></i>
                        </div>
                        <h3 class="h4 fw-bold">Customizable UI</h3>
                        <p class="text-secondary small">Easy to theme and extend. Bootstrap 5, custom layouts, and a clean codebase make design a breeze.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-5 bg-dark text-white">
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-4 display-5">Ready to Get Started?</h2>
            <p class="lead mb-5 opacity-75">Join thousands of developers building amazing things with Adash.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg">Create Your Account</a>
        </div>
    </section>
</x-app-layout>