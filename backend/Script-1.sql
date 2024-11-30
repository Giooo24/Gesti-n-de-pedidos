-- Tabla Usuario
CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL -- Puede ser 'admin', 'cocina', 'cliente'
) ENGINE=InnoDB;

-- Tabla Item
CREATE TABLE Item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    disponible BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB;

-- Tabla Pedido
CREATE TABLE Pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    mesa INT NOT NULL,
    estado VARCHAR(50) DEFAULT 'activo', -- Puede ser 'activo', 'en preparación', 'preparado', 'pagado'
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabla Factura
CREATE TABLE Factura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES Pedido(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabla Transaccion
CREATE TABLE Transaccion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL, -- Puede ser 'efectivo', 'tarjeta', etc.
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES Pedido(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabla intermedia PedidoItem (Muchos a Muchos)
CREATE TABLE PedidoItem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    item_id INT NOT NULL,
    cantidad INT NOT NULL,
    personalizacion TEXT,
    FOREIGN KEY (pedido_id) REFERENCES Pedido(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (item_id) REFERENCES Item(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
