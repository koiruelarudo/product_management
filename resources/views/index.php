<?php
session_start();

// データベース接続（PHP Sandbox用に簡易的なセッションベース）
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

class Product {
    public $id;
    public $name;
    public $price;
    public $description;

    public function __construct($id, $name, $price, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
}

// 商品の一覧を表示
function index() {
    $products = $_SESSION['products'];
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Products</title>
    </head>
    <body>
        <h1>Products</h1>
        <a href="?action=create">Create New Product</a>
        <ul>
            <?php foreach ($products as $product): ?>
                <?php if (!isset($product->deleted_at)): ?>
                    <li>
                        <?php echo htmlspecialchars($product->name); ?> - 
                        <a href="?action=show&id=<?php echo $product->id; ?>">View</a> - 
                        <a href="?action=edit&id=<?php echo $product->id; ?>">Edit</a> - 
                        <a href="?action=delete&id=<?php echo $product->id; ?>">Delete</a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </body>
    </html>
    <?php
}

// 商品の詳細を表示
function show($id) {
    $product = findProductById($id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo htmlspecialchars($product->name); ?></title>
    </head>
    <body>
        <h1><?php echo htmlspecialchars($product->name); ?></h1>
        <p>Price: <?php echo htmlspecialchars($product->price); ?></p>
        <p>Description: <?php echo htmlspecialchars($product->description); ?></p>
        <a href="?action=index">Back to Products</a>
    </body>
    </html>
    <?php
}

// 商品を新規登録
function create($data) {
    $id = count($_SESSION['products']) + 1;
    $product = new Product($id, $data['name'], $data['price'], $data['description']);
    $_SESSION['products'][] = $product;
    header('Location: ?action=index');
}

// 商品を更新
function update($id, $data) {
    foreach ($_SESSION['products'] as &$product) {
        if ($product->id == $id) {
            $product->name = $data['name'];
            $product->price = $data['price'];
            $product->description = $data['description'];
            break;
        }
    }
    header('Location: ?action=index');
}

// 商品を論理削除
function delete($id) {
    foreach ($_SESSION['products'] as &$product) {
        if ($product->id == $id) {
            $product->deleted_at = true;
            break;
        }
    }
    header('Location: ?action=index');
}

// 商品IDで検索
function findProductById($id) {
    foreach ($_SESSION['products'] as $product) {
        if ($product->id == $id && !isset($product->deleted_at)) {
            return $product;
        }
    }
    return null;
}

// ルーティング
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

switch ($action) {
    case 'index':
        index();
        break;
    case 'show':
        show($id);
        break;
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            create($_POST);
        } else {
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Create Product</title>
            </head>
            <body>
                <h1>Create Product</h1>
                <form action="?action=create" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" name="name" required><br>
                    <label for="price">Price:</label>
                    <input type="text" name="price" required><br>
                    <label for="description">Description:</label>
                    <textarea name="description" required></textarea><br>
                    <button type="submit">Create</button>
                </form>
                <a href="?action=index">Back to Products</a>
            </body>
            </html>
            <?php
        }
        break;
    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            update($id, $_POST);
        } else {
            $product = findProductById($id);
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Edit Product</title>
            </head>
            <body>
                <h1>Edit Product</h1>
                <form action="?action=edit&id=<?php echo $product->id; ?>" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($product->name); ?>" required><br>
                    <label for="price">Price:</label>
                    <input type="text" name="price" value="<?php echo htmlspecialchars($product->price); ?>" required><br>
                    <label for="description">Description:</label>
                    <textarea name="description" required><?php echo htmlspecialchars($product->description); ?></textarea><br>
                    <button type="submit">Update</button>
                </form>
                <a href="?action=index">Back to Products</a>
            </body>
            </html>
            <?php
        }
        break;
    case 'delete':
        delete($id);
        break;
    default:
        index();
        break;
}
?>
