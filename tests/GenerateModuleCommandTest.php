<?php

namespace Nosleepman\ArchCLI\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\File;

class GenerateModuleCommandTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Nosleepman\ArchCLI\ArchCLIServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->cleanUp();
    }

    protected function tearDown(): void
    {
        $this->cleanUp();
        parent::tearDown();
    }

    private function cleanUp()
    {
        File::deleteDirectory(app_path('Models'));
        File::deleteDirectory(app_path('Http'));
        File::deleteDirectory(app_path('Services'));
        File::deleteDirectory(app_path('Repositories'));
        File::deleteDirectory(app_path('Events'));
        File::deleteDirectory(app_path('Listeners'));
        File::deleteDirectory(app_path('Notifications'));
        File::deleteDirectory(app_path('Policies'));
        File::deleteDirectory(database_path('migrations'));
        File::delete(app_path('Product.php'));
        File::delete(app_path('Category.php'));
    }

    /**
     * Test full module generation with all components, including Service and Repository.
     */
    public function test_it_generates_complete_module_with_service_and_repository()
    {
        $this->artisan('make:module', ['name' => 'Product'])
            ->expectsQuestion('Field (or empty to finish)', 'title:string:unique')
            ->expectsQuestion('Field (or empty to finish)', 'price:integer:nullable')
            ->expectsQuestion('Field (or empty to finish)', '')
            ->expectsChoice('Controller version', 'v1', ['v1', 'v2', 'v3'])
            ->expectsConfirmation('Include policies?', 'yes')
            ->expectsConfirmation('Include service layer?', 'yes')
            ->expectsConfirmation('Include repository layer?', 'yes')
            ->expectsConfirmation('Include events and listeners?', 'yes')
            ->assertExitCode(0);

        // Assert Model and fillable fields
        $modelPath = app_path('Models/Product.php');
        if (!File::exists($modelPath)) {
            $modelPath = app_path('Product.php');
        }
        $this->assertTrue(File::exists($modelPath));
        $modelContent = File::get($modelPath);
        $this->assertStringContainsString("protected \$fillable = ['title', 'price'];", $modelContent);

        // Assert Migration files
        $migrations = File::files(database_path('migrations'));
        $this->assertCount(1, $migrations);
        $migrationContent = File::get($migrations[0]);
        $this->assertStringContainsString("\$table->string('title')->unique();", $migrationContent);
        $this->assertStringContainsString("\$table->integer('price')->nullable();", $migrationContent);

        // Assert Repository
        $repositoryPath = app_path('Repositories/ProductRepository.php');
        $this->assertTrue(File::exists($repositoryPath));
        $repositoryContent = File::get($repositoryPath);
        $this->assertStringContainsString('class ProductRepository', $repositoryContent);
        $this->assertStringContainsString('Product::create($data)', $repositoryContent);

        // Assert Service (uses Repository)
        $servicePath = app_path('Services/ProductService.php');
        $this->assertTrue(File::exists($servicePath));
        $serviceContent = File::get($servicePath);
        $this->assertStringContainsString('protected ProductRepository $repository', $serviceContent);
        $this->assertStringContainsString('$this->repository->create($data)', $serviceContent);
        $this->assertStringContainsString('use App\Events\ProductCreated;', $serviceContent);
        $this->assertStringContainsString('event(new ProductCreated($model));', $serviceContent);
        $this->assertStringContainsString('public function getProducts()', $serviceContent);

        // Assert Controller
        $controllerPath = app_path('Http/Controllers/Api/V1/ProductController.php');
        $this->assertTrue(File::exists($controllerPath));
        $controllerContent = File::get($controllerPath);
        $this->assertStringContainsString('protected ProductService $service', $controllerContent);
        $this->assertStringContainsString('getProducts()', $controllerContent);

        // Assert Form Requests and dynamic validation rules
        $storeRequestPath = app_path('Http/Requests/Product/StoreProductRequest.php');
        $this->assertTrue(File::exists($storeRequestPath));
        $storeRequestContent = File::get($storeRequestPath);
        $this->assertStringContainsString("'title' => 'required|string|max:255|unique:products,title'", $storeRequestContent);
        $this->assertStringContainsString("'price' => 'required|integer'", $storeRequestContent);

        $updateRequestPath = app_path('Http/Requests/Product/UpdateProductRequest.php');
        $this->assertTrue(File::exists($updateRequestPath));
        $updateRequestContent = File::get($updateRequestPath);
        $this->assertStringContainsString("'title' => 'required|string|max:255|unique:products,title'", $updateRequestContent);

        // Assert API Resource
        $resourcePath = app_path('Http/Resources/ProductResource.php');
        $this->assertTrue(File::exists($resourcePath));
        $resourceContent = File::get($resourcePath);
        $this->assertStringContainsString("'title' => \$this->title", $resourceContent);
        $this->assertStringContainsString("'price' => \$this->price", $resourceContent);

        // Assert Event, Listener, Notification, Policy
        $this->assertTrue(File::exists(app_path('Events/ProductCreated.php')));
        $this->assertTrue(File::exists(app_path('Listeners/ProductCreatedListener.php')));
        $this->assertTrue(File::exists(app_path('Notifications/ProductCreatedNotification.php')));
        $this->assertTrue(File::exists(app_path('Policies/ProductPolicy.php')));
    }

    /**
     * Test module generation without Service Layer and without Repository.
     */
    public function test_it_generates_module_without_service_and_repository()
    {
        $this->artisan('make:module', ['name' => 'Category'])
            ->expectsQuestion('Field (or empty to finish)', 'name:string')
            ->expectsQuestion('Field (or empty to finish)', '')
            ->expectsChoice('Controller version', 'v2', ['v1', 'v2', 'v3'])
            ->expectsConfirmation('Include policies?', 'no')
            ->expectsConfirmation('Include service layer?', 'no')
            ->expectsConfirmation('Include repository layer?', 'no')
            ->expectsConfirmation('Include events and listeners?', 'no')
            ->assertExitCode(0);

        // Assert Category Model exists
        $modelPath = app_path('Models/Category.php');
        if (!File::exists($modelPath)) {
            $modelPath = app_path('Category.php');
        }
        $this->assertTrue(File::exists($modelPath));

        // Assert Category Controller exists and uses Model directly
        $controllerPath = app_path('Http/Controllers/Api/V2/CategoryController.php');
        $this->assertTrue(File::exists($controllerPath));
        $controllerContent = File::get($controllerPath);
        $this->assertStringNotContainsString('protected CategoryService $service', $controllerContent);
        $this->assertStringContainsString('Category::all()', $controllerContent);

        // Assert Service & Repository do NOT exist
        $this->assertFalse(File::exists(app_path('Services/CategoryService.php')));
        $this->assertFalse(File::exists(app_path('Repositories/CategoryRepository.php')));
    }
}
