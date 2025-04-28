<?php

namespace Model;
use Model\Favorito;
use Model\ProductoTamaño;
use Model\ProductoCategoria;

class Producto {
    private static $tabla = 'producto';
    
    public $id;
    public $nombre;
    public $ruta;
    public $descripcion;
    public $estatus;

    //public $productoTamaño;

    // Variables para guardar los precios de cada tamaño
    public $precio; // En caso de que se necesite el precio de un solo tamaño
    public $chico; // Precio del tamaño chico
    public $mediano; // Precio del tamaño mediano
    public $grande; // Precio del tamaño grande

    public $favorito;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->ruta = $args['ruta'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->estatus = $args['estatus'] ?? 1;
    }

    public static function list() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE estatus = 1";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $products = [];

                // Obtener los tamaños, precios y favoritos de cada producto
                while ($row = mysqli_fetch_assoc($result)) {
                    $product = new Producto($row);

                    if (isLogged()) {
                        $favorito = Favorito::getByIdUsuarioAndIdProducto($_SESSION['id'], $product->id);
                        if ($favorito) {
                            $product->favorito = true;
                        } else {
                            $product->favorito = false;
                        }
                    } else {
                        $product->favorito = false;
                    }

                    $sizes = ProductoTamaño::getByIdProducto($product->id);

                    if ($sizes) {
                        foreach ($sizes as $size) {
                            switch ($size->id_tamaño) {
                                case 1:
                                    $product->chico = $size->precio;
                                    break;
                                case 2:
                                    $product->mediano = $size->precio;
                                    break;
                                case 3:
                                    $product->grande = $size->precio;
                                    break;
                            }
                        }
                    }

                    $products[] = $product;
                }
                
                return $products;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function listPagination($offset = 0, $limit = 10) {
        try {
            require __DIR__ . '/../includes/database.php';
    
            $query = "SELECT * FROM " . self::$tabla . " WHERE estatus = 1 LIMIT ? OFFSET ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            $products = [];
    
            while ($row = mysqli_fetch_assoc($result)) {
                $product = new Producto($row);
                $sizes = ProductoTamaño::getByIdProducto($product->id);
    
                if ($sizes) {
                    foreach ($sizes as $size) {
                        switch ($size->id_tamaño) {
                            case 1: $product->chico = $size->precio; break;
                            case 2: $product->mediano = $size->precio; break;
                            case 3: $product->grande = $size->precio; break;
                        }
                    }
                }
    
                $products[] = $product;
            }
    
            return $products;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function where($column, $value) {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT * FROM " . self::$tabla . " WHERE $column LIKE ? AND estatus = 1";
            $stmt = mysqli_prepare($db, $query);
            $value = "%$value%";
            mysqli_stmt_bind_param($stmt, 's', $value);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $products = [];
    
            while ($row = mysqli_fetch_assoc($result)) {
                $product = new Producto($row);

                if (isLogged()) {
                    $favorito = Favorito::getByIdUsuarioAndIdProducto($_SESSION['id'], $product->id);
                    if ($favorito) {
                        $product->favorito = true;
                    } else {
                        $product->favorito = false;
                    }
                } else {
                    $product->favorito = false;
                }
                
                $sizes = ProductoTamaño::getByIdProducto($product->id);
    
                if ($sizes) {
                    foreach ($sizes as $size) {
                        switch ($size->id_tamaño) {
                            case 1: $product->chico = $size->precio; break;
                            case 2: $product->mediano = $size->precio; break;
                            case 3: $product->grande = $size->precio; break;
                        }
                    }
                }
    
                $products[] = $product;
            }
    
            return $products;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function filter($columns, $values) {
        try {
            require __DIR__ . '/../includes/database.php';
            $products = [];
            $productsSearch = null;
            $productsCategory = null;
            $productsSize = null;
            $productsLiked = null;

            $sizeArray = [];
            $sort = null;

            /* 
                Primero se van a tomar las columnas y se haran busquedas por cada una de ellas con la funcion de where,
                cada una de estas se almacenara en un array, posteriormente se agarraran todos los arrays con los resultados de los filtros
                y se van a unir en un array, eliminando los duplicados, y se retornara el array final.
            */

            for ($i = 0; $i < count($columns); $i++) {
                $column = $columns[$i];
                $value = $values[$i];

                switch ($column) {
                    case 'search':
                        $productsSearch = self::where("nombre", $value);
                        break;
                    case 'liked':
                        $result = Favorito::getByIdUsuario($value); // Haber checado previamente si el id del usuario esta bien

                        if (!$result) {
                            $productsLiked = [];
                            break;
                        }

                        foreach ($result as $item) {
                            $product = self::where("id", $item->id_producto);
                            if ($product) {
                                $product[0]->favorito = true; // Marcar como favorito
                                $productsLiked[] = $product[0];
                            }
                        }
                        break;
                    case 'category':
                        $result = ProductoCategoria::getByIdCategoria($value); // Haber checado previamente si el id de la categoria esta bien

                        if (!$result) {
                            $productsCategory = [];
                            break;
                        }

                        foreach ($result as $item) {
                            $product = self::where("id", $item->id_producto);
                            if ($product) {
                                $productsCategory[] = $product[0];
                            }
                        }
                        break;
                    case 'size':
                        $size = $value;
                        $sizeArray[] = $size;
                        $result = ProductoTamaño::where("id_tamaño", $size);

                        if (!$result) {
                            $productsSize = [];
                            break;
                        }

                        foreach ($result as $item) {
                            $product = self::where("id", $item->id_producto);
                            if ($product) {
                                $productsSize[] = $product[0];
                            }
                        }
                        break;
                    case 'price':
                        if ($value == 1) {
                            $sort = "ASC";
                        } else if ($value == 2) {
                            $sort = "DESC";
                        }
                        break;
                    default:
                        $result = null;
                        break;
                }
            }

            // Primero mirar si alguno de los arreglos esta vacio, en caso de ser asi no se retorna ningun producto
            if ($productsSearch === [] || $productsCategory === [] || $productsSize === [] || $productsLiked === []) {
                return [];
            }

            if ($productsSearch === null && $productsCategory === null && $productsSize === null && $productsLiked === null) {
                $products = self::list(); // Si no se han hecho busquedas, se retornan todos los productos
            } else {
                // Combinar resultados
                $filters = array_filter([$productsSearch, $productsCategory, $productsSize, $productsLiked]);

                if (count($filters) > 0) {
                    $products = array_shift($filters);
                    foreach ($filters as $filterSet) {
                        $products = array_uintersect($products, $filterSet, function ($a, $b) {
                            return $a->id <=> $b->id;
                        });
                    }
                } else {
                    $products = [];
                }
            }

            if (!empty($sizeArray)) {
                sort($sizeArray); // Ordenar de menor a mayor el arreglo
            }

            if ($sort && !empty($products)) {
                foreach($products as $product) {
                    if ($product->precio == null) {
                        if (isset($size)) {
                            foreach ($sizeArray as $size) {
                                if ($size == 1) {
                                    if ($product->chico == null) continue; // No tiene ese tamaño
                                    $product->precio = $product->chico;
                                    break; // Salir del bucle una vez que se ha encontrado el precio
                                } else if ($size == 2) {
                                    if ($product->mediano == null) continue;
                                    $product->precio = $product->mediano;
                                    break;
                                } else if ($size == 3) {
                                    if ($product->grande == null) continue;
                                    $product->precio = $product->grande;
                                    break;
                                }
                            }
                        } else {
                            if ($product->chico != null) {
                                $product->precio = $product->chico;
                            } else if ($product->mediano != null) {
                                $product->precio = $product->mediano;
                            } else if ($product->grande != null) {
                                $product->precio = $product->grande;
                            } else {
                                continue; // No tiene ningun tamaño
                            }
                        }
                    }
                }
            }

            if ($sort) {
                usort($products, function ($a, $b) use ($sort) {
                    if ($sort == "ASC") {
                        return $a->precio <=> $b->precio;
                    } else if ($sort == "DESC") {
                        return $b->precio <=> $a->precio;
                    }
                });
            }

            $products = array_unique($products, SORT_REGULAR); // Eliminar duplicados
            $products = array_values($products); // Reindexar el array para que los indices sean consecutivos
            return $products;
        } catch (\Exception $e) {
            return null;
        }
    }
    
    public static function count() {
        try {
            require __DIR__ . '/../includes/database.php';

            $query = "SELECT COUNT(*) as total FROM " . self::$tabla . " WHERE estatus = 1";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['total'];
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function getAdminProductos() {
        require __DIR__ . '/../includes/database.php';
        $query = "SELECT * FROM " . self::$tabla . " WHERE estatus = 1";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $productos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $productos[] = new Producto($row);
        }
        return $productos;
    }

    public static function findById($id) {
        require __DIR__ . '/../includes/database.php';
        $query = "SELECT * FROM " . self::$tabla . " WHERE id = ? AND estatus = 1";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            return new Producto(mysqli_fetch_assoc($result));
        } else {
            return null;
        }
    }

    public static function create($nombre, $descripcion, $tamanos, $precios, $categorias, $rutaImagen) {
        require __DIR__ . '/../includes/database.php';
        $query = "INSERT INTO " . self::$tabla . " (nombre, ruta, descripcion, estatus) VALUES (?, ?, ?, 1)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'sss', $nombre, $rutaImagen, $descripcion);
        mysqli_stmt_execute($stmt);
    
        if (mysqli_affected_rows($db) > 0) {
            $id_producto = mysqli_insert_id($db);
    
            foreach ($tamanos as $i => $id_tamano) {
                $precio = $precios[$i] ?? 0;
                $query = "INSERT INTO producto_tamaño (id_producto, id_tamaño, precio, existencia) VALUES (?, ?, ?, 20)";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, 'iid', $id_producto, $id_tamano, $precio);
                mysqli_stmt_execute($stmt);
            }
    
            foreach ($categorias as $cat) {
                $query = "INSERT INTO producto_categoria (id_producto, id_categoria) VALUES (?, ?)";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, 'ii', $id_producto, $cat);
                mysqli_stmt_execute($stmt);
            }
    
            return true;
        } else {
            return false;
        }
    }
}
?>