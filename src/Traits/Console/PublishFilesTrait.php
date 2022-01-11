<?php

namespace Takshak\Adash\Traits\Console;

use Illuminate\Support\Str;

trait PublishFilesTrait {

	protected $stubsDir = __DIR__.'/../../../stubs/';
	protected $adminSidebar = 'views/components/admin/sidebar.blade.php';
	protected $dbSeederClass = 'seeders/DatabaseSeeder.php';

	
	public function publishDefault($options)
	{
		$kernel = $this->getAppFile('app_path', 'Http/Kernel.php');

		if (!Str::of($kernel)->after('routeMiddleware')->contains('gates')) {
			$newKernel = Str::of($kernel)->before("'auth'");
			$newKernel .= "'gates' => \Takshak\Adash\Http\Middleware\GatesMiddleware::class,\n";
			$newKernel .= "\t\t'auth'";
			$newKernel .= Str::of($kernel)->after("'auth'");

			$this->filesystem->put(app_path('Http/Kernel.php'), $newKernel);
		}

		$this->call('vendor:publish', $options);
	}

	public function publishBlog($options)
	{
		$seederCalls = [
			'$this->call(BlogCategorySeeder::class);',
			'$this->call(BlogPostSeeder::class);',
			'$this->call(BlogCommentSeeder::class);',
		];
		$this->addSeederClass($seederCalls);
		$this->addSidebarMenu('blog');
		$this->addRoutes('blog');
	    $this->call('vendor:publish', $options);
	}

	public function publishFaqs($options)
	{
		$seederCalls = [ '$this->call(FaqSeeder::class);' ];
		$this->addSeederClass($seederCalls);
		$this->addSidebarMenu('faqs');
		$this->addRoutes('faqs');
	    $this->call('vendor:publish', $options);
	}
	
	public function publishPages($options)
	{
		$seederCalls = [ '$this->call(PageSeeder::class);' ];
		$this->addSeederClass($seederCalls);
		$this->addSidebarMenu('pages');
		$this->addRoutes('pages');
	    $this->call('vendor:publish', $options);
	}
	
	public function publishTestimonials($options)
	{
		$seederCalls = [ '$this->call(TestimonialSeeder::class);' ];
		$this->addSeederClass($seederCalls);
		$this->addSidebarMenu('testimonials');
		$this->addRoutes('testimonials');
	    $this->call('vendor:publish', $options);
	}


	public function getAppFile($function='app_path', $file='')
	{
		return $this->filesystem->get($function($file));
	}

	public function addSidebarMenu($module)
	{
		$stub = $this->filesystem->get($this->stubsDir.'modules/'.$module.'/views/stubs/sidebar.stub');

		$adminSidebar = $this->getAppFile('resource_path', $this->adminSidebar);

		$sidebar = Str::of($adminSidebar)->beforeLast('</ul>');
		$sidebar .= $stub;
		$sidebar .= "\t\t\t</ul>";
		$sidebar .= Str::of($adminSidebar)->afterLast('</ul>');

		$this->filesystem->put(resource_path($this->adminSidebar), $sidebar);
	}

	public function addSeederClass($seederCalls)
	{
		$dbSeederClass = $this->getAppFile('database_path', $this->dbSeederClass);
		$seeder = Str::of($dbSeederClass)->beforeLast(';');
		$seeder .= ";\n";
		foreach ($seederCalls as $seederCall) {
			$seeder .= "\t\t".$seederCall."\n";
		}
		$seeder .= Str::of($dbSeederClass)->afterLast(';');
		$this->filesystem->put(database_path($this->dbSeederClass), $seeder);
	}

	public function addRoutes($module)
	{
		$stub = $this->filesystem->get($this->stubsDir.'modules/'.$module.'/routes/admin.stub');
		$adminRoutes = $this->getAppFile('base_path', 'routes/admin.php');

		$routes = Str::of($adminRoutes)->beforeLast('});');
		$routes .= $stub;
		$routes .= '});';

		$this->filesystem->put(base_path('routes/admin.php'), $routes);
	}

}