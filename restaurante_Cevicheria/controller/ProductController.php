<?php

class ProductController {
        private $conexion;
    
        public function __construct($conexion) {
            $this->conexion = $conexion;
        }
    
        public function getAllProducts() {
            $sql = "SELECT * FROM tbproductos WHERE estado = 1 ORDER BY categoria, nombre";
            $resultado = $this->conexion->query($sql);
            $productos = [];
            while ($row = $resultado->fetch_assoc()) {
                $productos[] = $row;
            }
            return $productos;
        }
    
        public function getProductsByCategory($categoria) {
            $sql = "SELECT * FROM tbproductos WHERE categoria = ? AND estado = 1 ORDER BY nombre";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s", $categoria);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $productos = [];
            while ($row = $resultado->fetch_assoc()) {
                $productos[] = $row;
            }
            $stmt->close();
            return $productos;
        }
    
        public function addProduct($data) {
            $sql = "INSERT INTO tbproductos (nombre, descripcion, precio_personal, precio_mediano, precio_familiar, categoria, imagen, estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssddsss", 
                $data['nombre'], 
                $data['descripcion'], 
                $data['precio_personal'], 
                $data['precio_mediano'], 
                $data['precio_familiar'], 
                $data['categoria'], 
                $data['imagen']
            );
            $stmt->execute();
            $stmt->close();
        }
    
        public function updateProduct($id, $data) {
            $sql = "UPDATE tbproductos SET nombre = ?, descripcion = ?, precio_personal = ?, precio_mediano = ?, precio_familiar = ?, categoria = ?, imagen = ? 
                    WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssddsssi", 
                $data['nombre'], 
                $data['descripcion'], 
                $data['precio_personal'], 
                $data['precio_mediano'], 
                $data['precio_familiar'], 
                $data['categoria'], 
                $data['imagen'], 
                $id
            );
            $stmt->execute();
            $stmt->close();
        }
    
        public function deleteProduct($id) {
            $sql = "DELETE FROM tbproductos WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    
}