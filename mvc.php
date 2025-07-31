<?php

// --- 1. Interfaces ---
// Define contracts for our components
interface ModelInterface {
    public function getData(): array;
}

interface ViewInterface {
    public function render(array $data): string;
}

interface ControllerInterface {
    public function execute(): void;
}

// --- 2. Model ---
// Represents data and business logic (simplified)
class ProductModel implements ModelInterface {
    private array $products = [];

    public function __construct() {
        // Simulate fetching data from a database
        $this->products = [
            ['id' => 1, 'name' => 'Laptop', 'price' => 1200],
            ['id' => 2, 'name' => 'Mouse', 'price' => 25],
            ['id' => 3, 'name' => 'Keyboard', 'price' => 75],
        ];
    }

    public function getData(): array {
        return $this->products;
    }

    public function getProductById(int $id): ?array {
        foreach ($this->products as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }
}

// --- 3. View ---
// Handles presentation logic
class ProductListView implements ViewInterface {
    public function render(array $data): string {
        $output = "<h1>Product List</h1>";
        if (empty($data)) {
            $output .= "<p>No products available.</p>";
        } else {
            $output .= "<ul>";
            foreach ($data as $product) {
                $output .= "<li>{$product['name']} - $" . number_format($product['price'], 2) . "</li>";
            }
            $output .= "</ul>";
        }
        return $output;
    }
}

class ProductDetailView implements ViewInterface {
    public function render(array $data): string {
        if (empty($data)) {
            return "<p>Product not found.</p>";
        }
        return "<h1>Product Details</h1>" .
               "<p>ID: {$data['id']}</p>" .
               "<p>Name: {$data['name']}</p>" .
               "<p>Price: $" . number_format($data['price'], 2) . "</p>";
    }
}

// --- 4. Controller ---
// Bridges Model and View, handles input (simplified routing)
class ProductController implements ControllerInterface {
    private ModelInterface $model;
    private ViewInterface $listView;
    private ViewInterface $detailView; // Added a second view for details

    public function __construct(ModelInterface $model, ViewInterface $listView, ViewInterface $detailView) {
        $this->model = $model;
        $this->listView = $listView;
        $this->detailView = $detailView;
    }

    public function execute(): void {
        // Simple routing based on a query parameter
        $action = $_GET['action'] ?? 'list';
        $productId = (int) ($_GET['id'] ?? 0);

        if ($action === 'list') {
            $products = $this->model->getData();
            echo $this->listView->render($products);
        } elseif ($action === 'detail' && $productId > 0) {
            // This requires casting the ModelInterface to ProductModel
            // A more robust solution would be to add getProductById to ModelInterface
            // For simplicity, we'll directly call here or refine the interface.
            // Let's refine the interface for better design.
            if ($this->model instanceof ProductModel) {
                 $product = $this->model->getProductById($productId);
                 echo $this->detailView->render($product ?? []);
            } else {
                 echo "<p>Model does not support detail view.</p>";
            }

        } else {
            echo "<p>Invalid action or product ID.</p>";
        }
    }
}

// --- 5. Bootstrap/Application Entry Point ---
// Initialize and run the application
try {
    $productModel = new ProductModel();
    $productListView = new ProductListView();
    $productDetailView = new ProductDetailView(); // Instantiate detail view

    $controller = new ProductController($productModel, $productListView, $productDetailView);
    $controller->execute();
} catch (Throwable $e) { // Catching Throwable for all errors and exceptions
    error_log("Application error: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
    echo "An unexpected error occurred. Please try again later.";
}

?>